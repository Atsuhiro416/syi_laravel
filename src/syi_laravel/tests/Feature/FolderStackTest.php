<?php

namespace Tests\Feature;

use App\Models\Folder;
use App\Models\Stack;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FolderStackTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //user_idが共通となるfolder,stackを作成
    protected function createUserStackFolder()
    {
        $user = factory(User::class)->create();

        $stack = Stack::create([
            'name' => $this->faker->sentence(rand(1,20)),
            'link' => $this->faker->url,
            'comment' => $this->faker->realText(150),
            'user_id' => $user->id,
        ]);

        $folder = Folder::create([
            'name' => $this->faker->sentence(rand(1,20)),
            'user_id' => $user->id,
        ]);

        return [
            'user' => $user,
            'stack' => $stack,
            'folder' => $folder,
        ];
    }

    public function testIndexFoldersStacks()
    {
        $items = $this->createUserStackFolder();
        //folderとstackをリレーション
        $items['folder']->stacks()->attach($items['stack']->id);

        $response = $this->get("/api/folders/{$items['folder']->id}/stacks");
        $response->assertStatus(200)->assertJsonFragment($items['stack']->toArray());
    }

    public function testAttachFolderToStack()
    {
        $items = $this->createUserStackFolder();
        $response = $this->post("/api/folders/{$items['folder']->id}/stacks/{$items['stack']->id}");
        $response->assertStatus(200);
        $this->assertDatabaseHas('folder_stack', [
            'folder_id' => $items['folder']->id,
            'stack_id' => $items['stack']->id,
        ]);
    }

    public function testDetachFolderToStack()
    {
        $items = $this->createUserStackFolder();
        $this->post("/api/folders/{$items['folder']->id}/stacks/{$items['stack']->id}");
        $response = $this->delete("/api/folders/{$items['folder']->id}/stacks/{$items['stack']->id}");
        $response->assertStatus(200);
        $this->assertDeleted('folder_stack', [
            'folder_id' => $items['folder']->id,
            'stack_id' => $items['stack']->id,
        ]);
    }

    //すでにリレーションが存在する場合のテスト
    public function testAttachFolderToStackTwoTimes()
    {
        $items = $this->createUserStackFolder();
        $folder = Folder::create([
            'name' => $this->faker->sentence(rand(1,20)),
            'user_id' => $items['user']->id,
        ]);

        //リレーション一回目
        $this->post("/api/folders/{$items['folder']->id}/stacks/{$items['stack']->id}");

        //$items['stack']と新しいfolderとのリレーション
        $items['stack']->folders()->attach($folder->id);

        //すでにリレーションがある場合は409を返す予定
        $response = $this->post("/api/folders/{$items['folder']->id}/stacks/{$items['stack']->id}");
        $response->assertStatus(409)->assertJsonFragment([
            'message' => 'リストはすでに該当のフォルダーに入っています。',
        ]);

        //別のリレーションに影響がないか確認
        $this->assertDatabaseHas('folder_stack', [
            'folder_id' => $folder->id,
            'stack_id' => $items['stack']->id,
        ]);
    }

    //リスト詳細取得時にリレーションしているフォルダーも取得する
    public function testShowStackWithRelatedFolder()
    {
        $items = $this->createUserStackFolder();
        //$itemsで作成したfolder,stack間のリレーション
        $items['folder']->stacks()->attach($items['stack']->id);
        $folder = Folder::create([
            'name' => $this->faker->sentence(rand(1,20)),
            'user_id' => $items['user']->id,
        ]);
        //$itemsで作成したstackと新たに作った$folder間のリレーション
        $items['stack']->folders()->attach($folder->id);

        $response = $this->get("/api/stacks/{$items['stack']->id}");
        $response->assertJsonFragment([
            'name' => $items['folder']->name,
            'name' => $folder->name,
        ]);
    }
}
