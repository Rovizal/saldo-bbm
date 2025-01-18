<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('layoutsV2/begin_html_admin');
$this->load->view('layoutsV2/navbar_admin');
?>
<!-- Page content -->
<div class="page-content">

	<?php $this->load->view('view_sidebar'); ?>

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title">
					<h4><i class="icon-quill4"></i>&nbsp;Perjalanan</h4>
				</div>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">
			<div class="card">
				<div class="card-header">
					<div class="d-flex">
						<button class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#modalActivity">Tambah Perjalanan</button>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped" id="tbl_activity">
								<thead>
									<th>Mobil</th>
									<th>Jarak Tempuh</th>
									<th>BBM Terpakai</th>
									<th>Tanggal</th>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- /main charts -->

		</div>
		<!-- /content area -->

		<!-- MODAL AREA -->
		<div class="modal fade" id="modalActivity" tabindex="-1" role="dialog" aria-labelledby="modalNotif" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Tambah Perjalanan</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="formActivity">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Mobil*</label>
										<select name="mobil_id" id="mobilSelect" class="form-control select">
											<option value="">-- Pilih Mobil --</option>
											<?php foreach ($mobil as $car) { ?>
												<option value="<?= $car->mobil_id ?>"><?= $car->merk ?> <?= $car->type ?> &#9728;BBM : <?= $car->saldo_awal ?> liter &#9728;konsumsi : <?= $car->jarak_tempuh_per_liter ?>km/ltr</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jarak Tempuh (km)*</label>
										<input type="text" maxlength="6" id="jartem" class="form-control" name="jarak_tempuh_aktifitas"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class=" modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-danger">Tutup</button>
						<button type="button" id="btnSubmitActivity" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END MODAL AREA -->

		<?php $this->load->view('layoutsV2/footer'); ?>

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->
<?php $this->load->view('script/activity_sopir_script'); ?>
<?php $this->load->view('layoutsV2/end_html'); ?>
