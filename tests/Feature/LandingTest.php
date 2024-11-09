<?php

it('tests that the .env key are same across all .env files.', function (): void {
    $this->artisan('env:keys-check --auto-add=none')->assertExitCode(0);
});

it('returns a successful response to landing', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('tests that the landing page have different section', function (): void {
    $response = $this->get('/');

    $response->assertSeeVolt('hero');
    $response->assertSee('why-us');
    $response->assertSee('how-it-works');
    $response->assertSee('footer');
});

it('returns a successful response to terms page', function (): void {
    $response = $this->get('/terms');

    $response->assertStatus(200);
});

it('tests that the terms page have different section', function (): void {
    $response = $this->get('/terms');

    $response->assertSee('terms');
    $response->assertSee('use-license');
    $response->assertSee('disclaimer');
    $response->assertSee('footer');
});

it('returns a successful response to privacy page', function (): void {
    $response = $this->get('/privacy');

    $response->assertStatus(200);
});

it('tests that the privacy page have different section', function (): void {
    $response = $this->get('/privacy');

    $response->assertSee('privacy');
    $response->assertSee('securing-api-keys');
    $response->assertSee('footer');
});
