<?php

use App\Models\Folder;
use App\Models\Stack;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class FoldersStacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user = factory(User::class)->create();

        $stack = Stack::create([
            'name' => $faker->sentence(rand(1,20)),
            'link' => $faker->url,
            'comment' => $faker->realText(150),
            'user_id' => $user->id,
        ]);

        $folder = Folder::create([
            'name' => $faker->sentence(rand(1,20)),
            'user_id' => $user->id,
        ]);

        $stack->folders()->attach($folder->id);
    }
}
