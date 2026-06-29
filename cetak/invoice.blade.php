<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak Invoice ({{ $modeLabel }}) · {{ $inv->no_invoice }}</title>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { background:#5b5b5b; font-family:'Arial','Helvetica',sans-serif; color:#000; padding:24px; }
  .toolbar { max-width:794px; margin:0 auto 16px; display:flex; gap:10px; justify-content:flex-end; align-items:center; }
  .toolbar .mode-tag { margin-right:auto; background:#fff; color:#333; border:1px solid #ccc; border-radius:8px; padding:8px 14px; font:600 12px/1 Arial,sans-serif; }
  .toolbar .mode-tag b { color:#D32027; }
  .toolbar button, .toolbar a { font:600 13px/1 Arial,sans-serif; padding:10px 18px; border-radius:8px; border:none; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
  .toolbar .print { background:#D32027; color:#fff; }
  .toolbar .back  { background:#fff; color:#333; border:1px solid #ccc; }
  .toolbar svg { width:15px; height:15px; }

  .page { width:794px; min-height:1123px; margin:0 auto; background:#fff; padding:44px 46px; box-shadow:0 4px 30px rgba(0,0,0,.4); font-size:12px; }

  .head { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; }
  .logo .l1 { font-size:21px; font-weight:800; letter-spacing:.2px; line-height:1; }
  .logo .l1 .it { font-style:italic; color:#D32027; font-family:Georgia,'Times New Roman',serif; }
  .logo .tag { font-style:italic; font-weight:700; font-size:11px; border-bottom:2px solid #000; padding-bottom:3px; margin-bottom:6px; display:inline-block; }
  .logo address { font-style:normal; font-size:10.5px; color:#1f3a6b; line-height:1.5; }
  .logo address .ph { color:#1f3a6b; }
  .inv-title { text-align:right; }
  .inv-title h1 { font-size:30px; font-weight:800; letter-spacing:5px; }
  .inv-title .no { font-size:15px; font-weight:700; margin-top:18px; }

  table.info { width:100%; border-collapse:collapse; margin-bottom:0; font-size:11px; }
  table.info td { border:1px solid #000; padding:4px 7px; vertical-align:top; }
  .info .yth { width:48%; font-weight:700; vertical-align:top; }
  .info .yth .lines { font-weight:400; margin-top:3px; }
  .info .k { width:90px; font-weight:400; }
  .info .pname { font-weight:700; text-transform:uppercase; }

  table.items { width:100%; border-collapse:collapse; font-size:11px; }
  table.items th, table.items td { border:1px solid #000; padding:7px; vertical-align:top; }
  table.items thead th { text-align:center; font-weight:700; }
  .items .c-no { width:34px; text-align:center; }
  .items .c-qty { width:80px; }
  .items .c-price { width:150px; }
  .items .c-total { width:150px; }
  .qty-cell { display:flex; justify-content:space-between; }
  .money2 { display:flex; justify-content:space-between; white-space:nowrap; }
  .items .filler td { height:60px; }
  .items .total-row td { font-weight:700; }
  .ta-r { text-align:right; }

  .totals { display:flex; border:1px solid #000; border-top:none; font-size:11px; }
  .totals .terb { width:48%; border-right:1px solid #000; padding:7px; }
  .totals .terb .k { font-weight:700; }
  .totals .nums { flex:1; }
  .totals .nums table { width:100%; border-collapse:collapse; }
  .totals .nums td { padding:4px 7px; }
  .totals .nums td.lbl { text-align:right; font-weight:700; }
  .totals .nums td.rp  { width:26px; border-left:1px solid #000; }
  .totals .nums td.amt { text-align:right; width:130px; white-space:nowrap; }
  .totals .nums tr.grand td { font-weight:800; border-top:1px solid #000; }

  .foot { display:flex; justify-content:space-between; margin-top:18px; font-size:11px; }
  .pay { width:54%; }
  .pay .lead { margin-bottom:4px; }
  table.bank { border-collapse:collapse; width:100%; max-width:330px; }
  table.bank td { border:1px solid #000; padding:5px 8px; }
  table.bank .title-row td { font-weight:700; text-align:center; }
  table.bank .idr { width:42px; font-weight:700; text-align:center; vertical-align:middle; }
  .sign { width:40%; text-align:center; }
  .sign .hk { margin-bottom:60px; }
  .sign .nm { font-weight:800; text-decoration:underline; }

  @media print {
    body { background:#fff; padding:0; }
    .toolbar { display:none; }
    .page { box-shadow:none; margin:0; width:100%; min-height:auto; padding:24px 28px; }
    @page { size:A4; margin:10mm; }
  }
</style>
</head>
<body>
@php
  $dash = fn ($v) => trim((string) $v) === '' ? '-' : trim((string) $v);
@endphp
  <div class="toolbar">
    <span class="mode-tag">Mode cetak: <b>{{ $modeLabel }}</b></span>
    <button class="print" onclick="window.print()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
      Cetak / Simpan PDF
    </button>
    <a class="back" href="{{ route('purchase_order.index') }}">Kembali</a>
  </div>

  <div class="page">
    <div class="head">
      <div class="logo">
        <div class="l1">PT.GARDA <span class="it">Integra</span> Solusindo</div>
        <div class="tag">Assessment, Inspection, Certification &amp; Consultant</div>
        <address>
          Jalan Andara Ujung, GG Sungai, RT 02 RW 02 No. 99,<br>
          Kel. Pangkalan Jati Baru, Kec. Cinere, Depok,<br>
          Jawa Barat, 16513<br>
          <span class="ph">Phone : (021) 7515957/58</span>
        </address>
      </div>
      <div class="inv-title">
        <h1>INVOICE</h1>
        <div class="no">No. : {{ $inv->no_invoice }}</div>
      </div>
    </div>

    <table class="info">
      <tr>
        <td class="yth" rowspan="7">
          Kepada YTH,
          <div class="lines">{!! nl2br(e($dash($inv->alamat))) !!}</div>
          <div style="margin-top:36px;">Up : {{ $dash($inv->pegawai->nama_pegawai ?? '') }}</div>
        </td>
        <td class="k">Date</td><td>{{ $inv->tanggal ? tgl_id($inv->tanggal) : '-' }}</td>
      </tr>
      <tr><td class="k">PO No.</td><td>{{ $dash($inv->po_no) }}</td></tr>
      <tr><td class="k">SPK No.</td><td>{{ $dash($inv->spk_no) }}</td></tr>
      <tr><td class="k">BAST</td><td>{{ $dash($inv->bast) }}</td></tr>
      <tr><td class="k">Tax Code</td><td>{{ $dash($inv->tax_code) }}</td></tr>
      <tr><td class="k">Terms.</td><td>{{ $dash($inv->terms) }}</td></tr>
      <tr><td class="k">Project Name</td><td class="pname">{{ $projectDesc }}</td></tr>
    </table>

    <table class="items">
      <thead>
        <tr>
          <th class="c-no">NO</th><th class="desc-main">DESCRIPTION</th>
          <th class="c-qty">QTY</th><th class="c-price">UNIT PRICE</th><th class="c-total">TOTAL</th>
        </tr>
      </thead>
      <tbody>
        @php $n = 0; @endphp
        @foreach ($lineItems as $li)
        @php $n++; @endphp
        <tr>
          <td class="c-no">{{ $n }}</td>
          <td class="desc-main">{{ $li['desc'] }}</td>
          <td><div class="qty-cell"><span>{{ angka($li['qty']) }}</span><span>{{ $li['unit'] }}</span></div></td>
          <td><div class="money2"><span class="rp">Rp</span><span>{{ angka($li['price']) }}</span></div></td>
          <td><div class="money2"><span class="rp">Rp</span><span>{{ angka($li['total']) }}</span></div></td>
        </tr>
        @endforeach
        @for ($i = $n; $i < 4; $i++)
        <tr class="filler"><td class="c-no">&nbsp;</td><td></td><td></td><td></td><td></td></tr>
        @endfor
        <tr class="total-row">
          <td></td><td></td><td class="ta-r">Total</td><td></td>
          <td><div class="money2"><span class="rp">Rp</span><span>{{ angka($total) }}</span></div></td>
        </tr>
      </tbody>
    </table>

    <div class="totals">
      <div class="terb">
        <span class="k">Terbilang :</span>
        <div style="font-style:italic;text-transform:capitalize;margin-top:3px;">{{ $terbilang }}</div>
      </div>
      <div class="nums">
        <table>
          <tr><td class="lbl">TOTAL</td><td class="rp">Rp</td><td class="amt">{{ angka($total) }}</td></tr>
          <tr><td class="lbl">DPP NILAI LAIN</td><td class="rp">Rp</td><td class="amt">{{ angka($dpp) }}</td></tr>
          <tr><td class="lbl">PPN</td><td class="rp">Rp</td><td class="amt">{{ angka($ppn) }}</td></tr>
          <tr class="grand"><td class="lbl">GRAND TOTAL</td><td class="rp">Rp</td><td class="amt">{{ angka($grand) }}</td></tr>
        </table>
      </div>
    </div>

    <div class="foot">
      <div class="pay">
        <div class="lead">Pembayaran (FULL AMOUNT) a/n Rekening :</div>
        <table class="bank">
          <tr class="title-row"><td colspan="2">{{ $dash($inv->rekening) }}</td></tr>
          <tr><td class="idr" rowspan="2">IDR</td><td>a/c -</td></tr>
          <tr><td>BANK -</td></tr>
        </table>
      </div>
      <div class="sign">
        <div class="hk">Hormat kami,</div>
        <div class="nm">WINARDO MARDANUS</div>
        <div class="role">DIREKTUR</div>
      </div>
    </div>
  </div>

  <script>
    @if ($auto)
    window.addEventListener('load', function(){ setTimeout(function(){ window.print(); }, 350); });
    @endif
  </script>
</body>
</html>
