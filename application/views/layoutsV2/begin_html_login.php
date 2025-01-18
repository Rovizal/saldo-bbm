<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no">
	<meta name="author" content="SaldoBBMROV" />
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css2?family=Sarala:wght@400;700&display=swap" rel="stylesheet">
	<link href="<?php echo base_url('assetsV2/css/icons/icomoon/styles.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/danastudi/vendor/icofont/icofont.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assetsV2/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/bootstrap_limitless.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/layout.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/components.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/colors.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/intlTelInput.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assetsV2/css/demo_phone.css'); ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<script src="<?php echo base_url('assetsV2/js/main/jquery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/main/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/loaders/blockui.min.js'); ?>"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script src="<?php echo base_url('assetsV2/js/plugins/visualization/d3/d3.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/visualization/d3/d3_tooltip.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/styling/switchery.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/forms/selects/bootstrap_multiselect.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/ui/moment/moment.min.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/pickers/daterangepicker.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/plugins/intl_phone/intlTelInput.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/app.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/dashboard.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/layout_fixed_sidebar_custom.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/form_layouts.js'); ?>"></script>
	<script src="<?php echo base_url('assetsV2/js/demo_pages/form_checkboxes_radios.js'); ?>"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<!-- <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@18657a9/css/all.min.css" rel="stylesheet" type="text/css" /> -->
	<style>
		:root {
			--namaVariable: #123;
		}

		/* small device */
		@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap');

		.wrapper-scroll-validate {
			min-height: 94vh;
			display: grid;
			justify-content: center;
			align-content: center;
			/* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; */
			line-height: 2;
			background: rgba(0, 0, 0, 0.6);
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			position: fixed;
			visibility: hidden;
			opacity: 0;
			z-index: 999;
		}

		.wrapper-modal-validate {
			/* width: 80%; */
			height: 100vh;
			padding: 20px;
			margin: auto;
			background: white;
			display: grid;
			grid-template-rows: 1fr auto;
			/* border-radius: 10px; */
			box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.4);
		}

		button.accept {
			/* background: #133C55; */
			/* background: linear-gradient(114.01deg, #04AF93 0%, #145B8E 87.68%); */
			border-radius: 10px;
			color: white;
			font-size: 1rem;
			/* padding: 1rem; */
			transition: opacity 0.2s;
			cursor: pointer;
			border: none;
		}

		button.accept:hover {
			opacity: 0.9;
		}

		button.accept[disabled] {
			opacity: 0.4;
			cursor: not-allowed;
			/* transform: translateX(-300%) scale(0.5); */
		}

		.terms-and-conditions {
			overflow-y: scroll;
		}

		.content-tcp {
			padding: 0 0.6rem;
		}

		.terms-and-conditions::-webkit-scrollbar {
			width: 12px;
		}

		.terms-and-conditions::-webkit-scrollbar-track {
			background-color: rgb(238, 238, 238);
			border-radius: 7px;
		}

		.terms-and-conditions::-webkit-scrollbar-thumb {
			background-color: rgb(208, 208, 208);
			border-radius: 7px;
		}

		.terms-and-conditions::-webkit-scrollbar-thumb:hover {
			background-color: rgb(200, 200, 200);
		}

		.tcp-heading {
			text-align: center;
			line-height: 1.5;
			position: sticky;
			top: -1px;
			background-color: white;
			margin: 0;
			padding-bottom: 1rem;
			font-size: 18px;
		}

		.tcp-subhead {
			line-height: 1.5;
			margin-top: 2.5rem;
			font-size: 16px;
		}

		.span-tcp-subhead {
			margin-left: 1.5rem;
		}

		.tcp-paragraph>li,
		p.tcp-text-paragraph {
			line-height: 1.5;
			text-align: justify;
			margin-bottom: 0.5rem;
			font-size: 14px;
			font-family: 'Open Sans', sans-serif;
			font-weight: 500;
		}

		.mt-4rem {
			margin-top: 2rem;
		}

		.mb-4rem {
			margin-bottom: 2rem;
		}

		.mt-5rem {
			margin-top: 2.5rem;
		}

		.mb-5rem {
			margin-bottom: 2.5rem;
		}

		.mt-6rem {
			margin-top: 3rem;
		}

		.mb-6rem {
			margin-bottom: 3rem;
		}

		/* dashboard custom col boostrap */
		.col-md-3-5 {
			position: relative;
			min-height: 1px;
			padding-right: 15px;
			padding-left: 15px;
		}

		/* /dashboard custom col boostrap */
		/* page penwaran */
		.parallel-list>.list-group-item {
			height: 87.14px;
		}

		/* /page penwaran */
		@media screen and (min-width: 768px) and (max-width: 991px) {
			.col-md-3-5 {
				float: left;
			}

			.col-md-3-5 {
				width: 29.16666667%;
			}
		}

		/* Large devices (desktops, 992px and up) */
		@media (min-width: 992px) {
			.defineHeightCard {
				height: 120px !important;
			}
		}

		/* Medium devices (tablets, 768px and up) */
		@media (min-width: 768px) {
			.mt-4rem {
				margin-top: 4rem;
			}

			.mb-4rem {
				margin-bottom: 4rem;
			}

			.mt-5rem {
				margin-top: 5rem;
			}

			.mb-5rem {
				margin-bottom: 5rem;
			}

			.mt-6rem {
				margin-top: 6rem;
			}

			.mb-6rem {
				margin-bottom: 6rem;
			}

			.sub-countdown>li {
				width: 120px;
				height: 120px;
			}

			.sub-countdown>li>span {
				font-size: 38px;
			}

			.sub-countdown>li:not(span) {
				font-size: 14px;
			}

			.tcp-heading {
				font-size: 20px;
			}
		}

		/* Small devices (landscape phones, 576px and up) */
		@media (min-width: 576px) {
			.parallel-list>.list-group-item {
				height: initial;
			}
		}
	</style>
	<!-- /theme JS files -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>" />
	<title>Saldo BBM App</title>
	<!-- META TAGS FOR SEO -->
	<meta name="description" content="Saldo BBM aplikasi ganteng menghitung BBM untuk usaha anda">
	<meta name="keywords" content="-">
	<!-- End Facebook Pixel Code -->
</head>

<body>
	<!-- <div id="preloader"></div> -->
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KQH4F7M" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
