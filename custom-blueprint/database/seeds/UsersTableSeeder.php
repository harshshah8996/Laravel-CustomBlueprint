<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $json = file_get_contents('database/data/users.json');
        $data = json_decode($json);

        foreach ($data as $obj) {
            User::create(array(
                'id' => $obj->id,
                'role_id' => $obj->role_id,
                'name' => $obj->name,
                'email' => $obj->email,
                'password' => Hash::make($obj->password)
            ));
        }
    }
}
