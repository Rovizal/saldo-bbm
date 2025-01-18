<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('layoutsV2/begin_html_admin');
$this->load->view('layoutsV2/navbar_admin');
?>
<!-- Page content -->
<div class="page-content">

	<?php $this->load->view('view_sidebar_admin'); ?>

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title">
					<h4><i class="icon-home4 mr-2"></i> Dashboard Admin</h4>
					<!--<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
				</div>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">

			<!-- Main charts -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<div class="p-3 mb-2 text-white" style="background:#f57a21;">
											<h1><?= $approval_aproved ?></h1>
											Request Disetujui
										</div>
									</div>
									<div class="col-md-4">
										<div class="p-3 mb-2 text-white" style="background:#f57a21;">
											<h1><?= $approval_pending ?></h1>
											Request Menunggu
										</div>
									</div>
									<div class="col-md-4">
										<div class="p-3 mb-2 text-white" style="background:#f57a21;">
											<h1><?= $approval_rejected ?></h1>
											Request Ditolak
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="p-3 mb-2 text-white" style="background:#f57a21;">
											<h1><?= $mobil_registered ?></h1>
											Mobil Terdaftar
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /main charts -->

		</div>
		<!-- /content area -->

		<?php $this->load->view('layoutsV2/footer'); ?>

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->

<?php
$this->load->view('layoutsV2/end_html');
