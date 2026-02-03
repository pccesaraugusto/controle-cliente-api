<?php
use Tests\TestCase;
use App\Models\Client;
use App\Repositories\ClientRepository;

uses(Tests\TestCase::class);

beforeEach(function () {
    $this->repo = new ClientRepository();
});

it('creates a client', function () {
    $data = ['name' => 'Test', 'email' => 't@test.com'];
    $client = $this->repo->create($data);
    expect($client->id)->toBeInt();
    expect($client->email)->toBe('t@test.com');
});
