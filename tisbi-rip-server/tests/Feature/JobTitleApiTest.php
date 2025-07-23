<?php

use App\Models\Bonus;
use App\Models\JobTitle;
use Tests\TestHelpers;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('unauthenticated_user_cannot_access_api', function () {
    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])->get('/api/job_titles');

    $response->assertStatus(401);
});
test('can_show_job_title', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $jobTitle = TestHelpers::makeJobTitle(TestHelpers::makeMockEmployee());
    $id = $jobTitle->id;

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
        ->withToken($token)
        ->get("/api/job_titles/$id");

    $response
        ->assertStatus(200);

    $response
        ->assertJson([
            'id' => $id,
            'name' => $jobTitle->name,
        ]);
});
test('can_create_job_title', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $name = 'TestJobTitle';

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
        ->withToken($token)
        ->postJson("/api/job_titles/", ['name' => $name]);

    $response->assertStatus(200);
    $response->assertJson([
        'name' => $name
    ]);

    expect(JobTitle::where('name', $name)->count())->toBe(1);
});
test('cannot_duplicate_job_title', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);
    $jobTitle = TestHelpers::makeJobTitle(TestHelpers::makeEmployee());

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->postJson("/api/job_titles/", ['name' => $jobTitle->name]);

    $response->assertStatus(400);

    expect(JobTitle::where('name', $jobTitle->name)->count())->toBe(1);
});
test('can_update_job_title', function() {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);
    $jobTitle = TestHelpers::makeJobTitle(TestHelpers::makeEmployee());

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->patchJson("/api/job_titles/{$jobTitle->id}", ['name' => 'abcde']);

    $response->assertStatus(200);
    expect(JobTitle::where('name', 'abcde')->count())->toBe(1);
    expect(JobTitle::where('name', $jobTitle->name)->count())->toBe(0);
});
test('can_delete_job_title', function() {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);
    $jobTitle = TestHelpers::makeJobTitle(TestHelpers::makeMockEmployee());

    expect(JobTitle::where('name', $jobTitle->name)->count())->toBe(1);

    $response = $this->withHeaders([
        'Accept' => 'application/json'
    ])
    ->withToken($token)
    ->delete("/api/job_titles/{$jobTitle->id}");

    $response->assertStatus(200);
    expect(JobTitle::where('name', $jobTitle->name)->count())->toBe(0);
});