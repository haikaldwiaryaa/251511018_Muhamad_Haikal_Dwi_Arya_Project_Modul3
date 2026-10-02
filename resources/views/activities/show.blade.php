@extends('layouts.app')

@section('content')
    <a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar</a>

    @if (session('success'))
        <div style="background: #dcfce7; color: #15803d; padding: 0.8rem; border-radius: 4px; margin: 1rem 0;">
            {{ session('success') }}
        </div>
    @endif

    <h1>{{ $activity->title }}</h1>
    <p><strong>Kode:</strong> {{ $activity->code ?? '-' }}</p>
    <p><strong>Kategori:</strong> {{ $activity->category?->name ?? '-' }}</p>
    <p><strong>Status:</strong> <span class="badge">{{ $activity->status }}</span></p>
    <p><strong>Tanggal Kegiatan:</strong> {{ $activity->activity_date->format('d F Y') }}</p>
    <p><strong>Deskripsi:</strong></p>
    <p>{{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>

    @if ($activity->poster_path)
        <div style="margin: 1.5rem 0;">
            <p><strong>Poster Kegiatan:</strong></p>
            <img src="{{ asset('storage/' . $activity->poster_path) }}" alt="Poster {{ $activity->title }}" style="max-width: 320px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;">
        </div>
    @endif

    <div style="margin-top: 1.5rem; display: flex; gap: 0.5rem;">
        <a href="{{ route('activities.edit', $activity) }}"
            style="background: #eab308; color: black; padding: 0.4rem 0.8rem; border-radius: 4px; text-decoration: none;">Ubah
            Kegiatan</a>
        <a href="{{ route('activities.index') }}"
            style="background: #6b7280; color: white; padding: 0.4rem 0.8rem; border-radius: 4px; text-decoration: none;">Kembali</a>
    </div>
@endsection
