<?php
namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Services\ClientService;
use App\Models\Client;

class ClientController extends Controller
{
    public function __construct(protected ClientService $service)
    {
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $data = $request->validated();
        $client = $this->service->create($data);
        return response()->json(['data' => $client], 201);
    }

    public function index(): JsonResponse
    {
        $filters = request()->only(['name','email']);
        $perPage = request()->get('per_page', 15);
        $result = $this->service->list($filters, $perPage);
        return response()->json($result);
    }

    public function show($id): JsonResponse
    {
        $client = $this->service->get((int)$id);
        if (!$client) return response()->json(['message' => 'Not found'], 404);
        return response()->json(['data' => $client]);
    }

    public function update(UpdateClientRequest $request, $id): JsonResponse
    {
        $client = $this->service->get((int)$id);
        if (!$client) return response()->json(['message' => 'Not found'], 404);
        $updated = $this->service->update($client, $request->validated());
        return response()->json(['data' => $updated]);
    }

    public function destroy($id): JsonResponse
    {
        $client = $this->service->get((int)$id);
        if (!$client) return response()->json(['message' => 'Not found'], 404);
        $this->service->delete($client);
        return response()->json(null, 204);
    }
}
