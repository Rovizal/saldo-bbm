/* Tanpa Rupiah */
/*
var tanpa_rupiah = document.getElementById('tanpa-rupiah');
tanpa_rupiah.addEventListener('keyup', function(e)
{
	tanpa_rupiah.value = formatRupiah(this.value);
});
*/

/* Dengan Rupiah */
var dengan_rupiah = document.getElementById('dengan-rupiah');
if (dengan_rupiah) {
	dengan_rupiah.addEventListener('keyup', function (e) {
		dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
	});
}

/* Fungsi */
function formatRupiah(angka, prefix) {
	var number_string = angka.replace(/[^-,\d]/g, '').toString();
	if (number_string.substr(0, 1) == '-') {

		var number_string_ori = number_string.substr(1, number_string.length);
		var split = number_string_ori.split(',');
		var sisa = number_string_ori.length % 3;
		var rupiah = number_string_ori.substr(0, sisa);
		var ribuan = number_string_ori.substr(sisa).match(/\d{3}/g);
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

		return prefix == undefined ? '-' + rupiah : (rupiah ? 'Rp. ' + '-' + rupiah : ''); // Hasil: 23.456.789

	} else {
		var split = number_string.split(',');
		var sisa = number_string.length % 3;
		var rupiah = number_string.substr(0, sisa);
		var ribuan = number_string.substr(sisa).match(/\d{3}/g);
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
}
//var input = '-23456789';
// var prefix = undefined;
//
// var	number_string = input.replace(/[^-,\d]/g, '').toString();
//
// if(number_string.substr(0,1) == '-'){
//
//   var number_string_ori = number_string.substr(1,number_string.length);
//   var split   		= number_string_ori.split(',');
//   var sisa 	= number_string_ori.length % 3;
// 	var rupiah 	= number_string_ori.substr(0, sisa);
// 	var ribuan 	= number_string_ori.substr(sisa).match(/\d{3}/g);
//   if (ribuan) {
// 	separator = sisa ? '.' : '';
// 	rupiah += separator + ribuan.join('.');
//   }
//   rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
//
//   console.log(prefix == undefined ? '-' + rupiah : (rupiah ? 'Rp. ' + '-' + rupiah : '')); // Hasil: 23.456.789
//
// } else {
//
//   var sisa 	= number_string.length % 3;
// 	var rupiah 	= number_string.substr(0, sisa);
// 	var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
//   if (ribuan) {
// 	separator = sisa ? '.' : '';
// 	rupiah += separator + ribuan.join('.');
// }
//
// // Cetak hasil
// console.log(rupiah); // Hasil: 23.456.789
// }
//
//
//
//
