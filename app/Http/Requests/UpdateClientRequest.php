<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => "sometimes|required|email|unique:clients,email,{$id}",
            'phone' => 'nullable|string|max:30',
            'cpf' => 'nullable|string|max:20',
        ];
    }
}
