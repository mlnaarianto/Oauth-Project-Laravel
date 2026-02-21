@php
    use Illuminate\Support\Facades\Auth;
@endphp

<x-layouts.app title="Video">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Video Informasi</h4>
            <small class="text-muted">Kelola video yang ditampilkan di dashboard</small>
        </div>

        <button type="button"
                class="btn btn-primary shadow-sm"
                data-bs-toggle="modal"
                data-bs-target="#addVideo">
            <i class="bi bi-plus-circle me-1"></i> Tambah Video
        </button>
    </div>

    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Galeri Video</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary" id="scrollLeft">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary" id="scrollRight">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
        
        <div class="overflow-auto pb-3" id="videoContainer" style="scroll-behavior: smooth; scrollbar-width: thin;">
            <div class="d-flex gap-3" style="width: max-content;">
                @foreach ($videos as $v)
                    @php
                        preg_match('/(youtu\.be\/|v=)([^&]+)/', $v->youtube_url, $m);
                        $videoId = $m[2] ?? null;
                    @endphp

                    @if ($videoId)
                        <div class="card shadow-sm" style="width: 320px;">
                            <div class="ratio ratio-16x9">
                                <iframe
                                    src="https://www.youtube-nocookie.com/embed/{{ $videoId }}"
                                    allowfullscreen>
                                </iframe>
                            </div>

                            <div class="card-body">
                                <h6 class="card-title mb-2">{{ $v->title ?? 'Tanpa Judul' }}</h6>
                                
                                @if ($v->user_id === Auth::id())
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge {{ $v->is_public ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $v->is_public ? 'Publik' : 'Pribadi' }}
                                        </span>
                                        
                                        <div class="btn-group btn-group-sm">
                                            <button type="button"
                                                    class="btn btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editVideo{{ $v->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteVideo{{ $v->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                
                @if (count($videos) == 0)
                    <div class="text-center py-5 px-5" style="min-width: 300px;">
                        <i class="bi bi-film display-1 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada video</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <strong>Daftar Video</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="videoTable" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Judul</th>
                            <th>URL</th>
                            <th>Status</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($videos as $v)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $v->title ?? '-' }}</td>
                                <td class="text-truncate" style="max-width:260px">
                                    {{ $v->youtube_url }}
                                </td>
                                <td>
                                    <span class="badge {{ $v->is_public ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $v->is_public ? 'Publik' : 'Pribadi' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    @if ($v->user_id === Auth::id())
                                        <div class="dropdown">
                                            <button type="button"
                                                    class="btn btn-sm btn-light"
                                                    data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#editVideo{{ $v->id }}">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#deleteVideo{{ $v->id }}">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- ================= MODAL EDIT ================= --}}
                            @if ($v->user_id === Auth::id())
                                <div class="modal fade" id="editVideo{{ $v->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('video.update', $v) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Video</h5>
                                                    <button type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul</label>
                                                        <input type="text"
                                                               name="title"
                                                               class="form-control"
                                                               value="{{ $v->title }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">YouTube URL</label>
                                                        <input type="url"
                                                               name="youtube_url"
                                                               class="form-control"
                                                               value="{{ $v->youtube_url }}"
                                                               required>
                                                        {{-- <div class="form-text">Contoh: https://www.youtube.com/watch?v=xxxxx</div> --}}
                                                    </div>

                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input"
                                                               type="checkbox"
                                                               name="is_public"
                                                               value="1"
                                                               id="isPublic{{ $v->id }}"
                                                               {{ $v->is_public ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                               for="isPublic{{ $v->id }}">
                                                            Video publik
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- ================= MODAL DELETE ================= --}}
                                <div class="modal fade" id="deleteVideo{{ $v->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-sm">
                                        <form method="POST" action="{{ route('video.destroy', $v) }}">
                                            @csrf
                                            @method('DELETE')

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hapus Video</h5>
                                                    <button type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <p>Yakin hapus video "<strong>{{ $v->title ?? 'Tanpa Judul' }}</strong>"?</p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= MODAL TAMBAH ================= --}}
    <div class="modal fade" id="addVideo" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('video.store') }}">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Video</h5>
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control" placeholder="Masukkan judul video">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">YouTube URL</label>
                            <input type="url"
                                   name="youtube_url"
                                   class="form-control"
                                   placeholder="https://www.youtube.com/watch?v=xxxxx"
                                   required>
                            {{-- <div class="form-text">Contoh: https://www.youtube.com/watch?v=xxxxx</div> --}}
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_public"
                                   value="1"
                                   id="isPublicAdd">
                            <label class="form-check-label" for="isPublicAdd">
                                Video publik (bisa dilihat user lain)
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= DATATABLES ================= --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <link rel="stylesheet"
              href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(function () {
                $('#videoTable').DataTable({
                    pageLength: 5,
                    lengthChange: false,
                    ordering: true,
                    info: true,
                    language: {
                        search: "Cari:",
                        emptyTable: "Belum ada video",
                        paginate: {
                            previous: "‹",
                            next: "›"
                        }
                    },
                    columnDefs: [
                        { orderable: false, targets: [0, 4] }
                    ]
                });
                
                // Horizontal scrolling controls
                $('#scrollLeft').on('click', function() {
                    $('#videoContainer').scrollLeft($('#videoContainer').scrollLeft() - 340);
                });
                
                $('#scrollRight').on('click', function() {
                    $('#videoContainer').scrollLeft($('#videoContainer').scrollLeft() + 340);
                });
            });
        </script>
    @endpush

</x-layouts.app>