@extends('layouts.app')

@section('content')
    <a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar</a>

    <h1>{{ $activity->title }}</h1>
    <p><strong>Status:</strong> <span class="badge">{{ $activity->status }}</span></p>
    <p><strong>Tanggal Kegiatan:</strong> {{ $activity->activity_date->format('d F Y') }}</p>
    <p><strong>Deskripsi:</strong></p>
    <p>{{ $activity->description ?? 'Tidak ada deskripsi.' }}</p>
@endsection