<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_produk', 'harga', 'stok', 'deskripsi'];
    protected $useTimestamps = true;

}
