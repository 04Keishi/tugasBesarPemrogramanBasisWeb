<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PT. Garda Integra Solusindo — Fire Safety Specialist</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@600;700;800;900&display=swap" rel="stylesheet">
<style>
:root{
    --red:#D32027; --red-dark:#A4161A; --red-soft:#FDECEC;
    --red-glow:rgba(211,32,39,.20);
    --ink:#1A1A1E; --ink-soft:#5A5A66; --line:#ECECF1;
    --white:#fff; --sans:'Plus Jakarta Sans',system-ui,sans-serif;
    --display:'Sora',var(--sans);
    --shadow:0 18px 50px rgba(16,16,20,.10);
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:var(--sans);color:var(--ink);-webkit-font-smoothing:antialiased;
    background:
        radial-gradient(1100px 600px at 88% -8%, var(--red-soft), transparent 60%),
        radial-gradient(900px 500px at -5% 105%, #FFF1F1, transparent 55%),
        linear-gradient(180deg,#fff 0%,#FCFCFE 100%);
    overflow-x:hidden;
}
a{text-decoration:none;color:inherit}
button{font-family:inherit;cursor:pointer;border:none}
.wrap{max-width:1200px;margin:0 auto;padding:0 26px}

/* subtle grid texture */
body::before{
    content:'';position:fixed;inset:0;z-index:0;pointer-events:none;opacity:.4;
    background-image:linear-gradient(var(--line) 1px,transparent 1px),linear-gradient(90deg,var(--line) 1px,transparent 1px);
    background-size:54px 54px;
    mask-image:radial-gradient(circle at 50% 30%,#000,transparent 75%);
}

/* ============ NAV ============ */
header{position:fixed;top:0;left:0;right:0;z-index:50;
    background:rgba(255,255,255,.78);backdrop-filter:saturate(180%) blur(14px);
    border-bottom:1px solid var(--line);transition:padding .3s ease}
.nav{display:flex;align-items:center;justify-content:space-between;height:70px}
.logo{display:flex;align-items:center;gap:12px;font-family:var(--display);font-weight:800;font-size:17px}
.logo-mark{width:40px;height:40px;border-radius:11px;background:linear-gradient(135deg,var(--red),var(--red-dark));
    display:grid;place-items:center;color:#fff;font-weight:900;font-size:19px;box-shadow:0 8px 18px var(--red-glow)}
.logo span b{color:var(--red)}
.logo small{display:block;font-family:var(--sans);font-weight:500;font-size:10px;color:var(--ink-soft);letter-spacing:.05em}
.nav-menu{display:flex;gap:6px;align-items:center}
.nav-menu a{padding:9px 15px;border-radius:9px;font-size:14px;font-weight:600;color:var(--ink-soft);transition:.2s}
.nav-menu a:hover{color:var(--red);background:var(--red-soft)}
.btn-login-nav{background:linear-gradient(135deg,var(--red),var(--red-dark));color:#fff !important;
    box-shadow:0 8px 20px var(--red-glow);transition:.25s}
.btn-login-nav:hover{transform:translateY(-2px)}
.burger{display:none;width:42px;height:42px;border-radius:10px;border:1px solid var(--line);background:#fff;place-items:center}
.burger svg{width:22px;height:22px}

/* ============ HERO ============ */
.hero{position:relative;z-index:1;padding:165px 0 90px;text-align:center}
.eyebrow{display:inline-flex;align-items:center;gap:8px;background:var(--white);border:1px solid var(--line);
    padding:8px 16px;border-radius:40px;font-size:13px;font-weight:700;color:var(--red);
    box-shadow:0 4px 14px rgba(16,16,20,.05);margin-bottom:26px;
    animation:fadeUp .6s ease both}
.eyebrow .dot{width:8px;height:8px;border-radius:50%;background:var(--red);box-shadow:0 0 0 4px var(--red-glow);animation:pulse 2s infinite}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 var(--red-glow)}50%{box-shadow:0 0 0 6px transparent}}
.hero h1{font-family:var(--display);font-weight:900;font-size:clamp(38px,6vw,68px);line-height:1.04;
    letter-spacing:-.03em;max-width:900px;margin:0 auto 22px;animation:fadeUp .7s ease both .08s}
.hero h1 .hl{color:var(--red);position:relative;display:inline-block}
.hero h1 .hl::after{content:'';position:absolute;left:0;right:0;bottom:6px;height:14px;
    background:var(--red-glow);z-index:-1;border-radius:4px}
.hero p{font-size:clamp(16px,2vw,19px);color:var(--ink-soft);max-width:680px;margin:0 auto 38px;line-height:1.65;
    animation:fadeUp .7s ease both .16s}
.hero-cta{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;animation:fadeUp .7s ease both .24s}
.btn-xl{display:inline-flex;align-items:center;gap:9px;padding:15px 28px;border-radius:13px;font-size:15.5px;font-weight:700;transition:.25s}
.btn-xl svg{width:19px;height:19px}
.btn-fill{background:linear-gradient(135deg,var(--red),var(--red-dark));color:#fff;box-shadow:0 14px 30px var(--red-glow)}
.btn-fill:hover{transform:translateY(-3px);box-shadow:0 20px 40px var(--red-glow)}
.btn-out{background:var(--white);color:var(--ink);border:1.5px solid var(--line)}
.btn-out:hover{border-color:var(--red);color:var(--red)}

@keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}

/* floating fire badges */
.float-badge{position:absolute;background:var(--white);border:1px solid var(--line);border-radius:14px;
    padding:13px 16px;box-shadow:var(--shadow);display:flex;align-items:center;gap:11px;z-index:2}
.float-badge .fi{width:38px;height:38px;border-radius:10px;background:var(--red-soft);color:var(--red);display:grid;place-items:center}
.float-badge .fi svg{width:20px;height:20px}
.float-badge b{font-size:14px;display:block}
.float-badge small{font-size:11.5px;color:var(--ink-soft)}
.fb-1{top:150px;left:5%;animation:floaty 5s ease-in-out infinite}
.fb-2{top:280px;right:5%;animation:floaty 5.5s ease-in-out infinite .6s}
@keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-14px)}}

