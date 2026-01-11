<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\InvoiceItemModel;
use App\Models\CustomerModel;
use App\Models\ProdukModel;

class Invoice extends BaseController
{
    protected $invoiceModel;
    protected $invoiceItemModel;
    protected $customerModel;
    protected $produkModel;
    protected $db;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->invoiceItemModel = new InvoiceItemModel();
        $this->customerModel = new CustomerModel();
        $this->produkModel = new ProdukModel();
        $this->db = \Config\Database::connect();
    }

    public function create()
    {
        // Ambil data customer dan produk untuk dropdown/select di form
        $data['customers'] = $this->customerModel->findAll();
        $data['produks'] = $this->produkModel->findAll();

        return view('invoice/create', $data);
    }

    public function store()
    {
        // Ambil data dari form
        $post = $this->request->getPost();

        // Validasi basic inputan utama
        $rules = [
            'kode_invoice' => 'required|is_unique[invoices.kode_invoice]',
            'customer_id' => 'required|integer',
            'tanggal' => 'required|valid_date',
            'diskon' => 'permit_empty|decimal',
            'ppn' => 'permit_empty|decimal',
        ];

        // Validasi item produk minimal 1 item
        $items = $post['produk_id'] ?? [];
        if (empty($items)) {
            return redirect()->back()->withInput()->with('error', 'Minimal satu produk harus ditambahkan.');
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mulai transaksi database
        $this->db->transStart();

        // Hitung total sebelum diskon & ppn
        $total = 0;
        $invoiceItems = [];

        foreach ($post['produk_id'] as $key => $produk_id) {
            $qty = (int)$post['jumlah'][$key];
            $harga = (float)$post['harga'][$key];
            $subtotal = $qty * $harga;
            $total += $subtotal;

            $invoiceItems[] = [
                'product_id' => $produk_id,
                'jumlah' => $qty,
                'harga' => $harga,
                'subtotal' => $subtotal,
            ];
        }

        // Diskon dan ppn
        $diskon = !empty($post['diskon']) ? (float)$post['diskon'] : 0;
        $ppn = !empty($post['ppn']) ? (float)$post['ppn'] : 0;

        // Hitung grand total
        $grand_total = $total - $diskon + $ppn;

        // Simpan data invoice utama
        $this->invoiceModel->save([
            'kode_invoice' => $post['kode_invoice'],
            'customer_id' => $post['customer_id'],
            'tanggal' => $post['tanggal'],
            'total' => $total,
            'diskon' => $diskon,
            'ppn' => $ppn,
            'status' => 'Belum Lunas',
            'grand_total' => $grand_total,
        ]);

        // Ambil id invoice yang baru saja disimpan
        $invoice_id = $this->invoiceModel->getInsertID();

        // Simpan item invoice dengan relasi invoice_id
        foreach ($invoiceItems as &$item) {
            $item['invoice_id'] = $invoice_id;
        }
        $this->invoiceItemModel->insertBatch($invoiceItems);

        // Commit transaksi
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data invoice.');
        }

        return redirect()->to('/invoice')->with('success', 'Invoice berhasil dibuat.');
    }
    public function index()
    {
        $builder = $this->db->table('invoices');
        $builder->select('invoices.*, customers.nama as customer_nama');
        $builder->join('customers', 'invoices.customer_id = customers.id', 'left');
        $builder->orderBy('tanggal', 'DESC');

        $data['invoices'] = $builder->get()->getResultArray();

        return view('invoice/index', $data);
    }
    public function edit($id)
    {
        // Ambil invoice utama
        $invoice = $this->invoiceModel->find($id);
        if (!$invoice) {
            return redirect()->to('/invoice')->with('error', 'Invoice tidak ditemukan.');
        }

        // Ambil item terkait invoice
        $items = $this->invoiceItemModel->where('invoice_id', $id)->findAll();

        // Ambil data customer dan produk untuk dropdown
        $data['invoice'] = $invoice;
        $data['items'] = $items;
        $data['customers'] = $this->customerModel->findAll();
        $data['produks'] = $this->produkModel->findAll();

        return view('invoice/edit', $data);
    }

    public function update($id)
    {
        $post = $this->request->getPost();

        // Validasi
        $rules = [
            'kode_invoice' => "required|is_unique[invoices.kode_invoice,id,{$id}]",
            'customer_id' => 'required|integer',
            'tanggal' => 'required|valid_date',
            'diskon' => 'permit_empty|decimal',
            'ppn' => 'permit_empty|decimal',
        ];

        $items = $post['produk_id'] ?? [];
        if (empty($items)) {
            return redirect()->back()->withInput()->with('error', 'Minimal satu produk harus ditambahkan.');
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transStart();

        // Hitung total dan siapkan data item
        $total = 0;
        $invoiceItems = [];
        foreach ($post['produk_id'] as $key => $produk_id) {
            $qty = (int)$post['jumlah'][$key];
            $harga = (float)$post['harga'][$key];
            $subtotal = $qty * $harga;
            $total += $subtotal;

            $invoiceItems[] = [
                'invoice_id' => $id,
                'product_id' => $produk_id,
                'jumlah' => $qty,
                'harga' => $harga,
                'subtotal' => $subtotal,
            ];
        }

        $diskon = !empty($post['diskon']) ? (float)$post['diskon'] : 0;
        $ppn = !empty($post['ppn']) ? (float)$post['ppn'] : 0;
        $grand_total = $total - $diskon + $ppn;

        // Update invoice utama
        $this->invoiceModel->update($id, [
            'kode_invoice' => $post['kode_invoice'],
            'customer_id' => $post['customer_id'],
            'tanggal' => $post['tanggal'],
            'total' => $total,
            'diskon' => $diskon,
            'ppn' => $ppn,
            'grand_total' => $grand_total,
            'status' => $post['status'] ?? 'Belum Lunas',
        ]);

        // Hapus dulu semua item lama, kemudian insert item baru
        $this->invoiceItemModel->where('invoice_id', $id)->delete();
        $this->invoiceItemModel->insertBatch($invoiceItems);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data invoice.');
        }

        return redirect()->to('/invoice')->with('success', 'Invoice berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Cari invoice berdasarkan ID
        $invoice = $this->invoiceModel->find($id);
        if (!$invoice) {
            return redirect()->to('/invoice')->with('error', 'Invoice tidak ditemukan.');
        }

        // Mulai transaksi
        $this->db->transStart();

        // Hapus item terkait invoice
        $this->invoiceItemModel->where('invoice_id', $id)->delete();

        // Hapus invoice utama
        $this->invoiceModel->delete($id);

        // Selesaikan transaksi
        $this->db->transComplete();

        // Cek status transaksi
        if ($this->db->transStatus() === false) {
            return redirect()->to('/invoice')->with('error', 'Gagal menghapus invoice.');
        }

        return redirect()->to('/invoice')->with('success', 'Invoice berhasil dihapus.');
    }



}
