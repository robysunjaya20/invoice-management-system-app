<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data['products'] = $this->produkModel->findAll();
        return view('produk/index', $data);
    }

    public function create()
    {
        return view('produk/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_produk' => 'required',
            'harga'       => 'required|decimal',
            'stok'        => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->produkModel->save([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['produk'] = $this->produkModel->find($id);
        return view('produk/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_produk' => 'required',
            'harga'       => 'required|decimal',
            'stok'        => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->produkModel->update($id, [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->produkModel->delete($id);
        return redirect()->to('/produk')->with('success', 'Produk berhasil dihapus.');
    }
}
