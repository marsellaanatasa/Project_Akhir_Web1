<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembelianRequest extends FormRequest
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
        $id = $this->route('pembelian')?->id ?? $this->route('pembelian');
        return [
            'nomor_faktur' => 'required|string|max:255|unique:pembelian,nomor_faktur,' . $id,
            'supplier_id' => 'required|exists:supplier,id',
            'tanggal_pembelian' => 'required|date',
            'catatan' => 'nullable|string',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barang,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'harga_beli' => 'required|array|min:1',
            'harga_beli.*' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nomor_faktur.required' => 'Nomor faktur wajib diisi.',
            'nomor_faktur.unique' => 'Nomor faktur sudah terdaftar.',
            'supplier_id.required' => 'Supplier wajib dipilih.',
            'supplier_id.exists' => 'Supplier tidak valid.',
            'tanggal_pembelian.required' => 'Tanggal pembelian wajib diisi.',
            'tanggal_pembelian.date' => 'Format tanggal pembelian tidak valid.',
            'barang_id.required' => 'Minimal harus ada 1 barang yang dibeli.',
            'barang_id.*.exists' => 'Barang yang dipilih tidak valid.',
            'jumlah.*.required' => 'Jumlah barang wajib diisi.',
            'jumlah.*.integer' => 'Jumlah barang harus berupa angka.',
            'jumlah.*.min' => 'Jumlah barang minimal 1.',
            'harga_beli.*.required' => 'Harga beli wajib diisi.',
            'harga_beli.*.numeric' => 'Harga beli harus berupa angka.',
            'harga_beli.*.min' => 'Harga beli minimal 0.',
        ];
    }
}
