<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user has points attribute', function () {
    $user = User::factory()->create();
    expect($user->points)->toBe(0);
});

test('user can add points', function () {
    $user = User::factory()->create();
    $user->addPoints(100, 'Test earn');
    
    expect($user->fresh()->points)->toBe(100);
    $this->assertDatabaseHas('point_transactions', [
        'user_id' => $user->id,
        'amount' => 100,
        'type' => 'earn',
        'description' => 'Test earn',
    ]);
});

test('user can redeem points', function () {
    $user = User::factory()->create(['points' => 200]);
    $user->redeemPoints(50, 'Test redeem');
    
    expect($user->fresh()->points)->toBe(150);
    $this->assertDatabaseHas('point_transactions', [
        'user_id' => $user->id,
        'amount' => -50,
        'type' => 'redeem',
        'description' => 'Test redeem',
    ]);
});

test('user cannot redeem insufficient points', function () {
    $user = User::factory()->create(['points' => 10]);
    
    expect(fn() => $user->redeemPoints(20))
        ->toThrow(Exception::class, 'Insufficient points');
        
    expect($user->fresh()->points)->toBe(10);
});
