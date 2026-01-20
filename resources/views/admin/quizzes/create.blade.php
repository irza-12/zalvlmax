<x-app-layout title="Buat Kuis Baru">
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
                                <span class="text-sm font-medium text-secondary-900">Buat Baru</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-display font-bold text-secondary-900 leading-tight">
                    Buat Kuis Baru
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.quizzes.index') }}"
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

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.quizzes.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Quiz Information Card -->
            <div class="bg-white rounded-3xl shadow-card border border-secondary-100/50 overflow-hidden">
                <div class="p-6 md:px-8 border-b border-secondary-50 bg-secondary-50/30">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-secondary-900 flex items-center gap-2">
                        <div class="p-1.5 bg-brand-600 rounded-lg text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </div>
                        Informasi Dasar
                    </h3>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <x-input-label for="title" value="Judul Kuis" class="mb-2" />
                        <x-text-input id="title" name="title" type="text" class="w-full" :value="old('title')"
                            placeholder="Masukkan judul kuis..." required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Deskripsi" class="mb-2" />
                        <textarea id="description" name="description" rows="4"
                            class="block w-full rounded-xl border-secondary-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-all px-4 py-3"
                            placeholder="Tuliskan deskripsi kuis di sini...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="duration" value="Durasi (Menit)" class="mb-2" />
                            <x-text-input id="duration" name="duration" type="number" class="w-full"
                                :value="old('duration', 60)" required />
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" value="Status" class="mb-2" />
                            <select id="status" name="status"
                                class="block w-full rounded-xl border-secondary-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-all px-4 py-3 h-[50px] appearance-none"
                                style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1em;">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="start_time" value="Waktu Mulai" class="mb-2" />
                            <x-text-input id="start_time" name="start_time" type="datetime-local" class="w-full"
                                :value="old('start_time')" required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="end_time" value="Waktu Selesai" class="mb-2" />
                            <x-text-input id="end_time" name="end_time" type="datetime-local" class="w-full"
                                :value="old('end_time')" required />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('admin.quizzes.index') }}"
                    class="text-sm font-semibold text-secondary-600 hover:text-secondary-900 transition-colors">
                    Kembali tanpa menyimpan
                </a>
                <x-primary-button class="py-3 px-10 text-base shadow-brand-200/50 shadow-lg">
                    Buat Kuis
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>