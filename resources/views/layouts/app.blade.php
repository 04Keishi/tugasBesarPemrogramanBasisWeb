<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard') · Garda Integra</title>
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>
<body>
@php
    $user = auth()->user();
    $nama = $user->name ?? 'User';
    $role = $user->role ?? 'pegawai';
    $inisial = strtoupper(substr($nama, 0, 1));
    $isPegawai = $user && $user->isPegawai();

    $active = $active ?? 'dashboard';

    $navItems = [
        'dashboard'      => ['Dashboard',      route('dashboard')],
        'pegawai'        => ['Pegawai',         route('pegawai.index')],
        'customer'       => ['Customer',        route('customer.index')],
        'project'        => ['Project',         route('project.index')],
        'vendor'         => ['Vendor',          route('vendor.index')],
        'product'        => ['Product',         route('product.index')],
        'purchase_order' => ['Purchase Order',  route('purchase_order.index')],
    ];

    $masterMenu = [
        'pegawai'  => ['Pegawai',  route('pegawai.index'),  '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
        'customer' => ['Customer', route('customer.index'), '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>'],
        'project'  => ['Project',  route('project.index'),  '<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>'],
        'vendor'   => ['Vendor',   route('vendor.index'),   '<path d="M3 9l1-5h16l1 5"/><path d="M5 9v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9"/><path d="M9 22V12h6v10"/>'],
        'product'  => ['Product',  route('product.index'),  '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>'],
    ];

    $transMenu = [
        'purchase_order' => ['Purchase Order & Invoice', route('purchase_order.index'), '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>'],
    ];
@endphp

<!-- NAVBAR -->
<nav class="navbar">
  <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Menu">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
  </button>
  <a href="{{ route('dashboard') }}" class="brand">
    <div class="logo-mark">G</div>
    <span>GARDA <b>INTEGRA</b><small>MANAGEMENT SYSTEM</small></span>
  </a>
  <div class="nav-links">
    @foreach ($navItems as $slug => $nav)
      <a href="{{ $nav[1] }}" class="{{ $active === $slug ? 'active' : '' }}">{{ $nav[0] }}</a>
    @endforeach
  </div>
  <div class="nav-right">
    <div class="nav-user">
      <div class="uname-wrap">
        <div class="uname">{{ $nama }}</div>
        <div class="urole">{{ $role }}</div>
      </div>
      <div class="avatar">{{ $inisial }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
      @csrf
      <button type="submit" class="btn-logout">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Logout
      </button>
    </form>
  </div>
</nav>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="group-label">Master</div>
  @foreach ($masterMenu as $slug => $m)
    <a href="{{ $m[1] }}" class="menu-item {{ $active === $slug ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $m[2] !!}</svg>
      {{ $m[0] }}
    </a>
  @endforeach

  <div class="group-label">Transaksi</div>
  @foreach ($transMenu as $slug => $m)
    <a href="{{ $m[1] }}" class="menu-item {{ $active === $slug ? 'active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $m[2] !!}</svg>
      {{ $m[0] }}
    </a>
  @endforeach

  <div class="group-label">Akun</div>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="menu-item" style="color:var(--red);width:100%;text-align:left;background:none;border:none;cursor:pointer;font:inherit;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Logout
    </button>
  </form>
</aside>

<!-- MAIN -->
<main class="main">
  @if (session('flash_success'))
    <div class="flash success"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>{{ session('flash_success') }}</div>
  @endif
  @if (session('flash_error'))
    <div class="flash error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ session('flash_error') }}</div>
  @endif
  @if ($errors->any())
    <div class="flash error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $errors->first() }}</div>
  @endif

  @if ($isPegawai && $active === 'pegawai')
    <div class="readonly-note">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
      Mode <b>Lihat Saja</b> — sebagai Pegawai, Anda hanya dapat melihat data Master Pegawai. Akses ubah tersedia untuk Direktur.
    </div>
  @elseif ($isPegawai && in_array($active, ['customer','project','vendor','product']))
    <div class="readonly-note">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
      Sebagai Pegawai, Anda dapat <b>menambah</b> dan <b>mengubah</b> data ini. Tindakan <b>hapus</b> hanya tersedia untuk Direktur.
    </div>
  @endif

  @yield('content')
</main>

<script>
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('overlay').classList.toggle('show');
}

/* Live table search */
function tableSearch(input, tableId){
  const q = input.value.toLowerCase();
  const rows = document.querySelectorAll('#'+tableId+' tbody tr');
  let visible = 0;
  rows.forEach(r=>{
    if(r.classList.contains('empty-row')) return;
    const match = r.textContent.toLowerCase().includes(q);
    r.style.display = match ? '' : 'none';
    if(match) visible++;
  });
  const noRes = document.getElementById('noResults');
  if(noRes) noRes.style.display = (visible===0 && q) ? '' : 'none';
}

/* Confirm delete: submit hidden form */
function confirmDelete(e, name){
  if(!confirm('Yakin ingin menghapus "'+name+'"? Tindakan ini tidak dapat dibatalkan.')){
    e.preventDefault();
    return false;
  }
  return true;
}
</script>
@stack('scripts')
</body>
</html>
