<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('barang')?->id ?? $this->route('barang');
        return [
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'kategori_id' => 'required|exists:kategori,id',
            'supplier_id' => 'nullable|exists:supplier,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique' => 'Kode barang sudah terdaftar.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'stok_minimum.required' => 'Stok minimum wajib diisi.',
            'stok_minimum.integer' => 'Stok minimum harus berupa bilangan bulat.',
            'satuan.required' => 'Satuan barang wajib diisi.',
            'kategori_id.required' => 'Kategori barang wajib dipilih.',
            'kategori_id.exists' => 'Kategori barang tidak valid.',
            'supplier_id.exists' => 'Supplier tidak valid.',
        ];
    }
}
