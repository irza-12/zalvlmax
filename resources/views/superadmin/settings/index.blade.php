<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
            Pengaturan
        </h2>
        <p class="mt-1 text-sm text-secondary-500">Konfigurasi sistem aplikasi</p>
    </x-slot>

    <form action="{{ route('superadmin.settings.update') }}" method="POST">
        @csrf

        @foreach($settings as $group => $groupSettings)
            <div class="mb-8 rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden">
                 <div class="px-6 py-4 border-b border-secondary-100 bg-secondary-50">
                    <h3 class="text-base font-semibold leading-6 text-secondary-900 flex items-center gap-2">
                         @switch($group)
                            @case('general')
                                <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                @break
                            @case('quiz')
                                <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                @break
                            @case('email')
                                <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                @break
                            @case('report')
                                <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                @break
                            @case('security')
                                <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                @break
                            @default
                                <svg class="h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        @endswitch
                        
                        @switch($group)
                            @case('general') Pengaturan Umum @break
                            @case('quiz') Pengaturan Kuis @break
                            @case('email') Pengaturan Email @break
                            @case('report') Pengaturan Laporan @break
                            @case('security') Pengaturan Keamanan @break
                            @default {{ ucfirst($group) }}
                        @endswitch
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($groupSettings as $setting)
                            <div>
                                <label class="block text-sm font-medium leading-6 text-secondary-900 mb-2">
                                    {{ $setting->description ?? $setting->key }}
                                </label>

                                @switch($setting->type)
                                    @case('boolean')
                                        <div class="relative flex items-start">
                                            <div class="flex h-6 items-center">
                                                <input type="hidden" name="settings[{{ $setting->key }}]" value="0">
                                                <input type="checkbox" name="settings[{{ $setting->key }}]" value="1" {{ $setting->value ? 'checked' : '' }} class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600">
                                            </div>
                                            <div class="ml-3 text-sm leading-6">
                                                <span class="text-secondary-500">{{ $setting->value ? 'Aktif' : 'Nonaktif' }}</span>
                                            </div>
                                        </div>
                                        @break

                                    @case('number')
                                        <input type="number" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                        @break

                                    @case('text')
                                        <textarea name="settings[{{ $setting->key }}]" rows="3" class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">{{ $setting->value }}</textarea>
                                        @break

                                    @default
                                        <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                @endswitch
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex justify-end">
            <button type="submit" class="rounded-md bg-brand-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
</x-app-layout>
