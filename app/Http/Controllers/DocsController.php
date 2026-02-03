<?php
namespace App\Http\Controllers;

class DocsController
{
    public function swagger()
    {
        $path = base_path('openapi/swagger.yaml');
        if (!file_exists($path)) {
            return response('Not found', 404);
        }
        return response()->file($path, ['Content-Type' => 'application/x-yaml']);
    }
}
