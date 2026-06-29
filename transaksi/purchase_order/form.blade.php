@php $active = 'purchase_order'; $isEdit = (bool) $item; @endphp
@extends('layouts.app')
@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Purchase Order')

@section('content')
<div class="page-head">
  <div>
    <h1>{{ $isEdit ? 'Edit' : 'Tambah' }} Purchase Order</h1>
    <div class="sub">{{ $isEdit ? 'Perbarui data purchase order & invoice' : 'Buat dokumen purchase order baru (nomor PO & invoice otomatis)' }}</div>
  </div>
  <a href="{{ route('purchase_order.index') }}" class="btn btn-ghost">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali
  </a>
</div>
<div class="form-card">
  <form method="POST" action="{{ $isEdit ? route('purchase_order.update', ['id_po' => $item->id_po]) : route('purchase_order.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="form-section-label" style="font-weight:800;color:var(--ink);margin-bottom:12px;">Data Purchase Order</div>
    <div class="form-grid">
      @if ($isEdit)
      <div class="field">
        <label>Nomor PO</label>
        <input type="text" value="{{ $item->po_no }}" readonly>
        <div class="hint">Nomor PO dibuat otomatis oleh sistem.</div>
      </div>
      <div class="field">
        <label>Nomor Invoice</label>
        <input type="text" value="{{ $item->no_invoice }}" readonly>
        <div class="hint">Nomor invoice dibuat otomatis oleh sistem.</div>
      </div>
      @endif
      <div class="field">
        <label>Tanggal PO</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', isset($item) && $item->tanggal ? $item->tanggal->format('Y-m-d') : date('Y-m-d')) }}">
      </div>
      <div class="field">
        <label>Project (No. SO)</label>
        <select name="no_so">
          <option value="">— Pilih Project —</option>
          @foreach ($projects as $p)
            <option value="{{ $p->no_so }}" {{ (string) old('no_so', $item->no_so ?? '') === (string) $p->no_so ? 'selected' : '' }}>{{ $p->no_so.' — '.$p->nama_project }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label>Vendor</label>
        <select name="id_vendor">
          <option value="">— Pilih Vendor —</option>
          @foreach ($vendors as $v)
            <option value="{{ $v->id_vendor }}" {{ (string) old('id_vendor', $item->id_vendor ?? '') === (string) $v->id_vendor ? 'selected' : '' }}>{{ $v->id_vendor.' — '.$v->nama_supplier }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label>Pegawai (Penyetuju)</label>
        <select name="id_pegawai">
          <option value="">— Pilih Pegawai —</option>
          @foreach ($pegawais as $pg)
            <option value="{{ $pg->id_pegawai }}" {{ (string) old('id_pegawai', $item->id_pegawai ?? '') === (string) $pg->id_pegawai ? 'selected' : '' }}>{{ $pg->id_pegawai.' — '.$pg->nama_pegawai }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label>NPWP</label>
        <input type="text" name="npwp" value="{{ old('npwp', $item->npwp ?? '') }}" placeholder="cth: 70.720.171.1-036.000">
      </div>
      <div class="field full">
        <label>Payment / Termin</label>
        <input type="text" name="payment" value="{{ old('payment', $item->payment ?? '') }}" placeholder="cth: DP 30%, Pelunasan 70% CBD">
      </div>
    </div>

    <hr style="margin:26px 0;border:none;border-top:1px solid var(--line,#eee);">
    <div class="form-section-label" style="font-weight:800;color:var(--ink);margin-bottom:12px;">Data Invoice (tergabung)</div>
    <div class="form-grid">
      <div class="field">
        <label>Tanggal Invoice</label>
        <input type="date" name="tanggal_invoice" value="{{ old('tanggal_invoice', isset($item) && $item->tanggal_invoice ? $item->tanggal_invoice->format('Y-m-d') : '') }}">
      </div>
      <div class="field"><label>Tax Code</label><input type="text" name="tax_code" value="{{ old('tax_code', $item->tax_code ?? '') }}" placeholder="cth: -"></div>
      <div class="field"><label>SPK No.</label><input type="text" name="spk_no" value="{{ old('spk_no', $item->spk_no ?? '') }}" placeholder="cth: -"></div>
      <div class="field"><label>BAST</label><input type="text" name="bast" value="{{ old('bast', $item->bast ?? '') }}" placeholder="cth: -"></div>
      <div class="field"><label>Terms</label><input type="text" name="terms" value="{{ old('terms', $item->terms ?? '') }}" placeholder="cth: 100%, 45 Days"></div>
      <div class="field"><label>No. Telp</label><input type="text" name="no_telp" value="{{ old('no_telp', $item->no_telp ?? '') }}" placeholder="cth: (021) 7515957/58"></div>
      <div class="field full"><label>Rekening</label><input type="text" name="rekening" value="{{ old('rekening', $item->rekening ?? '') }}" placeholder="cth: PT GARDA INTEGRA SOLUSINDO"></div>
      <div class="field full"><label>Alamat Invoice (Kepada YTH)</label><textarea name="alamat_invoice" rows="2" placeholder="Alamat penerima invoice">{{ old('alamat_invoice', $item->alamat_invoice ?? '') }}</textarea></div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Simpan Data
      </button>
      <a href="{{ route('purchase_order.index') }}" class="btn btn-ghost">Batal</a>
    </div>
  </form>
</div>
@endsection
