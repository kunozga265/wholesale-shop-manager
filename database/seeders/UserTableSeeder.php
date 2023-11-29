<?php

namespace Database\Seeders;

use App\Http\Controllers\AppController;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $user = User::create([
            'first_name'    => 'Kunozga',
            'last_name'     => 'Mlowoka',
            'code'          => (new AppController())->generateUniqueCode(),
            'password'      => bcrypt("12345678")
        ]);
        $user->roles()->attach([1]);

        $user = User::create([
            'first_name'    => 'Daisy',
            'last_name'     => 'Manyenje',
            'shop_id'       => '1',
            'code'          => (new AppController())->generateUniqueCode(),
            'password'      => bcrypt("12345678")
        ]);
        $user->roles()->attach([2]);
    }
}
