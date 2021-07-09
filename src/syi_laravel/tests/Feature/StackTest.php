<?php

namespace Tests\Feature;

use App\Models\Stack;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StackTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function factoryStack()
    {
        return factory(Stack::class)->create();
    }

    //以下から正常系テスト
    public function testIndexStacks()
    {
        $item = $this->factoryStack();
        $response = $this->get('/api/stacks');
        $response->assertStatus(200)->assertJsonFragment($item->toArray());
    }

    public function testStoreStack()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $data = [
            'name' => 'test',
            'link' => 'https://www.google.com',
            'comment' => 'コメント',
            'user_id' => $user->id,
        ];
        $response = $this->post('/api/stacks', $data);
        $response->assertStatus(201)->assertJsonFragment($data);
    }

    public function testShowStack()
    {
        $item = $this->factoryStack();
        $response = $this->get("/api/stacks/{$item->id}");
        $response->assertStatus(200)->assertJsonFragment($item->toArray());
    }

    public function testUpdateStack()
    {
        $item = $this->factoryStack();
        $data = [
            'name' => '変更しました',
            'link' => 'https://www.google.com',
            'comment' => 'コメントを変更しました',
        ];
        $response = $this->put("/api/stacks/{$item->id}", $data);
        $response->assertStatus(200)->assertJsonFragment(
            $data,
            [
                'id' => $item->id,
                'user_id' => $item->user_id,
            ]
        );
    }

    public function testDeleteStack()
    {
        $item = $this->factoryStack();
        $response = $this->delete("/api/stacks/{$item->id}");
        $response->assertStatus(200);
        $this->assertDeleted($item);
    }

    //以下から異常系テスト
    public function testStoreStackInputOverStrings()
    {
        $user = factory(User::class)->create();
        $data = [
            'name' => $this->faker->realText(300),
            'link' => null,
            'comment' => null,
            'user_id' => $user->id,
        ];
        $response = $this->post('/api/stacks', $data);
        $response->assertStatus(400)->assertJsonFragment([
            'name' => ['入力できる文字数は250字以内です'],
        ]);
    }

    public function testShowNonExistsStack()
    {
        $response = $this->get('/api/stacks/300');
        $response->assertStatus(404);
    }
}
