<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Portal pengajuan dan peninjauan penawaran supplier.">

        <title>@hasSection('title')@yield('title') · @endif{{ config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-full bg-slate-50 text-slate-950 antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="border-b border-slate-200/80 bg-white/95 backdrop-blur">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-5 py-4 sm:px-8 lg:px-10">
                    <a href="{{ url('/') }}" class="group flex items-center gap-3" aria-label="Beranda {{ config('app.name') }}">
                        <span class="grid size-10 place-items-center rounded-xl bg-brand-700 text-sm font-bold tracking-wide text-white shadow-sm transition group-hover:bg-brand-800">
                            KDI
                        </span>
                        <span>
                            <span class="block text-sm font-semibold leading-tight text-slate-950">Portal Penawaran</span>
                            <span class="block text-xs leading-tight text-slate-500">Supplier · Procurement</span>
                        </span>
                    </a>

                    <span class="hidden rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600 sm:inline-flex">
                        PT KDI
                    </span>
                </div>
            </header>

            <main class="flex-1">
                @if (session('status'))
                    <div class="mx-auto w-full max-w-7xl px-5 pt-6 sm:px-8 lg:px-10">
                        <x-ui.alert variant="success">{{ session('status') }}</x-ui.alert>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="border-t border-slate-200 bg-white">
                <div class="mx-auto flex w-full max-w-7xl flex-col gap-2 px-5 py-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-8 lg:px-10">
                    <p>&copy; {{ now()->year }} PT KDI. Portal penawaran supplier.</p>
                    <p>Data penawaran hanya dapat ditinjau oleh tim procurement.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
