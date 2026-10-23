@php
    use Illuminate\Support\Facades\Auth;
@endphp

<x-layouts.app title="Video">

    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h4 class="text-2xl font-bold text-slate-900 dark:text-white mb-1">Video Informasi</h4>
            <p class="text-sm text-slate-500 dark:text-slate-400">Kelola video yang ditampilkan di dashboard</p>
        </div>

        <button type="button"
                onclick="document.getElementById('addVideoModal').showModal()"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-semibold shadow-sm transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Video
        </button>
    </div>

    {{-- Galeri Video --}}
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-lg font-bold text-slate-900 dark:text-white">Galeri Video</h5>
            <div class="flex gap-2">
                <button type="button" class="p-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors" id="scrollLeft">
                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button type="button" class="p-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors" id="scrollRight">
                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
        
        {{-- Container Scroll Horizontal --}}
        <div class="overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-slate-300 dark:scrollbar-thumb-slate-600" id="videoContainer" style="scroll-behavior: smooth;">
            <div class="flex gap-4" style="width: max-content;">
                @foreach ($videos as $v)
                    @php
                        preg_match('/(youtu\.be\/|v=)([^&]+)/', $v->youtube_url, $m);
                        $videoId = $m[2] ?? null;
                    @endphp

                    @if ($videoId)
                        <div class="w-[320px] bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden shrink-0 flex flex-col transition-colors">
                            <div class="aspect-video w-full">
                                <iframe class="w-full h-full" src="https://www.youtube-nocookie.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                            </div>

                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <h6 class="font-bold text-slate-900 dark:text-white mb-3 line-clamp-2">{{ $v->title ?? 'Tanpa Judul' }}</h6>
                                
                                @if ($v->user_id === Auth::id())
                                    <div class="flex justify-between items-center mt-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $v->is_public ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300' }}">
                                            {{ $v->is_public ? 'Publik' : 'Pribadi' }}
                                        </span>
                                        
                                        <div class="flex gap-1.5">
                                            <button type="button" onclick="document.getElementById('editVideo{{ $v->id }}').showModal()" class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/40 rounded-md transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <button type="button" onclick="document.getElementById('deleteVideo{{ $v->id }}').showModal()" class="p-1.5 text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40 rounded-md transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                
                @if (count($videos) == 0)
                    <div class="w-full flex flex-col items-center justify-center py-12 px-8 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 border-dashed rounded-xl" style="min-width: 300px;">
                        <svg class="w-16 h-16 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                        <p class="text-slate-500 dark:text-slate-400">Belum ada video</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-8 transition-colors">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <strong class="text-slate-900 dark:text-white">Daftar Video</strong>
        </div>

        <div class="p-6 overflow-x-auto">
            {{-- Tambahkan class 'w-full text-sm text-left' agar DataTables tahu ini tabel Tailwind --}}
            <table id="videoTable" class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-700/50 dark:text-slate-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-16">No</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">URL</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-right w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @php $no = 1; @endphp
                    @foreach ($videos as $v)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">{{ $no++ }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $v->title ?? '-' }}</td>
                            <td class="px-6 py-4 max-w-[260px] truncate" title="{{ $v->youtube_url }}">
                                {{ $v->youtube_url }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $v->is_public ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300' }}">
                                    {{ $v->is_public ? 'Publik' : 'Pribadi' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if ($v->user_id === Auth::id())
                                    {{-- Dropdown pakai <details> murni HTML/JS --}}
                                    <details class="relative inline-block text-left">
                                        <summary class="list-none p-2 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 cursor-pointer text-slate-600 dark:text-slate-300 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                        </summary>
                                        <div class="absolute right-0 mt-2 w-36 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 py-1 z-10">
                                            <button type="button" onclick="document.getElementById('editVideo{{ $v->id }}').showModal()" class="w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg> Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('deleteVideo{{ $v->id }}').showModal()" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Hapus
                                            </button>
                                        </div>
                                    </details>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>

                        {{-- ================= MODAL EDIT (HTML DIALOG) ================= --}}
                        @if ($v->user_id === Auth::id())
                            <dialog id="editVideo{{ $v->id }}" class="backdrop:bg-slate-900/50 backdrop:backdrop-blur-sm p-0 rounded-2xl shadow-2xl w-full max-w-md bg-transparent open:flex open:items-center open:justify-center">
                                <div class="bg-white dark:bg-slate-800 w-full rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
                                    <form method="POST" action="{{ route('video.update', $v) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="flex justify-between items-center p-5 border-b border-slate-200 dark:border-slate-700">
                                            <h5 class="text-lg font-bold text-slate-900 dark:text-white">Edit Video</h5>
                                            <button type="button" onclick="this.closest('dialog').close()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>

                                        <div class="p-6 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul</label>
                                                <input type="text" name="title" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ $v->title }}">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">YouTube URL</label>
                                                <input type="url" name="youtube_url" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ $v->youtube_url }}" required>
                                            </div>

                                            <div class="flex items-center gap-3 mt-4">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" name="is_public" value="1" class="sr-only peer" {{ $v->is_public ? 'checked' : '' }}>
                                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                                                    <span class="ml-3 text-sm font-medium text-slate-900 dark:text-slate-300">Video publik</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="flex justify-end gap-3 p-5 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                                            <button type="button" onclick="this.closest('dialog').close()" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700">Batal</button>
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </dialog>

                            {{-- ================= MODAL DELETE (HTML DIALOG) ================= --}}
                            <dialog id="deleteVideo{{ $v->id }}" class="backdrop:bg-slate-900/50 backdrop:backdrop-blur-sm p-0 rounded-2xl shadow-2xl w-full max-w-sm bg-transparent open:flex open:items-center open:justify-center">
                                <div class="bg-white dark:bg-slate-800 w-full rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
                                    <form method="POST" action="{{ route('video.destroy', $v) }}">
                                        @csrf
                                        @method('DELETE')

                                        <div class="flex justify-between items-center p-5 border-b border-slate-200 dark:border-slate-700">
                                            <h5 class="text-lg font-bold text-slate-900 dark:text-white">Hapus Video</h5>
                                            <button type="button" onclick="this.closest('dialog').close()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>

                                        <div class="p-6">
                                            <p class="text-slate-600 dark:text-slate-300">Yakin hapus video "<strong class="text-slate-900 dark:text-white">{{ $v->title ?? 'Tanpa Judul' }}</strong>"?</p>
                                        </div>

                                        <div class="flex justify-end gap-3 p-5 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                                            <button type="button" onclick="this.closest('dialog').close()" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700">Batal</button>
                                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </dialog>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= MODAL TAMBAH (HTML DIALOG) ================= --}}
    <dialog id="addVideoModal" class="backdrop:bg-slate-900/50 backdrop:backdrop-blur-sm p-0 rounded-2xl shadow-2xl w-full max-w-md bg-transparent open:flex open:items-center open:justify-center">
        <div class="bg-white dark:bg-slate-800 w-full rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <form method="POST" action="{{ route('video.store') }}">
                @csrf

                <div class="flex justify-between items-center p-5 border-b border-slate-200 dark:border-slate-700">
                    <h5 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Video</h5>
                    <button type="button" onclick="this.closest('dialog').close()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul</label>
                        <input type="text" name="title" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan judul video">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">YouTube URL</label>
                        <input type="url" name="youtube_url" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="https://www.youtube.com/watch?v=xxxxx" required>
                    </div>

                    <div class="flex items-center gap-3 mt-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_public" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-medium text-slate-900 dark:text-slate-300">Video publik (bisa dilihat user lain)</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 p-5 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                    <button type="button" onclick="this.closest('dialog').close()" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- ================= DATATABLES ================= --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        
        {{-- Gunakan CSS DataTables standar (bukan Bootstrap) --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

        {{-- CSS Kustom agar DataTables menyatu dengan Tailwind --}}
        <style>
            /* Styling input search DataTables */
            div.dt-search input {
                border: 1px solid #cbd5e1 !important;
                border-radius: 0.5rem !important;
                padding: 0.5rem 1rem !important;
                outline: none !important;
                background-color: transparent !important;
            }
            .dark div.dt-search input {
                border-color: #475569 !important;
                color: white !important;
            }
            /* Styling Pagination DataTables */
            div.dt-paging button {
                border: 1px solid #cbd5e1 !important;
                background: white !important;
                border-radius: 0.375rem !important;
                padding: 0.25rem 0.75rem !important;
                margin: 0 0.125rem !important;
                color: #334155 !important;
            }
            .dark div.dt-paging button {
                border-color: #475569 !important;
                background: #1e293b !important;
                color: #cbd5e1 !important;
            }
            div.dt-paging button.current {
                background: #2563eb !important;
                color: white !important;
                border-color: #2563eb !important;
            }
            /* Sembunyikan info "Show X to Y" jika terlalu ramai */
            div.dt-info { display: none; }
        </style>

        <script>
            $(function () {
                $('#videoTable').DataTable({
                    pageLength: 5,
                    lengthChange: false,
                    ordering: true,
                    info: false, // Sembunyikan info bawaan
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
                    ],
                    // Agar DataTables tidak mengubah class Tailwind kita
                    createdRow: function (row, data, dataIndex) {
                        $(row).addClass('hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors');
                    }
                });
                
                // Horizontal scrolling controls
                $('#scrollLeft').on('click', function() {
                    $('#videoContainer').scrollLeft($('#videoContainer').scrollLeft() - 340);
                });
                
                $('#scrollRight').on('click', function() {
                    $('#videoContainer').scrollLeft($('#videoContainer').scrollLeft() + 340);
                });

                // Menutup dropdown <details> jika klik di luar
                document.addEventListener('click', function(event) {
                    const details = document.querySelectorAll('details');
                    details.forEach((detail) => {
                        if (!detail.contains(event.target)) {
                            detail.removeAttribute('open');
                        }
                    });
                });
            });
        </script>
    @endpush

</x-layouts.app>