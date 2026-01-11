<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceItemModel extends Model
{
    protected $table = 'invoice_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'invoice_id',
        'product_id',
        'jumlah',
        'harga',
        'subtotal'
    ];
}
