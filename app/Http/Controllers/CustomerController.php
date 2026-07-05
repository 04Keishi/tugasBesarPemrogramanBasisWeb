<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $items = Customer::orderBy('id_customer')->get();

        return view('master.customer.index', compact('items'));
    }

    public function create()
    {
        return view('master.customer.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_customer' => ['required', 'string', 'max:20', 'unique:customer,id_customer'],
            'nama_rek'    => ['required', 'string', 'max:100'],
            'no_rek'      => ['nullable', 'string', 'max:50'],
            'alamat'      => ['nullable', 'string'],
        ]);

        Customer::create($data);

        return redirect()->route('customer.index')
            ->with('flash_success', 'Data customer berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = Customer::findOrFail($id);

        return view('master.customer.form', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $item = Customer::findOrFail($id);

        $data = $request->validate([
            'id_customer' => ['required', 'string', 'max:20', "unique:customer,id_customer,{$id},id_customer"],
            'nama_rek'    => ['required', 'string', 'max:100'],
            'no_rek'      => ['nullable', 'string', 'max:50'],
            'alamat'      => ['nullable', 'string'],
        ]);

        $item->update($data);

        return redirect()->route('customer.index')
            ->with('flash_success', 'Data customer berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        try {
            Customer::findOrFail($id)->delete();

            return redirect()->route('customer.index')
                ->with('flash_success', 'Data customer berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('customer.index')
                ->with('flash_error', 'Gagal menghapus (kemungkinan masih dipakai pada Project).');
        }
    }
}
