<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Folder;
use App\Models\User;

class FolderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function factoryFolder()
    {
        return factory(Folder::class)->create();
    }

    //以下から正常系テスト
    public function testIndexFolders()
    {
        $item = $this->factoryFolder();
        $response = $this->get('/api/folders');
        $response->assertStatus(200)->assertJsonFragment($item->toArray());
    }

    public function testStoreFolder()
    {
        $user = factory(User::class)->create();
        $data = [
            'name' => 'test',
            'user_id' => $user->id,
        ];
        $response = $this->post('/api/folders', $data);
        $response->assertStatus(201)->assertJsonFragment($data);
    }

    public function testShowFolder()
    {
        $item = $this->factoryFolder();
        $response = $this->get("/api/folders/{$item->id}");
        $response->assertStatus(200)->assertJsonFragment($item->toArray());
    }

    public function testUpdateFolder()
    {
        $this->withoutExceptionHandling();
        $item = $this->factoryFolder();
        $data = [
            'name' => '変更しました。',
        ];
        $response = $this->put("/api/folders/{$item->id}", $data);
        $response->assertStatus(200)->assertJsonFragment([
            'name' => '変更しました。',
            'user_id' => $item->id,
        ]);
    }

    public function testDestroyFolder()
    {
        $item = $this->factoryFolder();
        $response = $this->delete("/api/folders/{$item->id}");
        $response->assertStatus(200);
        $this->assertDeleted($item);
    }
}
