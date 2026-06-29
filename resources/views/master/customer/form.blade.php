@php $active = 'customer'; $isEdit = (bool) $item; @endphp
@extends('layouts.app')
@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Customer')

@section('content')
<div class="page-head">
  <div><h1>{{ $isEdit ? 'Edit' : 'Tambah' }} Customer</h1><div class="sub">Data pelanggan / penerima pembayaran</div></div>
  <a href="{{ route('customer.index') }}" class="btn btn-ghost"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ $isEdit ? route('customer.update', $item->id_customer) : route('customer.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <div class="form-grid">
      <div class="field"><label>ID Customer <span class="req">*</span></label><input type="text" name="id_customer" value="{{ old('id_customer', $item->id_customer ?? '') }}" placeholder="cth: CUST003" required></div>
      <div class="field"><label>Nama Rekening <span class="req">*</span></label><input type="text" name="nama_rek" value="{{ old('nama_rek', $item->nama_rek ?? '') }}" placeholder="Nama pemilik rekening" required></div>
      <div class="field"><label>No. Rekening</label><input type="text" name="no_rek" value="{{ old('no_rek', $item->no_rek ?? '') }}" placeholder="Nomor rekening"></div>
      <div class="field full"><label>Alamat</label><textarea name="alamat" placeholder="Alamat lengkap">{{ old('alamat', $item->alamat ?? '') }}</textarea></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Simpan Data</button>
      <a href="{{ route('customer.index') }}" class="btn btn-ghost">Batal</a>
    </div>
  </form>
</div>
@endsection
