@extends('layouts.admin')

@section('title', 'Hasil Evaluasi')
@section('page-title', 'Hasil Evaluasi Peserta')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-8">
                             <form action="{{ route('admin.results.index') }}" method="GET" class="row g-2">
                                <div class="col-md-5">
                                    <select name="quiz_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">-- Semua Kuis --</option>
                                        @foreach($quizzes as $quiz)
                                            <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                                                {{ $quiz->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="search" class="form-control" placeholder="Cari Nama/Email User..."
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                             </form>
                        </div>
                        <div class="col-md-4 d-flex gap-1 justify-content-end">
                            <button type="submit" form="compareForm" class="btn btn-warning text-dark" id="btnCompare" disabled>
                                <i class="bi bi-arrows-angle-contract"></i> Bandingkan
                            </button>
                            <a href="{{ route('admin.results.export.excel', request()->all()) }}" class="btn btn-success"
                                target="_blank" title="Export Excel">
                                <i class="bi bi-file-earmark-excel"></i>
                            </a>
                            <a href="{{ route('admin.results.export.pdf', request()->all()) }}" class="btn btn-danger"
                                target="_blank" title="Export PDF">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.results.compare') }}" method="GET" id="compareForm">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="40" class="text-center">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>No</th>
                                        <th>Nama Peserta</th>
                                        <th>Kuis</th>
                                        <th>Skor</th>
                                        <th>Benar/Salah</th>
                                        <th>Waktu</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($results as $index => $result)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="ids[]" value="{{ $result->id }}" class="form-check-input select-item">
                                            </td>
                                            <td>{{ $results->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $result->user->name }}</strong><br>
                                                <small class="text-muted">{{ $result->user->email }}</small>
                                            </td>
                                            <td>{{ $result->quiz->title }}</td>
                                            <td>
                                                @if($result->completion_time)
                                                <span
                                                    class="badge bg-{{ $result->total_score >= 80 ? 'success' : ($result->total_score >= 60 ? 'warning' : 'danger') }} fs-6">
                                                    {{ floatval($result->total_score) }}
                                                </span>
                                                @else
                                                <span class="badge bg-secondary">
                                                    Proses
                                                </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-success">{{ $result->correct_answers }}</span> /
                                                <span class="text-danger">{{ $result->wrong_answers }}</span>
                                            </td>
                                            <td>{{ $result->formatted_completion_time }}</td>
                                            <td>{{ $result->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $result->status_color }}">
                                                    {{ $result->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.results.show', $result) }}"
                                                    class="btn btn-sm btn-info text-white">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">Tidak ada data hasil evaluasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="mt-3">
                        {{ $results->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const items = document.querySelectorAll('.select-item');
            const btnCompare = document.getElementById('btnCompare');

            function updateButtonState() {
                const checkedCount = document.querySelectorAll('.select-item:checked').length;
                btnCompare.disabled = checkedCount < 2;
                if(checkedCount >= 2) {
                     btnCompare.innerHTML = `<i class="bi bi-arrows-angle-contract"></i> Bandingkan (${checkedCount})`;
                } else {
                     btnCompare.innerHTML = `<i class="bi bi-arrows-angle-contract"></i> Bandingkan`;
                }
            }

            selectAll.addEventListener('change', function() {
                items.forEach(item => {
                    item.checked = selectAll.checked;
                });
                updateButtonState();
            });

            items.forEach(item => {
                item.addEventListener('change', updateButtonState);
            });
        });
    </script>
@endsection