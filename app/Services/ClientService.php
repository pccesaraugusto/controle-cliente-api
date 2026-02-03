<?php
namespace App\Services;

use App\Repositories\ClientRepository;
use App\Models\Client;

class ClientService
{
    public function __construct(protected ClientRepository $repo)
    {
    }

    public function create(array $data): Client
    {
        return $this->repo->create($data);
    }

    public function get(int $id): ?Client
    {
        return $this->repo->find($id);
    }

    public function list(array $filters = [], int $perPage = 15)
    {
        return $this->repo->paginate($filters, $perPage);
    }

    public function update(Client $client, array $data): Client
    {
        return $this->repo->update($client, $data);
    }

    public function delete(Client $client): bool
    {
        return $this->repo->delete($client);
    }
}
