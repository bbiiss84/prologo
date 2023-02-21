<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Мобильные телефоны',
                'code' => 'mobiles',
                'description' => 'Это категория, в которой находятся мобильные телефоны',
            ],
            [
                'name' => 'Портативная техника',
                'code' => 'portable',
                'description' => 'Это категория, в которой находится портативная техника',
            ],
            [
                'name' => 'Бытовая техника',
                'code' => 'appliances',
                'description' => 'Это категория, в которой находится бытовая техника',
            ],
        ]);
    }
}
