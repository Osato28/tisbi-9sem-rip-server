<?php

use App\Models\Bonus;
use Tests\TestCase;
use App\Models\Employee;
use App\Models\JobTitle;
use Tests\TestHelpers;

uses(TestCase::class);
uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('test_employee_creation', function() {
    $employee = TestHelpers::makeEmployee();
    expect(Employee::where('name', 'TestEmployee')->count())->toBe(1);
    expect($employee->name)->toBe('TestEmployee');
    expect($employee->salary)->toBe('123456.00');
});

test('test_employee_job_title_relationship', function() {
    $employee = TestHelpers::makeEmployee();
    $jt = TestHelpers::makeJobTitle($employee);
    expect($jt->name)->toBe('TestJobTitle');
});

test('test_employee_bonuses_relationship', function() {
    $employee = TestHelpers::makeEmployee();
    $bonuses = TestHelpers::makeBonuses($employee);
    expect($bonuses[0]->sum)->toBe('10200.24');
    expect($bonuses[1]->date)->toBe('2024-03-15');
});