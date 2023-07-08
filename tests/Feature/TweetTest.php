<?php


use App\Http\Livewire\Tweet\Create;
use App\Models\User;
use App\Models\Tweet;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('should be able to creat a tweet', function () {

    $user = User::factory()->create();

    Pest\Laravel\actingAs($user);

        livewire(Create::class)
        ->set('body', 'This is my first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created');

    \Pest\Laravel\assertDatabaseCount('tweets', 1);

    expect(Tweet::first())
        ->body
        ->toBe('This is my first tweet');
});

it('should make sure that only authenticated users can tweet', function () {
    livewire(Create::class)
        ->set('body', 'This is my first tweet')
        ->call('tweet')
        ->assertForbidden();

    actingAs(User::factory()->create());

    livewire(Create::class)
        ->set('body', 'This is my first tweet')
        ->call('tweet')
        ->assertEmitted('tweet::created');


});

todo('body is required');

todo('the tweet body should have a max lenght of 255 characters');

todo('should show the tweet on the timeline');
