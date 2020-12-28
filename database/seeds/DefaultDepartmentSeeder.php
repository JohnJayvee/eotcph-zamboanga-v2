<?php

use App\Laravel\Models\Department;
use Illuminate\Database\Seeder;

class DefaultDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::truncate();
        Department::create(['name' => 'Office of the City Health' , 'code' => '01']);
        Department::create(['name' => 'Office of the City Engineer' , 'code' => '02']);
        Department::create(['name' => 'Bureau of Fire Protection' , 'code' => '03']);
        Department::create(['name' => 'Barangay','code' => '4']);
        Department::create(['name' => 'Office of the City Veterinarian' , 'code' => '07']);
        Department::create(['name' => 'Office of the City Agriculturist' , 'code' => '09']);
        Department::create(['name' => 'Office of the City Planning and Development' , 'code' => '10']);
        Department::create(['name' => 'Office of the City Treasurer' , 'code' => '99']);
        Department::create(['name' => 'Office of the City Mayor-Tourism Division' , 'code' => '11']);
    }
}
