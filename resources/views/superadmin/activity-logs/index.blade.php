<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
                    Activity Log
                </h2>
                <p class="mt-1 text-sm text-secondary-500">Riwayat aktivitas sistem</p>
            </div>
            <form action="{{ route('superadmin.activity-logs.clear') }}" method="POST" onsubmit="return confirm('Hapus log lebih dari 30 hari?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-inset ring-red-300 hover:bg-red-50">
                    <svg class="-ml-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Log Lama
                </button>
            </form>
        </div>
    </x-slot>

    <!-- Filters -->
    <div class="mb-6 rounded-lg bg-white p-4 shadow-card border border-secondary-100">
        <form action="" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-secondary-500 mb-1">Tipe Aksi</label>
                <select name="action" class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                    <option value="">Semua Aksi</option>
                    <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-secondary-500 mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center rounded-md bg-secondary-900 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-secondary-800 transition-colors">
                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
                <a href="{{ route('superadmin.activity-logs.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center rounded-md bg-white px-3.5 py-2 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden">
        @if($logs->count() > 0)
            <ul role="list" class="divide-y divide-secondary-100">
                @foreach($logs as $log)
                    <li class="p-4 hover:bg-secondary-50 transition-colors">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 mt-1">
                                @switch($log->action)
                                    @case('create')
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </span>
                                        @break
                                    @case('update')
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </span>
                                        @break
                                    @case('delete')
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-red-100 text-red-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </span>
                                        @break
                                    @case('login')
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-600">
                                             <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 text-gray-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                @endswitch
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-sm font-medium text-secondary-900">{{ $log->user->name ?? 'System' }}</p>
                                    <p class="text-xs text-secondary-500 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <p class="text-sm text-secondary-600 mt-0.5">{{ $log->description }}</p>
                                @if($log->ip_address)
                                    <p class="text-xs text-secondary-400 mt-1 flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $log->ip_address }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="border-t border-secondary-200 bg-secondary-50 px-4 py-3 sm:px-6">
                {{ $logs->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 text-center text-secondary-500">
                <svg class="h-12 w-12 text-secondary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="mt-2 text-base font-semibold text-secondary-900">Tidak ada log aktivitas</p>
            </div>
        @endif
    </div>
</x-app-layout>
