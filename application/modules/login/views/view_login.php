<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('layoutsV2/begin_html_login');
?>
<style>
	* {
		font-family: Sarala;
	}

	.form-control-feedback {
		line-height: 2.7em !important;
	}

	.form-group-feedback-left .form-control {
		padding-left: 3.5rem !important;
	}

	@media only screen and (min-width: 576px) {
		.g-recaptcha {
			transform: scale(0.93);
		}
	}

	@media only screen and (max-width: 575px) {
		.login-form {
			width: 20rem !important;
		}

		.g-recaptcha {
			transform: scale(0.93);
		}
	}
</style>
<!-- Page content -->
<div class="page-content">
	<!-- Main content -->
	<div class="content-wrapper desktop" style="background: url(<?php echo base_url('assets/images/bg.jpg') ?>)  no-repeat;background-size: cover;">
		<div class="col-md-12" style="position:relative">
			<div id="login_update" class="row">
				<div class="col-md-6">
				</div>
				<div class="col-md-6">
				</div>
				<div class="col-md-6 d-flex content justify-content-center align-items-center" style="position: absolute;margin-top:70px;">
					<!-- Login card -->
					<div class="card" style="border-radius: 15px;">
						<?php if (!empty($this->session->flashdata('notifikasi'))) { ?>
							<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
								<span class="font-weight-semibold">
									<?php echo $this->session->flashdata('notifikasi'); ?>
							</div>
						<?php } ?>
						<?php if (!empty($this->session->flashdata('notifikasi_error'))) { ?>
							<div class="alert alert-warning alert-styled-left alert-dismissible">
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
								<span class="font-weight-semibold">
									<?php echo $this->session->flashdata('notifikasi_error'); ?>
							</div>
						<?php } ?>
						<?php if (!empty($this->session->tempdata('notifikasi'))) { ?>
							<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
								<span class="font-weight-semibold">
									<?php echo $this->session->tempdata('notifikasi'); ?>
							</div>
						<?php } ?>
						<?php if (!empty($this->session->tempdata('notifikasi_error'))) { ?>
							<div class="alert alert-warning alert-styled-left alert-dismissible">
								<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
								<span class="font-weight-semibold">
									<?php echo $this->session->tempdata('notifikasi_error'); ?>
							</div>
						<?php } ?>
						<?php if (!empty($this->session->userdata('attempt'))) : ?>
							<?php if ($this->session->userdata('attempt') == 2) : ?>
								<div class="alert alert-warning alert-styled-left alert-dismissible">
									<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
									<span class="font-weight-semibold">Anda telah gagal <?php echo $this->session->userdata('attempt'); ?> kali. Jika 3 kali gagal lagi, akun anda akan di bekukan untuk keamanan.
								</div>
							<?php endif; ?>
						<?php endif; ?>
						<?php echo form_open(base_url('login/attempt_login'), 'class="login-form" onsubmit="startProgress();" autocomplete="off"'); ?>
						<div class="card-body">
							<div class="text-center mb-3">
								<h5 class="mb-0">Silahkan Masuk ke Akun Anda</h5>
							</div>
							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" name="username" class="form-control" placeholder="Masukkan Username Anda" id="validationCustom01" autocomplete="off"
									style="border: 1px solid rgba(0, 0, 0, 0.4);border-radius:5px;">
								<div class="form-control-feedback" style="border: 1px solid rgba(0, 0, 0, 0.4);border-radius:5px;">
									<i class="icon-user text-muted"></i>
								</div>
							</div>
							<div class="form-group form-group-feedback form-group-feedback-left">
								<div class="input-group">
									<input type="password" name="password" class="form-control" autocomplete="off" id="validationCustom02" placeholder="Kata Sandi" style="border: 1px solid rgba(0, 0, 0, 0.4);border-radius:0;">
									<span class="input-group-append">
										<div id="div-showPass">
											<button class="btn btn-light" type="button" id="showPass" style="height:36px;border: 1px solid rgba(0, 0, 0, 0.4);border-radius:0 5px 5px 0;"><i class="icon-eye2"></i></button>
										</div>
										<div id="div-hidePass" style="display:none;">
											<button class="btn btn-light" type="button" id="hidePass" style="height:36px;border: 1px solid rgba(0, 0, 0, 0.4);border-radius:0 5px 5px 0;"><i class="icon-eye-blocked"></i></button>
										</div>
									</span>
								</div>
								<div class="form-control-feedback" style="border: 1px solid rgba(0, 0, 0, 0.4);border-radius:5px;">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>
							<!-- loading -->
							<div id="loadingIcon" style="display:none;"><i class="icon-spinner2 spinner mr-2"></i>&nbsp;Loading....</div>
							<script type="text/javascript">
								function startProgress() {
									$('#loadingIcon').show();
								}
							</script>
							<div style="height:10px;"></div>
							<div class="form-group">
								<button type="submit" style="background: #04B69A;" class="btn btn-dark btn-block">Masuk <i class="icofont-play-alt-1 ml-2"></i></button>
							</div>
							<div class="form-group text-center text-muted content-divider">
								<span class="px-2" style="color: #1F204E;">Belum ada akun?</span>
							</div>
							<div class="form-group">
								<a href="<?php echo base_url('daftar'); ?>" class="btn btn-dark btn-block" style="background: #1F204E;">Daftar</a>
							</div>
						</div>
					</div> <?php echo form_close(); ?>
					<!-- /login card -->
				</div>
				<div class="col-md-6" style="position: absolute;right:0">
					<p style="text-shadow: 20px 20px 30px rgba(0, 0, 0, 0.84);font-family: Sarala;font-weight: bold;font-size:3em;color:#fff;margin-top: 193px;margin-left: 73px;">Selamat Datang <br> di Aplikasi Saldo BBM</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
<?php $this->load->view('layoutsV2/end_html'); ?>
<script>
	$(function() {
		$("#showPass").click(function() {
			$('#validationCustom02').attr('type', 'text');
			$('#div-showPass').hide();
			$('#div-hidePass').show();
		});
		$("#hidePass").click(function() {
			$('#validationCustom02').attr('type', 'password');
			$('#div-showPass').show();
			$('#div-hidePass').hide();
		});
	});
</script>
