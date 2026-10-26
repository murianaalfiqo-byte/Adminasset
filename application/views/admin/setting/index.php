<div class="container-fluid px-4">
    <div class="mb-4">
        <h4 class="fw-bold text-dark">Pengaturan Sistem</h4>
        <p class="text-muted small">Kelola informasi profil dan keamanan akun Anda.</p>
    </div>

    <?php if($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success border-0 shadow-sm"><i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success_msg'); ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger border-0 shadow-sm"><i class="fas fa-times-circle me-2"></i> <?= $this->session->flashdata('error_msg'); ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Kolom Profil (Hanya Tampil) -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-4 text-center">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']); ?>&background=2563eb&color=fff&size=100" class="rounded-circle mb-3 shadow-sm">
                    <h5 class="fw-bold mb-1"><?= $user['name']; ?></h5>
                    <p class="text-muted mb-4"><?= $user['email']; ?></p>
                    
                    <ul class="list-group list-group-flush text-start small">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Kode Akses</span>
                            <span class="fw-bold font-monospace"><?= $user['employee_code']; ?></span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Role Sistem</span>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Super Admin</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Kolom Ganti Password -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="fas fa-lock text-primary me-2"></i> Ubah Password</h5>
                    <form action="<?= site_url('setting/change_password') ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Password Saat Ini</label>
                            <input type="password" class="form-control" name="old_password" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" required minlength="6">
                            <div class="form-text">Minimal 6 karakter demi keamanan.</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Password Baru</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>