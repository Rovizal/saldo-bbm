<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('layoutsV2/begin_html_admin');
$this->load->view('layoutsV2/navbar_admin');
?>

<style>
	#preview {
		max-width: 100%;
		max-height: 350px;
		border: 2px dashed #ccc;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		background-color: #f9f9f9;
	}

	#detailGambarPreview {
		max-width: 700px;
		max-height: 700px;
		display: block;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		background-color: #f9f9f9;
	}

	#preview img {
		max-width: 100%;
		max-height: 100%;
	}

	.error {
		color: red;
		font-size: 14px;
	}
</style>
<!-- Page content -->
<div class="page-content">

	<?php $this->load->view('view_sidebar_admin'); ?>

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title">
					<h4><i class="icon-clippy"></i>&nbsp;Approval</h4>
					<!--<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
				</div>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">
			<div class="card">
				<div class="card-header">
					<div class="d-flex">
						<div>
							<select id="statusFilter" class="form-control select">
								<option value="">-- Semua Status --</option>
								<option value="approved">Approved</option>
								<option value="pending">Pending</option>
								<option value="rejected">Rejected</option>
							</select>
							<input type="hidden" id="statusVal">
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped" id="tbl_approval">
								<thead>
									<th>Mobil</th>
									<th>Jenis BBM</th>
									<th>Jumlah</th>
									<th>Harga</th>
									<th>Status</th>
									<th>Approved By</th>
									<th>Action</th>
								</thead>
							</table>
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
<?php $this->load->view('script/approval_script'); ?>
<?php $this->load->view('layoutsV2/end_html'); ?>
