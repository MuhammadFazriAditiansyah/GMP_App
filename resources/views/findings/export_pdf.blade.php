<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LAPORAN GMP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .container {
            width: 95%;
            margin: auto;
        }
        h1, h4 {
            text-align: center;
            margin: 0;
        }
        h4 {
            margin-bottom: 20px;
            font-weight: normal;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            font-size: 13px;
        }
        th {
            background-color: orange;
            color: #222;
        }
        img {
            width:170px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>LAPORAN GMP</h1>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    @if (Auth::user()->role === 'user')
                        <th>Finding</th>
                    @endif
                    <th>Departemen</th>
                    <th>Kriteria GMP</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($findings as $no => $finding)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        @if (Auth::user()->role === 'user')
                            <td>
                                @if ($finding->image && file_exists(public_path('storage/' . $finding->image)))
                                    @php
                                        $path = public_path('storage/' . $finding->image);
                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                        $data = file_get_contents($path);
                                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    @endphp
                                    <img src="{{ $base64 }}" alt="image">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                        @endif
                        <td>{{ $finding->department }}</td>
                        <td>{{ $finding->gmp_criteria }}</td>
                        <td>{{ $finding->description }}</td>
                        <td>{{ $finding->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
