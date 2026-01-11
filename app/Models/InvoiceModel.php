<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_invoice',
        'customer_id',
        'tanggal',
        'total',
        'diskon',
        'ppn',
        'grand_total',
        'status',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';  // Kamu bisa tambahkan kolom ini di tabel kalau ingin update otomatis
}
