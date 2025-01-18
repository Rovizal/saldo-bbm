<!-- Main sidebar -->
<div class="sidebar sidebar-light bg-light text-dark sidebar-main sidebar-fixed sidebar-expand-md">

	<!-- Sidebar mobile toggler -->
	<div class="sidebar-mobile-toggler text-center">
		<a href="#" class="sidebar-mobile-main-toggle">
			<i class="icon-arrow-left8"></i>
		</a>
		Navigation
		<a href="#" class="sidebar-mobile-expand">
			<i class="icon-screen-full"></i>
			<i class="icon-screen-normal"></i>
		</a>
	</div>
	<!-- /sidebar mobile toggler -->


	<!-- Sidebar content -->
	<div class="sidebar-content">

		<!-- User menu -->
		<div class="sidebar-user">
			<div class="card-body">
				<div class="media">
					<div class="mr-3">
						<i class="icon-user icon-1x text-slate-800 border-slate-800 border-1 rounded-round p-1 mb-1 mt-1"></i>&nbsp; <?= ucfirst($this->session->userdata('username')) ?>
					</div>

					<div class="media-body">
						<div class="media-title font-weight-semibold"><?= $this->session->userdata('nama'); ?></div>
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->

		<!-- Main navigation -->
		<div class="card card-sidebar-mobile">
			<ul class="nav nav-sidebar" data-nav-type="accordion">
				<li class="nav-item">
					<a href="<?= base_url('admin/dashboard'); ?>" class="nav-link <?= ($this->router->fetch_class() == 'dashboard') ? 'active' : '' ?>">
						<i class="icon-home4"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= base_url('admin/mobil'); ?>" class="nav-link <?= ($this->router->fetch_class() == 'mobil') ? 'active' : '' ?>">
						<i class="icon-car"></i>
						<span>Daftar Mobil</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= base_url('admin/approval'); ?>" class="nav-link <?= ($this->router->fetch_class() == 'approval') ? 'active' : '' ?>">
						<i class="icon-clippy"></i>
						<span>Approval</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?= base_url('login/logout'); ?>" class="nav-link">
						<i class="icon-switch"></i>
						<span>Logout</span>
					</a>
				</li>
			</ul>
		</div>
		<!-- /main navigation -->

	</div>
	<!-- /sidebar content -->

</div>
<!-- /main sidebar -->
