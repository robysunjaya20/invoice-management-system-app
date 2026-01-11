<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customer extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();
        $data['customers'] = $model->findAll();
        return view('customer/index', $data);
    }

    public function create()
    {
        return view('customer/create');
    }

    public function store()
    {
        $model = new CustomerModel();
        $model->save([
            'nama'    => $this->request->getPost('nama'),
            'email'   => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat'  => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/customer');
    }

    public function edit($id)
    {
        $model = new CustomerModel();
        $data['customer'] = $model->find($id);
        return view('customer/edit', $data);
    }

    public function update($id)
    {
        $model = new CustomerModel();
        $model->update($id, [
            'nama'    => $this->request->getPost('nama'),
            'email'   => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat'  => $this->request->getPost('alamat'),
        ]);

        return redirect()->to('/customer');
    }

    public function delete($id)
    {
        $model = new CustomerModel();
        $model->delete($id);
        return redirect()->to('/customer');
    }
}
