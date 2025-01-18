<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('layoutsV2/begin_html_login');
?>

<!-- Page content -->
<div class="page-content">

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Content area -->
		<div class="content d-flex justify-content-center align-items-center">

			<!-- Login card -->
			<?php echo form_open(base_url('daftar/attempt_register'), 'class="login-form wmin-sm-600" onsubmit="startProgress();"'); ?>
			<div class="card mb-0">

				<?php if (!empty($this->session->flashdata('notifikasi'))) { ?>
					<div class="alert alert-success alert-styled-left alert-arrow-left alert-dismissible">
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
						<span class="font-weight-semibold"><?php echo $this->session->flashdata('notifikasi'); ?>
					</div>
				<?php } ?>

				<?php if (!empty($this->session->flashdata('notifikasi_error'))) { ?>
					<div class="alert alert-warning alert-styled-left alert-dismissible">
						<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
						<span class="font-weight-semibold"><?php echo $this->session->flashdata('notifikasi_error'); ?>
					</div>
				<?php } ?>

				<div class="card-body">
					<div class="text-center mb-3">
						<h5 class="mb-0">Daftar Akun Baru</h5>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="d-block font-weight-semibold">Username *</label>
								<input type="text" name="username" class="form-control" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="d-block font-weight-semibold">Role *</label>
								<select name="role" class="form-control" required>
									<option value="">Pilih</option>
									<option value="admin">Admin</option>
									<option value="sopir">Sopir</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="d-block font-weight-semibold">Kata Sandi *</label>
								<div class="input-group">
									<input type="password" name="password" id="pass1" class="form-control" onkeyup="validatePassword(this.value); return false;" required>
									<span class="input-group-append" style="z-index:0">
										<div id="div-showPass">
											<button class="btn btn-light" type="button" id="showPass" style="height:36px;"><i class="icon-eye2"></i></button>
										</div>
										<div id="div-hidePass" style="display:none;">
											<button class="btn btn-light" type="button" id="hidePass" style="height:36px;"><i class="icon-eye-blocked"></i></button>
										</div>
									</span>
								</div>
								<span style="color:#ff6666;font-weight:bold;" id="regexMessage"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="d-block font-weight-semibold">Konfirmasi Kata Sandi *</label>
								<input type="password" name="password2" id="pass2" class="form-control" onkeyup="checkPass(); return false;" required>
								<span style="color:#ff6666;" id="passMessage"></span>
							</div>
						</div>
					</div>
					<div id="info" style="display:none;color:red;"></div>
					<div class="form-check">
						<input class="form-check-input" type="hidden" name="persetujuan" value="1" id="defaultCheck2" required>
					</div>

					<!-- loading -->
					<div id="loadingIcon" style="display:none;"><i class="icon-spinner2 spinner mr-2"></i>&nbsp;Loading....</div>
					<script type="text/javascript">
						function startProgress() {
							$('#loadingIcon').show();
						}
					</script>
					<div style="height:10px;"></div>

					<!-- BEGIn TERMS AND CONDITIONS PENERBIT DAN PEMODAL -->
					<div class="wrapper justify-content-center">

						<div class="form-group" style="position:initial !important;">
							<button type="submit" class="btn btn-dark btn-block" style="background-color: #04B69A;color:#fff;position:initial !important">Daftar</button>
						</div>

						<div class="form-group text-center content-divider" style="position:initial !important;">
							<span class="px-2" style="z-index:0">Sudah punya akun? Silakan</span>
						</div>

						<div class="form-group" style="position:initial !important;">
							<a href="<?php echo base_url('login'); ?>" class="btn btn-block" style="background-color: #1F204E;color:#fff;position:initial !important" id="login-satu">Login</a>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
				<!-- /login card -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<?php
	$this->load->view('layoutsV2/end_html');
	?>

	<script>
		$(function() {
			$("#showPass").click(function() {
				$('#pass1').attr('type', 'text');
				$('#div-showPass').hide();
				$('#div-hidePass').show();
			});

			$("#hidePass").click(function() {
				$('#pass1').attr('type', 'password');
				$('#div-showPass').show();
				$('#div-hidePass').hide();
			});
		});
	</script>
	<script>
		function validatePassword(password) {
			const info = document.getElementById("info");
			const regexMessage = document.getElementById("regexMessage");
			const pass1 = document.getElementById('pass1');

			// Reset messages if password length is zero
			if (password.length === 0) {
				resetMessages(info, regexMessage);
				return;
			}

			// Define regex patterns for validation
			const patterns = [
				/[$@$!%*#?&]/, // Special Characters
				/[A-Z]/, // Uppercase Letters
				/[0-9]/, // Numbers
				/[a-z]/ // Lowercase Letters
			];

			// Check if password meets basic requirements
			if (isPasswordValid(pass1.value)) {
				info.style.display = "none";
				info.innerHTML = "";
			} else {
				showInfoMessage(info, "Password minimal 8 karakter yang terdiri dari huruf kecil, besar, dan angka");
			}

			// Calculate password strength
			const strength = calculateStrength(password, patterns);

			// Display strength
			displayStrength(regexMessage, strength);
		}

		function resetMessages(info, regexMessage) {
			info.style.display = "none";
			info.innerHTML = "";
			regexMessage.innerHTML = "";
		}

		function isPasswordValid(password) {
			const lowerCaseLetters = /[a-z]/;
			const upperCaseLetters = /[A-Z]/;
			const numbers = /[0-9]/;

			return (
				password.match(lowerCaseLetters) &&
				password.match(upperCaseLetters) &&
				password.match(numbers) &&
				password.length >= 8
			);
		}

		function calculateStrength(password, patterns) {
			let matchCount = 0;

			patterns.forEach(pattern => {
				if (pattern.test(password)) {
					matchCount++;
				}
			});

			switch (matchCount) {
				case 0:
				case 1:
				case 2:
					return {
						level: "Very Weak", color: "red"
					};
				case 3:
					return {
						level: "Medium", color: "orange"
					};
				case 4:
					return {
						level: "Strong", color: "green"
					};
			}
		}

		function displayStrength(element, strength) {
			element.innerHTML = strength.level;
			element.style.color = strength.color;
		}

		function showInfoMessage(info, message) {
			info.style.display = "block";
			info.innerHTML = message;
		}

		function checkPass() {
			const pass1 = document.getElementById('pass1');
			const pass2 = document.getElementById('pass2');
			let message = document.getElementById('passMessage');

			if (pass1.value == pass2.value) {
				message.innerHTML = "";
			} else {
				message.innerHTML = "Kata Sandi dan Konfirmasi Kata Sandi Tidak Sama";
			}
		}
	</script>
