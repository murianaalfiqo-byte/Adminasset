<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">Data Kategori Aset</h4>
        <!-- Tombol Tambah (Membuka Modal) -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus me-2"></i> Tambah Kategori
        </button>
    </div>

    <!-- Menampilkan pesan alert jika sukses/gagal -->
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
                            <th class="px-4 py-3" width="5%">No</th>
                            <th class="py-3">Nama Kategori</th>
                            <th class="py-3">Deskripsi</th>
                            <th class="py-3 text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($categories)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fs-1 mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data kategori</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($categories as $row): ?>
                                <tr>
                                    <td class="px-4 text-secondary"><?= $no++; ?></td>
                                    <td class="fw-medium text-dark"><?= $row['name']; ?></td>
                                    <td class="text-secondary"><?= $row['description'] ?: '-'; ?></td>
                                    <td class="text-center">
                                        <!-- Tombol Edit (Membuka Modal Edit) -->
                                        <button class="btn btn-sm btn-light text-primary me-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <a href="<?= site_url('category/delete/'.$row['id']); ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- MODAL EDIT (Dibuat berulang untuk setiap baris data) -->
                                <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-light border-0">
                                                <h5 class="modal-title fw-bold">Edit Kategori</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?= site_url('category/edit') ?>" method="POST">
                                                <div class="modal-body p-4">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label text-secondary small fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name" value="<?= $row['name']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-secondary small fw-bold">Deskripsi</label>
                                                        <textarea class="form-control" name="description" rows="3"><?= $row['description']; ?></textarea>
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

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH DATA -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('category/add') ?>" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Misal: Komputer & Laptop" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Opsional..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>