/* ============ SECTION HELPERS ============ */
section{position:relative;z-index:1}
.sec-head{text-align:center;max-width:680px;margin:0 auto 54px}
.sec-tag{font-size:13px;font-weight:800;color:var(--red);text-transform:uppercase;letter-spacing:.12em;margin-bottom:12px}
.sec-head h2{font-family:var(--display);font-weight:800;font-size:clamp(28px,4vw,42px);letter-spacing:-.02em;line-height:1.1}
.sec-head p{color:var(--ink-soft);font-size:16px;margin-top:14px;line-height:1.6}

/* reveal on scroll */
.reveal{opacity:0;transform:translateY(34px);transition:opacity .7s cubic-bezier(.16,1,.3,1),transform .7s cubic-bezier(.16,1,.3,1)}
.reveal.show{opacity:1;transform:none}

/* ============ SERVICES ============ */
.services{padding:80px 0}
.svc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.svc-card{background:var(--white);border:1px solid var(--line);border-radius:20px;padding:34px 30px;
    box-shadow:0 1px 2px rgba(16,16,20,.04),0 6px 20px rgba(16,16,20,.05);
    transition:transform .3s cubic-bezier(.16,1,.3,1),box-shadow .3s ease;position:relative;overflow:hidden}
.svc-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;
    background:linear-gradient(90deg,var(--red),var(--red-dark));transform:scaleX(0);transform-origin:left;transition:transform .35s ease}
