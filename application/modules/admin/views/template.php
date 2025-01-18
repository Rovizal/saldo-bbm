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
					<h4><i class="icon-car"></i>&nbsp;Daftar Mobil</h4>
					<!--<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
				</div>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">
			<div class="card">
				<div class="card-body">
					<div class="row">

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
<?php $this->load->view('script/mobil_script'); ?>
<?php $this->load->view('layoutsV2/end_html'); ?>
