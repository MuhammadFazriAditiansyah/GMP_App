@extends('layout')

@section('content')

<div class="container mt-4 pb-4">
    <h4 class="mb-4"><i class="fas fa-edit"></i> Edit Finding</h4>

    @if(Session::has('success'))
        <div class="alert alert-success mt-2"> <i class="fas fa-check-circle"></i> {{ Session::get('success') }} </div>
    @endif

    <div class="card p-4 shadow-sm">
        <form action="{{ route('findings.update', $finding->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Foto :</label>
                <!-- Preview gambar lama -->
                @if ($finding->image)
                    <div class="mb-2">
                        <img id="image-preview" src="{{ asset('storage/' . $finding->image) }}" alt="Foto Temuan" style="max-height: 200px;" class="img-thumbnail">
                    </div>
                @else
                    <div class="mb-2">
                        <img id="image-preview" src="#" alt="Preview Gambar" style="max-height: 200px; display: none;" class="img-thumbnail">
                    </div>
                @endif

                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="mb-3">
                <label class="form-label">Departemen :</label>
                <select name="department" class="form-select" required>
                    <option value="Produksi" {{ $finding->department == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                    <option value="Warehouse" {{ $finding->department == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                    <option value="Engineering" {{ $finding->department == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                    <option value="HR" {{ $finding->department == 'HR' ? 'selected' : '' }}>HR</option>
                    <option value="QA" {{ $finding->department == 'QA' ? 'selected' : '' }}>QA</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Kriteria GMP :</label>
                <select name="gmp_criteria" class="form-select" required>
                    <option value="Pest" {{ $finding->gmp_criteria == 'Pest' ? 'selected' : '' }}>Pest</option>
                    <option value="Infrastruktur" {{ $finding->gmp_criteria == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="Lingkungan" {{ $finding->gmp_criteria == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                    <option value="Personal Behavior" {{ $finding->gmp_criteria == 'Personal Behavior' ? 'selected' : '' }}>Personal Behavior</option>
                    <option value="Cleaning" {{ $finding->gmp_criteria == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Week ke - :</label>
                <select name="week" class="form-select" required>
                    @for ($i = 1; $i <= 52; $i++)
                        <option value="{{ $i }}" {{ $finding->week == $i ? 'selected' : '' }}>Week {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi :</label>
                <textarea name="description" class="form-control" rows="3" required>{{ $finding->description }}</textarea>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('findings.index') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button class="btn btn-success mt-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
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
