@extends('layouts.app')

@section('content')
    <a href="{{ route('activities.show', $activity) }}">&larr; Kembali ke Detail</a>
    <h2>Edit Kegiatan</h2>

    <form action="{{ route('activities.update', $activity) }}" method="POST">
        @csrf
        @method('PUT')
        @include('activities._form')
    </form>
@endsection