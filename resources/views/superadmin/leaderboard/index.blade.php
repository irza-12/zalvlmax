<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
            Leaderboard
        </h2>
        <p class="mt-1 text-sm text-secondary-500">Peringkat peserta berdasarkan skor</p>
    </x-slot>

    <!-- Quiz Filter -->
    <div class="mb-6 rounded-lg bg-white p-4 shadow-card border border-secondary-100">
        <form action="" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="w-full sm:w-auto flex-grow max-w-sm">
                <label class="block text-xs font-semibold text-secondary-500 mb-1">Pilih Kuis</label>
                <select name="quiz_id"
                    class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                    <option value="">-- Pilih Kuis --</option>
                    @foreach($quizzes as $quiz)
                        <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                            {{ $quiz->title }} ({{ $quiz->results_count }} peserta)
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center rounded-md bg-secondary-900 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-secondary-800 transition-colors">
                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Per Quiz Leaderboard -->
        <div class="lg:col-span-7">
            <div class="rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden">
                <div
                    class="px-6 py-4 border-b border-secondary-100 bg-secondary-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h3 class="text-base font-semibold leading-6 text-secondary-900 flex items-center gap-2">
                        @if($selectedQuiz)
                            <svg class="h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.699-3.189a1 1 0 011.414-.413 1 1 0 01.413 1.414l-1.695 3.193 1.25.5a1 1 0 01.558 1.282l-3.328 10.648a1 1 0 01-1.282.558l-5.992-2.398a1 1 0 01-.558-1.282l3.328-10.648 1.25-.5L9 3.323V3a1 1 0 011-1zm3.89 3.161l-5.78 2.312-2.73 8.736 4.978 1.992 2.73-8.736-1.57-4.304c-.39-.156-.78-.312-1.17-.468l1.17-.604-.62-.25zM10 5a1 1 0 100 2 1 1 0 000-2z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $selectedQuiz->title }}
                        @else
                            <svg class="h-5 w-5 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Pilih Kuis
                        @endif
                    </h3>
                    @if($selectedQuiz)
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50">
                                <svg class="-ml-0.5 h-4 w-4 text-secondary-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export
                                <svg class="-mr-0.5 h-4 w-4 text-secondary-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                style="display: none;">
                                <a href="{{ route('superadmin.reports.export-excel', $selectedQuiz) }}"
                                    class="flex px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                    <span class="w-6 text-green-600 font-bold">X</span> Excel
                                </a>
                                <a href="{{ route('superadmin.reports.export-pdf-all', $selectedQuiz) }}" target="_blank"
                                    class="flex px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                    <span class="w-6 text-red-600 font-bold">P</span> Semua PDF
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    @if(count($leaderboard) > 0)
                        <table class="min-w-full divide-y divide-secondary-200">
                            <thead class="bg-secondary-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider w-16">
                                        Rank</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                        Peserta</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                        Skor</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                        Durasi</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">
                                        Cetak</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-secondary-200 bg-white">
                                @foreach($leaderboard as $item)
                                    <tr class="hover:bg-secondary-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item['rank'] == 1)
                                                <svg class="h-8 w-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.699-3.189a1 1 0 011.414-.413 1 1 0 01.413 1.414l-1.695 3.193 1.25.5a1 1 0 01.558 1.282l-3.328 10.648a1 1 0 01-1.282.558l-5.992-2.398a1 1 0 01-.558-1.282l3.328-10.648 1.25-.5L9 3.323V3a1 1 0 011-1zm3.89 3.161l-5.78 2.312-2.73 8.736 4.978 1.992 2.73-8.736-1.57-4.304c-.39-.156-.78-.312-1.17-.468l1.17-.604-.62-.25zM10 5a1 1 0 100 2 1 1 0 000-2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @elseif($item['rank'] == 2)
                                                <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.699-3.189a1 1 0 011.414-.413 1 1 0 01.413 1.414l-1.695 3.193 1.25.5a1 1 0 01.558 1.282l-3.328 10.648a1 1 0 01-1.282.558l-5.992-2.398a1 1 0 01-.558-1.282l3.328-10.648 1.25-.5L9 3.323V3a1 1 0 011-1zm3.89 3.161l-5.78 2.312-2.73 8.736 4.978 1.992 2.73-8.736-1.57-4.304c-.39-.156-.78-.312-1.17-.468l1.17-.604-.62-.25zM10 5a1 1 0 100 2 1 1 0 000-2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @elseif($item['rank'] == 3)
                                                <svg class="h-8 w-8 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.699-3.189a1 1 0 011.414-.413 1 1 0 01.413 1.414l-1.695 3.193 1.25.5a1 1 0 01.558 1.282l-3.328 10.648a1 1 0 01-1.282.558l-5.992-2.398a1 1 0 01-.558-1.282l3.328-10.648 1.25-.5L9 3.323V3a1 1 0 011-1zm3.89 3.161l-5.78 2.312-2.73 8.736 4.978 1.992 2.73-8.736-1.57-4.304c-.39-.156-.78-.312-1.17-.468l1.17-.604-.62-.25zM10 5a1 1 0 100 2 1 1 0 000-2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <span
                                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-secondary-100 text-sm font-bold text-secondary-500">#{{ $item['rank'] }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-9 w-9 flex-shrink-0">
                                                    <div
                                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-50 text-xs font-bold text-brand-600 ring-1 ring-brand-100">
                                                        {{ strtoupper(substr($item['user']['name'], 0, 2)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-secondary-900">
                                                        {{ $item['user']['name'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-lg font-bold text-secondary-900">{{ $item['score'] }}</span>
                                            <span class="text-xs text-secondary-500">poin</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center rounded-md bg-secondary-100 px-2 py-1 text-xs font-medium text-secondary-600">{{ $item['formatted_completion_time'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            @php
                                                // Try to get session_id from leaderboard item or find it
                                                $printSessionId = $item['session_id'] ?? null;
                                                if (!$printSessionId) {
                                                    // Fallback: find session for this user and quiz
                                                    $printSession = \App\Models\QuizSession::where('user_id', $item['user']['id'])
                                                        ->where('quiz_id', $selectedQuiz->id)
                                                        ->latest('started_at')
                                                        ->first();
                                                    $printSessionId = $printSession?->id;
                                                }
                                            @endphp
                                            @if($printSessionId)
                                                <a href="{{ route('superadmin.reports.export-pdf', $printSessionId) }}"
                                                    target="_blank" class="text-secondary-400 hover:text-red-600 transition-colors"
                                                    title="Cetak Evaluasi">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="text-secondary-200 cursor-not-allowed" title="Sesi tidak tersedia">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex flex-col items-center justify-center py-12 text-center text-secondary-500">
                            <div class="rounded-full bg-secondary-100 p-4 mb-3">
                                <svg class="h-10 w-10 text-secondary-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <p class="text-base font-semibold text-secondary-900">
                                {{ $selectedQuiz ? 'Belum ada peserta' : 'Pilih kuis untuk melihat leaderboard' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Global Leaderboard -->
        <div class="lg:col-span-5">
            <div class="rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-secondary-100 bg-secondary-50">
                    <h3 class="text-base font-semibold leading-6 text-secondary-900 flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Global Leaderboard
                    </h3>
                </div>
                <ul role="list" class="divide-y divide-secondary-100">
                    @forelse($globalLeaderboard as $index => $item)
                        <li
                            class="flex items-center justify-between gap-x-6 px-6 py-4 hover:bg-secondary-50 transition-colors">
                            <div class="flex min-w-0 gap-x-4">
                                <span
                                    class="flex items-center justify-center w-6 font-bold text-secondary-400">#{{ $index + 1 }}</span>
                                <div class="h-9 w-9 flex-shrink-0">
                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-50 text-xs font-bold text-brand-600 ring-1 ring-brand-100">
                                        {{ strtoupper(substr($item->user->name ?? 'U', 0, 2)) }}
                                    </div>
                                </div>
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-secondary-900">
                                        {{ $item->user->name ?? 'Unknown' }}
                                    </p>
                                    <p class="mt-1 truncate text-xs leading-5 text-secondary-500">{{ $item->quiz_count }}
                                        kuis diselesaikan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-amber-500">{{ number_format($item->total_score) }}</p>
                                <p class="text-xs text-secondary-500">{{ round($item->avg_percentage) }}% avg</p>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center text-sm text-secondary-500">Belum ada data global.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>