@extends('layout')

@section('content')
    <div class="container mt-4 mb-5">
        <h4>Upload Foto Closing</h4>
        <div class="card p-3 mt-4">
            <form id="uploadForm" action="{{ route('findings.uploadPhotoSubmit', $finding->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="image2" class="form-label">Foto Closing :</label>

                    <!-- Tempat preview gambar -->
                    <div class="mb-2">
                        <img id="closing-preview" src="#" alt="Preview Gambar"
                            style="max-height: 200px; display: none;" class="img-thumbnail">
                    </div>

                    <input type="file" name="image2" class="form-control" accept="image/*"
                        onchange="previewClosing(event)" required>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('findings.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewClosing(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('closing-preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush
