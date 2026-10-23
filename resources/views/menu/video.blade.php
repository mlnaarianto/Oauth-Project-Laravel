@php
    use Illuminate\Support\Facades\Auth;
@endphp

<x-layouts.app title="Video">

    <style>
        /* Cyber card hover effect */
        .cyber-card {
            transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        }
        .cyber-card:hover {
            transform: translateY(-2px);
            border-color: rgba(34, 211, 238, .45);
            box-shadow: 0 16px 32px -22px rgba(34, 211, 238, .45);
        }
        
        /* Kustomisasi DataTables agar menyatu dengan tema */
        div.dt-search input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            outline: none !important;
            background-color: transparent !important;
            transition: all .2s ease;
        }
        div.dt-search input:focus {
            border-color: #22d3ee !important;
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.2) !important;
        }
        .dark div.dt-search input {
            border-color: #334155 !important;
            color: white !important;
        }
        .dark div.dt-search input:focus {
            border-color: #22d3ee !important;
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.1) !important;
        }
        
        /* Pagination DataTables */
        div.dt-paging button {
            border: 1px solid #cbd5e1 !important;
            background: white !important;
            border-radius: 0.375rem !important;
            padding: 0.25rem 0.75rem !important;
            margin: 0 0.125rem !important;
            color: #334155 !important;
            transition: all .2s ease;
        }
        .dark div.dt-paging button {
            border-color: #334155 !important;
            background: #0f172a !important;
            color: #cbd5e1 !important;
        }
        div.dt-paging button:hover {
            border-color: #22d3ee !important;
            color: #0891b2 !important;
        }
        .dark div.dt-paging button:hover {
            border-color: #22d3ee !important;
            color: #22d3ee !important;
            background: rgba(34, 211, 238, 0.1) !important;
        }
        div.dt-paging button.current {
            background: rgba(34, 211, 238, 0.1) !important;
            color: #0891b2 !important;
            border-color: #22d3ee !important;
            font-weight: 600;
        }
        .dark div.dt-paging button.current {
            color: #22d3ee !important;
        }
        div.dt-info { display: none; }
    </style>

    <div class="mx-auto w-full max-w-6xl py-4">

        {{-- ============================================================
             HEADER HALAMAN
             ============================================================ --}}
        <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/5 px-3 py-1 font-mono text-[10px] uppercase tracking-[0.2em] text-cyan-700 dark:border-cyan-400/25 dark:bg-cyan-400/5 dark:text-cyan-300">
                    <span class="relative flex h-1.5 w-1.5" aria-hidden="true">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-400 opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                    </span>
                    video.database
                </div>
                <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-50 sm:text-3xl">
                    Video <span class="text-cyan-700 dark:text-cyan-400">Informasi</span>
                </h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    Kelola video yang ditampilkan di dashboard Anda.
                </p>
            </div>

            <button type="button"
                    onclick="document.getElementById('addVideoModal').showModal()"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-4 py-2.5 text-sm font-semibold text-cyan-700 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/20 hover:shadow-[0_0_22px_-6px_rgba(34,211,238,.65)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:border-cyan-300 dark:hover:bg-cyan-400/15 dark:focus-visible:ring-offset-[#0b1220]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16m8-8H4" /></svg>
                Tambah Video
            </button>
        </header>

        {{-- ============================================================
             GALERI VIDEO
             ============================================================ --}}
        <section class="mb-8">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    Galeri Video
                </h2>
                <div class="flex gap-2">
                    <button type="button" id="scrollLeft" aria-label="Geser kiri"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition-colors hover:border-cyan-400/50 hover:text-cyan-600 dark:border-slate-700 dark:bg-[#0b1220] dark:text-slate-400 dark:hover:border-cyan-400/50 dark:hover:text-cyan-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button type="button" id="scrollRight" aria-label="Geser kanan"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition-colors hover:border-cyan-400/50 hover:text-cyan-600 dark:border-slate-700 dark:bg-[#0b1220] dark:text-slate-400 dark:hover:border-cyan-400/50 dark:hover:text-cyan-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>
            
            {{-- Container Scroll Horizontal --}}
            <div class="overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-slate-300 dark:scrollbar-thumb-slate-700" id="videoContainer" style="scroll-behavior: smooth;">
                <div class="flex gap-4" style="width: max-content;">
                    @foreach ($videos as $v)
                        @php
                            preg_match('/(youtu\.be\/|v=)([^&]+)/', $v->youtube_url, $m);
                            $videoId = $m[2] ?? null;
                        @endphp

                        @if ($videoId)
                            <div class="cyber-card flex w-[300px] shrink-0 flex-col overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-[#0b1220]">
                                <div class="aspect-video w-full bg-slate-100 dark:bg-slate-900">
                                    <iframe class="h-full w-full" src="https://www.youtube-nocookie.com/embed/{{ $videoId }}" allowfullscreen loading="lazy"></iframe>
                                </div>

                                <div class="flex flex-1 flex-col justify-between p-4">
                                    <h3 class="mb-3 line-clamp-2 text-sm font-semibold text-slate-900 dark:text-slate-100">
                                        {{ $v->title ?? 'Tanpa Judul' }}
                                    </h3>
                                    
                                    @if ($v->user_id === Auth::id())
                                        <div class="mt-auto flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1.5 rounded-full border {{ $v->is_public ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-700 dark:border-emerald-400/25 dark:bg-emerald-400/5 dark:text-emerald-300' : 'border-slate-300 bg-slate-100 text-slate-600 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-400' }} px-2.5 py-0.5 font-mono text-[10px] uppercase tracking-wider">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $v->is_public ? 'bg-emerald-500' : 'bg-slate-400 dark:bg-slate-500' }}" aria-hidden="true"></span>
                                                {{ $v->is_public ? 'Publik' : 'Pribadi' }}
                                            </span>
                                            
                                            <div class="flex gap-1">
                                                <button type="button" onclick="document.getElementById('editVideo{{ $v->id }}').showModal()" aria-label="Edit Video"
                                                        class="rounded p-1.5 text-slate-500 transition-colors hover:bg-slate-100 hover:text-cyan-600 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-cyan-400">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                                </button>
                                                <button type="button" onclick="document.getElementById('deleteVideo{{ $v->id }}').showModal()" aria-label="Hapus Video"
                                                        class="rounded p-1.5 text-slate-500 transition-colors hover:bg-red-50 hover:text-red-600 dark:text-slate-400 dark:hover:bg-red-500/10 dark:hover:text-red-400">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if (count($videos) == 0)
                        <div class="flex w-full flex-col items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50/50 px-8 py-12 dark:border-slate-700 dark:bg-slate-900/30" style="min-width: 300px;">
                            <svg class="mb-3 h-12 w-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" /></svg>
                            <p class="font-mono text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">// Belum ada video</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- ============================================================
             TABEL DATA
             ============================================================ --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-[#0b1220]">
            <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Daftar Video</h2>
            </div>

            <div class="overflow-x-auto p-6">
                <table id="videoTable" class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 dark:bg-slate-900/50 dark:text-slate-400">
                        <tr>
                            <th scope="col" class="w-16 px-4 py-3 font-medium">No</th>
                            <th scope="col" class="px-4 py-3 font-medium">Judul</th>
                            <th scope="col" class="px-4 py-3 font-medium">URL</th>
                            <th scope="col" class="px-4 py-3 font-medium">Status</th>
                            <th scope="col" class="w-24 px-4 py-3 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                        @php $no = 1; @endphp
                        @foreach ($videos as $v)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-4 py-4 font-mono text-xs">{{ str_pad($no++, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-4 py-4 font-medium text-slate-900 dark:text-slate-100">{{ $v->title ?? '-' }}</td>
                                <td class="max-w-[260px] truncate px-4 py-4 font-mono text-xs text-slate-500 dark:text-slate-500" title="{{ $v->youtube_url }}">
                                    {{ $v->youtube_url }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full border {{ $v->is_public ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-700 dark:border-emerald-400/25 dark:bg-emerald-400/5 dark:text-emerald-300' : 'border-slate-300 bg-slate-100 text-slate-600 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-400' }} px-2.5 py-0.5 font-mono text-[10px] uppercase tracking-wider">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $v->is_public ? 'bg-emerald-500' : 'bg-slate-400 dark:bg-slate-500' }}" aria-hidden="true"></span>
                                        {{ $v->is_public ? 'Publik' : 'Pribadi' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    @if ($v->user_id === Auth::id())
                                        {{-- Dropdown pakai <details> murni HTML/JS --}}
                                        <details class="relative inline-block text-left">
                                            <summary class="list-none rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-slate-100 hover:text-cyan-600 dark:text-slate-500 dark:hover:bg-white/5 dark:hover:text-cyan-400 cursor-pointer">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                                            </summary>
                                            <div class="absolute right-0 z-10 mt-1 w-36 overflow-hidden rounded-lg border border-slate-200 bg-white py-1 shadow-xl dark:border-slate-700 dark:bg-[#0b1220] dark:shadow-cyan-950/30">
                                                <button type="button" onclick="document.getElementById('editVideo{{ $v->id }}').showModal()" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 hover:text-cyan-700 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-cyan-400">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg> Edit
                                                </button>
                                                <button type="button" onclick="document.getElementById('deleteVideo{{ $v->id }}').showModal()" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg> Hapus
                                                </button>
                                            </div>
                                        </details>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- ================= MODAL EDIT ================= --}}
                            @if ($v->user_id === Auth::id())
                                <dialog id="editVideo{{ $v->id }}" class="m-auto w-[calc(100%-2rem)] max-w-md bg-transparent p-0 backdrop:bg-slate-900/60 backdrop:backdrop-blur-sm">
                                    <div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-800 dark:bg-[#0b1220]">
                                        <form method="POST" action="{{ route('video.update', $v) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="flex items-center justify-between border-b border-slate-200 p-5 dark:border-slate-800">
                                                <div>
                                                    <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-cyan-600 dark:text-cyan-400">// edit.data</p>
                                                    <h5 class="mt-1 text-lg font-bold text-slate-900 dark:text-slate-100">Edit Video</h5>
                                                </div>
                                                <button type="button" onclick="this.closest('dialog').close()" class="rounded-lg p-1 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5 dark:hover:text-slate-200">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>

                                            <div class="space-y-4 p-6">
                                                <div>
                                                    <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Judul</label>
                                                    <input type="text" name="title" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 outline-none transition-colors focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-cyan-400/60" value="{{ $v->title }}">
                                                </div>

                                                <div>
                                                    <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">YouTube URL</label>
                                                    <input type="url" name="youtube_url" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 outline-none transition-colors focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-cyan-400/60" value="{{ $v->youtube_url }}" required>
                                                </div>

                                                <div class="flex items-center gap-3 pt-2">
                                                    <label class="relative inline-flex cursor-pointer items-center">
                                                        <input type="checkbox" name="is_public" value="1" class="peer sr-only" {{ $v->is_public ? 'checked' : '' }}>
                                                        <div class="peer h-6 w-11 rounded-full bg-slate-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-cyan-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-cyan-400/50 dark:border-slate-600 dark:bg-slate-700 dark:peer-checked:bg-cyan-500"></div>
                                                        <span class="ml-3 text-sm font-medium text-slate-700 dark:text-slate-300">Video publik</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900/50">
                                                <button type="button" onclick="this.closest('dialog').close()" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-transparent dark:text-slate-300 dark:hover:bg-white/5">Batal</button>
                                                <button type="submit" class="rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-700 transition-colors hover:border-cyan-400 hover:bg-cyan-500/20 dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:bg-cyan-400/15">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </dialog>

                                {{-- ================= MODAL DELETE ================= --}}
                                <dialog id="deleteVideo{{ $v->id }}" class="m-auto w-[calc(100%-2rem)] max-w-sm bg-transparent p-0 backdrop:bg-slate-900/60 backdrop:backdrop-blur-sm">
                                    <div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-800 dark:bg-[#0b1220]">
                                        <form method="POST" action="{{ route('video.destroy', $v) }}">
                                            @csrf
                                            @method('DELETE')

                                            <div class="flex items-center justify-between border-b border-slate-200 p-5 dark:border-slate-800">
                                                <div>
                                                    <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-red-600 dark:text-red-400">// hapus.data</p>
                                                    <h5 class="mt-1 text-lg font-bold text-slate-900 dark:text-slate-100">Hapus Video</h5>
                                                </div>
                                                <button type="button" onclick="this.closest('dialog').close()" class="rounded-lg p-1 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5 dark:hover:text-slate-200">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>

                                            <div class="p-6">
                                                <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-400">Yakin ingin menghapus video <strong class="text-slate-900 dark:text-slate-100">"{{ $v->title ?? 'Tanpa Judul' }}"</strong>? Tindakan ini tidak bisa dibatalkan.</p>
                                            </div>

                                            <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900/50">
                                                <button type="button" onclick="this.closest('dialog').close()" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-transparent dark:text-slate-300 dark:hover:bg-white/5">Batal</button>
                                                <button type="submit" class="rounded-lg border border-red-500/50 bg-red-500/10 px-4 py-2 text-sm font-semibold text-red-600 transition-colors hover:border-red-400 hover:bg-red-500/20 dark:border-red-400/40 dark:text-red-400 dark:hover:bg-red-400/15">Hapus</button>
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
    </div>

    {{-- ================= MODAL TAMBAH ================= --}}
    <dialog id="addVideoModal" class="m-auto w-[calc(100%-2rem)] max-w-md bg-transparent p-0 backdrop:bg-slate-900/60 backdrop:backdrop-blur-sm">
        <div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl dark:border-slate-800 dark:bg-[#0b1220]">
            <form method="POST" action="{{ route('video.store') }}">
                @csrf

                <div class="flex items-center justify-between border-b border-slate-200 p-5 dark:border-slate-800">
                    <div>
                        <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-cyan-600 dark:text-cyan-400">// input.data</p>
                        <h5 class="mt-1 text-lg font-bold text-slate-900 dark:text-slate-100">Tambah Video</h5>
                    </div>
                    <button type="button" onclick="this.closest('dialog').close()" class="rounded-lg p-1 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5 dark:hover:text-slate-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="space-y-4 p-6">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">Judul</label>
                        <input type="text" name="title" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 outline-none transition-colors focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-cyan-400/60" placeholder="Masukkan judul video">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">YouTube URL</label>
                        <input type="url" name="youtube_url" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 outline-none transition-colors focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/30 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-cyan-400/60" placeholder="https://www.youtube.com/watch?v=xxxxx" required>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <label class="relative inline-flex cursor-pointer items-center">
                            <input type="checkbox" name="is_public" value="1" class="peer sr-only">
                            <div class="peer h-6 w-11 rounded-full bg-slate-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-slate-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-cyan-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-cyan-400/50 dark:border-slate-600 dark:bg-slate-700 dark:peer-checked:bg-cyan-500"></div>
                            <span class="ml-3 text-sm font-medium text-slate-700 dark:text-slate-300">Video publik (bisa dilihat user lain)</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 p-5 dark:border-slate-800 dark:bg-slate-900/50">
                    <button type="button" onclick="this.closest('dialog').close()" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-transparent dark:text-slate-300 dark:hover:bg-white/5">Batal</button>
                    <button type="submit" class="rounded-lg border border-cyan-500/50 bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-700 transition-colors hover:border-cyan-400 hover:bg-cyan-500/20 dark:border-cyan-400/40 dark:bg-cyan-400/10 dark:text-cyan-300 dark:hover:bg-cyan-400/15">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- ================= SCRIPT DATATABLES & SCROLL ================= --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

        <script>
            $(function () {
                $('#videoTable').DataTable({
                    pageLength: 5,
                    lengthChange: false,
                    ordering: true,
                    info: false,
                    language: {
                        search: "Cari:",
                        emptyTable: "Belum ada video",
                        paginate: { previous: "‹", next: "›" }
                    },
                    columnDefs: [
                        { orderable: false, targets: [0, 4] }
                    ],
                    createdRow: function (row, data, dataIndex) {
                        $(row).addClass('hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors');
                    }
                });
                
                $('#scrollLeft').on('click', function() {
                    $('#videoContainer').scrollLeft($('#videoContainer').scrollLeft() - 340);
                });
                
                $('#scrollRight').on('click', function() {
                    $('#videoContainer').scrollLeft($('#videoContainer').scrollLeft() + 340);
                });

                document.addEventListener('click', function(event) {
                    document.querySelectorAll('details').forEach((detail) => {
                        if (!detail.contains(event.target)) {
                            detail.removeAttribute('open');
                        }
                    });
                });
            });
        </script>
    @endpush

</x-layouts.app>