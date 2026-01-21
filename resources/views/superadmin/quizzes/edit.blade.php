<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-secondary-900 leading-tight tracking-tight">
                    Edit Kuis
                </h2>
                <div class="flex items-center gap-2 mt-1">
                    <span
                        class="inline-flex items-center rounded-md bg-secondary-100 px-2 py-1 text-xs font-medium text-secondary-600 ring-1 ring-inset ring-secondary-500/10">ID:
                        {{ $quiz->id }}</span>
                    <p class="text-sm text-secondary-500 truncate max-w-md" title="{{ $quiz->title }}">
                        {{ $quiz->title }}
                    </p>
                </div>
            </div>
            <a href="{{ route('superadmin.quizzes.index') }}"
                class="inline-flex items-center justify-center gap-x-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 hover:bg-secondary-50 hover:text-brand-600 transition-all duration-200">
                <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div x-data="{ 
        addQuestionModal: false,
        editQuestionModal: false,
        editingQuestion: null,
        
        generateCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = 'QZ-';
            for (let i = 0; i < 6; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('accessCode').value = result;
        },
        copyCode() {
            var copyText = document.getElementById('accessCode');
            if (!copyText.value) return;
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value).then(() => {
                alert('Kode berhasil disalin'); 
            });
        },
        openEditModal(question) {
            // Deep clone to prevent direct mutation issues and prepare for editing
            this.editingQuestion = JSON.parse(JSON.stringify(question));
            this.editQuestionModal = true;
        }
    }" class="pb-12">
        <form action="{{ route('superadmin.quizzes.update', $quiz) }}" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Quiz Info -->
                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-secondary-900/5 overflow-hidden">
                        <div
                            class="px-6 py-5 border-b border-secondary-100 bg-secondary-50/50 flex items-center justify-between">
                            <h3 class="text-base font-bold leading-6 text-secondary-900 flex items-center gap-2">
                                <div class="p-1.5 rounded-lg bg-brand-100 text-brand-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                Informasi Dasar
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Judul
                                    Kuis</label>
                                <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required
                                    class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Deskripsi</label>
                                <textarea name="description" rows="4"
                                    class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">{{ old('description', $quiz->description) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Kategori</label>
                                    <select name="category_id"
                                        class="block w-full rounded-xl border-0 py-3 pl-3 pr-10 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $quiz->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Durasi
                                        (menit)</label>
                                    <input type="number" name="duration" value="{{ old('duration', $quiz->duration) }}"
                                        min="1" required
                                        class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">
                                </div>
                            </div>

                            <div class="bg-brand-50/50 rounded-xl p-4 ring-1 ring-brand-100">
                                <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Kode Akses
                                    Kuis <span class="text-red-500">*</span></label>
                                <div class="flex rounded-xl shadow-sm">
                                    <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-brand-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 21H11.5l-2.436-1.524 1.516-2.484.093-.093m0-13.43a2 2 0 012.984 2.986 7.498 7.498 0 01-1.464 4.393M13 10v.01" />
                                            </svg>
                                        </div>
                                        <input type="text" name="access_password" id="accessCode"
                                            value="{{ old('access_password', $quiz->access_password) }}"
                                            placeholder="Contoh: QZ-A1B2C" required
                                            class="block w-full rounded-none rounded-l-xl border-0 py-3 pl-10 px-4 text-brand-700 font-bold font-mono uppercase tracking-wider ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 bg-white">
                                    </div>
                                    <button type="button" @click="generateCode()"
                                        class="relative -ml-px inline-flex items-center gap-x-1.5 bg-white px-4 py-2 text-sm font-semibold text-secondary-700 ring-1 ring-inset ring-secondary-200 hover:bg-secondary-50 hover:text-brand-600 transition-colors">
                                        Generate
                                    </button>
                                    <button type="button" @click="copyCode()"
                                        class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-xl bg-white px-4 py-2 text-sm font-semibold text-secondary-700 ring-1 ring-inset ring-secondary-200 hover:bg-secondary-50 hover:text-brand-600 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                        Salin
                                    </button>
                                </div>
                                <p class="mt-2 text-xs text-secondary-500 flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Simpan Perubahan untuk mengaktifkan kode ini.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Questions List -->
                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-secondary-900/5 overflow-hidden">
                        <div
                            class="px-6 py-5 border-b border-secondary-100 bg-secondary-50/50 flex items-center justify-between">
                            <h3 class="text-base font-bold leading-6 text-secondary-900 flex items-center gap-2">
                                <div class="p-1.5 rounded-lg bg-indigo-100 text-indigo-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                Daftar Soal
                                <span
                                    class="inline-flex items-center rounded-full bg-secondary-100 px-2.5 py-0.5 text-xs font-medium text-secondary-800">{{ $quiz->questions->count() }}</span>
                            </h3>
                            <button type="button" @click="addQuestionModal = true"
                                class="inline-flex items-center gap-x-2 rounded-xl bg-secondary-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-secondary-800 transition-all duration-200">
                                <svg class="-ml-0.5 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                Tambah Soal
                            </button>
                        </div>
                        <ul role="list" class="divide-y divide-secondary-100">
                            @forelse($quiz->questions as $index => $question)
                                <li class="p-6 hover:bg-secondary-50/50 transition-colors group">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-3 mb-3">
                                                <span
                                                    class="flex h-6 w-6 items-center justify-center rounded-full bg-secondary-100 text-xs font-bold text-secondary-600">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span
                                                    class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">{{ $question->type }}</span>
                                                <span
                                                    class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">{{ $question->score }}
                                                    poin</span>
                                            </div>
                                            <p class="text-sm font-medium text-secondary-900 leading-relaxed">
                                                {{ Str::limit($question->question_text, 150) }}
                                            </p>
                                        </div>
                                        <div
                                            class="flex items-center gap-2 flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <!-- Edit Button with Alpine Handler -->
                                            <button type="button" @click='openEditModal(@json($question))'
                                                class="p-2 rounded-lg text-secondary-400 hover:text-brand-600 hover:bg-brand-50 transition-colors"
                                                title="Edit Soal">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>

                                            <!-- Delete Button - Uses JS to avoid nested forms -->
                                            <button type="button"
                                                @click="if(confirm('Hapus soal ini?')) { document.getElementById('delete-question-{{ $question->id }}').submit(); }"
                                                class="p-2 rounded-lg text-secondary-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                                title="Hapus Soal">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-secondary-50 mb-4">
                                        <svg class="h-12 w-12 text-secondary-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-2 text-sm font-semibold text-secondary-900">Belum ada soal</h3>
                                    <p class="mt-1 text-sm text-secondary-500">Mulai dengan menambahkan soal untuk kuis ini.
                                    </p>
                                    <div class="mt-6">
                                        <button type="button" @click="addQuestionModal = true"
                                            class="inline-flex items-center rounded-xl bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 transition-colors">
                                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Buat Soal Pertama
                                        </button>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Right Column (Settings) -->
                <div class="space-y-6">
                    <div
                        class="rounded-2xl bg-white shadow-sm ring-1 ring-secondary-900/5 overflow-hidden sticky top-6">
                        <div class="px-6 py-5 border-b border-secondary-100 bg-secondary-50/50 flex items-center gap-2">
                            <div class="p-1.5 rounded-lg bg-emerald-100 text-emerald-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold leading-6 text-secondary-900">Pengaturan</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label
                                    class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Status</label>
                                <select name="status" required
                                    class="block w-full rounded-xl border-0 py-3 pl-3 pr-10 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">
                                    <option value="draft" {{ old('status', $quiz->status) == 'draft' ? 'selected' : '' }}>
                                        Draft</option>
                                    <option value="active" {{ old('status', $quiz->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $quiz->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="archived" {{ old('status', $quiz->status) == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Nilai
                                    Kelulusan (%)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="number" name="passing_score"
                                        value="{{ old('passing_score', $quiz->passing_score) }}" min="0" max="100"
                                        required
                                        class="block w-full rounded-xl border-0 py-3 pr-12 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                        <span class="text-secondary-500 sm:text-sm">%</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Maks.
                                    Percobaan</label>
                                <input type="number" name="max_attempts"
                                    value="{{ old('max_attempts', $quiz->max_attempts) }}" min="1" required
                                    class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                            </div>

                            <div class="border-t border-secondary-100 pt-6 space-y-4">
                                <div class="relative flex items-start group">
                                    <div class="flex h-6 items-center">
                                        <input id="shuffleQuestions" name="shuffle_questions" type="checkbox" {{ old('shuffle_questions', $quiz->shuffle_questions) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600 cursor-pointer">
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label for="shuffleQuestions"
                                            class="font-medium text-secondary-900 group-hover:text-brand-600 transition-colors cursor-pointer">Acak
                                            Urutan Soal</label>
                                    </div>
                                </div>
                                <div class="relative flex items-start group">
                                    <div class="flex h-6 items-center">
                                        <input id="shuffleOptions" name="shuffle_options" type="checkbox" {{ old('shuffle_options', $quiz->shuffle_options) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600 cursor-pointer">
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label for="shuffleOptions"
                                            class="font-medium text-secondary-900 group-hover:text-brand-600 transition-colors cursor-pointer">Acak
                                            Urutan Pilihan</label>
                                    </div>
                                </div>
                                <div class="relative flex items-start group">
                                    <div class="flex h-6 items-center">
                                        <input id="showCorrect" name="show_correct_answer" type="checkbox" {{ old('show_correct_answer', $quiz->show_correct_answer) ? 'checked' : '' }}
                                            class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600 cursor-pointer">
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label for="showCorrect"
                                            class="font-medium text-secondary-900 group-hover:text-brand-600 transition-colors cursor-pointer">Tampilkan
                                            Jawaban Benar</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="flex w-full justify-center rounded-xl bg-brand-600 px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 transition-all duration-200 transform hover:-translate-y-0.5 mt-4">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Hidden Delete Forms - Outside main form to avoid nesting -->
        @foreach($quiz->questions as $question)
            <form id="delete-question-{{ $question->id }}" action="{{ route('superadmin.questions.destroy', $question) }}"
                method="POST" class="hidden">
                @csrf @method('DELETE')
            </form>
        @endforeach

        <!-- Add Question Modal -->
        <div x-show="addQuestionModal" class="relative z-50" aria-labelledby="modal-title" role="dialog"
            aria-modal="true" style="display: none;">
            <div x-show="addQuestionModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-secondary-900/75 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="addQuestionModal" @click.outside="addQuestionModal = false"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-secondary-100">
                        <form action="{{ route('superadmin.questions.store', $quiz) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="multiple_choice">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <h3 class="text-xl font-bold leading-6 text-secondary-900 mb-6 flex items-center gap-2">
                                    <div class="p-1.5 rounded-lg bg-brand-100 text-brand-600">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    Tambah Soal Baru
                                </h3>
                                <div class="space-y-5">
                                    <div>
                                        <label
                                            class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Pertanyaan</label>
                                        <textarea name="question_text" rows="3" required
                                            placeholder="Tulis pertanyaan disini..."
                                            class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Poin</label>
                                        <input type="number" name="score" value="10" min="0" required
                                            class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                    </div>

                                    <div class="bg-secondary-50/50 p-4 rounded-xl ring-1 ring-secondary-200/50">
                                        <label
                                            class="block text-sm font-semibold leading-6 text-secondary-900 mb-4">Pilihan
                                            Jawaban (Pilih satu yang benar)</label>
                                        @foreach(range(0, 3) as $i)
                                            <div class="flex items-center gap-3 mb-3 last:mb-0">
                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-secondary-300 bg-white hover:border-brand-500 hover:bg-brand-50 transition-colors">
                                                    <input type="radio" name="correct_option" value="{{ $i }}" {{ $i === 0 ? 'required' : '' }}
                                                        class="h-5 w-5 border-secondary-300 text-brand-600 focus:ring-brand-600 cursor-pointer">
                                                </div>
                                                <input type="text" name="options[{{ $i }}][text]"
                                                    placeholder="Pilihan {{ chr(65 + $i) }}" required
                                                    class="block w-full rounded-xl border-0 py-2.5 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="bg-secondary-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 sm:ml-3 sm:w-auto transition-all">Simpan
                                    Soal</button>
                                <button type="button" @click="addQuestionModal = false"
                                    class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 sm:mt-0 sm:w-auto transition-all">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Question Modal -->
        <div x-show="editQuestionModal" class="relative z-50" aria-labelledby="modal-title" role="dialog"
            aria-modal="true" style="display: none;">
            <div x-show="editQuestionModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-secondary-900/75 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="editQuestionModal" @click.outside="editQuestionModal = false"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-secondary-100">
                        <template x-if="editingQuestion">
                            <form
                                :action="'{{ route('superadmin.questions.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', editingQuestion.id)"
                                method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="type" value="multiple_choice">
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <h3
                                        class="text-xl font-bold leading-6 text-secondary-900 mb-6 flex items-center gap-2">
                                        <div class="p-1.5 rounded-lg bg-orange-100 text-orange-600">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </div>
                                        Edit Soal
                                    </h3>
                                    <div class="space-y-5">
                                        <div>
                                            <label
                                                class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Pertanyaan</label>
                                            <textarea name="question_text" x-model="editingQuestion.question_text"
                                                rows="3" required placeholder="Tulis pertanyaan disini..."
                                                class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6"></textarea>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Poin</label>
                                            <input type="number" name="score" x-model="editingQuestion.score" min="0"
                                                required
                                                class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                        </div>

                                        <div class="bg-secondary-50/50 p-4 rounded-xl ring-1 ring-secondary-200/50">
                                            <label
                                                class="block text-sm font-semibold leading-6 text-secondary-900 mb-4">Pilihan
                                                Jawaban (Pilih satu yang benar)</label>
                                            <template x-for="(option, index) in editingQuestion.options"
                                                :key="option.id">
                                                <div class="flex items-center gap-3 mb-3 last:mb-0">
                                                    <div
                                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-secondary-300 bg-white hover:border-brand-500 hover:bg-brand-50 transition-colors">
                                                        <input type="radio" name="correct_option" :value="option.id"
                                                            :checked="option.is_correct == 1"
                                                            class="h-5 w-5 border-secondary-300 text-brand-600 focus:ring-brand-600 cursor-pointer">
                                                    </div>
                                                    <!-- Use option.id for unique grouping in request -->
                                                    <input type="text" :name="'options['+option.id+'][text]'"
                                                        x-model="option.option_text" placeholder="Pilihan Jawaban"
                                                        required
                                                        class="block w-full rounded-xl border-0 py-2.5 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-secondary-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-xl bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 sm:ml-3 sm:w-auto transition-all">Simpan
                                        Perubahan</button>
                                    <button type="button" @click="editQuestionModal = false"
                                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 sm:mt-0 sm:w-auto transition-all">Batal</button>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>