{{-- resources/views/components/partials/footer.blade.php --}}
<footer class="relative flex-shrink-0 border-t border-slate-200 bg-white transition-colors duration-300 dark:border-slate-800 dark:bg-[#0b1220]">

    {{-- Aksen tipis di atas footer --}}
    <div aria-hidden="true"
         class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan-500/40 to-transparent dark:via-cyan-400/25"></div>

    <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-1 px-4 py-3 sm:flex-row sm:gap-4">
        <span class="font-mono text-[11px] tracking-wide text-slate-500">
            &copy; {{ date('Y') }} MyApp
        </span>

        <span class="flex items-center gap-1.5 font-mono text-[11px] text-slate-500">
            <span class="h-1 w-1 rounded-full bg-cyan-500/70" aria-hidden="true"></span>
            all systems operational
        </span>
    </div>
</footer>