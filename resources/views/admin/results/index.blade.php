<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
                    Hasil Evaluasi
                </h2>
                <p class="mt-2 text-sm text-secondary-500">Laporan hasil pengerjaan kuis peserta</p>
            </div>

            <div class="flex gap-2">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" type="button"
                        class="inline-flex items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 transition-colors"
                        id="export-menu-button" aria-expanded="true" aria-haspopup="true">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-secondary-400" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Export Data
                        <svg class="-mr-1 ml-1.5 h-5 w-5 text-secondary-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
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
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="export-menu-button" tabindex="-1"
                        style="display: none;">
                        <div class="py-1" role="none">
                            <a href="{{ route('admin.results.export.excel', request()->all()) }}"
                                class="group flex items-center px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900"
                                role="menuitem" tabindex="-1" target="_blank">
                                <svg class="mr-3 h-5 w-5 text-green-500 group-hover:text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Export Excel
                            </a>
                            <a href="{{ route('admin.results.export.pdf', request()->all()) }}"
                                class="group flex items-center px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900"
                                role="menuitem" tabindex="-1" target="_blank">
                                <svg class="mr-3 h-5 w-5 text-red-500 group-hover:text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Export PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Filters -->
    <div class="mb-6 rounded-lg bg-white p-4 shadow-card border border-secondary-100">
        <form action="{{ route('admin.results.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-grow sm:max-w-xs">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-secondary-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full rounded-md border-0 py-2 pl-10 text-secondary-900 ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6"
                    placeholder="Cari Nama/Email...">
            </div>

            <div class="sm:w-64">
                <select name="quiz_id"
                    class="block w-full rounded-md border-0 py-2 pl-3 pr-10 text-secondary-900 ring-1 ring-inset ring-secondary-300 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6"
                    onchange="this.form.submit()">
                    <option value="">-- Semua Kuis --</option>
                    @foreach($quizzes as $quiz)
                        <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                            {{ $quiz->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="inline-flex items-center justify-center rounded-md bg-secondary-900 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-secondary-800 transition-colors">
                Filter
            </button>
        </form>
    </div>

    <div x-data="{ selected: [], allSelected: false, toggleAll() { this.allSelected = !this.allSelected; this.selected = this.allSelected ? {{ json_encode($results->pluck('id')) }} : []; } }"
        class="rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden">

        <!-- Compare Toolbar -->
        <div class="border-b border-secondary-200 bg-secondary-50 px-4 py-3 sm:px-6 flex items-center justify-between"
            x-show="selected.length > 0" x-transition>
            <span class="text-sm font-medium text-secondary-700" x-text="selected.length + ' dipilih'"></span>
            <form action="{{ route('admin.results.compare') }}" method="GET" class="inline">
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="submit" :disabled="selected.length < 2"
                    class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 disabled:cursor-not-allowed disabled:opacity-50">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-secondary-400" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                    </svg>
                    Bandingkan
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="relative px-6 py-3 w-12">
                            <input type="checkbox"
                                class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600"
                                @click="toggleAll()" :checked="allSelected">
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Peserta</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Kuis</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Skor</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Benar/Salah</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Waktu</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Detail</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-100">
                    @forelse($results as $result)
                        <tr class="hover:bg-secondary-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" value="{{ $result->id }}" x-model="selected"
                                    class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 flex-shrink-0">
                                        <img class="h-8 w-8 rounded-full border border-secondary-200"
                                            src="{{ $result->user->avatar_url }}" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-secondary-900">{{ $result->user->name }}
                                        </div>
                                        <div class="text-xs text-secondary-500">{{ $result->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-900">
                                {{ $result->quiz->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($result->completion_time)
                                    <span
                                        class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $result->total_score >= 80 ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20' : ($result->total_score >= 60 ? 'bg-yellow-50 text-yellow-800 ring-1 ring-inset ring-yellow-600/20' : 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/10') }}">
                                        {{ floatval($result->total_score) }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Proses</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="text-green-600 font-medium">{{ $result->correct_answers }}</span> <span
                                    class="text-secondary-400">/</span> <span
                                    class="text-red-600 font-medium">{{ $result->wrong_answers }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $result->completed_at ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $result->completed_at ? 'Selesai' : 'Proses' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500">
                                {{ $result->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.results.export.pdf', ['result_id' => $result->id]) }}"
                                        class="text-rose-600 hover:text-rose-800 transition-colors" title="Cetak PDF">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.results.show', $result) }}"
                                        class="text-brand-600 hover:text-brand-800 transition-colors">Detail</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-secondary-500">
                                Belum ada data hasil evaluasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($results->hasPages())
            <div class="border-t border-secondary-100 bg-white px-6 py-4 rounded-b-3xl">
                {{ $results->appends(request()->all())->links() }}
            </div>
        @endif
    </div>
</x-app-layout>