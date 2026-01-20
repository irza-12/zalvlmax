<x-app-layout title="Detail Hasil Evaluasi">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.results.index') }}"
                                class="text-sm font-medium text-secondary-500 hover:text-brand-600 transition-colors">Hasil</a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-secondary-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium text-secondary-900">Detail Hasil</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-display font-bold text-secondary-900 leading-tight">
                    Laporan Hasil Peserta
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.results.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-secondary-200 rounded-xl text-sm font-medium text-secondary-600 hover:bg-secondary-50 transition-all shadow-soft group">
                    <svg class="w-4 h-4 mr-2 text-secondary-400 group-hover:text-secondary-600 transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.results.export.pdf', ['result_id' => $result->id]) }}"
                    class="inline-flex items-center px-4 py-2 bg-rose-600 border border-transparent rounded-xl text-sm font-semibold text-white hover:bg-rose-700 transition-all shadow-rose-200/50 shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Unduh PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Participant Info -->
            <div class="bg-white rounded-3xl shadow-card border border-secondary-100/50 p-8">
                <h3 class="text-xs font-bold uppercase tracking-wider text-secondary-400 mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Peserta
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-brand-50 flex items-center justify-center text-brand-600 font-bold text-lg shadow-sm">
                            {{ strtoupper(substr($result->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-secondary-900 font-bold font-display text-lg leading-tight">
                                {{ $result->user->name }}</p>
                            <p class="text-secondary-500 text-sm">{{ $result->user->email }}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-secondary-50">
                        <p class="text-xs text-secondary-400 uppercase font-bold tracking-widest mb-1">Dikerjakan Pada
                        </p>
                        <p class="text-secondary-800 font-medium text-sm">
                            {{ $result->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                    </div>
                </div>
            </div>

            <!-- Score Summary -->
            <div class="bg-secondary-900 rounded-3xl shadow-2xl p-8 text-white relative overflow-hidden group">
                <div
                    class="absolute -top-10 -right-10 w-40 h-40 bg-brand-600/20 rounded-full blur-3xl group-hover:scale-150 transition-all duration-700">
                </div>

                <div class="relative text-center">
                    <p class="text-secondary-400 text-xs font-bold uppercase tracking-widest mb-4">Skor Akhir</p>
                    <div class="inline-flex items-baseline gap-1">
                        <span
                            class="text-7xl font-display font-extra-bold text-white">{{ floatval($result->total_score) }}</span>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                            <p class="text-emerald-400 text-2xl font-display font-bold">{{ $result->correct_answers }}
                            </p>
                            <p class="text-secondary-400 text-[10px] font-bold uppercase tracking-widest">Benar</p>
                        </div>
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                            <p class="text-rose-400 text-2xl font-display font-bold">{{ $result->wrong_answers }}</p>
                            <p class="text-secondary-400 text-[10px] font-bold uppercase tracking-widest">Salah</p>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-center gap-2 text-secondary-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">Durasi: {{ $result->formatted_completion_time }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Answers -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-card border border-secondary-100/50 overflow-hidden">
                <div
                    class="p-6 md:px-8 border-b border-secondary-50 bg-secondary-50/30 flex items-center justify-between">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-secondary-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Detail Pengerjaan: {{ $result->quiz->title }}
                    </h3>
                </div>
                <div class="p-8 space-y-10">
                    @foreach($result->quiz->questions as $index => $question)
                        @php
                            $userAnswer = $result->user->answers
                                ->where('question_id', $question->id)
                                ->first();
                            $isCorrect = $userAnswer ? $userAnswer->isCorrect() : false;
                        @endphp

                        <div class="relative pl-12">
                            <!-- Question Number Circle -->
                            <div
                                class="absolute left-0 top-0 w-8 h-8 rounded-full {{ $isCorrect ? 'bg-emerald-100 text-emerald-600 border-emerald-200' : 'bg-rose-100 text-rose-600 border-rose-200' }} border-2 flex items-center justify-center text-xs font-bold font-display shadow-sm">
                                {{ $index + 1 }}
                            </div>

                            <div class="flex items-start justify-between gap-4 mb-4">
                                <h4 class="text-base md:text-lg font-medium text-secondary-900 leading-relaxed">
                                    {{ $question->question_text }}
                                </h4>
                                <div class="flex-shrink-0 flex items-center gap-2">
                                    <span
                                        class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-secondary-100 text-secondary-500 border border-secondary-200">
                                        {{ $question->score }} POIN
                                    </span>
                                    @if($isCorrect)
                                        <span
                                            class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 border border-emerald-200 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            BENAR
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-rose-100 text-rose-700 border border-rose-200 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            SALAH
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($question->options as $option)
                                    @php
                                        $isSelected = $userAnswer && $userAnswer->option_id == $option->id;
                                        $isAnswerCorrect = $option->is_correct;

                                        $bgClass = 'bg-secondary-50 border-secondary-200';
                                        $textClass = 'text-secondary-600';
                                        $iconClass = 'bg-white border-secondary-300 text-secondary-300';

                                        if ($isAnswerCorrect) {
                                            $bgClass = 'bg-emerald-50 border-emerald-200 ring-1 ring-emerald-500/20';
                                            $textClass = 'text-emerald-900 font-bold';
                                            $iconClass = 'bg-emerald-500 text-white border-emerald-500 shadow-sm shadow-emerald-500/30';
                                        } elseif ($isSelected && !$isAnswerCorrect) {
                                            $bgClass = 'bg-rose-50 border-rose-200 ring-1 ring-rose-500/20';
                                            $textClass = 'text-rose-900 font-bold';
                                            $iconClass = 'bg-rose-500 text-white border-rose-500 shadow-sm shadow-rose-500/30';
                                        }
                                    @endphp

                                    <div class="relative group">
                                        <div
                                            class="flex items-center p-4 rounded-xl border {{ $bgClass }} transition-all flex h-full">
                                            <div
                                                class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full border {{ $iconClass }} mr-3">
                                                @if($isAnswerCorrect)
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @elseif($isSelected && !$isAnswerCorrect)
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <div class="w-1.5 h-1.5 rounded-full bg-current opacity-20"></div>
                                                @endif
                                            </div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="text-sm {{ $textClass }}">
                                                    {{ $option->option_text }}
                                                </span>
                                                @if($isSelected)
                                                    <span
                                                        class="flex-shrink-0 px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-widest {{ $isAnswerCorrect ? 'bg-emerald-200 text-emerald-800' : 'bg-rose-200 text-rose-800' }}">
                                                        Dipilih
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>