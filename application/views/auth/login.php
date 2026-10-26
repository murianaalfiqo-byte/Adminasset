<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AssetFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="p-4 text-center bg-primary text-white">
                        <i class="fas fa-cubes fs-1 mb-2"></i>
                        <h4 class="fw-bold mb-0">Asset<span class="text-warning">Flow</span></h4>
                        <p class="small opacity-75 mb-0">Sistem Inventaris & Aset Kantor</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <?php if($this->session->flashdata('error_msg')): ?>
                            <div class="alert alert-danger border-0 shadow-sm small rounded-3 mb-3">
                                <i class="fas fa-exclamation-circle me-1"></i> <?= $this->session->flashdata('error_msg'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('success_msg')): ?>
                            <div class="alert alert-success border-0 shadow-sm small rounded-3 mb-3">
                                <i class="fas fa-check-circle me-1"></i> <?= $this->session->flashdata('success_msg'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('auth/process'); ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-medium text-dark">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted ps-3"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control bg-light border-start-0 pe-3" name="email" value="<?= set_value('email'); ?>" placeholder="nama@perusahaan.com" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small fw-medium text-dark mb-0">Password</label>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted ps-3"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control bg-light border-start-0 pe-3" name="password" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-medium text-dark">Verifikasi CAPTCHA</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted ps-3"><i class="fas fa-th-large"></i></span>
                                        <input type="text" class="form-control bg-light" name="captcha_input" placeholder="Captcha" required autocomplete="off">
                                        <button type="button" class="btn btn-outline-secondary" id="btnRefreshCaptcha" title="Ganti Captcha">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                    <div class="border rounded-3 overflow-hidden d-flex align-items-center bg-light shadow-sm" style="height: 38px; flex-shrink: 0;">
                                        <img src="<?= isset($captcha_img) ? $captcha_img : ''; ?>" id="captchaImg" alt="Captcha" style="height: 38px; width: 120px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm">
                                Masuk ke Sistem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .extra-small {
        font-size: 0.75rem;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const refreshBtn = document.getElementById('btnRefreshCaptcha');
        const captchaImg = document.getElementById('captchaImg');

        if (refreshBtn) {
            refreshBtn.addEventListener('click', function() {
                const icon = refreshBtn.querySelector('i');
                if (icon) icon.classList.add('fa-spin');

                fetch('<?= site_url("auth/refresh_captcha"); ?>')
                    .then(response => response.json())
                    .then(data => {
                        captchaImg.src = data.captcha_img;
                        if (icon) icon.classList.remove('fa-spin');
                    })
                    .catch(() => {
                        if (icon) icon.classList.remove('fa-spin');
                    });
            });
        }
    });
    </script>
</body>
</html>