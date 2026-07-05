@php $active = 'pegawai'; $isEdit = (bool) $item; @endphp
@extends('layouts.app')
@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Pegawai')

@section('content')
<div class="page-head">
  <div>
    <h1>{{ $isEdit ? 'Edit' : 'Tambah' }} Pegawai</h1>
    <div class="sub">{{ $isEdit ? 'Perbarui informasi pegawai' : 'Tambahkan data pegawai baru' }}</div>
  </div>
  <a href="{{ route('pegawai.index') }}" class="btn btn-ghost">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali
  </a>
</div>
<div class="form-card">
  <form method="POST" action="{{ $isEdit ? route('pegawai.update', $item->id_pegawai) : route('pegawai.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <div class="form-grid">
      <div class="field">
        <label>ID Pegawai <span class="req">*</span></label>
        <input type="text" name="id_pegawai" value="{{ old('id_pegawai', $item->id_pegawai ?? '') }}" placeholder="cth: PEG004" required>
      </div>
      <div class="field">
        <label>Jabatan <span class="req">*</span></label>
        <input type="text" name="jabatan" value="{{ old('jabatan', $item->jabatan ?? '') }}" placeholder="cth: Staff Finance" required>
      </div>
      <div class="field full">
        <label>Nama Pegawai <span class="req">*</span></label>
        <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai', $item->nama_pegawai ?? '') }}" placeholder="Nama lengkap pegawai" required>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Simpan Data
      </button>
      <a href="{{ route('pegawai.index') }}" class="btn btn-ghost">Batal</a>
    </div>
  </form>
</div>
@endsection
