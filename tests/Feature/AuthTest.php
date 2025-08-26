<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login_redirects_to_inteded_page', function() {

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

test('unauthenticated users cannot access realtor listing create page ', function () {
    $response = $this->get('realtor/listing/create');

    $response->assertRedirect('login');
    $response->assertStatus(302);
});
