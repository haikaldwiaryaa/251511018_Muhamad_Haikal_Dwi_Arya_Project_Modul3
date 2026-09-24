@extends('layouts.app')

@section('content')
    <a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar</a>

    @if (session('success'))
        <div style="background: #dcfce7; color: #15803d; padding: 0.8rem; border-radius: 4px; margin: 1rem 0;">
            {{ session('success') }}
        </div>
    @endif

    <h1>{{ $activity->title }}</h1>
    <p><strong>Status:</strong> <span class="badge">{{ $activity->status }}</span></p>
    <p><strong>Tanggal Kegiatan:</strong> {{ $activity->activity_date->format('d F Y') }}</p>
    <p><strong>Deskripsi:</strong></p>
    <p>{{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>

    <div style="margin-top: 1.5rem;">
        <a href="{{ route('activities.edit', $activity) }}"
            style="background: #eab308; color: black; padding: 0.4rem 0.8rem; border-radius: 4px; text-decoration: none;">Ubah
            Kegiatan</a>
    </div>
@endsection