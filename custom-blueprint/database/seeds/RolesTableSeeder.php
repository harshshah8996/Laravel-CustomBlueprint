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
                'name' => $obj->name,
                'created_at' => $obj->created_at,
                'created_by' => $obj->created_by,
                'updated_at' => $obj->updated_at,
                'updated_by' => $obj->updated_by,
                'deleted_at' => $obj->deleted_at,
                'deleted_by' => $obj->deleted_by,
                'is_deleted' => $obj->is_deleted
            ));
        }
    }
}
