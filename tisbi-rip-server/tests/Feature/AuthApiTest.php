<?php

use Tests\TestHelpers;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can_login_by_password', function () {
    $user = TestHelpers::makeUser();

    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->postJson('/api/user/login_by_pass', ['email' => $user->email, 'password' => '123']);

    $response->assertStatus(200)->assertJsonPath('data.username', $user->name);
});
test('cannot_login_by_incorrect_password', function () {
    $user = TestHelpers::makeUser();

    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->postJson('/api/user/login_by_pass', ['email' => $user->email, 'password' => 'ObviouslyFakePassword']);

    $response->assertStatus(401);
});
test('can_login_by_token', function () {
    $user = TestHelpers::makeUser();
    $token = TestHelpers::getToken($user);

    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->postJson('/api/user/login_by_token', ['token' => $token]);

    $response->assertStatus(200)->assertJsonPath('data.username', $user->name);
});
test('cannot_login_by_incorrect_token', function () {
    $user = TestHelpers::makeUser();
    $token = '1|ObviouslyFakeToken';

    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->postJson('/api/user/login_by_token', ['token' => $token]);

    $response->assertStatus(401);
});
