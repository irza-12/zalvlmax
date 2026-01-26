<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-secondary-900 leading-tight tracking-tight">
                    Buat Kuis Baru
                </h2>
                <p class="mt-1 text-sm text-secondary-500">Isi informasi dasar untuk memulai kuis baru</p>
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
        init() {
            if (!document.getElementById('accessCode').value) {
                this.generateCode();
            }
        },
        generateCode() {
            let result = '';
            for (let i = 0; i < 6; i++) {
                result += Math.floor(Math.random() * 10);
            }
            document.getElementById('accessCode').value = result;
        },
        copyCode() {
            var copyText = document.getElementById('accessCode');
            if (!copyText.value) return;
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
        }
    }" class="pb-12">
        <form action="{{ route('superadmin.quizzes.store') }}" method="POST">
            @csrf

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
                                <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Judul Kuis
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}" required
                                    placeholder="Contoh: UTS Matematika Semester 1"
                                    class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Deskripsi</label>
                                <textarea name="description" rows="4" placeholder="Jelaskan tentang kuis ini..."
                                    class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">{{ old('description') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <label
                                        class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Kategori</label>
                                    <select name="category_id"
                                        class="block w-full rounded-xl border-0 py-3 px-4 pr-10 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Durasi
                                        (menit) <span class="text-red-500">*</span></label>
                                    <input type="number" name="duration" value="{{ old('duration', 60) }}" min="1"
                                        required
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
                                            value="{{ old('access_password') }}" placeholder="Contoh: 123456" required
                                            pattern="[0-9]{6}" inputmode="numeric" maxlength="6"
                                            class="block w-full rounded-none rounded-l-xl border-0 py-3 px-4 pl-10 text-brand-700 font-bold font-mono tracking-wider ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 bg-white">
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
                                    Kode ini akan aktif setelah Anda menyimpan kuis ini.
                                </p>
                            </div>
                        </div>
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
                                <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Status
                                    <span class="text-red-500">*</span></label>
                                <select name="status" required
                                    class="block w-full rounded-xl border-0 py-3 px-4 pl-3 pr-10 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6 transition-shadow">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Nilai
                                    Kelulusan (%) <span class="text-red-500">*</span></label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="number" name="passing_score" value="{{ old('passing_score', 60) }}"
                                        min="0" max="100" required
                                        class="block w-full rounded-xl border-0 py-3 px-4 pr-12 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                        <span class="text-secondary-500 sm:text-sm">%</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold leading-6 text-secondary-900 mb-2">Maks.
                                    Percobaan <span class="text-red-500">*</span></label>
                                <input type="number" name="max_attempts" value="{{ old('max_attempts', 1) }}" min="1"
                                    required
                                    class="block w-full rounded-xl border-0 py-3 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-200 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                            </div>

                            <div class="border-t border-secondary-100 pt-6 space-y-4">
                                <div class="relative flex items-start group">
                                    <div class="flex h-6 items-center">
                                        <input id="shuffleQuestions" name="shuffle_questions" type="checkbox" {{ old('shuffle_questions') ? 'checked' : '' }}
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
                                        <input id="shuffleOptions" name="shuffle_options" type="checkbox" {{ old('shuffle_options') ? 'checked' : '' }}
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
                                        <input id="showCorrect" name="show_correct_answer" type="checkbox" {{ old('show_correct_answer') ? 'checked' : '' }}
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
                                Simpan & Lanjutkan ke Soal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>