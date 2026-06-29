<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $items = Vendor::orderBy('id_vendor')->get();

        return view('master.vendor.index', compact('items'));
    }

    public function create()
    {
        return view('master.vendor.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        Vendor::create($data);

        return redirect()->route('vendor.index')
            ->with('flash_success', 'Data vendor berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $item = Vendor::findOrFail($id);

        return view('master.vendor.form', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $item = Vendor::findOrFail($id);
        $data = $this->validateData($request);

        $item->update($data);

        return redirect()->route('vendor.index')
            ->with('flash_success', 'Data vendor berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $vendor = Vendor::findOrFail($id);

        try {
            $vendor->delete();

            return redirect()->route('vendor.index')
                ->with('flash_success', 'Data vendor berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // FK restrictOnDelete: vendor yang masih dipakai pada Purchase Order tidak bisa dihapus.
            return redirect()->route('vendor.index')
                ->with('flash_error', 'Gagal menghapus: vendor masih terhubung dengan Purchase Order. Hapus PO terkait terlebih dahulu.');
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama_supplier' => ['required', 'string', 'max:150'],
            'pic'           => ['nullable', 'string', 'max:100'],
            'alamat'        => ['nullable', 'string'],
            'nohp_pic'      => ['nullable', 'string', 'max:30'],
            'no_telp'       => ['nullable', 'string', 'max:30'],
            'fax'           => ['nullable', 'string', 'max:30'],
        ]);
    }
}
