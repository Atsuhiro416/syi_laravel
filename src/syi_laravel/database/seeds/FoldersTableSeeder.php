<?php

use Illuminate\Database\Seeder;
use App\Models\Folder;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Folder::class, 10)->create();
    }
}
