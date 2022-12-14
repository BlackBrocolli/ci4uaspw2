<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-folder-open"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PemWeb 2</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>/home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- tampilkan hanya jika levelnya admin -->
    <?php if (session()->get('level') == 'admin') : ?>

        <!-- Heading -->
        <div class="sidebar-heading">
            Admin
        </div>

        <!-- Nav Item - Tambah buku -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/home/addbuku'); ?>">
                <i class="fas fa-fw fa-plus"></i>
                <span>Tambah Buku</span></a>
        </li>

        <!-- Nav Item - List anggota -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/home/anggota'); ?>">
                <i class="fas fa-fw fa-list"></i>
                <span>List Anggota</span></a>
        </li>

        <!-- Nav Item - Peminjaman -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/home/peminjaman'); ?>">
                <i class="fas fa-fw fa-clock"></i>
                <span>Peminjaman</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

    <?php endif; ?>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>