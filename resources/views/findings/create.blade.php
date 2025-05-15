@extends('layout')

@section('content')

<div class="container mt-4 pb-4">
    <h4 class="mb-4"><i class="fas fa-plus-circle"></i> Tambah Finding</h4>

    <div class="card p-4 shadow-sm mx-auto">
        <form action="{{ route('findings.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Foto :</label>
                <!-- Tempat preview gambar -->
                <div class="mb-2">
                    <img id="image-preview" src="#" alt="Preview Gambar" style="max-height: 200px; display: none;" class="img-thumbnail">
                </div>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Departemen :</label>
                <select name="department" class="form-select" required>
                    <option value="Produksi">Produksi</option>
                    <option value="Warehouse">Warehouse</option>
                    <option value="Engineering">Engineering</option>
                    <option value="HR">HR</option>
                    <option value="QA">QA</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kriteria GMP :</label>
                <select name="gmp_criteria" class="form-select" required>
                    <option value="Pest">Pest</option>
                    <option value="Infrastruktur">Infrastruktur</option>
                    <option value="Lingkungan">Lingkungan</option>
                    <option value="Personal Behavior">Personal Behavior</option>
                    <option value="Cleaning">Cleaning</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Week ke - :</label>
                <select name="week" class="form-select" required>
                    @for ($i = 1; $i <= 52; $i++)
                        <option value="{{ $i }}">Week {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi :</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('findings.index') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button class="btn btn-success mt-2">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </div>
        </form>
    </div>
</div>


@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush


@endsection
