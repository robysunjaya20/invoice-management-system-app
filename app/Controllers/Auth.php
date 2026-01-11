<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new UserModel();

        $user = $model->where('username', $this->request->getPost('username'))->first();

        if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'logged_in' => true
            ]);
            return redirect()->to('/customer');
        }

        return redirect()->back()->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
{
    $rules = [
        'username' => 'required|min_length[3]|is_unique[users.username]',
        'password' => 'required|min_length[6]',
        'nama_lengkap' => 'required|min_length[3]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $model = new UserModel();

    $model->insert([
        'username'      => $this->request->getPost('username'),
        'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
    ]);

    return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login.');
}
}
