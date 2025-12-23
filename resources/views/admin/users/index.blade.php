@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-title', 'Daftar Peserta')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Kuis Selesai</th>
                            <th>Bergabung</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                            style="width: 35px; height: 35px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-bold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form action="{{ route('admin.users.change-role', $user) }}" method="POST">
                                        @csrf
                                        <select name="role"
                                            class="form-select form-select-sm {{ $user->role == 'admin' ? 'bg-warning bg-opacity-10 border-warning text-dark' : '' }}"
                                            style="width: 140px;"
                                            onchange="if(confirm('Ubah role user ini?')) this.form.submit(); else this.value='{{ $user->role }}';">
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $user->results_count }} Kuis
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} border-0"
                                            title="Klik untuk mengubah status">
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('admin.users.reset-password', $user) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Reset password user ini menjadi \'password123\'?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Reset Password">
                                                <i class="bi bi-key"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin hapus user ini secara permanen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus User">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada user terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection