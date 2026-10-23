{{-- resources/views/tampilan/footer.blade.php --}}
<footer class="relative mt-12 border-t border-slate-200 bg-white dark:border-slate-800/80 dark:bg-[#070b12]">
    {{-- Garis aksen tipis di atas footer --}}
    <div aria-hidden="true"
         class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-500/40 to-transparent dark:via-cyan-400/30"></div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">

            <p class="font-mono text-xs tracking-wide text-slate-500 dark:text-slate-500">
                &copy; {{ date('Y') }} MyApp. All rights reserved.
            </p>

            <div class="flex items-center gap-2 font-mono text-xs text-slate-500 dark:text-slate-500">
                <span class="relative flex h-2 w-2" aria-hidden="true">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                </span>
                All systems operational
            </div>

        </div>
    </div>
</footer>