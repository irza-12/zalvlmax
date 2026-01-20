<x-app-layout title="Kelola Soal">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-display font-bold text-secondary-900 leading-snug">
                    {{ $quiz->title }}
                </h2>
                <div class="flex items-center gap-2 mt-2">
                    <span
                        class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-600 border border-secondary-200">
                        Total {{ $questions->total() }} Soal
                    </span>
                    <span
                        class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-50 text-brand-600 border border-brand-100">
                        Evaluasi
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.quizzes.show', $quiz) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-secondary-200 rounded-xl text-sm font-medium text-secondary-600 hover:bg-secondary-50 transition-all shadow-soft">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.questions.create', $quiz) }}"
                    class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-xl text-sm font-semibold text-white hover:bg-brand-700 transition-all shadow-brand-200/50 shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Soal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @forelse($questions as $index => $question)
            <div
                class="bg-white rounded-2xl shadow-card border border-secondary-100/50 overflow-hidden hover:shadow-soft transition-all duration-300">
                <div
                    class="px-6 py-4 bg-secondary-50/50 border-b border-secondary-100/50 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white font-bold text-sm shadow-brand-200/50 shadow-md">
                            {{ $questions->firstItem() + $index }}
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-brand-100 text-brand-700 border border-brand-200">
                                {{ str_replace('_', ' ', $question->type) }}
                            </span>
                            <span
                                class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 border border-emerald-200">
                                {{ $question->score }} POIN
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.questions.edit', [$quiz, $question]) }}"
                            class="p-2 text-secondary-500 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.questions.destroy', [$quiz, $question]) }}" method="POST"
                            class="inline" onsubmit="return confirm('Yakin ingin menghapus soal ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 text-secondary-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-medium text-secondary-900 leading-relaxed mb-6">
                        {{ $question->question_text }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($question->options as $option)
                            <div class="relative group">
                                <div
                                    class="flex items-center p-4 rounded-xl border {{ $option->is_correct ? 'bg-emerald-50 border-emerald-200' : 'bg-secondary-50 border-secondary-200' }} transition-all">
                                    <div
                                        class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full {{ $option->is_correct ? 'bg-emerald-500 text-white' : 'bg-white border border-secondary-300 text-secondary-400' }} mr-3">
                                        @if($option->is_correct)
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <div class="w-2 h-2 rounded-full bg-current"></div>
                                        @endif
                                    </div>
                                    <span
                                        class="text-sm {{ $option->is_correct ? 'text-emerald-900 font-semibold' : 'text-secondary-600' }}">
                                        {{ $option->option_text }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-card border border-secondary-100/50 p-12 text-center">
                <div class="w-20 h-20 bg-secondary-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 0h6" />
                    </svg>
                </div>
                <h3 class="text-lg font-display font-bold text-secondary-900 mb-2">Belum ada soal</h3>
                <p class="text-secondary-500 max-w-xs mx-auto mb-8">
                    Silakan tambahkan soal evaluasi pertama Anda untuk kuis ini.
                </p>
                <a href="{{ route('admin.questions.create', $quiz) }}"
                    class="inline-flex items-center px-6 py-3 bg-brand-600 border border-transparent rounded-xl text-sm font-semibold text-white hover:bg-brand-700 transition-all shadow-brand-200/50 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Soal Sekarang
                </a>
            </div>
        @endforelse

        @if($questions->hasPages())
            <div class="mt-10 bg-white rounded-2xl shadow-sm border border-secondary-100 p-4">
                {{ $questions->links() }}
            </div>
        @endif
    </div>
</x-app-layout>