<?php

use App\Models\User;

it('renders the once events page', function () {
    $this->actingAs(User::factory()->create());

    $page = visit('/features/events/once-events');

    $page->assertSee('Inertia.once')
        ->assertSee('Register once listeners')
        ->assertSee('Compare with router.on')
        ->assertSee('Event Log')
        ->assertSee('v3.2')
        ->assertNoJavaScriptErrors();
});

it('fires once(success) after registering and reloading', function () {
    $this->actingAs(User::factory()->create());

    $page = visit('/features/events/once-events');

    $page->click('[data-test="register-once-success"]')
        ->waitForText('Registered router.once', 5)
        ->click('Reload page')
        ->waitForText('once(success) fired', 10)
        ->assertNoJavaScriptErrors();
});
