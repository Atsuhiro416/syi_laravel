<?php

use Illuminate\Database\Seeder;
use App\Models\Stack;

class StacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Stack::class, 10)->create();
    }
}
