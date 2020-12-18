<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminAccountSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(DefaultApplicationSeeder::class);
        $this->call(ViolationSeeder::class);
        $this->call(DefaultDepartmentSeeder::class);

    }
}
