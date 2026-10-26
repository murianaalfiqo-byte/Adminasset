<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">Data Karyawan & Pengguna</h4>
        <!-- Tombol Tambah -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-user-plus me-2"></i> Tambah Karyawan
        </button>
    </div>

    <!-- Alert Messages -->
    <?php if($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success_msg'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?= $this->session->flashdata('error_msg'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Kode/ID</th>
                            <th class="py-3">Karyawan</th>
                            <th class="py-3">Departemen</th>
                            <th class="py-3">Role</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center" width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($employees)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-users-slash fs-1 mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data karyawan</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($employees as $row): ?>
                                <tr>
                                    <td class="px-4 fw-bold text-secondary"><?= $row['employee_code']; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['name']); ?>&background=random" class="rounded-circle me-3" width="40" height="40">
                                            <div>
                                                <div class="fw-bold text-dark"><?= $row['name']; ?></div>
                                                <div class="text-muted small"><?= $row['email']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark"><?= $row['department_name'] ?: '<span class="text-muted fst-italic">Belum diatur</span>'; ?></div>
                                        <div class="text-muted small"><?= $row['position']; ?></div>
                                    </td>
                                    <td>
                                        <?php if($row['role'] == 'admin'): ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">Karyawan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row['is_active'] == 1): ?>
                                            <span class="badge bg-success rounded-pill px-3">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary rounded-pill px-3">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- Jangan tampilkan tombol hapus untuk Super Admin (id=1) untuk mencegah bunuh diri sistem -->
                                        <?php if($row['id'] != 1): ?>
                                            <button class="btn btn-sm btn-light text-primary me-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?= site_url('employee/delete/'.$row['id']); ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Yakin ingin menghapus karyawan ini?');" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small"><i class="fas fa-lock"></i> Protected</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- MODAL EDIT KARYAWAN -->
                                <?php if($row['id'] != 1): ?>
                                <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-light border-0">
                                                <h5 class="modal-title fw-bold">Edit Data Karyawan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?= site_url('employee/edit') ?>" method="POST">
                                                <div class="modal-body p-4">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    
                                                    <div class="row g-3">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label text-secondary small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="name" value="<?= $row['name']; ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label text-secondary small fw-bold">No. Telepon / WhatsApp</label>
                                                            <input type="text" class="form-control" name="phone" value="<?= $row['phone']; ?>">
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label text-secondary small fw-bold">Departemen</label>
                                                            <select class="form-select" name="department_id">
                                                                <option value="">-- Pilih Departemen --</option>
                                                                <?php foreach($departments as $dept): ?>
                                                                    <option value="<?= $dept['id']; ?>" <?= ($row['department_id'] == $dept['id']) ? 'selected' : ''; ?>>
                                                                        <?= $dept['name']; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label text-secondary small fw-bold">Jabatan / Posisi</label>
                                                            <input type="text" class="form-control" name="position" value="<?= $row['position']; ?>" placeholder="Misal: Frontend Developer">
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label text-secondary small fw-bold">Role Sistem <span class="text-danger">*</span></label>
                                                            <select class="form-select" name="role" required>
                                                                <option value="employee" <?= ($row['role'] == 'employee') ? 'selected' : ''; ?>>Karyawan (Peminjam)</option>
                                                                <option value="admin" <?= ($row['role'] == 'admin') ? 'selected' : ''; ?>>Admin (Pengelola)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label text-secondary small fw-bold">Status Akun <span class="text-danger">*</span></label>
                                                            <select class="form-select" name="is_active" required>
                                                                <option value="1" <?= ($row['is_active'] == 1) ? 'selected' : ''; ?>>Aktif (Bisa Login)</option>
                                                                <option value="0" <?= ($row['is_active'] == 0) ? 'selected' : ''; ?>>Nonaktif (Diblokir)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KARYAWAN -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold">Tambah Karyawan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('employee/add') ?>" method="POST">
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 bg-primary bg-opacity-10 text-primary mb-4">
                        <i class="fas fa-info-circle me-2"></i> Password default untuk karyawan baru adalah: <strong>karyawan123</strong>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-secondary small fw-bold">Kode Karyawan/NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="employee_code" placeholder="Misal: EMP-0002" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-secondary small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-secondary small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="email@perusahaan.com" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-secondary small fw-bold">No. Telepon / WhatsApp</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-secondary small fw-bold">Departemen</label>
                            <select class="form-select" name="department_id">
                                <option value="">-- Pilih Departemen --</option>
                                <!-- Looping data departemen -->
                                <?php foreach($departments as $dept): ?>
                                    <option value="<?= $dept['id']; ?>"><?= $dept['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label text-secondary small fw-bold">Jabatan / Posisi</label>
                            <input type="text" class="form-control" name="position" placeholder="Misal: UI/UX Designer">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label text-secondary small fw-bold">Role Sistem <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="employee">Karyawan Biasa (Hanya Meminjam)</option>
                                <option value="admin">Admin (Akses Kelola Master Data & Transaksi)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>