@extends('layouts.app')

@section('content')
    <a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar</a>
    <h2>Tambah Kegiatan Baru</h2>

    <form action="{{ route('activities.store') }}" method="POST">
        @csrf
        @include('activities._form')
    </form>
@endsection