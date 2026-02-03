<?php
use Tests\TestCase;
use App\Services\ClientService;
use App\Repositories\ClientRepository;

uses(Tests\TestCase::class);

beforeEach(function () {
    $this->repo = new ClientRepository();
    $this->service = new ClientService($this->repo);
});

it('creates and retrieves client via service', function () {
    $data = ['name' => 'Service Test', 'email' => 's@test.com'];
    $client = $this->service->create($data);
    $fetched = $this->service->get($client->id);
    expect($fetched->email)->toBe('s@test.com');
});
