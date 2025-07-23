<?php

use App\Models\Employee;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestHelpers;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('unauthenticated_user_cannot_access_api', function () {
    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])->get('/api/employees');

    $response->assertStatus(401);
});
test('can_show_employee', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $employee = TestHelpers::makeEmployee();
    $id = $employee->id;

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
        ->withToken($token)
        ->get("/api/employees/$id");

    $response
        ->assertStatus(200);

    $response
        ->assertJson([
            'id' => $id,
            'name' => $employee->name,
        ]);
});
test('can_create_employee', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $jobTitle = TestHelpers::makeJobTitle(TestHelpers::makeMockEmployee());
    $name = 'TestEmployee';
    $salary = '123456.01';

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
        ->withToken($token)
        ->postJson("/api/employees/", ['name' => $name, 'salary' => $salary, 'job_title_id' => $jobTitle->id]);

    $response->assertStatus(200);
    $response->assertJson([
        'name' => $name,
        'salary' => $salary
    ]);

    expect(Employee::where('name', $name)->count())->toBe(1);
});
test('cannot_duplicate_employee', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $employee = TestHelpers::makeEmployee();
    $jobTitle = TestHelpers::makeJobTitle($employee);

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->postJson("/api/employees/", ['name' => $employee->name, 'salary' => $employee->salary, 'job_title_id' => $jobTitle->id]);

    $response->assertStatus(400);

    expect(Employee::where('name', $employee->name)->count())->toBe(1);
});
test('can_update_employee', function() {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $employee = TestHelpers::makeEmployee();
    TestHelpers::makeJobTitle($employee);

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->patchJson("/api/employees/{$employee->id}", ['name' => 'updated', 'salary' => '11111.00', 'job_title_id' => $employee->jobTitle->id]);

    $response->assertStatus(200);
    expect(Employee::where('name', 'updated')->count())->toBe(1);
    expect(Employee::where('name', $employee->name)->count())->toBe(0);
});
test('can_delete_employee', function() {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $employee = TestHelpers::makeEmployee();

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->delete("/api/employees/{$employee->id}");

    $response->assertStatus(200);
    expect(Employee::where('name', 'TestEmployee')->count())->toBe(0);
});