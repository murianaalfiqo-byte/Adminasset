<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h3 class="fw-bold text-dark mb-1">Pengaturan Profil & Keamanan</h3>
            <p class="text-muted mb-4">Kelola informasi data diri dan kata sandi akun Anda.</p>

            <?php if($this->session->flashdata('success_msg')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success_msg'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error_msg')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error_msg'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                        <div class="mb-3">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']); ?>&background=2563eb&color=fff&size=128" 
                                 class="rounded-circle border border-3 border-primary shadow-sm" width="100" height="100">
                        </div>
                        <h5 class="fw-bold text-dark mb-0"><?= $user['name']; ?></h5>
                        <p class="text-muted small mb-2"><?= $user['position'] ?: 'Karyawan'; ?></p>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 align-self-center">
                            <?= $user['department_name'] ?: 'Tanpa Departemen'; ?>
                        </span>
                        
                        <hr class="my-3 opacity-25">
                        
                        <div class="text-start small">
                            <div class="mb-2">
                                <span class="text-muted d-block">Kode Karyawan:</span>
                                <span class="fw-bold font-monospace text-dark"><?= $user['employee_code']; ?></span>
                            </div>
                            <div>
                                <span class="text-muted d-block">Email Terdaftar:</span>
                                <span class="fw-medium text-dark"><?= $user['email']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-user-edit me-2 text-primary"></i>Ubah Informasi Profil</h5>
                        <form action="<?= site_url('profile/update'); ?>" method="POST">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-medium text-dark">Nama Lengkap</label>
                                    <input type="text" class="form-control rounded-3" name="name" value="<?= $user['name']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-medium text-dark">Nomor Telepon / WhatsApp</label>
                                    <input type="text" class="form-control rounded-3" name="phone" value="<?= $user['phone']; ?>" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-medium text-muted">Email (Read-only)</label>
                                    <input type="email" class="form-control rounded-3 bg-light" value="<?= $user['email']; ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-medium text-muted">Jabatan (Read-only)</label>
                                    <input type="text" class="form-control rounded-3 bg-light" value="<?= $user['position']; ?>" readonly>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Perubahan</button>
                        </form>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-key me-2 text-warning"></i>Ganti Kata Sandi</h5>
                        <form action="<?= site_url('profile/change_password'); ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-medium text-dark">Password Saat Ini</label>
                                <input type="password" class="form-control rounded-3" name="old_password" required>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-medium text-dark">Password Baru</label>
                                    <input type="password" class="form-control rounded-3" name="new_password" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-medium text-dark">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control rounded-3" name="confirm_password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning text-dark fw-bold rounded-3 px-4">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>