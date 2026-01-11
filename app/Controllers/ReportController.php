<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\CustomerModel;
use App\Models\ProdukModel;
use CodeIgniter\Controller;

class ReportController extends BaseController
{
    public function index()
    {
        $invoiceModel = new InvoiceModel();
        $customerModel = new CustomerModel();
        $db = \Config\Database::connect();

        $customer_id = $this->request->getGet('customer_id');
        $status = $this->request->getGet('status');

        // Query invoice dengan join ke customer
        $query = $invoiceModel->select('invoices.*, invoices.status, customers.nama as customer_name')
        ->join('customers', 'customers.id = invoices.customer_id');

    if ($customer_id) {
        $query->where('customer_id', $customer_id);
    }

    if ($status) {
        $query->where('status', $status);
    }

    $invoices = $query->orderBy('tanggal', 'DESC')->findAll();

        $customers = $customerModel->findAll();

        // Hitung total pemasukan dari invoice yang sudah difilter
        $totalPemasukan = 0;
        foreach ($invoices as $inv) {
            $totalPemasukan += $inv['grand_total'];
        }

        // Query produk terjual dengan filter customer dan status juga
        $produk_terjual = $db->query("
            SELECT p.id, 
                p.nama_produk AS nama,
                SUM(ii.jumlah) AS total_jumlah,
                SUM(ii.jumlah * ii.harga) AS total_pemasukan
            FROM invoice_items ii
            JOIN products p ON ii.product_id = p.id
            JOIN invoices inv ON ii.invoice_id = inv.id
            " . ($customer_id || $status ? "WHERE 1=1 " : "") .
            ($customer_id ? " AND inv.customer_id = " . $db->escape($customer_id) : "") .
            ($status ? " AND inv.status = " . $db->escape($status) : "") . "
            GROUP BY p.id, p.nama_produk
        ")->getResultArray();


        return view('report/index', [
            'invoices' => $invoices,
            'customers' => $customers,
            'produkTerjual' => $produk_terjual,
            'filterCustomer' => $customer_id,
            'filterStatus' => $status,
            'totalPemasukan' => $totalPemasukan,
        ]);
    }

    public function pdf()
    {
        // Load Dompdf namespace
        $dompdf = new \Dompdf\Dompdf();

        // Data yang ingin ditampilkan di PDF
        $invoiceModel = new \App\Models\InvoiceModel();
        $invoices = $invoiceModel->findAll();

        // Render view jadi HTML
        $html = view('report/pdf_view', ['invoices' => $invoices]);

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // (Opsional) ukuran kertas dan orientasi
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output PDF ke browser langsung
        $dompdf->stream('laporan-invoice.pdf', ['Attachment' => 0]); // 0 = preview, 1 = download
    }

    public function excel()
    {
        $invoiceModel = new \App\Models\InvoiceModel();
        $customerModel = new \App\Models\CustomerModel();
        $db = \Config\Database::connect();

        $customer_id = $this->request->getGet('customer_id');
        $status = $this->request->getGet('status');

        // Query invoice dengan join customer sesuai filter
        $query = $invoiceModel->select('invoices.*, customers.nama as customer_name')
            ->join('customers', 'customers.id = invoices.customer_id');

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }
        if ($status) {
            $query->where('status', $status);
        }

        $invoices = $query->orderBy('tanggal', 'DESC')->findAll();

        // Load PhpSpreadsheet classes
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'Kode Invoice');
        $sheet->setCellValue('B1', 'Customer');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Total (Rp)');
        $sheet->setCellValue('E1', 'Status');

        // Isi data
        $row = 2;
        foreach ($invoices as $invoice) {
            $sheet->setCellValue('A' . $row, $invoice['kode_invoice']);
            $sheet->setCellValue('B' . $row, $invoice['customer_name']);
            $sheet->setCellValue('C' . $row, $invoice['tanggal']);
            $sheet->setCellValue('D' . $row, number_format($invoice['grand_total'], 0, ',', '.'));
            $sheet->setCellValue('E' . $row, $invoice['status']);
            $row++;
        }

        // Atur header response untuk download file Excel
        $filename = 'laporan-invoice-' . date('YmdHis') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

}
