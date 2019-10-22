<?php

use Illuminate\Database\Seeder;
use function GuzzleHttp\json_decode;
use App\Role;

class RolesTableSeeder extends Seeder
{

    public function run()
    {
        $json = file_get_contents('database/data/roles.json');
        $data = json_decode($json);

        foreach ($data as $obj) {
            Role::create(array(
                'id' => $obj->id,
                'name' => $obj->name
            ));
        }
    }
}
