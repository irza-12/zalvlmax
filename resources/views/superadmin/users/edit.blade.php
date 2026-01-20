<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
                Edit User
            </h2>
            <a href="{{ route('superadmin.users.index') }}"
                class="inline-flex items-center gap-x-2 rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 transition-colors">
                <svg class="-ml-0.5 h-5 w-5 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-lg shadow-card border border-secondary-100 overflow-hidden">
            <div class="p-8">
                <div class="flex justify-center mb-6">
                    <div
                        class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 to-indigo-600 text-3xl font-bold text-white shadow-lg shadow-brand-500/30">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                </div>

                <h1 class="text-center text-xl font-bold text-secondary-900 mb-1">Edit Profil</h1>
                <p class="text-center text-secondary-500 text-sm mb-8">Perbarui data sistem untuk pengguna ini.</p>

                @if($errors->any())
                    <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul role="list" class="list-disc space-y-1 pl-5">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('superadmin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium leading-6 text-secondary-900">Nama Lengkap</label>
                        <div class="mt-2">
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-secondary-900">Alamat Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-secondary-900">Nomor Telepon</label>
                        <div class="mt-2">
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08..."
                                class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-secondary-900">Peran (Role)</label>
                        <div class="mt-2">
                            <select name="role" required
                                class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User
                                    (Pengguna Biasa)</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="relative border-t border-secondary-100 pt-6">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-white px-2 text-sm text-secondary-400">
                            Security</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-secondary-900 flex justify-between">
                            Password Baru
                            <span class="font-normal text-secondary-400 text-xs">(Opsional)</span>
                        </label>
                        <div class="mt-2">
                            <input type="password" name="password" minlength="8" placeholder="••••••••"
                                class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-secondary-900">Konfirmasi
                            Password</label>
                        <div class="mt-2">
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="block w-full rounded-md border-0 py-2 px-4 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex h-6 items-center">
                            <input type="checkbox" name="is_active" id="isActive" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600">
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="isActive" class="font-medium text-secondary-900">Akun Aktif</label>
                            <p class="text-secondary-500 text-xs">Pengguna dapat login jika akun aktif.</p>
                        </div>
                    </div>

                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 transition-all transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>