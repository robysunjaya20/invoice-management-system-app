<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Aplikasi Manajemen INVOICE' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
            crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar shadow-sm" >
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="<?= base_url('/') ?>">INVOICE APP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link custom-text <?= uri_string() == 'customer' ? 'active fw-bold text-white' : '' ?>" href="<?= base_url('/customer') ?>">Customer</a>
                    <a class="nav-link custom-text<?= uri_string() == 'produk' ? 'active fw-bold text-white' : '' ?>" href="<?= base_url('/produk') ?>">Produk</a>
                    <a class="nav-link custom-text<?= uri_string() == 'invoice' ? 'active fw-bold text-white' : '' ?>" href="<?= base_url('/invoice') ?>">Invoice</a>
                    <a class="nav-link custom-text<?= uri_string() == 'report' ? 'active fw-bold text-white' : '' ?>" href="<?= base_url('/report') ?>">Report</a>
                    <a class="nav-link" style="color: #FF6500;" href="<?= base_url('/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="flex-fill d-flex justify-content-center align-items-center text-white">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

   
</body>
</html>
