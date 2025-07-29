<?php

namespace Tests;

use App\Models\Bonus;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;

class MockEmployee
{
    public $id = 20;
    public $name = 'MockEmployee';
}

class TestHelpers
{
    static function makeJobTitle($forEmployee)
    {
        JobTitle::create([
            'name' => 'TestJobTitle',
            'insurance_payout' => 0.30,
        ]);
        $jobTitle = JobTitle::where('name', 'TestJobTitle')->first();
        $forEmployee->job_title_id = $jobTitle->id;
        return $jobTitle;
    }
    static function makeBonuses($forEmployee)
    {
        Bonus::create([
            'date' => '2024-01-02',
            'sum' => '10200.24',
            'employee_id' => $forEmployee->id,
        ]);
        Bonus::create([
            'date' => '2024-03-15',
            'sum' => '10302.12',
            'employee_id' => $forEmployee->id,
        ]);
        return Bonus::where('employee_id', $forEmployee->id)->get();
    }
    static function makeEmployee()
    {
        Employee::create([
            'name' => 'TestEmployee',
            'salary' => '123456.00',
            'job_title_id' => null,
        ]);

        return Employee::where('name', 'TestEmployee')->first();
    }
    static function makeMockEmployee()
    {
        return new MockEmployee();
    }

    static function makeUser()
    {
        User::create([
            'name' => 'TestUser',
            'email' => 'a@b.cd',
            'password' => Hash::make('123')
        ]);
        return User::where('name', 'TestUser')->first();
    }
    static function getToken(User $user) {
        return $user->createToken('Test')->plainTextToken;
    }
}
