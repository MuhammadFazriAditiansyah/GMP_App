<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Finding;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExportController extends Controller
{
    public function exportPDF(Request $request)
    {
        // Ambil data finding yang sesuai dengan filter
        $findings = Finding::query();

        if ($request->has('week') && $request->week) {
            $findings->where('week', $request->week);
        }

        if ($request->has('department') && $request->department) {
            $findings->where('department', $request->department);
        }

        if ($request->has('year') && $request->year) {
            $findings->whereYear('created_at', $request->year);
        }

        $findings = $findings->get();

        // Load tampilan PDF tanpa menggunakan facade
        $html = view('findings.export_pdf', compact('findings'))->render();

        // Inisialisasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);  // Mengaktifkan parser HTML5
        $options->set('isPhpEnabled', true);  // Mengaktifkan PHP di Dompdf (jika diperlukan untuk kode PHP dalam HTML)

        $dompdf = new Dompdf($options);

        // Load konten HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set ukuran kertas (A4 adalah default, Anda bisa mengubahnya sesuai kebutuhan)
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (mungkin butuh waktu tergantung ukuran halaman)
        $dompdf->render();

        // Mengunduh PDF hasil render
        $filename = 'LAPORAN_GMP';
        if ($request->has('week') && $request->week) {
            $filename .= '_WEEK_' . $request->week;
        }
        if ($request->has('year') && $request->year) {
            $filename .= '_YEAR_' . $request->year;
        }
        $filename .= '.pdf';

        return $dompdf->stream($filename, ['Attachment' => true]);
    }

    public function exportFindings(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('LAPORAN GMP');

        // === Filter ===
        $week = $request->input('week');
        $department = $request->input('department');
        $year = $request->input('year');

        $query = Finding::query();
        if ($week) {
            $query->where('week', $week);
        }
        if ($department) {
            $query->where('department', $department);
        }
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $findings = $query->get();

        // === TABEL UTAMA (A1-H...) ===
        $sheet->fromArray([
            ['No', 'Departemen', 'Kode Dept', 'Kriteria GMP', 'Kode Kriteria', 'Deskripsi', 'Status', 'Kode Status']
        ], null, 'A1');

        $row = 2;
        foreach ($findings as $index => $finding) {
            $sheet->setCellValue("A{$row}", $index + 1);
            $sheet->setCellValue("B{$row}", $finding->department);
            $sheet->setCellValue("C{$row}", $this->getDepartmentCode($finding->department));
            $sheet->setCellValue("D{$row}", $finding->gmp_criteria);
            $sheet->setCellValue("E{$row}", $this->getCriteriaCode($finding->gmp_criteria));
            $sheet->setCellValue("F{$row}", $finding->description);
            $sheet->setCellValue("G{$row}", $finding->status);
            $sheet->setCellValue("H{$row}", $this->getStatusCode($finding->status));
            $row++;
        }

        $lastDataRow = $row - 1;

        // === TABEL 2: Rekap Kriteria vs Departemen ===
        $criteriaList = ['Pest', 'Infrastruktur', 'Lingkungan', 'Personal Behavior', 'Cleaning'];
        $departments = ['Produksi', 'Warehouse', 'Engineering', 'HR', 'QA'];
        $counts = [];

        foreach ($criteriaList as $criteria) {
            foreach ($departments as $dept) {
                $counts[$criteria][$dept] = $findings->where('gmp_criteria', $criteria)->where('department', $dept)->count();
            }
            $counts[$criteria]['total'] = $findings->where('gmp_criteria', $criteria)->count();
        }

        $criteriaTableStartRow = 1;
        $criteriaTableStartCol = 'J';

        $sheet->setCellValue("J{$criteriaTableStartRow}", 'Kriteria GMP');
        $sheet->setCellValue("K{$criteriaTableStartRow}", 'Jumlah Finding');

        $colLetter = 'L';
        foreach ($departments as $dept) {
            $sheet->setCellValue("{$colLetter}{$criteriaTableStartRow}", $dept);
            $colLetter++;
        }

        $currentRow = $criteriaTableStartRow + 1;
        foreach ($criteriaList as $criteria) {
            $sheet->setCellValue("J{$currentRow}", $criteria);
            $sheet->setCellValue("K{$currentRow}", $counts[$criteria]['total']);

            $colLetter = 'L';
            foreach ($departments as $dept) {
                $sheet->setCellValue("{$colLetter}{$currentRow}", $counts[$criteria][$dept]);
                $colLetter++;
            }
            $currentRow++;
        }

        // Total Row
        $sheet->setCellValue("J{$currentRow}", 'Total');
        $totalPerDept = [];
        $grandTotal = 0;

        foreach ($departments as $dept) {
            $total = $findings->where('department', $dept)->count();
            $totalPerDept[$dept] = $total;
            $grandTotal += $total;
        }

        $sheet->setCellValue("K{$currentRow}", $grandTotal);
        $colLetter = 'L';
        foreach ($departments as $dept) {
            $sheet->setCellValue("{$colLetter}{$currentRow}", $totalPerDept[$dept]);
            $colLetter++;
        }

        $lastCriteriaRow = $currentRow;

        // === TABEL 3: Rekap Departemen vs Status ===
        $statusTableStartRow = $lastCriteriaRow + 3; // Jarak 2 baris
        $sheet->setCellValue("J{$statusTableStartRow}", 'Departemen');
        $sheet->setCellValue("K{$statusTableStartRow}", 'Jumlah Finding');
        $sheet->setCellValue("L{$statusTableStartRow}", 'Close');
        $sheet->setCellValue("M{$statusTableStartRow}", 'Open');

        $row = $statusTableStartRow + 1;
        foreach ($departments as $dept) {
            $total = $findings->where('department', $dept)->count();
            $close = $findings->where('department', $dept)->where('status', 'Close')->count();
            $open = $findings->where('department', $dept)->where('status', 'Open')->count();

            $sheet->setCellValue("J{$row}", $dept);
            $sheet->setCellValue("K{$row}", $total);
            $sheet->setCellValue("L{$row}", $close);
            $sheet->setCellValue("M{$row}", $open);
            $row++;
        }

        // Total row
        $sheet->setCellValue("J{$row}", 'Total');
        $sheet->setCellValue("K{$row}", $findings->count());
        $sheet->setCellValue("L{$row}", $findings->where('status', 'Close')->count());
        $sheet->setCellValue("M{$row}", $findings->where('status', 'Open')->count());

        // === STYLING ===
        $yellowFill = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ];

        // Styling: borders, alignment
        $sheet->getStyle("A1:H{$lastDataRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);

        $sheet->getStyle("J1:P{$lastCriteriaRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);

        $sheet->getStyle("J{$statusTableStartRow}:M{$row}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);

        // Warna kuning untuk kolom "Jumlah Finding"
        $sheet->getStyle("K1:K{$lastCriteriaRow}")->applyFromArray($yellowFill);
        $sheet->getStyle("K{$statusTableStartRow}:K{$row}")->applyFromArray($yellowFill);


        // Otomatis lebar kolom berdasarkan isi
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        foreach (range('J', 'P') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Export
        $filename = 'LAPORAN_GMP';
        if ($week) {
            $filename .= '_WEEK_' . $week;
        }
        if ($year) {
            $filename .= '_YEAR_' . $year;
        }
        $filename .= '.xlsx';

        if (ob_get_contents()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function getDepartmentCode($department)
    {
        return match (strtolower($department)) {
            'produksi' => 1,
            'warehouse' => 2,
            'engineering' => 3,
            'hr' => 4,
            'qa' => 5,
            default => 0,
        };
    }

    private function getCriteriaCode($criteria)
    {
        return match (strtolower($criteria)) {
            'pest' => 1,
            'infrastruktur' => 2,
            'lingkungan' => 3,
            'personal behavior' => 4,
            'cleaning' => 5,
            default => 0,
        };
    }

    private function getStatusCode($status)
    {
        return strtolower($status) === 'close' ? 1 : 2;
    }
}
