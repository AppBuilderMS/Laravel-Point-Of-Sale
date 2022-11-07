<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'super_admin@app.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->attachRole('super_admin');

        $permissions = Permission::all()->pluck('id');
        $user->syncPermissions($permissions);
    }
}
