<x-layouts.app title="Profil Saya">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8"> {{-- Lebar card diperbesar sedikit (dari col-lg-7 menjadi col-lg-8) --}}

                {{-- Notifikasi --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-lg border-0 rounded-4"> {{-- Shadow lebih tebal --}}

                    {{-- Header Profil --}}
                    <div class="card-body p-5 text-center bg-light rounded-top-4"> {{-- Memberi latar belakang ringan pada header --}}
                        
                        {{-- Avatar --}}
                        <div class="position-relative d-inline-block mb-3">
                            <img id="avatar-preview" 
                                 src="{{ Auth::user()->userAvatar() }}"
                                 class="rounded-circle shadow-lg border border-white" {{-- Border putih tebal --}}
                                 width="150" height="150" style="object-fit: cover;">
                            
                            {{-- Placeholder untuk Tombol Upload Avatar (Jika ada) --}}
                            {{-- <button class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0" title="Ganti Foto">
                                <i class="fas fa-camera"></i>
                            </button> --}}
                        </div>

                        <h3 class="fw-bold mb-1">{{ Auth::user()->userName() }}</h3>
                        <p class="text-secondary mb-0">{{ Auth::user()->userEmail() }}</p>

                       
                    </div>

                    {{-- Konten Utama: Informasi & Keamanan --}}
                    <div class="row g-0">

                        {{-- Kolom Informasi Akun --}}
                        <div class="col-md-6 border-end p-4">
                            <h5 class="fw-bold mb-4 text-primary"><i class="fas fa-info-circle me-2"></i> Detail Dasar</h5>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-0">
                                    <span class="text-muted">Nama Lengkap</span>
                                    <span class="fw-semibold">{{ Auth::user()->userName() }}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-0">
                                    <span class="text-muted">Email</span>
                                    <span class="fw-semibold text-break">{{ Auth::user()->userEmail() }}</span> {{-- Tambahkan text-break --}}
                                </li>
                                
                                {{-- Jika ada informasi lain (e.g., Nomor Telepon, Alamat) bisa ditambahkan di sini --}}
                                {{-- <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-0">
                                    <span class="text-muted">Nomor Telepon</span>
                                    <span class="fw-semibold">0812-xxxx-xxxx</span>
                                </li> --}}
                            </ul>
                        </div>

                        {{-- Kolom Keamanan Akun --}}
                        <div class="col-md-6 p-4">
                            <h5 class="fw-bold mb-4 text-danger"><i class="fas fa-shield-alt me-2"></i> Keamanan Akun</h5>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-0">
                                    <span class="text-muted">Login Terakhir Via</span>
                                    <span class="badge bg-primary px-3 py-2 fw-normal"> {{-- Ubah dari bg-info ke bg-primary --}}
                                        <i class="fab fa-{{ strtolower(Auth::user()->last_login_provider ?? 'user') }} me-1"></i>
                                        {{ ucfirst(Auth::user()->last_login_provider ?? 'Sistem') }}
                                    </span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-0">
                                    <span class="text-muted">Tanggal Dibuat</span>
                                    <span class="fw-semibold">{{ Auth::user()->created_at->format('d F Y') }}</span>
                                </li>
                            </ul>
                        </div>
                        
                    </div> {{-- Akhir dari row g-0 --}}
                    
                   
                </div>

            </div>
        </div>

    </div>

</x-layouts.app>