@php $active = 'dashboard'; @endphp
@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-head">
  <div>
    <h1>Selamat datang, {{ explode(' ', auth()->user()->name)[0] }} 👋</h1>
    <div class="sub">Ringkasan aktivitas sistem manajemen Garda Integra Solusindo</div>
  </div>
  <span class="badge-role" style="background:var(--red-soft);color:var(--red);padding:8px 16px;font-size:12px;border-radius:30px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
    {{ auth()->user()->isDirektur() ? '🛡️ Akses Penuh — Direktur' : '👤 Akses Terbatas — Pegawai' }}
  </span>
</div>

<!-- STAT CARDS -->
<div class="stat-grid">
  <div class="stat-card">
    <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
    <div class="num">{{ $stats['pegawai'] }}</div>
    <div class="lbl">Total Pegawai</div>
  </div>
  <div class="stat-card">
    <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
    <div class="num">{{ $stats['customer'] }}</div>
    <div class="lbl">Total Customer</div>
  </div>
  <div class="stat-card">
    <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg></div>
    <div class="num">{{ $stats['project'] }}</div>
    <div class="lbl">Total Project</div>
  </div>
  <div class="stat-card">
    <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9"/></svg></div>
    <div class="num">{{ $stats['vendor'] }}</div>
    <div class="lbl">Total Vendor</div>
  </div>
  <div class="stat-card">
    <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg></div>
    <div class="num">{{ $stats['product'] }}</div>
    <div class="lbl">Total Produk</div>
  </div>
  <div class="stat-card">
    <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
    <div class="num">{{ $stats['po'] }}</div>
    <div class="lbl">Purchase Order</div>
  </div>
  <div class="stat-card">
    <div class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
    <div class="num">{{ $stats['invoice'] }}</div>
    <div class="lbl">Total Invoice</div>
  </div>
  <div class="stat-card" style="background:linear-gradient(135deg,var(--red),var(--red-dark));border:none;">
    <div class="ico" style="background:rgba(255,255,255,.18);color:#fff;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/><path d="M6 12h.01M18 12h.01"/></svg></div>
    <div class="num" style="color:#fff;font-size:22px;">{{ rupiah($totalPo) }}</div>
    <div class="lbl" style="color:rgba(255,255,255,.85);">Nilai Total PO</div>
  </div>
</div>

<!-- RECENT TABLES -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:22px;">
  <div class="card">
    <div class="card-toolbar">
      <h3 style="font-family:var(--display);font-size:17px;font-weight:700;">Purchase Order Terbaru</h3>
      <a href="{{ route('purchase_order.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>PO No.</th><th>Vendor</th><th>Tanggal</th><th>Grand Total</th></tr></thead>
        <tbody>
          @forelse ($recentPo as $r)
          <tr>
            <td><span class="id-pill">{{ $r->po_no }}</span></td>
            <td>{{ $r->vendor->nama_supplier ?? '-' }}</td>
            <td>{{ tgl_id($r->tanggal) }}</td>
            <td><b>{{ rupiah($r->grand_total) }}</b></td>
          </tr>
          @empty
          <tr class="empty-row"><td colspan="4">Belum ada data Purchase Order</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="card-toolbar">
      <h3 style="font-family:var(--display);font-size:17px;font-weight:700;">Invoice Terbaru</h3>
      <a href="{{ route('purchase_order.index') }}" class="btn btn-ghost btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>No. Invoice</th><th>PO No.</th><th>Tanggal</th><th>Total</th></tr></thead>
        <tbody>
          @forelse ($recentInv as $r)
          <tr>
            <td><span class="id-pill">{{ $r->no_invoice }}</span></td>
            <td>{{ $r->po_no ?? '-' }}</td>
            <td>{{ tgl_id($r->tanggal_invoice ?? $r->tanggal) }}</td>
            <td><b>{{ rupiah($r->total_invoice) }}</b></td>
          </tr>
          @empty
          <tr class="empty-row"><td colspan="4">Belum ada data Invoice</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>@media(max-width:860px){.main > div[style*="grid-template-columns:1fr 1fr"]{grid-template-columns:1fr !important;}}</style>
@endsection
