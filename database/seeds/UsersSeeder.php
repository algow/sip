<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat role admin
        $adminRole = new Role();
        $adminRole->name = "admin";
        $adminRole->display_name = "Admin";
        $adminRole->save();
        
        // Membuat role member
        $foRole = new Role();
        $foRole->name = "front_office";
        $foRole->display_name = "Front Office";
        $foRole->save();

        // Membuat sample admin
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'algow64@gmail.com';
        $admin->username = 'admin';
        $admin->password = bcrypt('admin');
        $admin->save();
        $admin->attachRole($adminRole);
        
        // Membuat sample member
        $frontoffice = new User();
        $frontoffice->name = "Front Office";
        $frontoffice->email = 'sampel@gmail.com';
        $admin->username = 'fo';
        $frontoffice->password = bcrypt('fo');
        $frontoffice->save();
        $frontoffice->attachRole($foRole);
    }
}
