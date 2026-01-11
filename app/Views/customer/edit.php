<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="main-content-awal">
    <div class="auth-card">
        <h2 class="text-white">Edit Customer</h2>
        <form method="post" action="<?= base_url('/customer/update/' . $customer['id']) ?>" class="auth-form">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= esc($customer['nama']) ?>" required>
            <label>Email</label>
            <input type="email" name="email" value="<?= esc($customer['email']) ?>" required>
            <label>Telepon</label>
            <input type="text" name="telepon" value="<?= esc($customer['telepon']) ?>" required>
            <label>Alamat</label>
            <textarea name="alamat" required><?= esc($customer['alamat']) ?></textarea>
            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
