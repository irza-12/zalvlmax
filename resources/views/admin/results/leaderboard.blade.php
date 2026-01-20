<x-app-layout title="Leaderboard">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-secondary-500 hover:text-brand-600 transition-colors">Dashboard</a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-secondary-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium text-secondary-900">Leaderboard</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-display font-bold text-secondary-900 leading-tight">
                        Peringkat Hasil Evaluasi
                    </h2>
                </div>
            </div>
            <div>
                <form action="{{ route('admin.results.leaderboard') }}" method="GET">
                    <select name="quiz_id" x-data @change="$el.form.submit()"
                        class="block w-full rounded-xl border-secondary-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-all px-4 py-2.5 bg-white h-[45px] appearance-none"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1em; min-width: 250px;">
                        <option value="">-- Semua Kuis --</option>
                        @foreach($quizzes as $q)
                            <option value="{{ $q->id }}" {{ $quiz && $quiz->id == $q->id ? 'selected' : '' }}>
                                {{ $q->title }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if($leaderboard->count() > 0)
            <div class="bg-white rounded-3xl shadow-card border border-secondary-100/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-secondary-50 text-secondary-400 text-[10px] font-bold uppercase tracking-widest border-b border-secondary-100">
                                <th class="px-8 py-5 text-center">Rank</th>
                                <th class="px-6 py-5">Peserta</th>
                                <th class="px-6 py-5">Total Skor</th>
                                <th class="px-6 py-5">Waktu Pengerjaan</th>
                                <th class="px-6 py-5">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-secondary-50">
                            @foreach($leaderboard as $index => $entry)
                                <tr class="group hover:bg-brand-50/30 transition-all duration-300">
                                    <td class="px-8 py-5">
                                        <div class="flex justify-center">
                                            @if($index + 1 == 1)
                                                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 shadow-sm border border-amber-200 animate-bounce">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                    </svg>
                                                </div>
                                            @elseif($index + 1 == 2)
                                                <div class="w-10 h-10 rounded-xl bg-secondary-100 flex items-center justify-center text-secondary-500 shadow-sm border border-secondary-200">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                    </svg>
                                                </div>
                                            @elseif($index + 1 == 3)
                                                <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600 shadow-sm border border-orange-200">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 rounded-lg bg-secondary-50 flex items-center justify-center text-secondary-500 font-bold text-sm">
                                                    {{ $index + 1 }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                                {{ strtoupper(substr($entry->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-secondary-900 group-hover:text-brand-600 transition-colors">{{ $entry->user->name }}</p>
                                                <p class="text-xs text-secondary-500">{{ $entry->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xl font-display font-bold text-brand-600">{{ floatval($entry->total_score) }}</span>
                                            <span class="text-[10px] font-bold text-secondary-400 uppercase tracking-widest">Poin</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-secondary-600 font-medium font-mono">
                                        {{ $entry->formatted_completion_time }}
                                    </td>
                                    <td class="px-6 py-5 text-sm text-secondary-500">
                                        {{ $entry->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-card border border-secondary-100/50 p-20 text-center">
                <div class="w-24 h-24 bg-secondary-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-display font-bold text-secondary-900 mb-2">Belum ada data</h3>
                <p class="text-secondary-500 max-w-sm mx-auto">
                    Belum ada hasil evaluasi yang masuk untuk kuis ini. Silakan pilih kuis lain atau tunggu peserta menyelesaikan kuis.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>