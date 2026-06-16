<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjualanRequest extends FormRequest
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
        $id = $this->route('penjualan')?->id ?? $this->route('penjualan');
        return [
            'nomor_faktur' => 'required|string|max:255|unique:penjualan,nomor_faktur,' . $id,
            'nama_pelanggan' => 'nullable|string|max:255',
            'telepon_pelanggan' => 'nullable|string|max:50',
            'tanggal_penjualan' => 'required|date',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'catatan' => 'nullable|string',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barang,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
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
            'tanggal_penjualan.required' => 'Tanggal penjualan wajib diisi.',
            'tanggal_penjualan.date' => 'Format tanggal penjualan tidak valid.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid.',
            'barang_id.required' => 'Minimal harus ada 1 barang yang dijual.',
            'barang_id.*.exists' => 'Barang yang dipilih tidak valid.',
            'jumlah.*.required' => 'Jumlah barang wajib diisi.',
            'jumlah.*.integer' => 'Jumlah barang harus berupa angka.',
            'jumlah.*.min' => 'Jumlah barang minimal 1.',
        ];
    }
}
