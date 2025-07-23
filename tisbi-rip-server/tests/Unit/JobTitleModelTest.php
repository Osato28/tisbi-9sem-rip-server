<?php

use App\Models\Employee;
use App\Models\JobTitle;
use Tests\TestHelpers;

uses(Tests\TestCase::class);
uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('test_job_title_creation', function () {
    $mockEmployee = TestHelpers::makeMockEmployee();
    $jobTitle = TestHelpers::makeJobTitle($mockEmployee);
    expect($jobTitle->name)->toBe('TestJobTitle');
});

test('test_job_title_employees_relationship', function () {
    $jobTitle = JobTitle::factory()->has(
        Employee::factory()->count(2)->sequence(
            ['salary' => '40000.00'],
            ['salary' => '50000.00']
        )
    )->create(['name' => 'TestJobTitle']);
    expect($jobTitle->employees->count())->toBe(2);
    expect($jobTitle->employees[0]->name)->not->toBeEmpty();
});
