<nav class="navbar navbar-dark bg-dark px-3">
    {{-- Mobile Sidebar Toggle --}}
    <button class="btn btn-outline-light d-md-none" id="mobileToggle">
        <i class="bi bi-list"></i>
    </button>

    {{-- Desktop Sidebar Toggle --}}
    <button class="btn btn-outline-light d-none d-md-block" id="sidebarToggle">
        <i class="bi bi-layout-sidebar"></i>
    </button>

    <a class="navbar-brand ms-2" href="#">My App</a>

    <div class="ms-auto d-flex align-items-center gap-3">
        @auth

            @php
                $avatar = Auth::user()->userAvatar();
                $name = Auth::user()->userName();
                $email = Auth::user()->userEmail();
            @endphp


            {{-- Dropdown User Profile --}}
            <div class="dropdown">
                <button class="btn d-flex align-items-center text-white dropdown-toggle" type="button" id="profileDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none;">

                    {{-- Avatar kecil di navbar --}}
                    <img src="{{ $avatar }}" alt="User Avatar" class="rounded-circle me-2" width="35"
                        height="35" style="object-fit: cover;"
                        onerror="this.onerror=null; this.src='{{ asset('images/images1.png') }}';">

                    <span class="fw-semibold d-none d-md-inline">
                        {{ $name }}
                    </span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end mt-2 p-0" aria-labelledby="profileDropdown"
                    style="width: 260px;">

                    {{-- Header: Avatar besar + Nama + Email --}}
                    <li class="p-3 border-bottom">
                        <div class="text-center">
                            <img src="{{ $avatar }}" class="rounded-circle mb-2" width="70" height="70"
                                style="object-fit: cover;"
                                onerror="this.onerror=null; this.src='{{ asset('images/images1.png') }}';">

                            <div class="fw-semibold" style="font-size: 0.95rem;">
                                {{ $name }}
                            </div>
                            <div class="text-muted" style="font-size: 0.8rem;">
                                {{ $email }}
                            </div>
                        </div>
                    </li>

                    {{-- Menu Profile --}}
                    <li>
                        <a class="dropdown-item py-2" href="/profil">
                            <i class="bi bi-person-circle me-2"></i> Profile
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    {{-- Logout --}}
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger py-2">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        @endauth
    </div>
</nav>
