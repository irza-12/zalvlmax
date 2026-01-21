<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
                    Komparasi Jawaban
                </h2>
                <p class="mt-1 text-sm text-secondary-500">Bandingkan hasil jawaban antar peserta @if(isset($quiz)) - {{ $quiz->title }} @endif</p>
            </div>
            
            <div class="flex gap-2">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" type="button" class="inline-flex items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 transition-colors" id="export-menu-button-compare" aria-expanded="true" aria-haspopup="true">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Export
                        <svg class="-mr-1 ml-1.5 h-5 w-5 text-secondary-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="export-menu-button-compare" tabindex="-1" style="display: none;">
                        <div class="py-1" role="none">
                             <a href="{{ route('admin.results.compare.export.excel', ['ids' => $results->pluck('id')->toArray()]) }}" class="group flex items-center px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900" role="menuitem" tabindex="-1" target="_blank">
                                <svg class="mr-3 h-5 w-5 text-green-500 group-hover:text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Export Excel
                            </a>
                             <a href="{{ route('admin.results.compare.export.pdf', ['ids' => $results->pluck('id')->toArray()]) }}" class="group flex items-center px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-100 hover:text-secondary-900" role="menuitem" tabindex="-1" target="_blank">
                                <svg class="mr-3 h-5 w-5 text-red-500 group-hover:text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Export PDF
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.results.index') }}" class="inline-flex items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200 border-collapse table-fixed">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider w-1/3 border-r border-secondary-200">Soal</th>
                        @foreach($results as $result)
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-secondary-500 uppercase tracking-wider border-r border-secondary-200 min-w-[200px]">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-sm font-bold text-secondary-900">{{ $result->user->name }}</span>
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $result->total_score >= 80 ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20' : ($result->total_score >= 60 ? 'bg-yellow-50 text-yellow-800 ring-1 ring-inset ring-yellow-600/20' : 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/10') }}">
                                        Skor: {{ floatval($result->total_score) }}
                                    </span>
                                    <span class="text-xs text-secondary-400 font-normal">
                                        {{ $result->formatted_completion_time }}
                                    </span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-secondary-100 bg-white">
                    @foreach($quiz->questions as $index => $question)
                        <tr class="hover:bg-secondary-50/50 transition-colors">
                            <td class="px-6 py-4 border-r border-secondary-200 align-top">
                                <div class="flex flex-col gap-2">
                                    <span class="text-xs font-semibold text-brand-600">No. {{ $index + 1 }}</span>
                                    <p class="text-sm text-secondary-900">{{ $question->question_text }}</p>
                                    <div class="mt-2 rounded-md bg-green-50 px-3 py-2 text-xs text-green-700 border border-green-200">
                                        <div class="flex items-start gap-1.5">
                                            <svg class="h-4 w-4 shrink-0 text-green-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="font-semibold">Kunci Jawaban:</span>
                                                <ul class="list-inside list-disc mt-1">
                                                    @foreach($question->options as $option)
                                                        @if($option->is_correct) 
                                                            <li>{{ $option->option_text }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @foreach($results as $result)
                                @php
                                    $answer = ($result->session && $result->session->answers->where('question_id', $question->id)->count() > 0)
                                        ? $result->session->answers->where('question_id', $question->id)->first()
                                        : $result->user->answers->where('question_id', $question->id)->first();
                                    $selectedOption = $answer ? $question->options->where('id', $answer->option_id)->first() : null;
                                    $isCorrect = $answer ? $answer->isCorrect() : false;
                                    $bgClass = $isCorrect ? 'bg-green-50/50' : ($answer ? 'bg-red-50/50' : 'bg-gray-50/50');
                                @endphp
                                <td class="px-6 py-4 text-center align-top border-r border-secondary-200 {{ $bgClass }}">
                                    <div class="flex flex-col items-center justify-center h-full">
                                        @if($selectedOption)
                                            <span class="text-sm font-medium {{ $isCorrect ? 'text-green-700' : 'text-red-700' }}">
                                                {{ $selectedOption->option_text }}
                                            </span>
                                            <div class="mt-2">
                                                @if($isCorrect)
                                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                        Benar
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Salah
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-sm text-secondary-400 italic">Tidak dijawab</span>
                                            <div class="mt-2">
                                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-secondary-600">
                                                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                                    </svg>
                                                    Kosong
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
