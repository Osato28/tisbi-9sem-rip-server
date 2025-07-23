<?php

use App\Models\Bonus;
use Tests\TestHelpers;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('unauthenticated_user_cannot_access_api', function () {
    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])->get('/api/bonuses');

    $response->assertStatus(401);
});
test('can_show_bonus', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $bonus = TestHelpers::makeBonuses(TestHelpers::makeMockEmployee())[0];
    $id = $bonus->id;

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
        ->withToken($token)
        ->get("/api/bonuses/$id");

    $response
        ->assertStatus(200);

    $response
        ->assertJson([
            'id' => $id,
            'date' => $bonus->date,
        ]);
});
test('can_create_bonus', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $employee = TestHelpers::makeEmployee();
    $date = '2021-01-14';

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
        ->withToken($token)
        ->postJson("/api/bonuses/", ['date' => $date, 'sum' => '20000.00', 'employee_id' => $employee->id]);

    $response->assertStatus(200);
    $response->assertJson([
        'date' => '2021-01-14', 
        'sum' => '20000.00'
    ]);

    expect(Bonus::where('date', $date)->count())->toBe(1);
});
test('can_add_duplicate_bonus', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);
    $bonus = TestHelpers::makeBonuses(TestHelpers::makeEmployee())[0];

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->postJson("/api/bonuses/", ['date' => $bonus->date, 'sum' => $bonus->sum, 'employee_id' => $bonus->employee->id]);

    $response->assertStatus(200);

    expect(Bonus::where('date', $bonus->date)->count())->toBe(2);
});
test('can_update_bonus', function() {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);
    $bonus = TestHelpers::makeBonuses(TestHelpers::makeEmployee())[0];

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->patchJson("/api/bonuses/{$bonus->id}", ['date' => '2422-01-12', 'sum' => '11111.00', 'employee_id' => $bonus->employee->id]);

    $response->assertStatus(200);
    expect(Bonus::where('date', '2422-01-12')->count())->toBe(1);
    expect(Bonus::where('date', $bonus->date)->count())->toBe(0);
});
test('can_delete_bonus', function() {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);
    $bonus = TestHelpers::makeBonuses(TestHelpers::makeMockEmployee())[0];

    expect(Bonus::where('date', $bonus->date)->where('sum', $bonus->sum)->count())->toBe(1);

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->delete("/api/bonuses/{$bonus->id}");

    $response->assertStatus(200);
    expect(Bonus::where('date', $bonus->date)->where('sum', $bonus->sum)->count())->toBe(0);
});