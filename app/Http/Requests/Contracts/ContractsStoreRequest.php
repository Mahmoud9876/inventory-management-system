<?php

namespace App\Http\Requests\Contracts;

use Illuminate\Foundation\Http\FormRequest;

class ContractsStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'product_id' => 'required',
            'payment_terms' => 'required',
            'ordered_quantity' => 'required|integer',
            'unit_price' => 'required|numeric',
            'contract_terms' => 'required',
        ];
    }
}
