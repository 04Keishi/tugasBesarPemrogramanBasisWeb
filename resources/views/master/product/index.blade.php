@php $active = 'product'; $canWrite = auth()->user()->isDirektur() || auth()->user()->isPegawai(); $canDelete = auth()->user()->isDirektur(); @endphp
@extends('layouts.app')
@section('title', 'Master Product')

@section('content')
<div class="page-head">
  <div><h1>Master Produk</h1><div class="sub">Kelola katalog produk proteksi kebakaran</div></div>
  @if ($canWrite)<a href="{{ route('product.create') }}" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Tambah Produk</a>@endif
</div>
<div class="card">
  <div class="card-toolbar">
    <div class="search-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input type="text" placeholder="Cari produk / vendor..." onkeyup="tableSearch(this,'tbl')"></div>
  </div>
  <div class="table-wrap">
    <table id="tbl">
      <thead><tr><th>ID</th><th>Deskripsi</th><th class="money">Harga</th><th>Nama Vendor</th>@if($canWrite)<th style="text-align:right;">Aksi</th>@endif</tr></thead>
      <tbody>
        @forelse ($items as $r)
        <tr>
          <td><span class="id-pill">{{ $r->id_product }}</span></td>
          <td><b>{{ $r->deskripsi }}</b></td>
          <td class="money cell-strong">{{ rupiah($r->harga) }}</td>
          <td>
            {{ $r->nama_vendor }}
            @if ($r->nama_vendor === \App\Models\Product::VENDOR_SENDIRI)
              <span class="tag muted" style="margin-left:6px;">Produksi Sendiri</span>
            @endif
          </td>
          @if ($canWrite)
          <td><div class="row-actions" style="justify-content:flex-end;">
            <a href="{{ route('product.edit', $r->id_product) }}" class="act-btn edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
            @if ($canDelete)<form method="POST" action="{{ route('product.destroy', $r->id_product) }}" style="display:inline;" onsubmit="return confirmDelete(event,'{{ $r->deskripsi }}')">@csrf @method('DELETE')<button type="submit" class="act-btn del"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button></form>@endif
          </div></td>
          @endif
        </tr>
        @empty
        <tr class="empty-row"><td colspan="5">Belum ada data produk.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div id="noResults" style="display:none;text-align:center;padding:40px;color:var(--ink-soft);">Tidak ada hasil.</div>
  </div>
</div>
@endsection
