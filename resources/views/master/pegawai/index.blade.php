@php $active = 'pegawai'; $canWrite = auth()->user()->isDirektur(); @endphp
@extends('layouts.app')
@section('title', 'Master Pegawai')

@section('content')
<div class="page-head">
  <div>
    <h1>Master Pegawai</h1>
    <div class="sub">Kelola data pegawai PT. Garda Integra Solusindo</div>
  </div>
  @if ($canWrite)
  <a href="{{ route('pegawai.create') }}" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Tambah Pegawai
  </a>
  @endif
</div>

<div class="card">
  <div class="card-toolbar">
    <div class="search-box">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" placeholder="Cari pegawai..." onkeyup="tableSearch(this,'tbl')">
    </div>
  </div>
  <div class="table-wrap">
    <table id="tbl">
      <thead>
        <tr><th>ID Pegawai</th><th>Nama Pegawai</th><th>Jabatan</th>@if($canWrite)<th style="text-align:right;">Aksi</th>@endif</tr>
      </thead>
      <tbody>
        @forelse ($items as $r)
        <tr>
          <td><span class="id-pill">{{ $r->id_pegawai }}</span></td>
          <td><b>{{ $r->nama_pegawai }}</b></td>
          <td>{{ $r->jabatan }}</td>
          @if ($canWrite)
          <td>
            <div class="row-actions" style="justify-content:flex-end;">
              <a href="{{ route('pegawai.edit', $r->id_pegawai) }}" class="act-btn edit" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
              <form method="POST" action="{{ route('pegawai.destroy', $r->id_pegawai) }}" style="display:inline;" onsubmit="return confirmDelete(event,'{{ $r->nama_pegawai }}')">
                @csrf @method('DELETE')
                <button type="submit" class="act-btn del" title="Hapus"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
              </form>
            </div>
          </td>
          @endif
        </tr>
        @empty
        <tr class="empty-row"><td colspan="4">Belum ada data pegawai.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div id="noResults" style="display:none;text-align:center;padding:40px;color:var(--ink-soft);">Tidak ada hasil yang cocok.</div>
  </div>
</div>
@endsection
