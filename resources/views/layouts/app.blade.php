<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>PROXY.FACTURE</title>

@include('partials.favicon')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@stack('styles')

<style>

body{
background:#f4f6f9;
}

.sidebar{
height:100vh;
width:250px;
position:fixed;
left:0;
top:0;
box-sizing:border-box;
background:#2d6a4f;
color:white;
padding:16px 1rem 16px 0;
overflow:hidden;
display:flex;
flex-direction:column;
}

.sidebar-inner {
    min-height: 0;
    flex: 1 1 auto;
    display: flex;
    flex-direction: column;
}

.sidebar .logo { margin-bottom: 1rem; padding-left: 1rem; min-width: 0; }
.sidebar-brand-block { gap: 0.65rem; }
.sidebar .logo img.sidebar-brand-logo {
    display: block;
    width: auto;
    height: auto;
    max-height: 56px;
    max-width: min(180px, 100%);
    object-fit: contain;
    object-position: left center;
    flex-shrink: 0;
}
.sidebar-brand-title {
    font-size: 0.95rem;
    line-height: 1.3;
    letter-spacing: 0.04em;
    color: rgba(255,255,255,0.98);
    text-align: left;
    width: 100%;
    padding-right: 0.5rem;
}
.sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    padding-right: 4px;
    padding-left: 1rem;
    min-height: 0;
    flex: 1 1 auto;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
}
.sidebar-nav::-webkit-scrollbar { width: 6px; }
.sidebar-nav::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); border-radius: 3px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
.sidebar-link {
    display: flex;
    align-items: center;
    color: white;
    padding: 0.6rem 1rem;
    text-decoration: none;
    border-radius: 0.375rem;
    transition: background 0.2s;
    flex-shrink: 0;
}
.sidebar-link:hover { background: #40916c; color: white; }
.sidebar-icon { width: 1.5rem; margin-right: 0.75rem; flex-shrink: 0; text-align: center; }

/* Pied : bloc utilisateur — ne recouvre pas la nav (nav scroll au-dessus) */
.sidebar-user-area {
    position: relative;
    padding-top: 0.5rem;
    margin-top: 0.35rem;
    border-top: 1px solid rgba(255,255,255,0.22);
}
.sidebar-user-btn {
    background: rgba(0,0,0,0.2);
    border-radius: 10px;
    padding: 0.45rem 0.5rem;
    transition: background 0.2s;
}
.sidebar-user-btn:hover,
.sidebar-user-btn:focus-visible {
    background: rgba(0,0,0,0.3);
    color: #fff;
    outline: none;
}
.sidebar-user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #fff;
    font-size: 1rem;
}
.sidebar-user-email { opacity: 0.88; font-size: 0.7rem !important; }
.sidebar-user-chevron { transition: transform 0.2s ease; }
.sidebar-user-btn[aria-expanded="true"] .sidebar-user-chevron { transform: rotate(180deg); }

/* Carte menu : reste dans la colonne sidebar (~230px), au-dessus du bouton */
.sidebar-user-flyout {
    position: absolute;
    left: 0;
    right: 0;
    bottom: calc(100% + 6px);
    width: 100%;
    max-width: 100%;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.18);
    z-index: 20;
    max-height: min(300px, 48vh);
    overflow-x: hidden;
    overflow-y: auto;
    text-align: left;
}
.sidebar-user-flyout-head {
    background: linear-gradient(180deg, #e8f5ef 0%, #f6fbf8 100%);
    border-radius: 12px 12px 0 0;
}
.sidebar-user-avatar-lg {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #fff;
    border: 2px solid #c3e6d0;
    font-size: 1.1rem;
}
.sidebar-flyout-ico {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
}
.sidebar-flyout-ico--prof { background: #d8f3e0; color: #1e5c3d; }
.sidebar-flyout-ico--set { background: #ebe4f7; color: #4a3f6b; }
.sidebar-flyout-ico--help { background: #ebe4f7; color: #4a3f6b; }
.sidebar-flyout-ico--out { background: #fde8e8; color: #c92a2a; }
.sidebar-user-flyout .list-group-item:hover { background: #f8faf9; }
.sidebar-logout-btn:hover { background: #fff5f5 !important; }

.main-content{
margin-left:250px;
padding:20px;
min-height:100vh;
box-sizing:border-box;
position:relative;
}

.logo{
font-size:24px;
font-weight:bold;
margin-bottom:30px;
}

</style>

</head>

<body>

@include('layouts.sidebar')

<div class="main-content">

@include('layouts.navbar')

@yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('sidebarUserToggle');
    var flyout = document.getElementById('sidebarUserFlyout');
    if (!toggle || !flyout) return;

    function setOpen(open) {
        flyout.hidden = !open;
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    toggle.addEventListener('click', function (e) {
        e.stopPropagation();
        setOpen(flyout.hidden);
    });

    document.addEventListener('click', function (e) {
        if (toggle.contains(e.target) || flyout.contains(e.target)) return;
        setOpen(false);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') setOpen(false);
    });
});
</script>
@stack('scripts')
</body>
</html>