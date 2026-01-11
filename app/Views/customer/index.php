<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>


<div class="main-content">
    <div class="auth-card customer-card text-white">
        <h2 class="text-white">Data Customer</h2>
        <div class="action-bar">
            <a href="<?= base_url('/customer/create') ?>" class="btn-create">+ Tambah Customer</a>
        </div>
        <div class="table-responsive">
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $c): ?>
                        <tr>
                            <td><?= esc($c['nama']) ?></td>
                            <td><?= esc($c['email']) ?></td>
                            <td><?= esc($c['telepon']) ?></td>
                            <td><?= esc($c['alamat']) ?></td>
                            <td>
                                <a href="<?= base_url('/customer/edit/' . $c['id']) ?>" class="link-edit btn-edit">Edit</a> |
                                <a href="<?= base_url('/customer/delete/' . $c['id']) ?>" onclick="return confirm('Yakin hapus?')" class="link-delete btn-create">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
