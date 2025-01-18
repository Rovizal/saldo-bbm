<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no">
	<meta name="author" content="Saldo BBM" />

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/icons/icomoon/styles.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/bootstrap_limitless.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/layout.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/components.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/colors.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/intlTelInput.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/demo_phone.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/plugins/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?php echo base_url('assetsV2/js/main/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/main/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/loaders/blockui.min.js'); ?>"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="<?php echo base_url('assetsV2/js/plugins/visualization/d3/d3.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/visualization/d3/d3_tooltip.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/validation/validate.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/selects/select2.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/styling/switch.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/styling/switchery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/styling/uniform.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/styling/switchery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/selects/bootstrap_multiselect.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/ui/moment/moment.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/pickers/daterangepicker.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/ui/perfect_scrollbar.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/intl_phone/intlTelInput.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/tables/datatables/datatables.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/tables/footable/footable.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/pickers/pickadate/daterangepicker.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/pickers/pickadate/anytime.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/pickers/pickadate/picker.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/pickers/pickadate/picker.date.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/pickers/pickadate/picker.time.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/pickers/pickadate/legacy.js'); ?>"></script>

	<script src="<?php echo base_url('assetsV2/js/app.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/dashboard.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/layout_fixed_sidebar_custom.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/form_layouts.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/form_checkboxes_radios.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/table_responsive.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/datatables_responsive.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/picker_date.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/form_validation.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/form_select2.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/plugins/toastr/toastr.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
	<!-- /theme JS files -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>" />
	<title>Saldo BBM | Admin</title>
	<!-- META TAGS FOR SEO -->
	<meta name="description" content="Saldo BBM APLIKASI GANTENG">
	<meta name="keywords" content="-">
	<!-- End Facebook Pixel Code -->
</head>

<script>
	function base64UrlSafeEncode(data) {
		// Check if data is an object (excluding null)
		if (typeof data === "object" && data !== null) {
			// Convert object to JSON
			data = JSON.stringify(data);
		}

		// First layer of encoding
		let enc1 = btoa(data);

		// URL-safe encoding: Replace characters to make it URL-safe
		const encFinal = enc1
			.replace(/\+/g, "-")
			.replace(/\//g, "_")
			.replace(/=+$/, "");

		return encFinal;
	}

	function base64UrlSafeDecode(data) {
		// Replace URL-safe characters to Base64 characters
		let replacedInput = data.replace(/-/g, "+").replace(/_/g, "/");

		// Add padding if necessary
		const padding = replacedInput.length % 4;
		if (padding) {
			replacedInput += "=".repeat(4 - padding);
		}

		// Fifth layer of decoding
		let dec5 = atob(replacedInput);

		// Parse JSON back to original data
		const originalData = JSON.parse(dec5);

		return originalData;
	}
</script>

<body class="navbar-top">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
