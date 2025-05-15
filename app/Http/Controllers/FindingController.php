<?php

namespace App\Http\Controllers;

use App\Models\Finding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FindingController extends Controller
{

    public function landing()
    {
        return view('landingpage');
    }

    public function home()
    {
        return view('home');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Finding::with('closing');

        if ($request->has('department') && $request->department != '') {
            $query->where('department', $request->department);
        }

        if ($request->has('week') && $request->week != '') {
            $query->where('week', $request->week);
        }

        $year = $request->input('year', now()->year);
        $query->where('year', $year);

        $findings = $query->get();

        $years = Finding::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('findings.index', compact('findings', 'years', 'year'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('findings.create');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'gmp_criteria' => 'required',
            'department' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'week' => 'required|integer|min:1|max:52',
        ]);

        // Simpan file gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('findings', 'public'); // Simpan di storage/app/public/findings
        }

        Finding::create([
            'gmp_criteria' => $request->gmp_criteria,
            'department' => $request->department,
            'description' => $request->description,
            'image' => $imagePath,
            'week' => $request->week,
            'year' => now()->year,
        ]);

        return redirect()->route('findings.index')->with('success', 'Berhasil menambahkan Finding.');
    }

    public function uploadPhotoForm($id)
    {
        $finding = Finding::findOrFail($id);

        // Cek apakah user berhak mengakses
        if (auth()->user()->department !== $finding->department) {
            return redirect()->route('findings.index')
                ->with('error', 'Hanya Departemen ' . $finding->department . ' yang bisa mengupload foto');
        }

        return view('findings.upload_photo', compact('finding'));
    }

    public function uploadPhotoSubmit(Request $request, $id)
    {
        $finding = Finding::findOrFail($id);

        // Cek apakah user berhak mengupload foto
        if (auth()->user()->department !== $finding->department) {
            return redirect()->route('findings.index')
                ->with('error', 'Hanya Departemen ' . $finding->department . ' yang bisa mengupload foto');
        }

        $request->validate([
            'image2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image2')) {
            // Hapus gambar lama kalau ada
            if ($finding->image2) {
                Storage::delete('public/' . $finding->image2);
            }

            $image2Path = $request->file('image2')->store('findings', 'public');
            $finding->image2 = $image2Path;
            $finding->save();
        }

        return redirect()->route('findings.index')->with('success', 'Foto Closing berhasil diupload.');
    }

    public function editPhotoForm($id)
    {
        $finding = Finding::findOrFail($id);

        // Hanya user dari departemen yang sama yang boleh mengakses form edit
        if (auth()->user()->department !== $finding->department) {
            return redirect()->route('findings.index')
                ->with('error', 'Hanya Departemen ' . $finding->department . ' yang bisa mengedit foto');
        }

        return view('findings.edit-photo', compact('finding'));
    }

    public function updatePhoto(Request $request, $id)
    {
        $finding = Finding::findOrFail($id);

        // Cek apakah user dari departemen yang benar
        if (auth()->user()->department !== $finding->department) {
            return redirect()->route('findings.index')
                ->with('error', 'Hanya Departemen ' . $finding->department . ' yang bisa memperbarui foto');
        }

        $request->validate([
            'image2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Hapus foto lama jika ada
        if ($finding->image2) {
            Storage::delete('public/' . $finding->image2);
        }

        // Simpan foto baru
        $path = $request->file('image2')->store('closing_images', 'public');
        $finding->image2 = $path;
        $finding->save();

        return redirect()->route('findings.index')->with('success', 'Foto closing berhasil diperbarui.');
    }


    public function toggleStatus($id)
    {
        $finding = Finding::findOrFail($id);

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $finding->status = $finding->status === 'Open' ? 'Close' : 'Open';
        $finding->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $finding = Finding::find($id);
        return view('findings.edit', compact('finding'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'gmp_criteria' => 'required',
            'department' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'week' => 'required|integer|min:1|max:52',
        ]);

        $finding = Finding::find($id);

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            if ($finding->image) {
                Storage::delete('public/' . $finding->image); // Hapus gambar lama
            }
            $imagePath = $request->file('image')->store('findings', 'public');
            $finding->image = $imagePath;
        }

        $finding->update([
            'gmp_criteria' => $request->gmp_criteria,
            'department' => $request->department,
            'description' => $request->description,
            'image' => $finding->image,
            'week' => $request->week,
        ]);

        return redirect()->route('findings.index')->with('success', 'Berhasil mengedit Finding.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $findings = Finding::find($id);
        $findings->delete();

        return redirect()->route('findings.index')->with('success', 'Data berhasil dihapus.');
    }
}
