@php $active = 'product'; $isEdit = (bool) $item; @endphp
@extends('layouts.app')
@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Produk')

@section('content')
<div class="page-head">
  <div><h1>{{ $isEdit ? 'Edit' : 'Tambah' }} Produk</h1><div class="sub">Data produk proteksi kebakaran</div></div>
  <a href="{{ route('product.index') }}" class="btn btn-ghost"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ $isEdit ? route('product.update', $item->id_product) : route('product.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <div class="form-grid">
      @if ($isEdit)
      <div class="field"><label>ID Produk</label><input type="text" value="{{ $item->id_product }}" readonly><div class="hint">ID dibuat otomatis oleh sistem.</div></div>
      @endif
      <div class="field">
        <label>Harga (Rp) <span class="req">*</span></label>
        <input type="text" name="harga" value="{{ old('harga', isset($item) ? angka($item->harga) : '') }}" placeholder="cth: 997.760" inputmode="numeric">
        <div class="hint">Harga satuan produk. Dipakai sebagai harga acuan saat menambah item Detail PO.</div>
      </div>
      <div class="field">
        <label>Nama Vendor</label>
        <input type="text" name="nama_vendor" value="{{ old('nama_vendor', $item->nama_vendor ?? '') }}" placeholder="Kosongkan jika diproduksi sendiri">
        <div class="hint">Kosongkan untuk produk yang diproduksi sendiri (otomatis: <b>PT Garda Integra Solusindo</b>). Produk sama dengan vendor berbeda dihitung sebagai item baru.</div>
      </div>
      <div class="field full"><label>Deskripsi <span class="req">*</span></label><textarea name="deskripsi" placeholder="Deskripsi produk" required>{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Simpan Data</button>
      <a href="{{ route('product.index') }}" class="btn btn-ghost">Batal</a>
    </div>
  </form>
</div>
@endsection
