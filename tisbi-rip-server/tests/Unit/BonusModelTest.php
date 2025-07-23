<?php

use Tests\TestHelpers;

uses(Tests\TestCase::class);
uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('test_bonus_creation', function () {
    $mockEmployee = TestHelpers::makeMockEmployee();
    $bonuses = TestHelpers::makeBonuses($mockEmployee);
    $bonus = $bonuses[0];
    expect($bonus->date)->toBe('2024-01-02');
    expect($bonus->sum)->toBe('10200.24');
});

test('test_bonus_employee_relationship', function () {
    $employee = TestHelpers::makeEmployee();
    $bonuses = TestHelpers::makeBonuses($employee);
    $bonus = $bonuses[0];
    expect($bonus->employee->name)->toBe('TestEmployee');
});