.svc-card:hover{transform:translateY(-8px);box-shadow:var(--shadow)}
.svc-card:hover::before{transform:scaleX(1)}
.svc-ico{width:58px;height:58px;border-radius:15px;background:linear-gradient(135deg,var(--red-soft),#FFF6F6);
    color:var(--red);display:grid;place-items:center;margin-bottom:22px;transition:.3s}
.svc-card:hover .svc-ico{background:linear-gradient(135deg,var(--red),var(--red-dark));color:#fff;transform:rotate(-6deg) scale(1.06)}
.svc-ico svg{width:28px;height:28px}
.svc-card h3{font-family:var(--display);font-size:20px;font-weight:700;margin-bottom:10px}
.svc-card p{color:var(--ink-soft);font-size:14.5px;line-height:1.65}
.svc-num{position:absolute;right:24px;top:20px;font-family:var(--display);font-weight:800;font-size:46px;color:var(--red-soft)}

/* ============ STATS BAND ============ */
.stats-band{padding:60px 0}
.stats-inner{background:linear-gradient(120deg,var(--red),var(--red-dark));border-radius:26px;
    padding:50px 40px;display:grid;grid-template-columns:repeat(4,1fr);gap:30px;position:relative;overflow:hidden;
    box-shadow:0 24px 60px var(--red-glow)}
.stats-inner::before{content:'';position:absolute;right:-60px;top:-60px;width:260px;height:260px;border-radius:50%;
    background:rgba(255,255,255,.08)}
.stats-inner::after{content:'';position:absolute;left:-40px;bottom:-80px;width:220px;height:220px;border-radius:50%;
    background:rgba(255,255,255,.06)}
.stat-i{text-align:center;color:#fff;position:relative;z-index:1}
.stat-i .n{font-family:var(--display);font-size:44px;font-weight:900;letter-spacing:-.02em}
.stat-i .l{font-size:14px;opacity:.9;font-weight:600;margin-top:4px}

/* ============ ABOUT ============ */
.about{padding:80px 0}
.about-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:54px;align-items:center}
.about-text h2{font-family:var(--display);font-weight:800;font-size:clamp(26px,3.5vw,38px);letter-spacing:-.02em;line-height:1.12;margin-bottom:18px}
.about-text p{color:var(--ink-soft);font-size:15.5px;line-height:1.75;margin-bottom:16px}
.about-list{list-style:none;margin-top:24px;display:grid;gap:14px}
.about-list li{display:flex;align-items:flex-start;gap:12px;font-size:15px;font-weight:600}
.about-list .ck{width:26px;height:26px;border-radius:8px;background:var(--red-soft);color:var(--red);display:grid;place-items:center;flex-shrink:0;margin-top:1px}
.about-list .ck svg{width:15px;height:15px}
.about-visual{position:relative}
.about-visual .panel{background:linear-gradient(135deg,#fff,#FFF8F8);border:1px solid var(--line);border-radius:24px;
    padding:38px;box-shadow:var(--shadow);position:relative;overflow:hidden}
.about-visual .panel .ring{position:absolute;width:200px;height:200px;border:24px solid var(--red-soft);border-radius:50%;right:-70px;top:-70px}
.about-visual .big-ico{width:90px;height:90px;border-radius:24px;background:linear-gradient(135deg,var(--red),var(--red-dark));
    color:#fff;display:grid;place-items:center;margin-bottom:24px;box-shadow:0 16px 34px var(--red-glow)}
.about-visual .big-ico svg{width:46px;height:46px}
.about-visual h4{font-family:var(--display);font-size:22px;font-weight:800;margin-bottom:10px}
.about-visual p{color:var(--ink-soft);font-size:14.5px;line-height:1.65;position:relative;z-index:1}

/* ============ CONTACT ============ */
.contact{padding:80px 0 90px}
.contact-card{background:var(--white);border:1px solid var(--line);border-radius:26px;overflow:hidden;
    display:grid;grid-template-columns:1fr 1fr;box-shadow:var(--shadow)}
.contact-left{padding:50px 46px;background:linear-gradient(135deg,var(--red),var(--red-dark));color:#fff;position:relative;overflow:hidden}
.contact-left::before{content:'';position:absolute;right:-50px;bottom:-50px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.08)}
.contact-left h3{font-family:var(--display);font-size:26px;font-weight:800;margin-bottom:14px}
.contact-left p{opacity:.92;font-size:15px;line-height:1.65;margin-bottom:30px}
.cinfo{display:flex;align-items:flex-start;gap:14px;margin-bottom:20px;position:relative;z-index:1}
.cinfo .ci{width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,.16);display:grid;place-items:center;flex-shrink:0}
.cinfo .ci svg{width:20px;height:20px}
.cinfo b{display:block;font-size:14px;margin-bottom:3px}
.cinfo span{font-size:13.5px;opacity:.88;line-height:1.5}
.contact-right{padding:50px 46px;display:flex;flex-direction:column;justify-content:center}
.contact-right h3{font-family:var(--display);font-size:24px;font-weight:800;margin-bottom:8px}
.contact-right .muted{color:var(--ink-soft);font-size:14.5px;margin-bottom:24px}
.fld{margin-bottom:16px}
.fld label{display:block;font-size:13px;font-weight:700;margin-bottom:7px}
.fld input,.fld textarea{width:100%;padding:12px 15px;border:1px solid var(--line);border-radius:11px;font-size:14px;font-family:inherit;background:#FAFAFC;outline:none;transition:.2s}
.fld input:focus,.fld textarea:focus{border-color:var(--red);background:#fff;box-shadow:0 0 0 4px var(--red-glow)}

/* ============ FOOTER ============ */
footer{background:var(--ink);color:#fff;padding:50px 0 30px;position:relative;z-index:1}
.foot-grid{display:flex;justify-content:space-between;align-items:flex-start;gap:30px;flex-wrap:wrap;margin-bottom:30px}
.foot-brand{max-width:340px}
.foot-brand .logo{color:#fff;margin-bottom:14px}
.foot-brand .logo small{color:#9a9aa5}
.foot-brand p{color:#9a9aa5;font-size:14px;line-height:1.65}
.foot-col h5{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;margin-bottom:16px;color:#c9c9d2}
.foot-col a{display:block;color:#9a9aa5;font-size:14px;margin-bottom:10px;transition:.2s}
.foot-col a:hover{color:var(--red)}
.foot-bottom{border-top:1px solid #2a2a32;padding-top:24px;text-align:center;color:#7a7a86;font-size:13px}

/* ============ LOGIN MODAL ============ */
.modal-bg{position:fixed;inset:0;background:rgba(20,12,12,.55);backdrop-filter:blur(6px);z-index:200;
    display:none;align-items:center;justify-content:center;padding:20px;opacity:0;transition:opacity .3s ease}
.modal-bg.show{display:flex;opacity:1}
.modal{background:#fff;border-radius:24px;width:100%;max-width:430px;overflow:hidden;
    box-shadow:0 40px 90px rgba(0,0,0,.4);transform:translateY(30px) scale(.96);transition:transform .35s cubic-bezier(.16,1,.3,1)}
.modal-bg.show .modal{transform:none}
.modal-top{background:linear-gradient(135deg,var(--red),var(--red-dark));padding:34px 36px 30px;color:#fff;position:relative;overflow:hidden}
.modal-top::before{content:'';position:absolute;right:-40px;top:-40px;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.1)}
.modal-top .mlogo{width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,.18);display:grid;place-items:center;font-family:var(--display);font-weight:900;font-size:24px;margin-bottom:16px}
.modal-top h3{font-family:var(--display);font-size:23px;font-weight:800}
.modal-top p{opacity:.9;font-size:14px;margin-top:4px}
.modal-close{position:absolute;top:18px;right:18px;width:34px;height:34px;border-radius:9px;background:rgba(255,255,255,.18);color:#fff;display:grid;place-items:center;transition:.2s}
.modal-close:hover{background:rgba(255,255,255,.3)}
.modal-close svg{width:18px;height:18px}
.modal-body{padding:32px 36px 36px}
.modal-body .fld input{background:#FAFAFC}
.login-err{background:var(--red-soft);color:var(--red-dark);border:1px solid #F6C9CB;padding:11px 15px;border-radius:11px;font-size:13.5px;font-weight:600;margin-bottom:18px;display:flex;align-items:center;gap:9px}
.login-err svg{width:17px;height:17px;flex-shrink:0}
.btn-submit{width:100%;padding:14px;border-radius:12px;background:linear-gradient(135deg,var(--red),var(--red-dark));color:#fff;font-size:15px;font-weight:700;box-shadow:0 12px 26px var(--red-glow);transition:.25s;margin-top:6px}
.btn-submit:hover{transform:translateY(-2px)}
.hint-box{margin-top:22px;padding:15px 17px;background:#F6F8FC;border:1px dashed #D6DCE8;border-radius:13px;font-size:12.5px;color:var(--ink-soft);line-height:1.7}
.hint-box b{color:var(--ink)}
.hint-box .creds{display:flex;gap:10px;margin-top:8px;flex-wrap:wrap}
.cred-chip{background:#fff;border:1px solid var(--line);border-radius:8px;padding:6px 11px;font-size:12px}
.cred-chip .r{font-weight:700;color:var(--red)}

/* ============ RESPONSIVE ============ */
@media(max-width:920px){
    .svc-grid{grid-template-columns:1fr 1fr}
    .stats-inner{grid-template-columns:1fr 1fr;gap:36px 20px}
    .about-grid{grid-template-columns:1fr;gap:40px}
    .contact-card{grid-template-columns:1fr}
    .float-badge{display:none}
}
@media(max-width:680px){
    .nav-menu{display:none}
    .burger{display:grid}
    .svc-grid{grid-template-columns:1fr}
    .stats-inner{grid-template-columns:1fr 1fr;padding:36px 24px}
    .contact-left,.contact-right{padding:36px 28px}
    .hero{padding:140px 0 60px}
}
.mobile-menu{position:fixed;top:70px;left:0;right:0;background:#fff;border-bottom:1px solid var(--line);
    padding:16px 26px;z-index:49;display:none;flex-direction:column;gap:6px;box-shadow:var(--shadow)}
.mobile-menu.show{display:flex}
.mobile-menu a{padding:12px;border-radius:10px;font-weight:600;color:var(--ink-soft)}
.mobile-menu a:hover{background:var(--red-soft);color:var(--red)}
</style>
</head>
<body>

<!-- NAVBAR -->
<header id="top">
  <div class="wrap nav">
    <a href="#top" class="logo">
      <div class="logo-mark">G</div>
      <span>GARDA <b>INTEGRA</b><small>FIRE SAFETY SPECIALIST</small></span>
    </a>
    <nav class="nav-menu">
      <a href="#layanan">Layanan</a>
      <a href="#tentang">Tentang</a>
      <a href="#kontak">Kontak</a>
      <a href="#" class="btn-login-nav" onclick="openLogin();return false;" style="padding:10px 20px;border-radius:10px;font-weight:700;">Login</a>
    </nav>
    <button class="burger" onclick="toggleMobile()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="#layanan" onclick="toggleMobile()">Layanan</a>
    <a href="#tentang" onclick="toggleMobile()">Tentang</a>
    <a href="#kontak" onclick="toggleMobile()">Kontak</a>
    <a href="#" onclick="toggleMobile();openLogin();return false;" style="color:var(--red);font-weight:700;">Login ke Dashboard</a>
  </div>
</header>

<!-- HERO -->
<section class="hero">
  <div class="float-badge fb-1">
    <div class="fi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg></div>
    <div><b>ISO Certified</b><small>Standar Keamanan</small></div>
  </div>
  <div class="float-badge fb-2">
    <div class="fi"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
    <div><b>500+ Proyek</b><small>Terselesaikan</small></div>
  </div>

  <div class="wrap">
    <div class="eyebrow"><span class="dot"></span> Spesialis Proteksi Kebakaran Industri & Komersil</div>
    <h1>Lindungi Aset Anda dengan <span class="hl">Sistem Fire Safety</span> Terpercaya</h1>
    <p>PT. Garda Integra Solusindo adalah spesialis <b>fire safety</b> — mulai dari konsultasi, instalasi, hingga pengadaan produk proteksi kebakaran berkualitas tinggi untuk kebutuhan industri dan komersil.</p>
    <div class="hero-cta">
      <a href="#" class="btn-xl btn-fill" onclick="openLogin();return false;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        Masuk ke Sistem
      </a>
      <a href="#layanan" class="btn-xl btn-out">
        Lihat Layanan
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services" id="layanan">
  <div class="wrap">
    <div class="sec-head reveal">
      <div class="sec-tag">Layanan Kami</div>
      <h2>Solusi Proteksi Kebakaran Menyeluruh</h2>
      <p>Tiga pilar layanan kami memastikan keamanan total dari perencanaan hingga implementasi sistem.</p>
    </div>
    <div class="svc-grid">
      <div class="svc-card reveal">
        <div class="svc-num">01</div>
        <div class="svc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6M10 22h4M12 2a7 7 0 0 0-4 12.7c.5.4.8 1 .8 1.6V17h6.4v-.7c0-.6.3-1.2.8-1.6A7 7 0 0 0 12 2z"/></svg></div>
        <h3>Konsultasi</h3>
        <p>Analisis risiko kebakaran dan perencanaan sistem proteksi yang disesuaikan dengan karakteristik bangunan dan regulasi yang berlaku.</p>
      </div>
      <div class="svc-card reveal">
        <div class="svc-num">02</div>
        <div class="svc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
        <h3>Instalasi</h3>
        <p>Pemasangan fire alarm system, smoke detector, dan sistem proteksi aktif oleh teknisi bersertifikat dengan standar mutu tertinggi.</p>
      </div>
      <div class="svc-card reveal">
        <div class="svc-num">03</div>
        <div class="svc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></div>
        <h3>Pengadaan Produk</h3>
        <p>Penyediaan produk proteksi kebakaran berkualitas tinggi — detector, control module, hingga sparepart original bergaransi.</p>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats-band">
  <div class="wrap">
    <div class="stats-inner reveal">
      <div class="stat-i"><div class="n" data-count="500">0</div><div class="l">Proyek Selesai</div></div>
      <div class="stat-i"><div class="n" data-count="15">0</div><div class="l">Tahun Pengalaman</div></div>
      <div class="stat-i"><div class="n" data-count="200">0</div><div class="l">Klien Korporat</div></div>
      <div class="stat-i"><div class="n" data-count="24">0</div><div class="l">Layanan / Jam</div></div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="about" id="tentang">
  <div class="wrap">
    <div class="about-grid">
      <div class="about-text reveal">
        <div class="sec-tag">Tentang Kami</div>
        <h2>Mitra Terpercaya untuk Keamanan Kebakaran Anda</h2>
        <p>PT. Garda Integra Solusindo hadir sebagai <i>Assessment, Inspection, Certification & Consultant</i> di bidang fire safety. Kami berkomitmen menghadirkan sistem proteksi kebakaran yang andal untuk melindungi nyawa, aset, dan kelangsungan bisnis Anda.</p>
        <p>Dengan tim ahli berpengalaman dan produk berkualitas, kami memberikan solusi end-to-end yang sesuai standar nasional maupun internasional.</p>
        <ul class="about-list">
          <li><span class="ck"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></span> Teknisi bersertifikat & berpengalaman</li>
          <li><span class="ck"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></span> Produk original bergaransi resmi</li>
          <li><span class="ck"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg></span> Layanan pemeliharaan berkala</li>
        </ul>
      </div>
      <div class="about-visual reveal">
        <div class="panel">
          <div class="ring"></div>
          <div class="big-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
          <h4>Keamanan Adalah Prioritas</h4>
          <p>Setiap proyek kami tangani dengan standar keselamatan tertinggi, memastikan setiap sistem berfungsi optimal saat dibutuhkan.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="contact" id="kontak">
  <div class="wrap">
    <div class="sec-head reveal">
      <div class="sec-tag">Hubungi Kami</div>
      <h2>Mari Diskusikan Kebutuhan Anda</h2>
    </div>
    <div class="contact-card reveal">
      <div class="contact-left">
        <h3>PT. Garda Integra Solusindo</h3>
        <p>Spesialis fire safety untuk industri dan komersil. Kami siap membantu kebutuhan proteksi kebakaran Anda.</p>
        <div class="cinfo">
          <div class="ci"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
          <div><b>Alamat Kantor</b><span>Jl. Sungai No.44, Pangkalan Jati Baru, Kec. Cinere, Kota Depok, Jawa Barat 16513</span></div>
        </div>
        <div class="cinfo">
          <div class="ci"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
          <div><b>Telepon</b><span>(021) 7515957 / 58</span></div>
        </div>
        <div class="cinfo">
          <div class="ci"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
          <div><b>Email</b><span>info@gardaintegra.co.id</span></div>
        </div>
      </div>
      <div class="contact-right">
        <h3>Kirim Pesan</h3>
        <p class="muted">Tim kami akan merespons dalam 1×24 jam.</p>
        <div class="fld"><label>Nama Lengkap</label><input type="text" placeholder="Nama Anda"></div>
        <div class="fld"><label>Email</label><input type="email" placeholder="email@perusahaan.com"></div>
        <div class="fld"><label>Pesan</label><textarea rows="3" placeholder="Ceritakan kebutuhan Anda..."></textarea></div>
        <button class="btn-submit" onclick="alert('Terima kasih! Pesan Anda telah kami terima.');return false;">Kirim Pesan</button>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <a href="#top" class="logo"><div class="logo-mark">G</div><span>GARDA <b>INTEGRA</b><small>FIRE SAFETY SPECIALIST</small></span></a>
        <p>Spesialis fire safety untuk industri dan komersil. Konsultasi, instalasi, hingga pengadaan produk proteksi kebakaran berkualitas tinggi.</p>
      </div>
      <div class="foot-col">
        <h5>Layanan</h5>
        <a href="#layanan">Konsultasi</a>
        <a href="#layanan">Instalasi</a>
        <a href="#layanan">Pengadaan Produk</a>
      </div>
      <div class="foot-col">
        <h5>Perusahaan</h5>
        <a href="#tentang">Tentang Kami</a>
        <a href="#kontak">Kontak</a>
        <a href="#" onclick="openLogin();return false;">Login Sistem</a>
      </div>
    </div>
    <div class="foot-bottom">© {{ date('Y') }} PT. Garda Integra Solusindo. Seluruh hak cipta dilindungi.</div>
  </div>
</footer>

<!-- LOGIN MODAL -->
<div class="modal-bg {{ $errors->any() ? 'show' : '' }}" id="loginModal">
  <div class="modal">
    <div class="modal-top">
      <button class="modal-close" onclick="closeLogin()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      <div class="mlogo">G</div>
      <h3>Selamat Datang</h3>
      <p>Masuk ke sistem manajemen Garda Integra</p>
    </div>
    <div class="modal-body">
      @if($errors->any())
      <div class="login-err"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> {{ $errors->first() }}</div>
      @endif
      <form method="POST" action="{{ route('login.attempt') }}">@csrf
        <div class="fld"><label>Username</label><input type="text" name="username" placeholder="Masukkan username" required autofocus></div>
        <div class="fld"><label>Password</label><input type="password" name="password" placeholder="Masukkan password" required></div>
        <button type="submit" class="btn-submit">Masuk ke Dashboard</button>
      </form>
      <div class="hint-box">
        <b>Akun Login:</b>
        <div class="creds">
          <div class="cred-chip"><span class="r">Direktur</span> · direktur / admin123</div>
          <div class="cred-chip"><span class="r">Pegawai</span> · pegawai / staff123</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function openLogin(){document.getElementById('loginModal').classList.add('show');document.body.style.overflow='hidden';}
function closeLogin(){document.getElementById('loginModal').classList.remove('show');document.body.style.overflow='';}
function toggleMobile(){document.getElementById('mobileMenu').classList.toggle('show');}
document.getElementById('loginModal').addEventListener('click',function(e){if(e.target===this)closeLogin();});
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeLogin();});

/* shrink navbar on scroll */
window.addEventListener('scroll',function(){
  const h=document.querySelector('header');
  if(window.scrollY>20){h.style.height='62px';h.querySelector('.nav').style.height='62px';}
  else{h.style.height='';h.querySelector('.nav').style.height='';}
});

/* reveal on scroll */
const io=new IntersectionObserver((entries)=>{
  entries.forEach(en=>{if(en.isIntersecting){en.target.classList.add('show');io.unobserve(en.target);}});
},{threshold:.12});
document.querySelectorAll('.reveal').forEach(el=>io.observe(el));

/* count up stats */
function animateCount(el){
  const target=+el.dataset.count;let cur=0;const step=Math.ceil(target/45);
  const t=setInterval(()=>{cur+=step;if(cur>=target){cur=target;clearInterval(t);}el.textContent=cur+'+';},22);
}
const statIo=new IntersectionObserver((entries)=>{
  entries.forEach(en=>{if(en.isIntersecting){animateCount(en.target);statIo.unobserve(en.target);}});
},{threshold:.5});
document.querySelectorAll('[data-count]').forEach(el=>statIo.observe(el));
</script>
</body>
</html>
