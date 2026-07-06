<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use App\Support\Terbilang;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $items = PurchaseOrder::with(['project', 'vendor'])
            ->orderBy('id_po')
            ->get();

        return view('transaksi.purchase_order.index', compact('items'));
    }

    public function create()
    {
        return view('transaksi.purchase_order.form', [
            'item'      => null,
            'projects'  => Project::orderBy('no_so')->get(),
            'vendors'   => Vendor::orderBy('id_vendor')->get(),
            'pegawais'  => Pegawai::orderBy('id_pegawai')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // Nomor PO & Invoice di-generate otomatis — user tidak mengetik ID.
        $data['po_no']       = PurchaseOrder::generatePoNo();
        $data['no_invoice']  = PurchaseOrder::generateInvoiceNo();
        $data['grand_total'] = 0;
        $data['terbilang']   = Terbilang::rupiah(0);

        $po = PurchaseOrder::create($data);

        return redirect()
            ->route('detail_po.index', ['id_po' => $po->id_po])
            ->with('flash_success', 'Purchase Order berhasil ditambahkan. Lengkapi item pada Detail PO.');
    }

    public function edit(int $id_po)
    {
        $item = PurchaseOrder::findOrFail($id_po);

        return view('transaksi.purchase_order.form', [
            'item'      => $item,
            'projects'  => Project::orderBy('no_so')->get(),
            'vendors'   => Vendor::orderBy('id_vendor')->get(),
            'pegawais'  => Pegawai::orderBy('id_pegawai')->get(),
        ]);
    }

    public function update(Request $request, int $id_po)
    {
        $item = PurchaseOrder::findOrFail($id_po);
        $data = $this->validateData($request);

        $item->update($data);

        // Sinkronkan grand total dari item yang sudah ada.
        $item->refresh()->syncGrandTotal();

        return redirect()->route('purchase_order.index')
            ->with('flash_success', 'Purchase Order berhasil diperbarui.');
    }

    public function destroy(int $id_po)
    {
        try {
            PurchaseOrder::findOrFail($id_po)->delete();

            return redirect()->route('purchase_order.index')
                ->with('flash_success', 'Purchase Order berhasil dihapus.');
        } catch (\Throwable $e) {
            // restrictOnDelete: PO yang masih punya item Detail PO tidak bisa dihapus.
            return redirect()->route('purchase_order.index')
                ->with('flash_error', 'Gagal menghapus: hapus dahulu seluruh item Detail PO pada PO ini.');
        }
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'no_so'      => ['nullable', 'integer', 'exists:project,no_so'],
            'id_vendor'  => ['nullable', 'integer', 'exists:vendor,id_vendor'],
            'id_pegawai' => ['nullable', 'integer', 'exists:pegawai,id_pegawai'],
            'npwp'       => ['nullable', 'string', 'max:40'],
            'payment'    => ['nullable', 'string', 'max:150'],
            'tanggal'    => ['nullable', 'date'],
            // Field invoice (digabung ke PO)
            'tanggal_invoice' => ['nullable', 'date'],
            'alamat_invoice'  => ['nullable', 'string'],
            'tax_code'        => ['nullable', 'string', 'max:40'],
            'no_telp'         => ['nullable', 'string', 'max:30'],
            'terms'           => ['nullable', 'string', 'max:100'],
            'bast'            => ['nullable', 'string', 'max:60'],
            'spk_no'          => ['nullable', 'string', 'max:60'],
            'rekening'        => ['nullable', 'string', 'max:120'],
        ]);

        foreach (['no_so', 'id_vendor', 'id_pegawai'] as $k) {
            $data[$k] = $data[$k] ?: null;
        }

        return $data;
    }
}
