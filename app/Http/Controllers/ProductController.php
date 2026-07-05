<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        $items = Product::orderBy('id_product')->get();

        return view('master.product.index', compact('items'));
    }

    public function create()
    {
        return view('master.product.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->prepare($request);

        Product::create($data);

        return redirect()->route('product.index')
            ->with('flash_success', 'Data produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $item = Product::findOrFail($id);

        return view('master.product.form', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $item = Product::findOrFail($id);
        $data = $this->prepare($request, $id);

        $item->update($data);

        return redirect()->route('product.index')
            ->with('flash_success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);

        try {
            $product->delete();

            return redirect()->route('product.index')
                ->with('flash_success', 'Data produk berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // FK restrictOnDelete: produk yang sudah dipakai di Detail PO tidak bisa dihapus.
            return redirect()->route('product.index')
                ->with('flash_error', 'Gagal menghapus: produk masih terhubung dengan Detail PO. Hapus item Detail PO terkait terlebih dahulu.');
        }
    }

    /**
     * Validasi produk.
     *
     * Aturan:
     *  - "harga" adalah harga satuan produk (Rupiah), ditampilkan di master
     *    produk dan dipakai sebagai harga acuan pada Detail PO.
     *  - Produk yang diproduksi sendiri (vendor dikosongkan) otomatis memakai
     *    nama "PT Garda Integra Solusindo".
     *  - Produk dengan deskripsi sama TAPI vendor berbeda = item baru (boleh).
     *  - Produk dengan deskripsi + vendor yang sama persis = duplikat (ditolak).
     */
    private function prepare(Request $request, ?int $id = null): array
    {
        $validated = $request->validate([
            'deskripsi'   => ['required', 'string', 'max:255'],
            'harga'       => ['nullable', 'string', 'max:30'],
            'nama_vendor' => ['nullable', 'string', 'max:150'],
        ]);

        // Normalisasi harga: terima format "1.000.000" / "1000000" -> angka.
        $hargaRaw = (string) ($validated['harga'] ?? '');
        $validated['harga'] = (float) str_replace(['.', ','], ['', '.'], $hargaRaw !== '' ? $hargaRaw : '0');

        // Kosong -> produksi sendiri.
        $vendor = trim((string) ($validated['nama_vendor'] ?? ''));
        $validated['nama_vendor'] = $vendor !== '' ? $vendor : Product::VENDOR_SENDIRI;

        // Cek duplikat kombinasi deskripsi + vendor (abaikan baris yang sedang diedit).
        $exists = Product::where('deskripsi', $validated['deskripsi'])
            ->where('nama_vendor', $validated['nama_vendor'])
            ->when($id, fn ($q) => $q->where('id_product', '!=', $id))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'nama_vendor' => 'Produk dengan deskripsi dan vendor yang sama sudah ada.',
            ]);
        }

        return $validated;
    }
}
