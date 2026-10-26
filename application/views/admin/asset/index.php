<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Data Master Aset</h4>
            <p class="text-muted small mb-0">Kelola semua inventaris fisik perusahaan di sini</p>
        </div>
        <!-- Tombol Tambah -->
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus me-2"></i> Tambah Aset Baru
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

    <!-- Form Pencarian & Tombol Search -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="<?= base_url('asset'); ?>" method="GET" class="row g-2 align-items-center">
                <div class="col-md-9 col-lg-10">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" id="assetSearchInput" name="keyword" class="form-control border-start-0 bg-light" placeholder="Cari berdasarkan nama barang, kode, merek, model, atau kategori..." value="<?= htmlspecialchars($keyword ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-3 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                    <?php if(!empty($keyword)): ?>
                        <a href="<?= base_url('asset'); ?>" class="btn btn-outline-secondary" title="Reset Pencarian">
                            <i class="fas fa-undo"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Master Aset -->
    <div class="card border-0 shadow-sm rounded-3 mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="assetTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3" width="60">Foto</th>
                            <th class="py-3">Kode & Nama Barang</th>
                            <th class="py-3">Kategori & Lokasi</th>
                            <th class="py-3 text-center">Kondisi</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center" width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($assets)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-box-open fs-1 mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data aset yang ditemukan</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($assets as $row): ?>
                                <tr class="asset-row">
                                    <td class="px-4">
                                        <img src="<?= base_url('assets/img/assets/'.$row['photo']) ?>" alt="Foto Aset" class="rounded shadow-sm" width="50" height="50" style="object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $row['name']; ?></div>
                                        <div class="text-secondary small font-monospace"><?= $row['asset_code']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-dark fw-medium"><i class="fas fa-tag text-muted me-1"></i> <?= $row['category_name'] ?: '-'; ?></div>
                                        <div class="text-muted small"><i class="fas fa-map-marker-alt text-muted me-1"></i> <?= $row['location_name'] ?: 'Belum diatur'; ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            $kondisi = ['good' => ['Bagus', 'success'], 'fair' => ['Layak', 'warning'], 'damaged' => ['Rusak', 'danger'], 'lost' => ['Hilang', 'dark']];
                                            $k = $kondisi[$row['condition_status']] ?? ['Bagus', 'success'];
                                        ?>
                                        <span class="badge bg-<?= $k[1]; ?> bg-opacity-10 text-<?= $k[1]; ?> border border-<?= $k[1]; ?> border-opacity-25 px-2 py-1">
                                            <?= $k[0]; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            $ops = [
                                                'available' => ['Tersedia', 'success'], 
                                                'in_use' => ['Dipinjam', 'primary'], 
                                                'assigned' => ['Ditugaskan', 'info'], 
                                                'maintenance' => ['Perawatan', 'warning']
                                            ];
                                            $o = $ops[$row['operational_status']] ?? ['Tersedia', 'success'];
                                        ?>
                                        <span class="badge bg-<?= $o[1]; ?> rounded-pill px-3"><?= $o[0]; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light text-primary me-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Archive agar riwayat peminjaman tetap aman -->
                                        <a href="<?= site_url('asset/archive/'.$row['id']); ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Arsipkan aset ini? Aset tidak akan dihapus permanen tetapi akan hilang dari daftar aktif.');" title="Arsipkan">
                                            <i class="fas fa-archive"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- MODAL EDIT ASET (Khusus Baris Ini) -->
                                <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-light border-0">
                                                <h5 class="modal-title fw-bold">Edit Data Aset</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?= site_url('asset/edit') ?>" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body p-4">
                                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                    <div class="row g-3">
                                                        <!-- Kolom Kiri -->
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label text-secondary small fw-bold">Kode Barang (Dikunci)</label>
                                                                <input type="text" class="form-control bg-light" value="<?= $row['asset_code']; ?>" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-secondary small fw-bold">Nama Barang <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="name" value="<?= $row['name']; ?>" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label text-secondary small fw-bold">Kategori <span class="text-danger">*</span></label>
                                                                    <select class="form-select" name="category_id" required>
                                                                        <?php foreach($categories as $cat): ?>
                                                                            <option value="<?= $cat['id']; ?>" <?= ($row['category_id'] == $cat['id']) ? 'selected' : ''; ?>><?= $cat['name']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label text-secondary small fw-bold">Lokasi Fisik</label>
                                                                    <select class="form-select" name="location_id">
                                                                        <option value="">-- Kosong --</option>
                                                                        <?php foreach($locations as $loc): ?>
                                                                            <option value="<?= $loc['id']; ?>" <?= ($row['location_id'] == $loc['id']) ? 'selected' : ''; ?>><?= $loc['name']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label text-secondary small fw-bold">Merek / Brand</label>
                                                                    <input type="text" class="form-control" name="brand" value="<?= $row['brand']; ?>">
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label text-secondary small fw-bold">Model / Tipe</label>
                                                                    <input type="text" class="form-control" name="model" value="<?= $row['model']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Kolom Kanan -->
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label text-secondary small fw-bold">Departemen Pemilik</label>
                                                                <select class="form-select" name="department_id">
                                                                    <option value="">-- Umum / Perusahaan --</option>
                                                                    <?php foreach($departments as $dept): ?>
                                                                        <option value="<?= $dept['id']; ?>" <?= ($row['department_id'] == $dept['id']) ? 'selected' : ''; ?>><?= $dept['name']; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-secondary small fw-bold">Nomor Seri (S/N)</label>
                                                                <input type="text" class="form-control font-monospace" name="serial_number" value="<?= $row['serial_number']; ?>">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label text-secondary small fw-bold">Sifat Barang <span class="text-danger">*</span></label>
                                                                    <select class="form-select" name="management_type" required>
                                                                        <option value="borrowable" <?= ($row['management_type'] == 'borrowable') ? 'selected' : ''; ?>>Bisa Dipinjam (Bebas)</option>
                                                                        <option value="assignable" <?= ($row['management_type'] == 'assignable') ? 'selected' : ''; ?>>Ditugaskan (Inventaris Karyawan)</option>
                                                                        <option value="fixed" <?= ($row['management_type'] == 'fixed') ? 'selected' : ''; ?>>Aset Tetap (CCTV, AC, dll)</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label text-secondary small fw-bold">Kondisi Fisik <span class="text-danger">*</span></label>
                                                                    <select class="form-select" name="condition_status" required>
                                                                        <option value="good" <?= ($row['condition_status'] == 'good') ? 'selected' : ''; ?>>Bagus / Normal</option>
                                                                        <option value="fair" <?= ($row['condition_status'] == 'fair') ? 'selected' : ''; ?>>Layak Pakai (Ada Minus)</option>
                                                                        <option value="damaged" <?= ($row['condition_status'] == 'damaged') ? 'selected' : ''; ?>>Rusak / Butuh Servis</option>
                                                                        <option value="lost" <?= ($row['condition_status'] == 'lost') ? 'selected' : ''; ?>>Hilang</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 border p-3 rounded bg-light">
                                                                <label class="form-label text-secondary small fw-bold">Ganti Foto Aset (Abaikan jika tidak ingin ganti)</label>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="<?= base_url('assets/img/assets/'.$row['photo']) ?>" class="rounded me-3 border" width="60" height="60" style="object-fit: cover;">
                                                                    <input type="file" class="form-control" name="photo" accept="image/png, image/jpeg">
                                                                </div>
                                                            </div>
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
                                <!-- END MODAL EDIT -->

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH ASET -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold">Registrasi Aset Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('asset/add') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    
                    <div class="row g-4">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6 border-end pe-4">
                            <h6 class="fw-bold mb-3 text-primary border-bottom pb-2">Informasi Dasar</h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Kode Barang (Unik) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control font-monospace text-uppercase" name="asset_code" placeholder="Misal: IT-LAP-001" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Jumlah Unit (Kuantitas) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="quantity" value="1" min="1" max="100" required>
                                </div>
                            </div>
                            <small class="text-muted d-block mb-3" style="margin-top: -10px;">Isi lebih dari 1 jika ingin menambahkan unit berurutan otomatis (misal: IT-LAP-001 s/d IT-LAP-005).</small>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Misal: MacBook Pro M2 2023" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Sifat Barang <span class="text-danger">*</span></label>
                                <select class="form-select" name="management_type" required>
                                    <option value="borrowable">Bisa Dipinjam Sementara</option>
                                    <option value="assignable">Ditugaskan (Inventaris Karyawan)</option>
                                    <option value="fixed">Aset Tetap (CCTV, Meja, dll)</option>
                                </select>
                            </div>
                            
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" name="category_id" required>
                                        <option value="">-- Pilih --</option>
                                        <?php foreach($categories as $cat): ?>
                                            <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Lokasi Fisik</label>
                                    <select class="form-select" name="location_id">
                                        <option value="">-- Kosong --</option>
                                        <?php foreach($locations as $loc): ?>
                                            <option value="<?= $loc['id']; ?>"><?= $loc['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Departemen Penanggung Jawab</label>
                                <select class="form-select" name="department_id">
                                    <option value="">-- Milik Umum / Perusahaan --</option>
                                    <?php foreach($departments as $dept): ?>
                                        <option value="<?= $dept['id']; ?>"><?= $dept['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6 ps-4">
                            <h6 class="fw-bold mb-3 text-primary border-bottom pb-2">Spesifikasi & Foto</h6>
                            
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Merek / Brand</label>
                                    <input type="text" class="form-control" name="brand" placeholder="Misal: Apple, Dell">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Model / Tipe</label>
                                    <input type="text" class="form-control" name="model">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Nomor Seri (S/N)</label>
                                    <input type="text" class="form-control font-monospace" name="serial_number">
                                    <small class="text-muted">Abaikan jika diisi massal.</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Kondisi Awal <span class="text-danger">*</span></label>
                                    <select class="form-select" name="condition_status" required>
                                        <option value="good">Bagus / Normal</option>
                                        <option value="fair">Layak Pakai (Ada Minus)</option>
                                        <option value="damaged">Rusak / Butuh Servis</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Tgl. Pembelian</label>
                                    <input type="date" class="form-control" name="purchase_date">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Harga Beli</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-light">Rp</span>
                                        <input type="text" class="form-control rupiah-input" name="purchase_price" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Foto Barang (Opsional)</label>
                                <input type="file" class="form-control" name="photo" accept="image/png, image/jpeg, image/jpg">
                                <div class="form-text">Maksimal 30 MB. Format: JPG, PNG.</div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Simpan Aset Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Pencarian Realtime & Format Rupiah -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Live Filter Realtime saat Mengetik
        var searchInput = document.getElementById('assetSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                var filter = this.value.toLowerCase().trim();
                var rows = document.querySelectorAll('#assetTable tbody tr.asset-row');

                rows.forEach(function(row) {
                    var text = row.textContent.toLowerCase();
                    if (text.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

        // Format Rupiah Otomatis
        var rupiahInputs = document.querySelectorAll('.rupiah-input');
        rupiahInputs.forEach(function(input) {
            input.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
        });

        function formatRupiah(angka) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split       = number_string.split(','),
                sisa        = split[0].length % 3,
                rupiah      = split[0].substr(0, sisa),
                ribuan      = split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }
    });
</script>