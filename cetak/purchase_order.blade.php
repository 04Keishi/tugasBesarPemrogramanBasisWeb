<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak PO · {{ $po->po_no }}</title>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { background:#5b5b5b; font-family:'Arial', 'Helvetica', sans-serif; color:#000; padding:24px; }
  .toolbar { max-width:794px; margin:0 auto 16px; display:flex; gap:10px; justify-content:flex-end; }
  .toolbar button, .toolbar a {
    font:600 13px/1 Arial, sans-serif; padding:10px 18px; border-radius:8px; border:none; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px;
  }
  .toolbar .print { background:#D32027; color:#fff; }
  .toolbar .back  { background:#fff; color:#333; border:1px solid #ccc; }
  .toolbar svg { width:15px; height:15px; }

  .page {
    width:794px; min-height:1123px; margin:0 auto; background:#fff; padding:48px 50px;
    box-shadow:0 4px 30px rgba(0,0,0,.4); font-size:12px; line-height:1.45;
  }

  .head { display:flex; justify-content:space-between; align-items:flex-start; }
  .head .co h1 { font-size:14px; font-weight:700; letter-spacing:.2px; }
  .head .co p  { font-size:11px; }
  .head .meta { text-align:left; font-size:11px; min-width:235px; }
  .head .meta table { width:100%; }
  .head .meta td { padding:1px 0; vertical-align:top; }
  .head .meta td.lbl { width:62px; font-weight:400; }
  .head .meta td.sep { width:10px; }

  hr.rule { border:none; border-top:2px solid #000; margin:8px 0 0; }

  .title { text-align:center; font-size:18px; font-weight:700; letter-spacing:3px; margin:18px 0 14px; }

  .two { display:flex; justify-content:space-between; gap:24px; margin-bottom:6px; }
  .two .col { width:48%; }
  .lbl-strong { font-weight:700; }
  .vendor-name { font-weight:700; }
  .npwp-box .npwp-no { font-weight:700; }

  .attn { margin-top:8px; }
  .attn td { padding:1px 0; font-size:11px; }
  .attn td.k { width:48px; }

  .deliv { margin:10px 0 4px; }
  .deliv .blk { margin-bottom:6px; }
  .deliv .blk .k { font-weight:700; }

  table.items { width:100%; border-collapse:collapse; margin-top:8px; font-size:11px; }
  table.items th, table.items td { border:1px solid #000; padding:6px 7px; vertical-align:top; }
  table.items thead th { text-align:center; font-weight:700; background:#fff; }
  table.items td.no   { text-align:center; width:32px; }
  table.items td.qty  { text-align:center; width:42px; }
  table.items td.unit { text-align:center; width:46px; }
  table.items td.price,
  table.items td.sub  { text-align:right; width:120px; white-space:nowrap; }
  table.items .desc { width:auto; }

  .totwrap { display:flex; justify-content:space-between; margin-top:10px; gap:20px; }
  .terbilang { width:50%; font-size:11px; }
  .terbilang .k { font-weight:700; }
  .terbilang .val { font-style:italic; text-transform:capitalize; }
  table.tot { border-collapse:collapse; font-size:11px; }
  table.tot td { padding:4px 10px; }
  table.tot td.k { text-align:left; font-weight:700; }
  table.tot td.v { text-align:right; white-space:nowrap; border:1px solid #000; min-width:140px; }

  .sign { display:flex; justify-content:space-between; margin-top:48px; font-size:11px; text-align:center; }
  .sign .col { width:45%; }
  .sign .role { font-weight:700; margin-bottom:54px; }
  .sign .name { font-weight:700; }
  .sign .nm-line { margin-bottom:2px; }

  @media print {
    body { background:#fff; padding:0; }
    .toolbar { display:none; }
    .page { box-shadow:none; margin:0; width:100%; min-height:auto; padding:30px 34px; }
    @page { size:A4; margin:12mm; }
  }
</style>
</head>
<body>
  <div class="toolbar">
    <button class="print" onclick="window.print()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
      Cetak / Simpan PDF
    </button>
    <a class="back" href="{{ route('detail_po.index', ['id_po' => $po->id_po]) }}">Kembali</a>
  </div>

  <div class="page">
    <div class="head">
      <div class="co">
        <h1>PT. GARDA INTEGRA SOLUSINDO</h1>
        <p>Jalan Andara Ujung, GG Sungai, RT 02 RW 02 No. 99,</p>
        <p>Kel. Pangkalan Jati Baru, Kec. Cinere, Depok, Jawa Barat, 16513</p>
        <p>Telp. (021) 7515957/58 &nbsp; Fax. (021) 7507714</p>
      </div>
      <div class="meta">
        <table>
          <tr><td class="lbl">No.</td><td class="sep">:</td><td>{{ $po->po_no }}</td></tr>
          <tr><td class="lbl">SO</td><td class="sep">:</td><td>{{ $po->no_so ?: '-' }}</td></tr>
          <tr><td class="lbl">Tanggal</td><td class="sep">:</td><td>{{ $po->tanggal ? tgl_id($po->tanggal) : '-' }}</td></tr>
        </table>
      </div>
    </div>
    <hr class="rule">

    <div class="title">PURCHASE ORDER</div>

    <div class="two">
      <div class="col">
        <div class="lbl-strong">Vendor :</div>
        <div class="vendor-name">{{ $po->vendor->nama_supplier ?? '-' }}</div>
        <div>{!! nl2br(e($po->vendor->alamat ?? '')) !!}</div>
      </div>
      <div class="col npwp-box">
        <div class="lbl-strong">NPWP :</div>
        <div class="npwp-no">{{ $po->npwp ?: '-' }}</div>
      </div>
    </div>

    <div class="two">
      <div class="col">
        <table class="attn">
          <tr><td class="k">Attn</td><td>: {{ $po->vendor->pic ?? '-' }}</td></tr>
          <tr><td class="k">Telp</td><td>: {{ $po->vendor->no_telp ?? '-' }}</td></tr>
          <tr><td class="k">Fax</td><td>: {{ $po->vendor->fax ?? '-' }}</td></tr>
        </table>
      </div>
      <div class="col">
        <div class="lbl-strong">Project</div>
        <div>{{ $po->project->nama_project ?? '-' }}</div>
      </div>
    </div>

    <div class="deliv">
      <div class="blk"><span class="k">Delivery :</span><br>-</div>
      <div class="blk"><span class="k">Payment :</span><br>{!! nl2br(e($po->payment ?: '-')) !!}</div>
    </div>

    <table class="items">
      <thead>
        <tr>
          <th class="no">No</th><th class="desc">Description</th>
          <th>QTY</th><th>Unit</th><th>Unit Price</th><th>Sub Total</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($rows as $i => $r)
        <tr>
          <td class="no">{{ $i + 1 }}</td>
          <td class="desc">{{ $r->product->deskripsi ?? $r->id_product }}</td>
          <td class="qty">{{ angka($r->qty) }}</td>
          <td class="unit">Unit</td>
          <td class="price">Rp {{ number_format((float) $r->subtotal_unit, 2, ',', '.') }}</td>
          <td class="sub">Rp {{ number_format((float) $r->subtotal_final, 2, ',', '.') }}</td>
        </tr>
        @empty
        <tr><td class="no"></td><td class="desc">&nbsp;</td><td></td><td></td><td></td><td></td></tr>
        @endforelse
      </tbody>
    </table>

    <div class="totwrap">
      <div class="terbilang">
        <span class="k">Terbilang :</span>
        <div class="val">{{ $terbilang }}</div>
      </div>
      <table class="tot">
        <tr><td class="k">Sub Total</td><td class="v">{{ rupiah($subTotal) }}</td></tr>
        <tr><td class="k">PPN 11%</td><td class="v">{{ rupiah($ppn) }}</td></tr>
        <tr><td class="k">Grand Total</td><td class="v">{{ rupiah($grand) }}</td></tr>
      </table>
    </div>

    <div class="sign">
      <div class="col">
        <div class="role">User Acceptance</div>
        <div>(…………………………………)</div>
      </div>
      <div class="col">
        <div class="role">PT. GARDA INTEGRA SOLUSINDO</div>
        <div class="nm-line">( Winardo Mardanus )</div>
        <div class="name">DIREKTUR</div>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('load', function(){ setTimeout(function(){ window.print(); }, 350); });
  </script>
</body>
</html>
