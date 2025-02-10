<form action="{{ route('detect') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image" accept="image/*" required>
    <button type="submit">Analyser</button>
</form>
