<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pegawai;
use App\Models\Product;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\Vendor;

class DashboardController extends Controller
{
    public function index()
    {
        // Invoice kini menjadi bagian dari Purchase Order (PO yang punya no_invoice).
        $invoiceCount = PurchaseOrder::whereNotNull('no_invoice')->count();

        $stats = [
            'pegawai'  => Pegawai::count(),
            'customer' => Customer::count(),
            'project'  => Project::count(),
            'vendor'   => Vendor::count(),
            'product'  => Product::count(),
            'po'       => PurchaseOrder::count(),
            'invoice'  => $invoiceCount,
        ];

        $totalPo  = (float) PurchaseOrder::sum('grand_total');
        $totalInv = (float) PurchaseOrder::sum('total_invoice');

        $recentPo = PurchaseOrder::with(['vendor', 'project'])
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        // "Invoice terbaru" = PO terbaru yang memiliki nomor invoice.
        $recentInv = PurchaseOrder::with(['vendor', 'project'])
            ->whereNotNull('no_invoice')
            ->orderByDesc('tanggal_invoice')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'stats', 'totalPo', 'totalInv', 'recentPo', 'recentInv'
        ));
    }
}
