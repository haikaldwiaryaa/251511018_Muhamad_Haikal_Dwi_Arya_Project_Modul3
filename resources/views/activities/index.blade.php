@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h1>Daftar Kegiatan</h1>
        <a href="{{ route('activities.create') }}"
            style="background: #16a34a; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
            + Tambah Kegiatan
        </a>
    </div>

    @if (session('success'))
        <div style="background: #dcfce7; color: #15803d; padding: 0.8rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Filter Status (Independent Challenge) --}}
    <form action="{{ route('activities.index') }}" method="GET"
        style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem; align-items: center; background: #f1f5f9; padding: 0.8rem; border-radius: 6px;">
        <label for="filter_status"><strong>Filter Status:</strong></label>
        <select name="status" id="filter_status" style="padding: 0.4rem; border-radius: 4px; border: 1px solid #cbd5e1;">
            <option value="">Semua Status</option>
            <option value="Planned" {{ request('status') === 'Planned' ? 'selected' : '' }}>Planned</option>
            <option value="Ongoing" {{ request('status') === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
            <option value="Done" {{ request('status') === 'Done' ? 'selected' : '' }}>Done</option>
        </select>
        <button type="submit"
            style="padding: 0.4rem 0.8rem; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Terapkan
        </button>
        @if (request('status'))
            <a href="{{ route('activities.index') }}"
                style="color: #ef4444; font-size: 0.9rem; text-decoration: none; margin-left: 0.5rem;">
                Reset Filter
            </a>
        @endif
    </form>

    @forelse ($activities as $activity)
        <article class="card">
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }}
                </a>
            </h2>
            <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
            <p>Status: <span class="badge">{{ $activity->status }}</span></p>
            <div style="margin-top: 0.5rem;">
                <a href="{{ route('activities.edit', $activity) }}">Ubah</a> |
                <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display: inline;"
                    onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="background: none; border: none; color: red; cursor: pointer; padding: 0;">Hapus</button>
                </form>
            </div>
        </article>
    @empty
        <p>Belum ada kegiatan.</p>
    @endforelse
@endsection