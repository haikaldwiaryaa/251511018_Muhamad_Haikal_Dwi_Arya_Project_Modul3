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
    <label for="status">Status:</label><br>
    <select id="status" name="status" style="padding: 0.5rem;">
        @php
            $currentStatus = old('status', $activity->status ?? 'Planned');
        @endphp
        <option value="Planned" {{ $currentStatus === 'Planned' ? 'selected' : '' }}>Planned</option>
        <option value="Ongoing" {{ $currentStatus === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
        <option value="Done" {{ $currentStatus === 'Done' ? 'selected' : '' }}>Done</option>
    </select>
    @error('status')
        <p style="color: red; margin: 0.2rem 0;">{{ $message }}</p>
    @enderror
</div>

<button type="submit"
    style="padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">
    Simpan
</button>