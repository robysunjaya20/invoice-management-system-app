<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="main-content">
    <div class="customer-card">
        <h2 class="text-white">Laporan Invoice</h2>

        <!-- Filter Form -->
        <form method="get" action="<?= base_url('report') ?>" class="auth-form" style="margin-bottom: 1.5rem;">
            <label for="filter_customer">Filter Customer</label>
            <select name="customer" id="filter_customer" style="margin-bottom: 1rem;">
                <option value="">-- Semua Customer --</option>
                <?php foreach ($customers as $c) : ?>
                    <option value="<?= esc($c['id']) ?>" <?= ($filterCustomer == $c['id']) ? 'selected' : '' ?>>
                        <?= esc($c['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="filter_status">Filter Status</label>
            <select name="status" id="filter_status" style="margin-bottom: 1rem;">
                <option value="">-- Semua Status --</option>
                <?php
                $statuses = ['Lunas', 'Belum Lunas', 'Pending'];
                foreach ($statuses as $status) : ?>
                    <option value="<?= $status ?>" <?= ($filterStatus == $status) ? 'selected' : '' ?>>
                        <?= $status ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-create" style="padding: 0.3rem 1rem;">Filter</button>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>Kode Invoice</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total (Rp)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($invoices) > 0) : ?>
                        <?php foreach ($invoices as $inv) : ?>
                            <tr>
                                <td><?= esc($inv['kode_invoice']) ?></td>
                                <td><?= esc($inv['customer_name'] ?? 'N/A') ?></td>
                                <td><?= esc($inv['tanggal']) ?></td>
                                <td>Rp<?= number_format($inv['grand_total'], 0, ',', '.') ?></td>
                                <td><?= esc($inv['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data invoice.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Total pemasukan -->
        <div style="margin-top: 1rem; font-weight: bold; font-size: 1.1rem; text-align: right;">
            Total Pemasukan: Rp<?= number_format($totalPemasukan, 0, ',', '.') ?>
        </div>

        <!-- Produk Terjual -->
        <div style="margin-top: 2rem;">
            <h3>Laporan Produk Terjual</h3>
            <div class="table-responsive">
                <table class="customer-table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($produkTerjual) > 0) : ?>
                            <?php foreach ($produkTerjual as $produk) : ?>
                                <tr>
                                    <td><?= esc($produk['nama']) ?></td>
                                    <td><?= esc($produk['total_jumlah']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada data produk terjual.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tombol Cetak di tengah -->
        <div class="text-center mt-4">
            <a href="<?= base_url('report/pdf') . '?' . $_SERVER['QUERY_STRING'] ?>" target="_blank" class="btn-cetak mx-2">Cetak PDF</a>
            <a href="<?= base_url('report/excel') . '?' . $_SERVER['QUERY_STRING'] ?>" class="btn-edit mx-2">Export Excel</a>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
