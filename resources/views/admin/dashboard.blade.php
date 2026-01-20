<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <!-- Welcome Section -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-2xl font-bold text-secondary-900">Selamat datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="mt-1 text-sm text-secondary-600">Berikut adalah ringkasan aktivitas sistem kuis Anda hari ini.
                </p>
            </div>
            <div class="flex gap-2">
                <span
                    class="inline-flex items-center rounded-md bg-brand-50 px-2 py-1 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-700/10">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Total Quizzes -->
            <div
                class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-secondary-900/5 hover:ring-brand-500/20 transition-all duration-300">
                <dt>
                    <div class="absolute rounded-xl bg-brand-50 p-3">
                        <svg class="h-6 w-6 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-secondary-500">Total Kuis</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                    <p class="text-2xl font-semibold text-secondary-900">{{ \App\Models\Quiz::count() }}</p>
                </dd>
            </div>

            <!-- Active Quizzes -->
            <div
                class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-secondary-900/5 hover:ring-brand-500/20 transition-all duration-300">
                <dt>
                    <div class="absolute rounded-xl bg-emerald-50 p-3">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-secondary-500">Kuis Aktif</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                    <p class="text-2xl font-semibold text-secondary-900">
                        {{ \App\Models\Quiz::where('status', 'active')->count() }}</p>
                </dd>
            </div>

            <!-- Total Questions -->
            <div
                class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-secondary-900/5 hover:ring-brand-500/20 transition-all duration-300">
                <dt>
                    <div class="absolute rounded-xl bg-amber-50 p-3">
                        <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-secondary-500">Total Soal</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                    <p class="text-2xl font-semibold text-secondary-900">{{ \App\Models\Question::count() }}</p>
                </dd>
            </div>

            <!-- Total Attempts -->
            <div
                class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-secondary-900/5 hover:ring-brand-500/20 transition-all duration-300">
                <dt>
                    <div class="absolute rounded-xl bg-purple-50 p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-secondary-500">Total Percobaan</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                    <p class="text-2xl font-semibold text-secondary-900">
                        {{ \App\Models\Result::whereNotNull('completed_at')->count() }}</p>
                </dd>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-secondary-900/5">
            <div class="border-b border-secondary-100 px-6 py-5">
                <h3 class="text-base font-semibold leading-6 text-secondary-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                    Aksi Cepat
                </h3>
            </div>
            <div class="grid grid-cols-2 gap-px bg-secondary-100/50 sm:grid-cols-4">
                <a href="#" class="group relative bg-white p-6 hover:bg-secondary-50 focus:z-10 transition-colors">
                    <div>
                        <span class="inline-flex rounded-lg bg-brand-50 p-3 text-brand-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3
                            class="text-sm font-medium leading-6 text-secondary-900 group-hover:text-brand-600 transition-colors">
                            Buat Kuis Baru
                        </h3>
                        <p class="mt-1 text-sm text-secondary-500">Mulai membuat kuis baru</p>
                    </div>
                </a>

                <a href="#" class="group relative bg-white p-6 hover:bg-secondary-50 focus:z-10 transition-colors">
                    <div>
                        <span class="inline-flex rounded-lg bg-amber-50 p-3 text-amber-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3
                            class="text-sm font-medium leading-6 text-secondary-900 group-hover:text-amber-600 transition-colors">
                            Tambah Soal
                        </h3>
                        <p class="mt-1 text-sm text-secondary-500">Kelola bank soal Anda</p>
                    </div>
                </a>

                <a href="#" class="group relative bg-white p-6 hover:bg-secondary-50 focus:z-10 transition-colors">
                    <div>
                        <span class="inline-flex rounded-lg bg-purple-50 p-3 text-purple-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3
                            class="text-sm font-medium leading-6 text-secondary-900 group-hover:text-purple-600 transition-colors">
                            Monitor Live
                        </h3>
                        <p class="mt-1 text-sm text-secondary-500">Pantau kuis yang sedang berjalan</p>
                    </div>
                </a>

                <a href="#" class="group relative bg-white p-6 hover:bg-secondary-50 focus:z-10 transition-colors">
                    <div>
                        <span class="inline-flex rounded-lg bg-emerald-50 p-3 text-emerald-700 ring-4 ring-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3
                            class="text-sm font-medium leading-6 text-secondary-900 group-hover:text-emerald-600 transition-colors">
                            Export Laporan
                        </h3>
                        <p class="mt-1 text-sm text-secondary-500">Unduh laporan hasil kuis</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>