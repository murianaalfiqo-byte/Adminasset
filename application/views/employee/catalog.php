<div class="container py-4 my-2">
    <!-- Header Page & Filter Control -->
    <div class="row mb-4 align-items-center g-3">
        <div class="col-lg-6">
            <div class="d-flex align-items-center mb-1">
                <span class="badge bg-teal bg-opacity-10 text-teal border border-teal border-opacity-25 rounded-pill px-3 py-1 me-2 extra-small">
                    <i class="fas fa-stethoscope me-1"></i> Inventaris Medis & IT
                </span>
            </div>
            <h3 class="fw-bold text-dark mb-1">Katalog Perangkat</h3>
            <p class="text-muted small mb-0">Pilih peralatan medis atau perangkat kerja yang tersedia untuk diajukan.</p>
        </div>
        
        <!-- Filter Kategori & Search Bar -->
        <div class="col-lg-6">
            <div class="row g-2">
                <div class="col-md-5">
                    <select id="filterCategory" class="form-select border-0 shadow-sm rounded-3 py-2 small">
                        <option value="">Semua Kategori</option>
                        <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id']; ?>"><?= $cat['name']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-7">
                    <div class="input-group shadow-sm rounded-3 overflow-hidden">
                        <span class="input-group-text bg-white border-0 text-muted ps-3"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchKeyword" class="form-control border-0 pe-3 py-2 small" placeholder="Cari perangkat, brand, atau tipe...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Flash Data -->
    <?php if($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success_msg'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Grid Asset Cards -->
    <div class="row g-4" id="assetContainer">
        <?php if(empty($assets)): ?>
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm rounded-4 p-5">
                    <i class="fas fa-box-open fs-1 text-teal mb-3 opacity-50"></i>
                    <h5 class="fw-bold text-dark mb-1">Tidak ada perangkat siap pinjam</h5>
                    <p class="text-muted small mb-0">Saat ini seluruh unit sedang digunakan atau dalam pemeliharaan.</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($assets as $row): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 asset-item" 
                     data-name="<?= strtolower($row['name']); ?>" 
                     data-brand="<?= strtolower($row['brand'] ?? ''); ?>" 
                     data-model="<?= strtolower($row['model'] ?? ''); ?>"
                     data-category="<?= $row['category_id']; ?>">
                    
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover">
                        <div class="position-relative bg-light text-center p-3">
                            <span class="badge bg-teal bg-opacity-10 text-teal border border-teal border-opacity-25 rounded-pill position-absolute top-0 start-0 m-3 px-2 py-1 extra-small">
                                <i class="fas fa-tag me-1"></i><?= $row['category_name'] ?: 'Umum'; ?>
                            </span>
                            
                            <img src="<?= base_url('assets/img/assets/'.$row['photo']) ?>" 
                                 class="img-fluid rounded-3 my-2" 
                                 alt="<?= $row['name']; ?>" 
                                 style="height: 150px; object-fit: contain;">
                        </div>

                        <div class="card-body d-flex flex-column p-3">
                            <h6 class="fw-bold text-dark mb-1 text-truncate" title="<?= $row['name']; ?>"><?= $row['name']; ?></h6>
                            <p class="text-muted extra-small mb-3">
                                <?= !empty($row['brand']) ? $row['brand'] : 'Brand -'; ?> <?= !empty($row['model']) ? '• '.$row['model'] : ''; ?>
                            </p>
                            
                            <div class="mt-auto d-grid gap-2">
                                <button type="button" 
                                        class="btn btn-sm btn-light text-secondary border-0 fw-medium rounded-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#detailModal<?= $row['id']; ?>">
                                    <i class="fas fa-info-circle me-1"></i> Spesifikasi
                                </button>
                                
                                <a href="<?= site_url('borrowing/request/'.$row['id']) ?>" class="btn btn-sm btn-teal fw-bold text-white rounded-3">
                                    <i class="fas fa-hand-holding-medical me-1"></i> Ajukan Pinjaman
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Perangkat -->
                <div class="modal fade" id="detailModal<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header border-0 bg-light">
                                <h6 class="modal-title fw-bold text-dark"><i class="fas fa-microchip me-2 text-teal"></i>Detail Perangkat Medis</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="text-center mb-4">
                                    <img src="<?= base_url('assets/img/assets/'.$row['photo']) ?>" 
                                         class="img-fluid rounded-3 mb-2" 
                                         alt="<?= $row['name']; ?>" 
                                         style="max-height: 160px; object-fit: contain;">
                                    <h5 class="fw-bold text-dark mb-0"><?= $row['name']; ?></h5>
                                    <span class="badge bg-teal bg-opacity-10 text-teal border border-teal border-opacity-25 rounded-pill px-3 py-1 mt-2 extra-small">
                                        <?= $row['category_name'] ?: 'Umum'; ?>
                                    </span>
                                </div>
                                
                                <div class="list-group list-group-flush rounded-3 border">
                                    <div class="list-group-item d-flex justify-content-between align-items-center extra-small">
                                        <span class="text-muted"><i class="fas fa-barcode me-2"></i>Kode Aset</span>
                                        <span class="fw-bold font-monospace text-dark"><?= $row['asset_code']; ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center extra-small">
                                        <span class="text-muted"><i class="fas fa-industry me-2"></i>Merek / Brand</span>
                                        <span class="fw-medium text-dark"><?= $row['brand'] ?: '-'; ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center extra-small">
                                        <span class="text-muted"><i class="fas fa-cube me-2"></i>Model / Tipe</span>
                                        <span class="fw-medium text-dark"><?= $row['model'] ?: '-'; ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center extra-small">
                                        <span class="text-muted"><i class="fas fa-hashtag me-2"></i>Serial Number</span>
                                        <span class="fw-medium font-monospace text-dark"><?= $row['serial_number'] ?: '-'; ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center extra-small">
                                        <span class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Lokasi Unit</span>
                                        <span class="fw-medium text-dark"><?= $row['location_name'] ?: 'Gudang Utama'; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 bg-light">
                                <button type="button" class="btn btn-sm btn-secondary rounded-3" data-bs-dismiss="modal">Tutup</button>
                                <a href="<?= site_url('borrowing/request/'.$row['id']) ?>" class="btn btn-sm btn-teal fw-bold text-white rounded-3">
                                    <i class="fas fa-hand-holding-medical me-1"></i> Ajukan Pinjaman
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="col-12 text-center py-5 d-none" id="noMatchMessage">
            <div class="card border-0 shadow-sm rounded-4 p-5">
                <i class="fas fa-search fs-1 text-muted mb-3 opacity-50"></i>
                <h5 class="fw-bold text-dark mb-1">Perangkat tidak ditemukan</h5>
                <p class="text-muted small mb-0">Coba ubah kata kunci atau kata pencarian kategori Anda.</p>
            </div>
        </div>
    </div>
</div>

<style>
.btn-teal {
    background-color: #0D9488 !important;
    border-color: #0D9488 !important;
}
.btn-teal:hover {
    background-color: #0F766E !important;
}
.text-teal {
    color: #0D9488 !important;
}
.bg-teal {
    background-color: #0D9488 !important;
}
.border-teal {
    border-color: #0D9488 !important;
}
.extra-small {
    font-size: 0.78rem;
}
.card-hover {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(13, 148, 136, 0.12) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchKeyword');
    const filterSelect = document.getElementById('filterCategory');
    const assetItems = document.querySelectorAll('.asset-item');
    const noMatchMessage = document.getElementById('noMatchMessage');

    function filterAssets() {
        const keyword = searchInput.value.toLowerCase().trim();
        const selectedCategory = filterSelect.value;
        let visibleCount = 0;

        assetItems.forEach(item => {
            const name = item.getAttribute('data-name');
            const brand = item.getAttribute('data-brand');
            const model = item.getAttribute('data-model');
            const category = item.getAttribute('data-category');

            const matchesSearch = name.includes(keyword) || brand.includes(keyword) || model.includes(keyword);
            const matchesCategory = selectedCategory === '' || category === selectedCategory;

            if (matchesSearch && matchesCategory) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        if (visibleCount === 0 && assetItems.length > 0) {
            noMatchMessage.classList.remove('d-none');
        } else {
            noMatchMessage.classList.add('d-none');
        }
    }

    if(searchInput) searchInput.addEventListener('keyup', filterAssets);
    if(filterSelect) filterSelect.addEventListener('change', filterAssets);
});
</script>   