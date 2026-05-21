<?php

use App\Models\User;

it('renders the polling page with live data', function () {
    $this->actingAs(User::factory()->create());

    $page = visit('/features/data-loading/polling');

    $page->assertSee('Polling')
        ->assertSee('Polling Controls')
        ->assertSee('Live Data')
        ->assertSee('Start Polling')
        ->assertSee('Server Time')
        ->assertNoJavaScriptErrors();
});

it('exposes the poll mode toggle (overlap/cancel/rest)', function () {
    $this->actingAs(User::factory()->create());

    $page = visit('/features/data-loading/polling');

    $page->assertSee('Mode')
        ->assertSee('v3.2')
        ->assertSee('overlap')
        ->assertSee('cancel')
        ->assertSee('rest')
        ->click('cancel')
        ->assertSee('Aborts the in-flight request')
        ->click('rest')
        ->assertSee('Waits the interval after each response')
        ->assertNoJavaScriptErrors();
});

it('toggles polling and increments the poll count', function () {
    $this->actingAs(User::factory()->create());

    $page = visit('/features/data-loading/polling');

    $page->assertSee('Stopped')
        ->click('Start Polling')
        ->assertSee('Active')
        ->waitForText('Stop Polling', 10)
        ->click('Stop Polling')
        ->assertSee('Stopped')
        ->assertNoJavaScriptErrors();
});
