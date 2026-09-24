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