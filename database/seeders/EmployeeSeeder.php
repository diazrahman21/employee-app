<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            ['nama' => 'Jane Doe', 'kota' => 'Madrid', 'pekerjaan' => 'Programmer'],
            ['nama' => 'Adam Smith', 'kota' => 'London', 'pekerjaan' => 'UI/UX Designer'],
            ['nama' => 'Steven Berk', 'kota' => 'Madrid', 'pekerjaan' => 'System Analyst'],
            ['nama' => 'John Drink Water', 'kota' => 'Jakarta', 'pekerjaan' => 'Programmer'],
            ['nama' => 'Alphonse Calman', 'kota' => 'Paris', 'pekerjaan' => 'UI/UX Designer'],
            ['nama' => 'Paulo Verbose', 'kota' => 'Jakarta', 'pekerjaan' => 'System Analyst'],
            ['nama' => 'Rebecca Bernardo', 'kota' => 'Paris', 'pekerjaan' => 'Programmer'],
            ['nama' => 'Luis Petrucci', 'kota' => 'London', 'pekerjaan' => 'System Analyst'],
            ['nama' => 'Frank Bethoveen', 'kota' => 'Madrid', 'pekerjaan' => 'UI/UX Designer'],
            ['nama' => 'Calumn Sweet', 'kota' => 'Jakarta', 'pekerjaan' => 'UI/UX Designer'],
            ['nama' => 'Edward Campbell', 'kota' => 'Lisbon', 'pekerjaan' => 'Programmer'],
            ['nama' => 'Harry Potter', 'kota' => 'Jakarta', 'pekerjaan' => 'UI/UX Designer'],
            ['nama' => 'Gilberto', 'kota' => 'Lisbon', 'pekerjaan' => 'System Analyst'],
            ['nama' => 'Luka Smitic', 'kota' => 'Madrid', 'pekerjaan' => 'Programmer'],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
