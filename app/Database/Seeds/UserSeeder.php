<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run(){
        $userObject = new UserModel();

        $userObject->insertBatch([
            [
                "username"=> 'subhadip',
                "password" => password_hash("subha1993", PASSWORD_DEFAULT),
                "role" => 'admin'
            ],
            [
                "username"=> 'sagar',
                "password" => password_hash("sagar1998", PASSWORD_DEFAULT),
                "role" => 'admin'
            ],
            [
                "username"=> 'pr_goenka',
                "password" => password_hash("pr@1234", PASSWORD_DEFAULT),
                "role" => 'viewer'
            ],
            [
                "username"=> 'way_bridge1',
                "password" => password_hash("way@1234", PASSWORD_DEFAULT),
                "role" => 'viewer'
            ],
            [
                "username"=> 'jiten',
                "password" => password_hash("jiten@1234", PASSWORD_DEFAULT),
                "role" => 'way_bridge'
            ],
        ]);
    }
}

?>