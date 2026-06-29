@php
  $active = 'purchase_order';
  // Purchase Order: pegawai & direktur sama-sama boleh CRUD.
  $canWrite = auth()->user()->isDirektur() || auth()->user()->isPegawai();
@endphp
@extends('layouts.app')
@section('title', 'Purchase Order')

@section('content')
<div class="page-head">
  <div>
    <h1>Purchase Order &amp; Invoice</h1>
    <div class="sub">Kelola dokumen purchase order, detail item, dan invoice yang tergabung</div>
  </div>
  @if ($canWrite)
  <a href="{{ route('purchase_order.create') }}" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Tambah PO
  </a>
  @endif
</div>

<style>
  .print-options { display:flex; gap:6px; justify-content:center; align-items:center; flex-wrap:wrap; }
  .print-options .act-btn.print {
    display:inline-flex; align-items:center; justify-content:center; gap:5px;
    width:auto; height:auto; min-height:30px; padding:6px 12px; border-radius:7px;
    white-space:nowrap; line-height:1;
  }
  .print-options .act-btn.print svg { width:15px; height:15px; flex:0 0 auto; }
  .print-options .act-btn.print span { font:600 11px/1 Arial,sans-serif; }
</style>

<div class="card">
  <div class="card-toolbar">
    <div class="search-box">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" placeholder="Cari nomor PO / invoice / vendor / project..." onkeyup="tableSearch(this,'tbl')">
    </div>
  </div>
  <div class="table-wrap">
    <table id="tbl">
      <thead>
        <tr>
          <th>Nomor PO</th><th>No. Invoice</th><th>Project</th><th>Vendor</th><th>Tanggal</th>
          <th class="money">Grand Total</th>
          <th style="text-align:center;">Detail</th>
          <th style="text-align:center;">Cetak</th>
          @if($canWrite)<th style="text-align:right;">Aksi</th>@endif
        </tr>
      </thead>
      <tbody>
        @forelse ($items as $r)
        <tr>
          <td><span class="id-pill">{{ $r->po_no }}</span></td>
          <td>{{ $r->no_invoice ?? '-' }}</td>
          <td>
            <div class="cell-strong">{{ $r->no_so ?? '-' }}</div>
            <div class="cell-sub">{{ $r->project->nama_project ?? 'Tanpa project' }}</div>
          </td>
          <td>{{ $r->vendor->nama_supplier ?? '-' }}</td>
          <td>{{ tgl_id($r->tanggal) }}</td>
          <td class="money cell-strong">{{ rupiah($r->grand_total) }}</td>
          <td style="text-align:center;">
            <a href="{{ route('detail_po.index', ['id_po' => $r->id_po]) }}" class="btn btn-sm btn-detail">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
              Detail PO
            </a>
          </td>
          <td style="text-align:center;">
            <div class="print-options">
              <a href="{{ route('cetak.po', ['id_po' => $r->id_po]) }}" target="_blank" class="act-btn print" title="Cetak Purchase Order" style="background:#6A1B9A;border-color:#6A1B9A;color:#fff;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                <span>PO</span>
              </a>
              <a href="{{ route('cetak.invoice', ['id_po' => $r->id_po, 'mode' => 'produk', 'auto' => 1]) }}" target="_blank" class="act-btn print" title="Cetak Invoice — Barang">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                <span>Inv. Barang</span>
              </a>
            </div>
          </td>
          @if($canWrite)
          <td>
            <div class="row-actions" style="justify-content:flex-end;">
              <a href="{{ route('purchase_order.edit', ['id_po' => $r->id_po]) }}" class="act-btn edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
              <form method="POST" action="{{ route('purchase_order.destroy', ['id_po' => $r->id_po]) }}" style="display:inline;" onsubmit="return confirmDelete(event,'{{ $r->po_no }}')">@csrf @method('DELETE')<button type="submit" class="act-btn del" title="Hapus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></form>
            </div>
          </td>
          @endif
        </tr>
        @empty
        <tr class="empty-row"><td colspan="9">Belum ada data purchase order.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div id="noResults" style="display:none;text-align:center;padding:40px;color:var(--ink-soft);">Tidak ada hasil yang cocok.</div>
  </div>
</div>
@endsection
