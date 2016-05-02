<?php

use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder {

    public function run()
    {
        /*User::create([
            'first_name' => 'Juan',
            'last_name'  => 'Rosas',
            'username'   => 'juan.rosas@citriom.com',
            'email'      => 'juan.rosas@citriom.com',
            'password'   =>  Hash::make('123456')
        ]);*/
        User::create([
            'first_name' => 'Pedro',
            'last_name'  => 'Escalante',
            'username'   => 'pedro.escalante@citriom.com',
            'email'      => 'pedro.escalante@citriom.com',
            'password'   =>  Hash::make('secret')
        ]);
    }

}
