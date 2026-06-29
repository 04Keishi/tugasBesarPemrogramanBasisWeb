@php $active = 'purchase_order'; $isEdit = (bool) $item; @endphp
@extends('layouts.app')
@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Item Detail PO')

@section('content')
<div class="page-head">
  <div>
    <h1>{{ $isEdit ? 'Edit' : 'Tambah' }} Item Detail PO</h1>
    <div class="sub">PO <b>{{ $po->po_no }}</b></div>
  </div>
  <a href="{{ route('detail_po.index', ['id_po' => $po->id_po]) }}" class="btn btn-ghost">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg> Kembali
  </a>
</div>
<div class="form-card">
  <form method="POST" action="{{ $isEdit ? route('detail_po.update', $item->id_detail) : route('detail_po.store') }}">
    @csrf
    @if ($isEdit) @method('PUT') @endif
    <input type="hidden" name="id_po" value="{{ $po->id_po }}">
    <div class="form-grid">
      <div class="field full">
        <label>Produk <span class="req">*</span></label>
        <select name="id_product" id="selProduk" required>
          <option value="">— Pilih Produk —</option>
          @foreach ($products as $pr)
            <option value="{{ $pr->id_product }}" data-harga="{{ (int) $pr->harga }}" {{ (string) old('id_product', $item->id_product ?? '') === (string) $pr->id_product ? 'selected' : '' }}>
              {{ $pr->id_product.' — '.$pr->deskripsi }} ({{ $pr->nama_vendor }}) — {{ rupiah($pr->harga) }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label>QTY <span class="req">*</span></label>
        <input type="number" name="qty" id="inpQty" value="{{ old('qty', $item->qty ?? '1') }}" min="1" oninput="hitung()" required>
      </div>
      <div class="field">
        <label>Unit Price (Rp)</label>
        <input type="text" name="subtotal_unit" id="inpUnit" value="{{ old('subtotal_unit', isset($item) ? angka($item->subtotal_unit) : '') }}" placeholder="cth: 997.760" inputmode="numeric" oninput="hitung()">
      </div>
      <div class="field">
        <label>Diskon (Rp)</label>
        <input type="text" name="diskon" id="inpDiskon" value="{{ old('diskon', isset($item) ? angka($item->diskon) : '0') }}" placeholder="0" inputmode="numeric" oninput="hitung()">
      </div>
      <div class="field full">
        <label>Subtotal Final (otomatis)</label>
        <input type="text" id="inpFinal" value="{{ isset($item) ? angka($item->subtotal_final) : '0' }}" readonly>
        <div class="hint">Subtotal Final = (QTY × Unit Price) − Diskon. Dihitung ulang saat disimpan.</div>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Simpan Item
      </button>
      <a href="{{ route('detail_po.index', ['id_po' => $po->id_po]) }}" class="btn btn-ghost">Batal</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  function parseNum(s){ return parseFloat((s||'').toString().replace(/\./g,'').replace(/,/g,'.'))||0; }
  function fmt(n){ return Math.round(n).toLocaleString('id-ID'); }
  function hitung(){
    var qty=parseNum(document.getElementById('inpQty').value);
    var unit=parseNum(document.getElementById('inpUnit').value);
    var dis=parseNum(document.getElementById('inpDiskon').value);
    var final=qty*unit-dis;
    document.getElementById('inpFinal').value=fmt(final);
  }
  // Saat produk dipilih, isi otomatis Unit Price dari harga produk
  // (hanya bila Unit Price masih kosong agar tidak menimpa input manual).
  (function(){
    var sel=document.getElementById('selProduk');
    var unit=document.getElementById('inpUnit');
    if(!sel||!unit) return;
    sel.addEventListener('change', function(){
      var opt=sel.options[sel.selectedIndex];
      var harga=opt ? parseFloat(opt.getAttribute('data-harga')||'0') : 0;
      if(harga>0 && parseNum(unit.value)===0){
        unit.value=fmt(harga);
        hitung();
      }
    });
  })();
</script>
@endpush
