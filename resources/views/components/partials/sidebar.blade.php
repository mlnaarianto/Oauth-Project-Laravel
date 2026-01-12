<div id="sidebar" class="bg-dark">
    <ul class="nav flex-column pt-3 px-2">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                <i class="bi bi-house"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::is('video') ? 'active' : '' }}" href="/video">
                <i class="bi bi-play-circle"></i> Video
            </a>
        </li>


        <li class="nav-item mt-3">
            <small class="text-secondary ms-2">Menu Lain</small>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::is('example') ? 'active' : '' }}" href="#">
                <i class="bi bi-box"></i> Example Menu
            </a>
        </li>

    </ul>
</div>

{{-- CSS Langsung di sini --}}
<style>
    #sidebar {
        width: 240px;
        min-height: 100vh;
    }

    #sidebar .nav-link {
        color: #bbb;
        padding: 10px 14px;
        border-radius: 6px;
        margin-bottom: 4px;
        transition: 0.2s;
    }

    /* Saat hover */
    #sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    /* ACTIVE MENU (Dashboard, About, dll) */
    #sidebar .nav-link.active {
        background: #fff !important;
        color: #000 !important;
        font-weight: 600;
    }

    #sidebar .nav-link.active i {
        color: #000 !important;
    }
</style>
