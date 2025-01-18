<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Akses Ditolak</title>
</head>

<body>
	<h1>403 - Akses Ditolak</h1>
	<p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
	<?php if ($this->session->userdata('role') == 'admin') { ?>
		<a href="<?= base_url('admin/dashboard'); ?>">Kembali ke Dashboard</a>
	<?php } else { ?>
		<a href="<?= base_url('sopir/dashboard'); ?>">Kembali ke Dashboard</a>
	<?php }  ?>

</body>

</html>
