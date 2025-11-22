<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OrderBulananExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithCustomStartCell
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function startCell(): string
    {
        return 'A3'; // heading akan dimulai dari baris 3
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pembeli',
            'Produk',
            'Qty',
            'Total Harga',
            'Status',
            'Tanggal Transaksi',
        ];
    }

    public function collection()
    {
        $orders = Order::with('user', 'product')
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->orderBy('created_at', 'asc')
            ->get();

        $no = 1;

        return $orders->map(function ($order) use (&$no) {
            return [
                'no'         => $no++,
                'pembeli'    => $order->user->name ?? '-',
                'produk'     => $order->product->name ?? '-',
                'qty'        => $order->quantity,
                'total'      => ($order->product->harga * $order->quantity), // angka asli
                'status'     => ucfirst($order->status),
                'tanggal'    => $order->created_at->format('d-m-Y'),
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        // === Judul Laporan ===
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', "LAPORAN TRANSAKSI BULAN {$this->bulan} - {$this->tahun}");

        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => 'center'],
        ]);

        // === Styling Header (Row 3) ===
        $sheet->getStyle('A3:G3')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'DCE6F1']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin']
            ],
        ]);

        // Border semua data
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A3:G{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin']
            ],
        ]);

        // === Format angka menjadi Rupiah (Kolom Total Harga / kolom E) ===
        $sheet->getStyle("E4:E{$lastRow}")
            ->getNumberFormat()
            ->setFormatCode('"Rp" #,##0');

        // Center kolom nomor + qty
        $sheet->getStyle("A4:A{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("D4:D{$lastRow}")->getAlignment()->setHorizontal('center');

        // Freeze header
        $sheet->freezePane('A4');

        return [];
    }
}
