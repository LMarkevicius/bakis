<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
          'id'    => 1,
          'sleep' => 1,
          'daily' => '07:00'
        ]);
    }
}
