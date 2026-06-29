@php $active = 'vendor'; $isEdit = (bool) $item; @endphp
@extends('layouts.app')
@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Vendor')

@section('content')
<div class="page-head">
  <div><h1>{{ $isEdit ? 'Edit' : 'Tambah' }} Vendor</h1><div class="sub">Data supplier / vendor pengadaan</div></div>
  <a href="{{ route('vendor.index') }}" class="btn btn-ghost"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ $isEdit ? route('vendor.update', $item->id_vendor) : route('vendor.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <div class="form-grid">
      @if ($isEdit)
      <div class="field"><label>ID Vendor</label><input type="text" value="{{ $item->id_vendor }}" readonly><div class="hint">ID dibuat otomatis oleh sistem.</div></div>
      @endif
      <div class="field"><label>Nama Supplier <span class="req">*</span></label><input type="text" name="nama_supplier" value="{{ old('nama_supplier', $item->nama_supplier ?? '') }}" placeholder="Nama perusahaan supplier" required></div>
      <div class="field"><label>PIC</label><input type="text" name="pic" value="{{ old('pic', $item->pic ?? '') }}" placeholder="Nama PIC"></div>
      <div class="field"><label>No. HP PIC</label><input type="text" name="nohp_pic" value="{{ old('nohp_pic', $item->nohp_pic ?? '') }}" placeholder="Nomor HP PIC"></div>
      <div class="field"><label>No. Telepon</label><input type="text" name="no_telp" value="{{ old('no_telp', $item->no_telp ?? '') }}" placeholder="Nomor telepon kantor"></div>
      <div class="field"><label>Fax</label><input type="text" name="fax" value="{{ old('fax', $item->fax ?? '') }}" placeholder="Nomor fax"></div>
      <div class="field full"><label>Alamat</label><textarea name="alamat" placeholder="Alamat lengkap">{{ old('alamat', $item->alamat ?? '') }}</textarea></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Simpan Data</button>
      <a href="{{ route('vendor.index') }}" class="btn btn-ghost">Batal</a>
    </div>
  </form>
</div>
@endsection
