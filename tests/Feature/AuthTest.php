<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login redirects to inteded page', function() {

    User::create([
        'name' => 'User',
        'email' => 'user@test.com',
        'password' => bcrypt('password123')
    ]);

    $response = $this->post('/login', [
        'email' => 'user@test.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/');
});

test('login failed', function () {
    $response = $this->post('/login', [
        'email' => 'saheer@test.com',
        'password' => 'wrong-password',
    ]);

    // User should not be authenticated
    $this->assertGuest();

    // // Assert redirect back (Laravel usually redirects back on failed login)
    $response->assertStatus(302);

    // Assert validation/auth errors exist in session
    $response->assertSessionHasErrors();
});

test('unauthenticated users cannot access realtor listing create page ', function () {
    $response = $this->get('realtor/listing/create');

    $response->assertRedirect('login');
    $response->assertStatus(302);
});
