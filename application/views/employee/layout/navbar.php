<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm" style="background-color: #0F172A;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('user_panel/dashboard') ?>">
            <i class="fas fa-heartpulse text-teal me-2 fs-4"></i>
            <span>Asset<span class="text-teal">Flow</span></span>
            <span class="badge bg-white bg-opacity-10 text-teal border border-teal border-opacity-25 ms-2 rounded-pill px-2 py-1 extra-small d-none d-md-inline-block">
                PT Indo Techno Medic
            </span>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == '') ? 'active fw-bold text-white' : 'text-light opacity-75'; ?>" href="<?= site_url('user_panel/dashboard') ?>">
                        <i class="fas fa-chart-pie me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(2) == 'catalog') ? 'active fw-bold text-white' : 'text-light opacity-75'; ?>" href="<?= site_url('user_panel/catalog') ?>">
                        <i class="fas fa-boxes me-1"></i> Katalog Aset
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'history') ? 'active fw-bold text-white' : 'text-light opacity-75'; ?>" href="<?= site_url('history') ?>">
                        <i class="fas fa-history me-1"></i> Riwayat Peminjaman
                    </a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center gap-3 mt-2 mt-lg-0">
                <button type="button" class="btn btn-outline-light btn-sm rounded-circle p-2 border-0 opacity-75 hover-opacity-100" onclick="toggleTheme()" title="Switch Mode">
    <i class="fas fa-moon theme-toggle-icon fs-5"></i>
</button>

                <div class="dropdown">
                    <a class="text-decoration-none text-light fw-medium dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_name); ?>&background=0D9488&color=fff&bold=true" class="rounded-circle me-2 border border-2 border-info shadow-sm" width="36" height="36" alt="<?= $user_name; ?>">
                        <span class="d-none d-sm-inline"><?= $user_name; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-4 overflow-hidden">
                        <li>
                            <div class="dropdown-header text-center py-3 bg-light border-bottom">
                                <h6 class="mb-0 fw-bold text-dark"><?= $user_name; ?></h6>
                                <small class="text-muted d-block mt-1">PT Indo Techno Medic</small>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 px-3 mt-1" href="<?= site_url('profile') ?>">
                                <i class="fas fa-user-gear me-2 text-secondary"></i> Profil & Keamanan
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item text-danger py-2 px-3 fw-bold mb-1" href="<?= site_url('auth/logout') ?>">
                                <i class="fas fa-right-from-bracket me-2"></i> Keluar (Logout)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
.text-teal {
    color: #0D9488 !important;
}
.border-teal {
    border-color: #0D9488 !important;
}
.extra-small {
    font-size: 0.72rem;
}
.hover-opacity-100:hover {
    opacity: 1 !important;
}
</style>