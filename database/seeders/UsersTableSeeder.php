<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user1'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        User::create([
            'name' => 'user2',
            'email' => 'user2@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user2'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'created_at' => now(),
            'updated_at' => now()
        ]);


    }
}
