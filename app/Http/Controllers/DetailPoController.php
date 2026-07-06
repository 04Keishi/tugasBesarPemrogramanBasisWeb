<?php

namespace App\Http\Controllers;

use App\Models\DetailPo;
use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class DetailPoController extends Controller
{
    /** Tampilkan rincian item untuk satu PO. */
    public function index(Request $request)
    {
        $id_po = (int) $request->query('id_po', 0);

        $po = $id_po
            ? PurchaseOrder::with(['project', 'vendor'])->find($id_po)
            : null;

        $items = collect();
        if ($po) {
            $items = $po->details()->with('product')->orderBy('id_detail')->get();
        }

        $subTotal = (float) $items->sum('subtotal_final');
        $ppn = round($subTotal * 0.11);
        $grand = $subTotal + $ppn;

        return view('transaksi.detail_po.index', compact('po', 'id_po', 'items', 'subTotal', 'ppn', 'grand'));
    }

    public function create(Request $request)
    {
        $id_po = (int) $request->query('id_po', 0);
        $po = PurchaseOrder::findOrFail($id_po);

        return view('transaksi.detail_po.form', [
            'po'       => $po,
            'item'     => null,
            'products' => Product::orderBy('id_product')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->prepare($request);

        DetailPo::create($data);

        $this->syncParent($data['id_po']);

        return redirect()
            ->route('detail_po.index', ['id_po' => $data['id_po']])
            ->with('flash_success', 'Item detail PO berhasil ditambahkan.');
    }

    public function edit(int $id_detail)
    {
        $item = DetailPo::findOrFail($id_detail);
        $po = PurchaseOrder::findOrFail($item->id_po);

        return view('transaksi.detail_po.form', [
            'po'       => $po,
            'item'     => $item,
            'products' => Product::orderBy('id_product')->get(),
        ]);
    }

    public function update(Request $request, int $id_detail)
    {
        $item = DetailPo::findOrFail($id_detail);
        $data = $this->prepare($request);

        $item->update($data);

        $this->syncParent($item->id_po);

        return redirect()
            ->route('detail_po.index', ['id_po' => $item->id_po])
            ->with('flash_success', 'Item detail PO berhasil diperbarui.');
    }

    public function destroy(int $id_detail)
    {
        $item = DetailPo::findOrFail($id_detail);
        $id_po = $item->id_po;

        $item->delete();
        $this->syncParent($id_po);

        return redirect()
            ->route('detail_po.index', ['id_po' => $id_po])
            ->with('flash_success', 'Item detail PO berhasil dihapus.');
    }

    /**
     * Validasi & hitung subtotal_final + ppn di server.
     *   subtotal_final = (qty * unit_price) - diskon
     *   ppn_11         = 11% * subtotal_final
     * Unit price diinput pada baris detail (master produk tidak lagi menyimpan harga).
     */
    private function prepare(Request $request): array
    {
        $request->validate([
            'id_po'      => ['required', 'integer', 'exists:purchase_order,id_po'],
            'id_product' => ['nullable', 'integer', 'exists:product,id_product'],
            'qty'        => ['required', 'integer', 'min:1'],
        ]);

        $qty    = max(1, (int) $request->input('qty'));
        $diskon = (float) str_replace(['.', ','], ['', '.'], $request->input('diskon', '0') ?: '0');
        $unit   = (float) str_replace(['.', ','], ['', '.'], $request->input('subtotal_unit', '0') ?: '0');
        $final  = ($qty * $unit) - $diskon;
        $ppn    = round($final * 0.11);

        return [
            'id_po'          => (int) $request->input('id_po'),
            'id_product'     => $request->input('id_product') ?: null,
            'qty'            => $qty,
            'diskon'         => $diskon,
            'subtotal_unit'  => $unit,
            'subtotal_final' => $final,
            'ppn_11'         => $ppn,
        ];
    }

    private function syncParent(int $id_po): void
    {
        if ($po = PurchaseOrder::find($id_po)) {
            $po->syncGrandTotal();
        }
    }
}
