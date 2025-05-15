@extends('layout')

@section('content')
    <div class="container mt-4 mb-5">
        <h4>Edit Foto Closing</h4>
        <div class="card p-3 mt-4">
            <form action="{{ route('findings.updatePhoto', $finding->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Foto Saat Ini:</label><br>
                    @if ($finding->image2)
                        <img src="{{ asset('storage/' . $finding->image2) }}" class="img-thumbnail mb-3" style="max-height: 200px;">
                    @else
                        <p class="text-muted">Belum ada foto closing</p>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="image2" class="form-label">Edit Foto:</label>
                    <input type="file" name="image2" class="form-control" accept="image/*" required>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('findings.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
