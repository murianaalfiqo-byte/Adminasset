<aside class="sidebar-dark min-vh-100 d-flex flex-column flex-shrink-0 p-3 position-fixed top-0 start-0 z-3" 
       style="width: 260px; background-color: #0F172A;">
    
    <!-- Brand Logo -->
    <a href="<?= site_url('admin/dashboard'); ?>" class="d-flex align-items-center px-2 py-3 text-white text-decoration-none border-bottom border-secondary border-opacity-25 mb-3">
        <i class="fas fa-heartpulse text-teal fs-3 me-2"></i>
        <div>
            <h5 class="fw-bold mb-0 text-white">Asset<span class="text-teal">Flow</span></h5>
            <span class="extra-small text-white-50 font-monospace d-block">PT Indo Techno Medic</span>
        </div>
    </a>

    <!-- Navigation Menu -->
    <div class="nav-wrapper flex-grow-1 overflow-auto">
        <!-- MASTER DATA -->
        <div class="menu-header text-uppercase extra-small fw-bold text-white-50 px-2 mt-2 mb-2">Master Data</div>
        <ul class="nav nav-pills flex-column mb-3 gap-1">
            <li class="nav-item">
                <a href="<?= site_url('asset'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'asset') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-cubes me-2 width-20"></i> Data Aset
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('category'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'category') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-tags me-2 width-20"></i> Kategori
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('location'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'location') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-map-marker-alt me-2 width-20"></i> Lokasi
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('department'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'department') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-building me-2 width-20"></i> Departemen
                </a>
            </li>
        </ul>

        <!-- TRANSAKSI -->
        <div class="menu-header text-uppercase extra-small fw-bold text-white-50 px-2 mt-3 mb-2">Transaksi</div>
        <ul class="nav nav-pills flex-column mb-3 gap-1">
            <li class="nav-item">
                <a href="<?= site_url('borrowing'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'borrowing') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-exchange-alt me-2 width-20"></i> Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('assignment'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'assignment') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-user-check me-2 width-20"></i> Penugasan
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('maintenance'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'maintenance') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-wrench me-2 width-20"></i> Maintenance
                </a>
            </li>
        </ul>

        <!-- SYSTEM -->
        <div class="menu-header text-uppercase extra-small fw-bold text-white-50 px-2 mt-3 mb-2">System</div>
        <ul class="nav nav-pills flex-column mb-3 gap-1">
            <li class="nav-item">
                <a href="<?= site_url('report'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'report') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-chart-bar me-2 width-20"></i> Laporan
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('employee'); ?>" class="nav-link text-white-70 <?= ($this->uri->segment(1) == 'employee') ? 'active bg-teal text-white fw-semibold' : ''; ?>">
                    <i class="fas fa-users-cog me-2 width-20"></i> Data Karyawan
                </a>
            </li>
        </ul>
    </div>

    <!-- User Profile Footer Sidebar -->
    <div class="border-top border-secondary border-opacity-25 pt-3 mt-auto">
        <div class="d-flex align-items-center">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_name); ?>&background=0D9488&color=fff&bold=true" class="rounded-circle me-2 border border-teal" width="38" height="38">
            <div class="flex-grow-1 overflow-hidden">
                <div class="fw-bold text-white text-truncate small mb-0"><?= $user_name; ?></div>
                <small class="text-teal extra-small d-block">Super Admin</small>
            </div>
            <a href="<?= site_url('auth/logout'); ?>" class="btn btn-sm btn-link text-danger p-1" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</aside>

<style>
.sidebar-dark .nav-link {
    color: rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    padding: 0.55rem 0.85rem;
    transition: all 0.2s ease;
    font-size: 0.88rem;
}
.sidebar-dark .nav-link:hover {
    color: #FFFFFF;
    background-color: rgba(255, 255, 255, 0.08);
}
.sidebar-dark .nav-link.active {
    background-color: #0D9488 !important;
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
}
.width-20 {
    width: 20px;
    text-align: center;
}
.text-teal {
    color: #0D9488 !important;
}
.bg-teal {
    background-color: #0D9488 !important;
}
.extra-small {
    font-size: 0.75rem;
}
</style>