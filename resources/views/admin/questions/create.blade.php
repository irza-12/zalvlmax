<x-app-layout title="Tambah Soal Baru">
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.quizzes.index') }}"
                                class="text-sm font-medium text-secondary-500 hover:text-brand-600 transition-colors">Kuis</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-secondary-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <a href="{{ route('admin.questions.index', $quiz) }}"
                                    class="text-sm font-medium text-secondary-500 hover:text-brand-600 transition-colors">Kelola
                                    Soal</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-secondary-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium text-secondary-900">Tambah</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-display font-bold text-secondary-900 leading-tight">
                    Tambah Soal Baru
                </h2>
                <p class="text-sm text-secondary-500 mt-2">
                    {{ $quiz->title }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.questions.index', $quiz) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-secondary-200 rounded-xl text-sm font-medium text-secondary-600 hover:bg-secondary-50 transition-all shadow-soft group">
                    <svg class="w-4 h-4 mr-2 text-secondary-400 group-hover:text-secondary-600 transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Batal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto" x-data="{ 
        type: '{{ old('type', 'multiple_choice') }}',
        options: @js(old('options', ['', '', '', ''])),
        corrects: @js(old('correct_options', ['0'])),
        addOption() {
            this.options.push('');
        },
        removeOption(index) {
            if (this.options.length > 2) {
                this.options.splice(index, 1);
                // Adjust correctness array
                this.corrects = this.corrects.filter(i => i != index).map(i => i > index ? i - 1 : i);
            }
        },
        toggleCorrect(index) {
            const idx = this.corrects.indexOf(index.toString());
            if (this.type === 'multiple_choice' || this.type === 'true_false') {
                this.corrects = [index.toString()];
            } else {
                if (idx > -1) {
                    if (this.corrects.length > 1) this.corrects.splice(idx, 1);
                } else {
                    this.corrects.push(index.toString());
                }
            }
        },
        isCorrect(index) {
            return this.corrects.includes(index.toString());
        },
        checkType() {
            if (this.type === 'true_false') {
                this.options = ['Benar', 'Salah'];
                this.corrects = ['0'];
            }
        }
    }" x-init="checkType()">
        <form action="{{ route('admin.questions.store', $quiz) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Question Card -->
            <div class="bg-white rounded-2xl shadow-card border border-secondary-100/50 overflow-hidden">
                <div class="p-6 border-b border-secondary-100/50 bg-secondary-50/50">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-secondary-900 flex items-center gap-2">
                        <div class="p-1.5 bg-brand-600 rounded-lg text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        Konten Pertanyaan
                    </h3>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <x-input-label for="question_text" value="Pertanyaan" class="mb-2" />
                        <textarea id="question_text" name="question_text" rows="4"
                            class="block w-full rounded-xl border-secondary-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-all px-4 py-3"
                            placeholder="Tuliskan teks pertanyaan di sini..."
                            required>{{ old('question_text') }}</textarea>
                        <x-input-error :messages="$errors->get('question_text')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="type" value="Tipe Soal" class="mb-2" />
                            <select id="type" name="type" x-model="type" @change="checkType()"
                                class="block w-full rounded-xl border-secondary-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-all px-4 py-3 h-[50px] appearance-none"
                                style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1em;">
                                <option value="multiple_choice">Pilihan Ganda (Single Answer)</option>
                                <option value="true_false">Benar / Salah</option>
                                <option value="multiple_correct">Pilihan Ganda (Multiple Answers)</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="score" value="Bobot Nilai (Poin)" class="mb-2" />
                            <x-text-input id="score" type="number" name="score" value="{{ old('score', 10) }}" min="1"
                                required class="w-full" />
                            <x-input-error :messages="$errors->get('score')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options Card -->
            <div class="bg-white rounded-2xl shadow-card border border-secondary-100/50 overflow-hidden">
                <div class="p-6 border-b border-secondary-100/50 bg-secondary-50/50 flex items-center justify-between">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-secondary-900 flex items-center gap-2">
                        <div class="p-1.5 bg-emerald-600 rounded-lg text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        Opsi Jawaban
                    </h3>
                    <template x-if="type !== 'true_false'">
                        <button type="button" @click="addOption()"
                            class="inline-flex items-center text-xs font-bold text-brand-600 hover:text-brand-700 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition-all uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Opsi
                        </button>
                    </template>
                </div>
                <div class="p-8 space-y-4">
                    <p class="text-xs text-secondary-500 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Klik pada simbol centang di sebelah kiri untuk menandai jawaban yang benar.
                    </p>

                    <div class="space-y-3">
                        <template x-for="(option, index) in options" :key="index">
                            <div class="group flex items-center gap-3">
                                <!-- Correct Toggle -->
                                <button type="button" @click="toggleCorrect(index)"
                                    :class="isCorrect(index) ? 'bg-emerald-500 text-white border-emerald-500 shadow-emerald-200' : 'bg-white text-secondary-300 border-secondary-200 hover:border-brand-400 group-hover:bg-secondary-50 shadow-soft'"
                                    class="flex-shrink-0 w-11 h-11 rounded-xl border-2 flex items-center justify-center transition-all shadow-md">
                                    <svg class="w-6 h-6" :class="isCorrect(index) ? 'scale-110' : 'scale-90'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <input type="checkbox" name="correct_options[]" :value="index" class="hidden"
                                        :checked="isCorrect(index)">
                                </button>

                                <!-- Input Field -->
                                <div class="relative flex-grow">
                                    <input type="text" name="options[]" x-model="options[index]"
                                        class="block w-full rounded-xl border-secondary-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-all px-4 py-3"
                                        :placeholder="'Opsi Jawaban ' + (index + 1) + '...'"
                                        :readonly="type === 'true_false'" required>
                                </div>

                                <!-- Remove Action -->
                                <template x-if="type !== 'true_false' && options.length > 2">
                                    <button type="button" @click="removeOption(index)"
                                        class="flex-shrink-0 p-2.5 text-secondary-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>

                    <x-input-error :messages="$errors->get('options')" class="mt-2" />
                    <x-input-error :messages="$errors->get('correct_options')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('admin.questions.index', $quiz) }}"
                    class="text-sm font-semibold text-secondary-600 hover:text-secondary-900 transition-colors">
                    Kembali tanpa menyimpan
                </a>
                <x-primary-button class="py-3 px-8 text-base">
                    Simpan Soal
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>