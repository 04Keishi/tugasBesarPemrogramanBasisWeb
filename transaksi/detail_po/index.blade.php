@php
  $active = 'purchase_order';
  $canWrite = auth()->user()->isDirektur() || auth()->user()->isPegawai();
@endphp
@extends('layouts.app')
@section('title', 'Detail PO')

@section('content')
@if (! $po)
  <div class="page-head">
    <div><h1>Detail PO</h1><div class="sub">Purchase order tidak ditemukan</div></div>
    <a href="{{ route('purchase_order.index') }}" class="btn btn-ghost">Kembali ke daftar PO</a>
  </div>
  <div class="card"><div style="padding:40px;text-align:center;color:var(--ink-soft);">
    Silakan pilih purchase order terlebih dahulu dari halaman <a href="{{ route('purchase_order.index') }}" style="color:var(--red);font-weight:700;">Purchase Order</a>.
  </div></div>
@else
  <div class="page-head">
    <div>
      <h1>Detail PO</h1>
      <div class="sub">Rincian item untuk purchase order <b>{{ $po->po_no }}</b></div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <a href="{{ route('cetak.po', ['id_po' => $po->id_po]) }}" target="_blank" class="btn btn-ghost act-btn-print" style="border-color:#E4D4F4;color:#6A1B9A;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
        Cetak PO
      </a>
      <a href="{{ route('purchase_order.index') }}" class="btn btn-ghost">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Daftar PO
      </a>
    </div>
  </div>

  <div class="po-meta">
    <div class="mi"><div class="k">Vendor</div><div class="v">{{ $po->vendor->nama_supplier ?? '-' }}</div></div>
    <div class="mi"><div class="k">Project</div><div class="v">{{ $po->project->nama_project ?? '-' }}</div></div>
    <div class="mi"><div class="k">Tanggal</div><div class="v">{{ tgl_id($po->tanggal) }}</div></div>
    <div class="mi"><div class="k">Payment</div><div class="v">{{ $po->payment ?? '-' }}</div></div>
    <div class="mi"><div class="k">Grand Total</div><div class="v" style="color:var(--red);">{{ rupiah($po->grand_total) }}</div></div>
  </div>

  <div class="card">
    <div class="card-toolbar">
      <div style="font-weight:800;color:var(--ink);">Item Produk</div>
      @if ($canWrite)
      <a href="{{ route('detail_po.create', ['id_po' => $po->id_po]) }}" class="btn btn-primary btn-sm">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Tambah Item
      </a>
      @endif
    </div>
    <div class="table-wrap">
      <table id="tbl">
        <thead>
          <tr>
            <th style="width:46px;">No</th><th>Produk</th>
            <th class="money">QTY</th><th class="money">Unit Price</th>
            <th class="money">Diskon</th><th class="money">Subtotal Final</th>
            @if($canWrite)<th style="text-align:right;">Aksi</th>@endif
          </tr>
        </thead>
        <tbody>
          @forelse ($items as $i => $r)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>
              <div class="cell-strong">{{ $r->product->deskripsi ?? $r->id_product }}</div>
              <div class="cell-sub">{{ $r->product->nama_vendor ?? '' }}</div>
            </td>
            <td class="money">{{ angka($r->qty) }}</td>
            <td class="money">{{ rupiah($r->subtotal_unit) }}</td>
            <td class="money">{{ rupiah($r->diskon) }}</td>
            <td class="money cell-strong">{{ rupiah($r->subtotal_final) }}</td>
            @if($canWrite)
            <td>
              <div class="row-actions" style="justify-content:flex-end;">
                <a href="{{ route('detail_po.edit', $r->id_detail) }}" class="act-btn edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                <form method="POST" action="{{ route('detail_po.destroy', $r->id_detail) }}" style="display:inline;" onsubmit="return confirmDelete(event,'item ini')">@csrf @method('DELETE')<button type="submit" class="act-btn del" title="Hapus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></form>
              </div>
            </td>
            @endif
          </tr>
          @empty
          <tr class="empty-row"><td colspan="7">Belum ada item pada PO ini.</td></tr>
          @endforelse

          @if ($items->count())
          <tr><td colspan="5" class="money cell-strong" style="text-align:right;">Sub Total</td><td class="money cell-strong">{{ rupiah($subTotal) }}</td>@if($canWrite)<td></td>@endif</tr>
          <tr><td colspan="5" class="money" style="text-align:right;">PPN 11%</td><td class="money">{{ rupiah($ppn) }}</td>@if($canWrite)<td></td>@endif</tr>
          <tr><td colspan="5" class="money cell-strong" style="text-align:right;color:var(--red);">Grand Total</td><td class="money cell-strong" style="color:var(--red);">{{ rupiah($grand) }}</td>@if($canWrite)<td></td>@endif</tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endif
@endsection
