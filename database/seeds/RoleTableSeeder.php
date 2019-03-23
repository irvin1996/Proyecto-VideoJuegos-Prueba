<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $author = \App\Role::create([
        'name'        => 'administrador',
        'permissions' => json_encode([
            'create-vj' => true
        ]),
    ]);

    $editor = \App\Role::create([
        'name'        => 'supervisor',
        'permissions' => json_encode([
            'update-vj'  => true,
            'publish-vj' => true
        ]),
    ]);
    }
}
