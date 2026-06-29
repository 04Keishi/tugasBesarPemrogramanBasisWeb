@php $active = 'project'; $isEdit = (bool) $item; @endphp
@extends('layouts.app')
@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Project')

@section('content')
<div class="page-head">
  <div><h1>{{ $isEdit ? 'Edit' : 'Tambah' }} Project</h1><div class="sub">Data project / Sales Order</div></div>
  <a href="{{ route('project.index') }}" class="btn btn-ghost"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali</a>
</div>
<div class="form-card">
  <form method="POST" action="{{ $isEdit ? route('project.update', $item->no_so) : route('project.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <div class="form-grid">
      <div class="field"><label>No. SO <span class="req">*</span></label><input type="text" name="no_so" value="{{ old('no_so', $item->no_so ?? '') }}" placeholder="cth: SO-004" required></div>
      <div class="field">
        <label>Customer</label>
        <select name="id_customer">
          <option value="">— Pilih Customer —</option>
          @foreach ($customers as $c)
            <option value="{{ $c->id_customer }}" {{ old('id_customer', $item->id_customer ?? '') === $c->id_customer ? 'selected' : '' }}>{{ $c->id_customer.' — '.$c->nama_rek }}</option>
          @endforeach
        </select>
      </div>
      <div class="field full"><label>Nama Project <span class="req">*</span></label><textarea name="nama_project" placeholder="Deskripsi nama project" required>{{ old('nama_project', $item->nama_project ?? '') }}</textarea></div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Simpan Data</button>
      <a href="{{ route('project.index') }}" class="btn btn-ghost">Batal</a>
    </div>
  </form>
</div>
@endsection
