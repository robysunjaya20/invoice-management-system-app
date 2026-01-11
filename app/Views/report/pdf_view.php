<!DOCTYPE html>
<html>
<head>
    <title>Laporan Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #000; padding: 8px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Invoice</h2>
    <table>
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
            <?php foreach ($invoices as $inv): ?>
            <tr>
                <td><?= esc($inv['kode_invoice']) ?></td>
                <td><?= esc($inv['customer_name'] ?? 'N/A') ?></td>
                <td><?= esc($inv['tanggal']) ?></td>
                <td>Rp<?= number_format($inv['grand_total'], 0, ',', '.') ?></td>
                <td><?= esc($inv['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
