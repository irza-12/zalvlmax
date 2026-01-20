<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
            Statistik
        </h2>
        <p class="mt-1 text-sm text-secondary-500">Analisa performa kuis dan peserta</p>
    </x-slot>

    <!-- Date Filter -->
    <div class="mb-6 rounded-lg bg-white p-4 shadow-card border border-secondary-100">
        <form action="" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-secondary-500 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
            </div>
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-secondary-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
            </div>
            <button type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center rounded-md bg-secondary-900 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-secondary-800 transition-colors">
                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                </svg>
                Terapkan
            </button>
        </form>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Attempts -->
        <div class="rounded-lg bg-white p-5 shadow-card border border-secondary-100 flex items-center">
            <div class="flex-shrink-0">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <dt class="truncate text-sm font-medium text-secondary-500">Total Percobaan</dt>
                <dd class="mt-1 text-2xl font-semibold tracking-tight text-secondary-900">
                    {{ number_format($summary['total_attempts'] ?? 0) }}</dd>
            </div>
        </div>

        <!-- Pass Rate -->
        <div class="rounded-lg bg-white p-5 shadow-card border border-secondary-100 flex items-center">
            <div class="flex-shrink-0">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 ring-1 ring-green-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <dt class="truncate text-sm font-medium text-secondary-500">Tingkat Kelulusan</dt>
                <dd class="mt-1 text-2xl font-semibold tracking-tight text-secondary-900">
                    {{ $summary['pass_rate'] ?? 0 }}%</dd>
            </div>
        </div>

        <!-- Avg Score -->
        <div class="rounded-lg bg-white p-5 shadow-card border border-secondary-100 flex items-center">
            <div class="flex-shrink-0">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 ring-1 ring-amber-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <dt class="truncate text-sm font-medium text-secondary-500">Rata-rata Nilai</dt>
                <dd class="mt-1 text-2xl font-semibold tracking-tight text-secondary-900">
                    {{ $summary['avg_score'] ?? 0 }}%</dd>
            </div>
        </div>

        <!-- Highest Score -->
        <div class="rounded-lg bg-white p-5 shadow-card border border-secondary-100 flex items-center">
            <div class="flex-shrink-0">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-50 text-sky-600 ring-1 ring-sky-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <dt class="truncate text-sm font-medium text-secondary-500">Nilai Tertinggi</dt>
                <dd class="mt-1 text-2xl font-semibold tracking-tight text-secondary-900">
                    {{ $summary['highest_score'] ?? 0 }}%</dd>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Per Quiz Stats -->
        <div class="lg:col-span-2 rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-secondary-100 bg-secondary-50">
                <h3 class="text-base font-semibold leading-6 text-secondary-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Statistik Per Kuis
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-secondary-200">
                    <thead class="bg-secondary-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Kuis</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Percobaan</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Lulus</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                Avg Score</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider w-1/4">
                                Pass Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-200 bg-white">
                        @forelse($quizStats as $quiz)
                            <tr class="hover:bg-secondary-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-secondary-900">{{ $quiz->title ?? 'Unknown' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-md bg-secondary-100 px-2.5 py-0.5 text-xs font-medium text-secondary-800">{{ $quiz->total_attempts ?? 0 }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $quiz->passed ?? 0 }}</span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-secondary-600">
                                    {{ round($quiz->avg_score ?? 0, 1) }}%</td>
                                <td class="px-6 py-4">
                                    @php $passRate = ($quiz->total_attempts ?? 0) > 0 ? round(($quiz->passed ?? 0) / ($quiz->total_attempts ?? 1) * 100) : 0; @endphp
                                    <div class="flex items-center gap-3">
                                        <div class="flex-grow rounded-full bg-secondary-100 h-2">
                                            <div class="h-2 rounded-full {{ $passRate >= 70 ? 'bg-green-500' : 'bg-red-500' }}"
                                                style="width: {{ $passRate }}%"></div>
                                        </div>
                                        <span
                                            class="text-xs font-medium text-secondary-500 w-8 text-right">{{ $passRate }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-secondary-500">Tidak ada data
                                    statistik kuis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-secondary-100 bg-secondary-50">
                <h3 class="text-base font-semibold leading-6 text-secondary-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z"
                            clip-rule="evenodd" />
                    </svg>
                    Top Performers
                </h3>
            </div>
            <ul role="list" class="divide-y divide-secondary-100">
                @forelse($topPerformers as $index => $result)
                    <li class="flex items-center justify-between gap-x-6 px-6 py-4 hover:bg-secondary-50 transition-colors">
                        <div class="flex min-w-0 gap-x-4">
                            <span
                                class="flex items-center justify-center w-6 font-bold {{ $index < 3 ? 'text-amber-500' : 'text-secondary-400' }}">#{{ $index + 1 }}</span>
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-secondary-900">
                                    {{ $result->user->name ?? 'Unknown' }}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-secondary-500">
                                    {{ Str::limit($result->quiz->title ?? '', 25) }}</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ round($result->percentage) }}%</span>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-8 text-center text-sm text-secondary-500">Belum ada data performer.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>