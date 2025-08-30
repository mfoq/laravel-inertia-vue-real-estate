<?php

use App\Models\User;
use App\Models\Listing;
use Inertia\Testing\AssertableInertia as Inertia;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// beforeEach(function () {

//     $user = User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'test@example.com',
//             'is_admin' => true,
//         ]);

//     Listing::factory()->count(20)->create([
//             'by_user_id' => $user
//     ]);
// });

test('first listing page contains 10 items', function () {

     $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

    Listing::factory()->count(20)->create(['by_user_id' => $user]);

    $response = $this->get('/listing');

    $response->assertStatus(200);

    $response->assertInertia(fn (Inertia $page) =>
        $page
            ->component('Listing/Index')
            ->has('listings.data', 10) // first page items
            ->where('listings.total', 20) // total items seeded
            ->where('listings.current_page', 1)
            ->where('listings.per_page', 10)
    );
});

test('second listing page contains remaining 10 items', function () {

     $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

    Listing::factory()->count(20)->create(['by_user_id' => $user]);

    $response = $this->get('/listing?page=2');

    $response->assertStatus(200);

    $response->assertInertia(fn (Inertia $page) =>
        $page
            ->component('Listing/Index')
            ->has('listings.data', 10) // second page items
            ->where('listings.total', 20)
            ->where('listings.current_page', 2)
            ->where('listings.per_page', 10)
    );
});

test('listing page works with fewer items than page size', function () {
    $user = User::factory()->create();

    Listing::factory()->count(5)->create(['by_user_id' => $user->id]);

    $response = $this->get('/listing');

    $response->assertStatus(200);

    $response->assertInertia(fn (Inertia $page) =>
        $page
            ->component('Listing/Index')
            ->has('listings.data', 5)
            ->where('listings.total', 5)
            ->where('listings.current_page', 1)
            ->where('listings.per_page', 10)
    );
});

test('successfully creating listing by realtor', function () {
    $user = User::factory()->create(['is_admin' => 1]);

    $listing = [
        'beds' => 2,
        'baths' => 1,
        'area' => 120,
        'city' => 'Amman',
        'code' => 11937,
        'street' => "Moh'd shbailat",
        'street_nr' => 200,
        'price' => 20000,
    ];

    $response = $this->actingAs($user)->post(route('realtor.listing.store'), $listing);

    $response->assertStatus(302);
    $response->assertRedirect(route('realtor.listing.index'));
    $response->assertSessionHas('success', 'Listing Created Successfully!');

    $this->assertDatabaseHas('listings', [
        'city' => 'Amman',
        'price' => 20000,
        'by_user_id' => $user->id,
    ]);

    $lastListing = Listing::latest()->first();
    $this->assertEquals($listing['city'], $lastListing->city);
    $this->assertEquals($listing['price'], $lastListing->price);
});
