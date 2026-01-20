@if($activeSessions->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-secondary-200">
            <thead class="bg-secondary-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">User
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Kuis
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Progress
                        & Speed</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Waktu
                        Berjalan</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">Status
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-secondary-100">
                @foreach($activeSessions as $session)
                    <tr class="session-row hover:bg-secondary-50/50 transition-colors"
                        data-start="{{ $session->started_at ? $session->started_at->timestamp : now()->timestamp }}"
                        data-answered="{{ $session->progress->where('status', 'answered')->count() }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-100 ring-1 ring-brand-200">
                                        <span
                                            class="text-sm font-bold text-brand-700">{{ strtoupper(substr($session->user->name, 0, 2)) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-secondary-900">{{ $session->user->name }}</div>
                                    <div class="text-sm text-secondary-500">{{ $session->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-secondary-700">{{ $session->quiz->title }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $answered = $session->progress->where('status', 'answered')->count();
                                $total = $session->progress->count();
                                $percentage = $total > 0 ? round(($answered / $total) * 100) : 0;
                            @endphp
                            <div class="w-full max-w-xs">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <span
                                        class="text-xs font-semibold text-secondary-700 text-right">{{ $answered }}/{{ $total }}</span>
                                </div>
                                <div class="overflow-hidden rounded-full bg-secondary-100 h-2">
                                    <div class="h-2 rounded-full bg-brand-600 transition-all duration-500"
                                        style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="mt-1 flex items-center text-xs text-secondary-500">
                                    <svg class="mr-1 h-3 w-3 text-secondary-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Avg: <span class="avg-time font-mono ml-1">-</span>/soal
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div
                                class="inline-flex rounded-md bg-amber-50 px-2.5 py-1.5 text-sm font-bold text-amber-700 ring-1 ring-inset ring-amber-600/20 font-mono items-center gap-1">
                                <svg class="h-4 w-4 text-amber-500 animate-[spin_3s_linear_infinite]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="elapsed-time">00:00</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center gap-x-1.5 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                <span class="relative flex h-2 w-2">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                Live
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.results.export.pdf', ['session_id' => $session->id]) }}"
                                class="text-rose-600 hover:text-rose-900 flex items-center justify-end gap-1"
                                title="Cetak Evaluasi (Bisa saat proses)">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Cetak
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="flex flex-col items-center justify-center py-12 text-center text-secondary-500 bg-white">
        <div class="rounded-full bg-brand-50 p-6 mb-4 ring-1 ring-brand-100">
            <svg class="h-10 w-10 text-brand-300 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-base font-semibold text-secondary-900">Tidak Ada Sesi Aktif</h3>
        <p class="mt-1 text-sm text-secondary-500 max-w-sm">Saat ini tidak ada user yang sedang mengerjakan kuis. Data akan
            muncul otomatis saat user mulai mengerjakan.</p>
    </div>
@endif