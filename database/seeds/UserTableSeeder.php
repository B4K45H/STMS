<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'abin_12914',
                'user_name' => 'superadmin',
                'email'     => 'abin111abin@gmail.com',
                'phone'     => '+918714439950',
                'password'  => Hash::make('123456'),
                'role'      => '0',
                'status'    => '1'
            ],
            [
                'name'      => 'Principal',
                'user_name' => 'admin',
                'email'     => 'admin@gmail.com',
                'phone'     => '+910000000000',
                'password'  => Hash::make('123456'),
                'role'      => '1',
                'status'    => '1'
            ],
            [
                'name'      => 'Employee',
                'user_name' => 'employee',
                'email'     => 'employee@gmail.com',
                'phone'     => '+911000000000',
                'password'  => Hash::make('123456'),
                'role'      => '2',
                'status'    => '1'
            ]
        ]);
    }
}
