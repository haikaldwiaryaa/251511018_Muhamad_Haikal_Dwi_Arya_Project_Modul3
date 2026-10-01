<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kegiatan Terhapus (Trash)</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; z}
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
        th { background: #f4f4f4; }
        .btn { padding: 0.3rem 0.6rem; border-radius: 4px; text-decoration: none; border: none; cursor: pointer; }
        .btn-success { background: #16a34a; color: white; }
    </style>
</head>
<body>
    <h1>Daftar Kegiatan Terhapus (Trash)</h1>
    <p><a href="{{ route('activities.index') }}">&larr; Kembali ke Daftar Utama</a></p>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal Dihapus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $item)
                <tr>
                    <td>{{ $item->code ?? '-' }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>{{ $item->deleted_at }}</td>
                    <td>
                        <form action="{{ route('activities.restore', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('OATCH')
                            <button type="submit" class="btn btn-success">Restore</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data di trash.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 1rem;">
        {{ $activities->links() }}
    </div>
</body>
</html>
