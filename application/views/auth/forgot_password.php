<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - AssetFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg rounded-4 p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-lock-open fs-1 text-primary mb-2"></i>
                        <h4 class="fw-bold text-dark">Lupa Password?</h4>
                        <p class="text-muted small">Masukkan email terdaftar Anda untuk menerima tautan pemulihan kata sandi.</p>
                    </div>

                    <?php if($this->session->flashdata('error_msg')): ?>
                        <div class="alert alert-danger border-0 shadow-sm small mb-3"><?= $this->session->flashdata('error_msg'); ?></div>
                    <?php endif; ?>

                    <?php if($this->session->flashdata('success_msg')): ?>
                        <div class="alert alert-success border-0 shadow-sm small mb-3"><?= $this->session->flashdata('success_msg'); ?></div>
                    <?php endif; ?>

                    <form action="<?= site_url('auth/send_reset_link'); ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Alamat Email</label>
                            <input type="email" class="form-control rounded-3" name="email" placeholder="nama@perusahaan.com" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-medium mb-3">Kirim Link Reset</button>
                        <div class="text-center">
                            <a href="<?= site_url('auth'); ?>" class="text-decoration-none small text-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>