<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //$this->call(VideojuegoTableSeeder::class);
        $this->call(PlataformaTableSeeder::class);
          $this->call(RoleTableSeeder::class);
    }
}
