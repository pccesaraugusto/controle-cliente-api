<?php
namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function find(int $id): ?Client
    {
        return Client::find($id);
    }

    public function paginate(array $filters = [], int $perPage = 15)
    {
        $query = Client::query();
        if (!empty($filters['name'])) {
            $query->where('name', 'like', "%{$filters['name']}%");
        }
        if (!empty($filters['email'])) {
            $query->where('email', $filters['email']);
        }
        return $query->paginate($perPage);
    }

    public function update(Client $client, array $data): Client
    {
        $client->update($data);
        return $client;
    }

    public function delete(Client $client): bool
    {
        return $client->delete();
    }
}
