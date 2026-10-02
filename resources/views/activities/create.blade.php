@extends('layouts.app')

@section('content')
    <a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar</a>
    <h2 style="margin-top: 1rem;">Tambah Kegiatan Baru</h2>

    @if ($errors->any())
        <div style="background: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 0.8rem 1rem; border-radius: 4px; margin: 1rem 0;">
            <strong>Terjadi kesalahan pengisian form:</strong>
            <ul style="margin: 0.5rem 0 0 0; padding-left: 1.2rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('activities._form')
    </form>
@endsection
