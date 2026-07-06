<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Support\Terbilang;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    /** Cetak Purchase Order (format dokumen PO). */
    public function purchaseOrder(Request $request)
    {
        $id_po = (int) $request->query('id_po', 0);
        $po = PurchaseOrder::with(['project', 'vendor'])->findOrFail($id_po);

        $rows = $po->details()->with('product')->orderBy('id_detail')->get();
        $subTotal = (float) $rows->sum('subtotal_final');
        $ppn = round($subTotal * 0.11);
        $grand = $subTotal + $ppn;
        $terbilang = trim(Terbilang::rupiah($grand));

        return view('cetak.purchase_order', compact('po', 'rows', 'subTotal', 'ppn', 'grand', 'terbilang'));
    }

    /**
     * Cetak Invoice (data invoice menempel pada PO).
     *
     * Mode cetak "Invoice Jasa" sudah dihapus dari halaman Purchase Order &
     * Invoice. Invoice kini dicetak berdasarkan rincian Detail PO (mode
     * 'produk'). Mode 'jasa' hanya dipertahankan sebagai fallback internal
     * apabila sebuah PO belum memiliki item Detail PO, agar invoice tetap
     * dapat tercetak (satu baris ringkas) dan tidak error.
     */
    public function invoice(Request $request)
    {
        $id_po = (int) $request->query('id_po', 0);
        $mode = strtolower($request->query('mode', 'produk'));
        if (! in_array($mode, ['produk', 'jasa'], true)) {
            $mode = 'produk';
        }

        $po = PurchaseOrder::with(['project', 'pegawai', 'vendor'])->findOrFail($id_po);

        // Objek invoice "virtual" agar view cetak lama tetap kompatibel.
        $inv = (object) [
            'no_invoice'    => $po->no_invoice,
            'po_no'         => $po->po_no,
            'tanggal'       => $po->tanggal_invoice ?: $po->tanggal,
            'alamat'        => $po->alamat_invoice,
            'tax_code'      => $po->tax_code,
            'total'         => (float) ($po->total_invoice ?: $po->grand_total),
            'no_telp'       => $po->no_telp,
            'terms'         => $po->terms,
            'bast'          => $po->bast,
            'spk_no'        => $po->spk_no,
            'rekening'      => $po->rekening,
            'purchaseOrder' => $po,
            'pegawai'       => $po->pegawai,
        ];

        $projectDesc = optional($po->project)->nama_project
            ?: 'Jasa / Pengadaan sesuai purchase order';

        $lineItems = [];

        if ($mode === 'produk') {
            $details = $po->details()->with('product')->orderBy('id_detail')->get();

            foreach ($details as $d) {
                $qty = (float) $d->qty;
                $price = (float) $d->subtotal_unit;
                $lineTotal = (float) $d->subtotal_final;
                if ($lineTotal <= 0) {
                    $lineTotal = $qty * $price;
                }
                $lineItems[] = [
                    'desc'  => $d->product->deskripsi ?? '-',
                    'qty'   => $qty,
                    'unit'  => 'Unit',
                    'price' => $price,
                    'total' => $lineTotal,
                ];
            }
        }

        // Fallback ke mode jasa bila tidak ada rincian.
        if ($mode === 'produk' && count($lineItems) === 0) {
            $mode = 'jasa';
        }

        if ($mode === 'jasa') {
            $lineItems[] = [
                'desc'  => $projectDesc,
                'qty'   => 1,
                'unit'  => 'Lot',
                'price' => (float) $inv->total,
                'total' => (float) $inv->total,
            ];
        }

        $itemsTotal = array_sum(array_column($lineItems, 'total'));
        $total = $itemsTotal > 0 ? $itemsTotal : (float) $inv->total;

        $dpp = round($total * 11 / 12);
        $ppn = round($total * 0.11);
        $grand = $total + $ppn;
        $terbilang = trim(Terbilang::rupiah($grand));

        $modeLabel = $mode === 'produk' ? 'Barang' : 'Jasa';
        $auto = $request->query('auto') === '1';

        return view('cetak.invoice', compact(
            'inv', 'mode', 'modeLabel', 'lineItems', 'projectDesc',
            'total', 'dpp', 'ppn', 'grand', 'terbilang', 'auto', 'id_po'
        ));
    }
}
