<div style="margin-bottom: 1rem;">
    <label for="category_id">Kategori:</label><br>
    <select id="category_id" name="category_id" style="width: 100%; padding: 0.5rem;">
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $activity->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p style="color: red; margin: 0.2rem 0;">{{ $message }}</p>
    @enderror
</div>
<div style="margin-bottom: 1rem;">
    <label for="code">Kode Kegiatan (Unik):</label><br>
    <input type="text" id="code" name="code" value="{{ old('code', $activity->code ?? '') }}"
        style="width: 100%; padding: 0.5rem;">
    @error('code')
        <p style="color: red; margin: 0.2rem 0;">{{ $message }}</p>
    @enderror
</div>
<div style="margin-bottom: 1rem;">
    <label for="title">Judul Kegiatan (min 5 karakter):</label><br>
    <input type="text" id="title" name="title" value="{{ old('title', $activity->title ?? '') }}"
        style="width: 100%; padding: 0.5rem;">
    @error('title')
        <p style="color: red; margin: 0.2rem 0;">{{ $message }}</p>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="description">Deskripsi:</label><br>
    <textarea id="description" name="description" rows="3"
        style="width: 100%; padding: 0.5rem;">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <p style="color: red; margin: 0.2rem 0;">{{ $message }}</p>
    @enderror
</div>

<div style="margin-bottom: 1rem;">
    <label for="activity_date">Tanggal Kegiatan:</label><br>
    <input type="date" id="activity_date" name="activity_date"
        value="{{ old('activity_date', isset($activity) ? $activity->activity_date->format('Y-m-d') : '') }}"
        style="padding: 0.5rem;">
    @error('activity_date')
        <p style="color: red; margin: 0.2rem 0;">{{ $message }}</p>
    @enderror
</div>



<div style="margin-bottom: 1rem;">
    <label for="poster">Poster Kegiatan (Gambar, Maks 2MB):</label><br>
    <input type="file" id="poster" name="poster" accept="image/*" style="padding: 0.5rem 0;">
    @error('poster')
        <p style="color: red; margin: 0.2rem 0;">{{ $message }}</p>
    @enderror
    @if(isset($activity) && $activity->poster_path)
        <div style="margin-top: 0.5rem;">
            <p style="margin: 0; font-size: 0.9rem; color: #555;">Poster saat ini:</p>
            <img src="{{ asset('storage/' . $activity->poster_path) }}" alt="Poster" style="max-height: 120px; border-radius: 4px; border: 1px solid #ccc; margin-top: 0.2rem;">
        </div>
    @endif
</div>

<button type="submit"
    style="padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">
    Simpan
</button>