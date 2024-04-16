<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StoreInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_image'     => 'image|file|max:2048',
            'name'              => 'required|string',
            'category_id'       => 'required|integer',
            'unit_id'           => 'required|integer',
            'quantity'          => 'required|integer',
            'selling_price'     => 'required|integer',
            'tax'               => 'nullable|numeric',
            'tax_type'          => 'nullable|integer',
            'stock_phy' => 'nullable|integer'

        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name, '-'),
            'code' => IdGenerator::generate([
                'table' => 'inventory',
                'field' => 'code',
                'length' => 4,
                'prefix' => 'INV'
            ]),
        ]);
    }
}
