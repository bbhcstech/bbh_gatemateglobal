<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationSeeder extends Seeder
{
    public function run()
    {
        $relations = [
            ['name' => 'Self', 'status' => 1],
            ['name' => 'Husband', 'status' => 1],
            ['name' => 'Wife', 'status' => 1],
            ['name' => 'Daughter', 'status' => 1],
            ['name' => 'Brother', 'status' => 1],
            ['name' => 'Sister', 'status' => 1],
            ['name' => 'Grandfather', 'status' => 1],
            ['name' => 'Grandmother', 'status' => 1],
            ['name' => 'Father-in-law', 'status' => 1],
            ['name' => 'Mother-in-law', 'status' => 1],
            ['name' => 'Nephew', 'status' => 1],
            ['name' => 'Niece', 'status' => 1],
            ['name' => 'Cousin', 'status' => 1],
            ['name' => 'Uncle', 'status' => 1],
            ['name' => 'Aunt', 'status' => 1],
        ];

        DB::table('relations')->insertOrIgnore($relations);
    }
}
