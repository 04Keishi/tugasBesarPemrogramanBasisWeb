<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $items = Pegawai::orderBy('id_pegawai')->get();

        return view('master.pegawai.index', compact('items'));
    }

    public function create()
    {
        return view('master.pegawai.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_pegawai'   => ['required', 'string', 'max:20', 'unique:pegawai,id_pegawai'],
            'nama_pegawai' => ['required', 'string', 'max:100'],
            'jabatan'      => ['required', 'string', 'max:100'],
        ]);

        Pegawai::create($data);

        return redirect()->route('pegawai.index')
            ->with('flash_success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = Pegawai::findOrFail($id);

        return view('master.pegawai.form', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $item = Pegawai::findOrFail($id);

        $data = $request->validate([
            'id_pegawai'   => ['required', 'string', 'max:20', "unique:pegawai,id_pegawai,{$id},id_pegawai"],
            'nama_pegawai' => ['required', 'string', 'max:100'],
            'jabatan'      => ['required', 'string', 'max:100'],
        ]);

        $item->update($data);

        return redirect()->route('pegawai.index')
            ->with('flash_success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        try {
            Pegawai::findOrFail($id)->delete();

            return redirect()->route('pegawai.index')
                ->with('flash_success', 'Data pegawai berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('pegawai.index')
                ->with('flash_error', 'Gagal menghapus (kemungkinan masih dipakai pada transaksi).');
        }
    }
}
