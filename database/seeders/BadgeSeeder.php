<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('badges')->insert([
            'id' => '',
            'name' => "Top Achiever",
            'description' => 'When obtaining the highest grade in one assignment (given for the first three).',
        ]);
    }
}
