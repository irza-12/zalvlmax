<x-app-layout title="Detail Kuis">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.quizzes.index') }}"
                                class="text-sm font-medium text-secondary-500 hover:text-brand-600 transition-colors">Kuis</a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-secondary-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium text-secondary-900">Detail</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-display font-bold text-secondary-900 leading-tight">
                        {{ Str::limit($quiz->title, 40) }}
                    </h2>
                    <span
                        class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $quiz->status === 'active' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-secondary-100 text-secondary-600 border border-secondary-200' }}">
                        {{ $quiz->status }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.quizzes.edit', $quiz) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-secondary-200 rounded-xl text-sm font-medium text-secondary-600 hover:bg-secondary-50 transition-all shadow-soft group">
                    <svg class="w-4 h-4 mr-2 text-secondary-400 group-hover:text-amber-500 transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                    Edit Kuis
                </a>
                <a href="{{ route('admin.questions.index', $quiz) }}"
                    class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-xl text-sm font-semibold text-white hover:bg-brand-700 transition-all shadow-brand-200/50 shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 0h6" />
                    </svg>
                    Kelola Soal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Quiz Card -->
            <div class="bg-white rounded-3xl shadow-card border border-secondary-100/50 overflow-hidden">
                <div class="p-8 md:p-10">
                    <div class="flex flex-col gap-6">
                        <div>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-secondary-400 mb-2">Deskripsi
                                Kuis</h3>
                            <p class="text-secondary-600 leading-relaxed text-lg">
                                {{ $quiz->description ?: 'Tidak ada deskripsi.' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-secondary-50">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-brand-50 flex items-center justify-center text-brand-600 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-secondary-400 uppercase tracking-widest">Durasi</p>
                                    <p class="text-secondary-900 font-bold font-display text-lg">{{ $quiz->duration }}
                                        <span class="text-sm font-normal text-secondary-500 uppercase">Menit</span></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-secondary-400 uppercase tracking-widest">Mulai</p>
                                    <p class="text-secondary-900 font-bold font-display text-lg">
                                        {{ $quiz->start_time->format('d M Y') }} <span
                                            class="text-sm font-normal text-secondary-500 uppercase">{{ $quiz->start_time->format('H:i') }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-secondary-400 uppercase tracking-widest">Selesai
                                    </p>
                                    <p class="text-secondary-900 font-bold font-display text-lg">
                                        {{ $quiz->end_time->format('d M Y') }} <span
                                            class="text-sm font-normal text-secondary-500 uppercase">{{ $quiz->end_time->format('H:i') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Questions -->
            <div class="bg-white rounded-3xl shadow-card border border-secondary-100/50 overflow-hidden">
                <div
                    class="p-6 md:px-8 border-b border-secondary-50 flex items-center justify-between bg-secondary-50/30">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-secondary-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 0h6" />
                        </svg>
                        Daftar Soal (Preview)
                    </h3>
                    <a href="{{ route('admin.questions.index', $quiz) }}"
                        class="text-xs font-bold text-brand-600 hover:text-brand-700 uppercase tracking-widest group flex items-center gap-1.5 transition-all">
                        Lihat Semua Soal
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
                <div class="p-0">
                    @if($quiz->questions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="bg-secondary-50 text-secondary-400 text-[10px] font-bold uppercase tracking-widest">
                                        <th class="px-8 py-4">No</th>
                                        <th class="px-6 py-4">Pertanyaan</th>
                                        <th class="px-6 py-4">Tipe</th>
                                        <th class="px-6 py-4">Skor</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-secondary-50">
                                    @foreach($quiz->questions->take(5) as $index => $question)
                                        <tr class="group hover:bg-secondary-50/50 transition-colors">
                                            <td class="px-8 py-4 text-sm font-bold text-secondary-900">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-secondary-600 leading-relaxed max-w-md">
                                                    {{ Str::limit($question->question_text, 100) }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-brand-50 text-brand-600 border border-brand-100">
                                                    {{ str_replace('_', ' ', $question->type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-bold text-emerald-600">{{ $question->score }} pts
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <div
                                class="w-20 h-20 bg-secondary-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-secondary-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 0h6" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-display font-bold text-secondary-900 mb-2">Belum ada soal</h3>
                            <p class="text-secondary-500 max-w-xs mx-auto mb-8 text-sm">
                                Silakan tambahkan soal evaluasi pertama Anda untuk kuis ini.
                            </p>
                            <a href="{{ route('admin.questions.create', $quiz) }}"
                                class="inline-flex items-center px-5 py-2.5 bg-brand-100 border border-transparent rounded-xl text-sm font-bold text-brand-700 hover:bg-brand-200 transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Soal
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-8 text-white">
            <!-- Stats Widget -->
            <div class="bg-secondary-900 rounded-3xl shadow-2xl p-8 relative overflow-hidden group">
                <div
                    class="absolute -top-10 -right-10 w-40 h-40 bg-brand-600/20 rounded-full blur-3xl group-hover:scale-150 transition-all duration-700">
                </div>

                <h3 class="text-sm font-bold uppercase tracking-wider text-secondary-400 mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistik Kuis
                </h3>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-secondary-400 text-sm">Total Soal</span>
                        <span class="text-2xl font-display font-bold text-white">{{ $quiz->questions_count }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10">
                        <span class="text-secondary-400 text-sm">Total Poin</span>
                        <span
                            class="text-2xl font-display font-bold text-emerald-400">{{ $quiz->questions->sum('score') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-secondary-400 text-sm">Peserta Selesai</span>
                        <span
                            class="text-2xl font-display font-bold text-brand-400">{{ $quiz->results->count() }}</span>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('admin.results.index', ['quiz_id' => $quiz->id]) }}"
                        class="flex items-center justify-center w-full py-3 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-brand-600/30">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Lihat Hasil Peserta
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl shadow-card border border-secondary-100/50 p-8">
                <h3 class="text-sm font-bold uppercase tracking-wider text-secondary-900 mb-6">Aksi Cepat</h3>

                <div class="space-y-4">
                    <form action="{{ route('admin.quizzes.toggle-status', $quiz) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex flex-col items-start w-full p-4 rounded-2xl border-2 {{ $quiz->status === 'active' ? 'border-amber-100 bg-amber-50 hover:bg-amber-100 group' : 'border-emerald-100 bg-emerald-50 hover:bg-emerald-100 group' }} transition-all text-left">
                            <span class="flex items-center gap-2 mb-1">
                                <div
                                    class="w-7 h-7 rounded-lg flex items-center justify-center {{ $quiz->status === 'active' ? 'bg-amber-500' : 'bg-emerald-500' }} text-white shadow-sm">
                                    @if($quiz->status === 'active')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <span
                                    class="text-sm font-bold {{ $quiz->status === 'active' ? 'text-amber-700' : 'text-emerald-700' }} uppercase tracking-wider">
                                    {{ $quiz->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </span>
                            </span>
                            <span class="text-xs text-secondary-500 ml-9">
                                {{ $quiz->status === 'active' ? 'Peserta tidak akan bisa memulai kuis ini.' : 'Izinkan peserta untuk mengerjakan kuis ini.' }}
                            </span>
                        </button>
                    </form>

                    <a href="{{ route('admin.results.leaderboard', $quiz) }}"
                        class="flex flex-col items-start w-full p-4 rounded-2xl border-2 border-brand-100 bg-brand-50 hover:bg-brand-100 transition-all text-left">
                        <span class="flex items-center gap-2 mb-1">
                            <div
                                class="w-7 h-7 rounded-lg bg-brand-600 flex items-center justify-center text-white shadow-sm font-bold text-xs uppercase">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-brand-700 uppercase tracking-wider">Leaderboard</span>
                        </span>
                        <span class="text-xs text-secondary-500 ml-9">Lihat daftar peringkat nilai tertinggi.</span>
                    </a>

                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuis ini? Semua data soal dan hasil peserta akan ikut terhapus!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full text-center py-3 text-xs font-bold text-rose-500 hover:text-rose-600 uppercase tracking-widest transition-colors">
                            <i class="bi bi-trash me-1"></i> Hapus Permanen Kuis
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>