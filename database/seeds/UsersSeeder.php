<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@yahoo.com',
            'password' => '$2y$10$8lluysYBzL20KobNG/tE5e/KYOef/I2HX617Az7AcGkS7Thdnb/8i',
            'role' => 'admin',
            'confirmation_status' => 1,
            'account_no' => 1023456,
         ]);
    }
}
