<div class="main-content flex-grow-1" style="margin-left: 260px;">
    <!-- Sticky Topbar -->
    <header class="navbar navbar-expand bg-white sticky-top shadow-sm px-4 py-3 border-bottom border-light-subtle">
        <div class="container-fluid p-0 d-flex align-items-center justify-content-between">
            <!-- Left: Title & Today's Date -->
            <div>
                <h4 class="fw-bold text-dark mb-0">Dashboard Ikhtisar</h4>
                <div class="text-muted extra-small d-flex align-items-center gap-2">
                    <span><i class="far fa-calendar-alt me-1 text-teal"></i> <?= date('l, d F Y'); ?></span>
                    <span>•</span>
                    <span class="badge bg-teal bg-opacity-10 text-teal border border-teal border-opacity-25 rounded-pill px-2">PT Indo Techno Medic</span>
                </div>
            </div>

            <!-- Right: Actions & Admin Profile -->
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle p-2 border-0" onclick="toggleTheme()" title="Toggle Mode">
                    <i class="fas fa-moon theme-toggle-icon fs-5"></i>
                </button>

                <div class="dropdown">
                    <a class="text-decoration-none text-dark fw-bold dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_name); ?>&background=0F172A&color=fff&bold=true" class="rounded-circle border border-2 border-teal" width="36" height="36">
                        <div class="d-none d-sm-block text-start">
                            <span class="d-block small lh-1"><?= $user_name; ?></span>
                            <small class="text-muted extra-small">Administrator</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-4 overflow-hidden">
                        <li>
                            <div class="dropdown-header py-2 text-center bg-light">
                                <span class="fw-bold text-dark d-block"><?= $user_name; ?></span>
                                <small class="text-muted">Super Admin System</small>
                            </div>
                        </li>
                        <li><a class="dropdown-item py-2" href="<?= site_url('setting'); ?>"><i class="fas fa-sliders-h me-2 text-secondary"></i> Pengaturan Sistem</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item text-danger py-2 fw-bold" href="<?= site_url('auth/logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>