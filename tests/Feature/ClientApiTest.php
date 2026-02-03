<?php
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class)->group('feature');

it('returns 200 for clients index', function () {
    $this->get('/api/clients')->assertStatus(200);
});
