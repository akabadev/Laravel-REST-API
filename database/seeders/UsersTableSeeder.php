<?php

namespace Database\Seeders;

use App\Models\Profile;
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
        User::create(
            [
                'name' => 'John Doe',
                'email' => 'john.doe@logiweb.com',
                'password' => Hash::make("password"),
                'email_verified_at' => now(),
                'profile_id' => Profile::find("ADMIN")->id
            ]
        );
        User::create(
            [
                'name' => 'abdou Kaba',
                'email' => 'akabadev@gmail.com',
                'password' => Hash::make("Logiweb2021*"),
                'email_verified_at' => now(),
                'profile_id' => Profile::find('ADMIN')->id
            ]
        );

        User::factory(10)->profiled()->create();
    }
}
