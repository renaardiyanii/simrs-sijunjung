$('.result-send-sosmed').on('click', function () {
	var jns_penunjang = $(this).data('jenis');
	var nopnj = $(this).data('nopnj');
	var noreg = $(this).data('noreg');
	var nomr = $(this).data('nomr');
	var pasienname = $(this).data('pasienname');
	var nohp = $(this).data('nohp').toString();
	if (nohp.substring(0, 3) == '+62') {
		nohp = nohp.replace('+', '');
	} else if (nohp.substring(0, 1) == '0') {
		nohp = nohp.replace('0', '62');
	}
	Swal.fire({
		title: 'Kirim hasil melalui',
		icon: 'warning',
		showDenyButton: true,
		showCancelButton: true,
		cancelButtonText: '<i class="fa fa-close"></i>' + ' Batal',
		confirmButtonText: '<i class="fa fa-whatsapp"></i>' + ' Whatsapp',
		confirmButtonColor: '#377D71',
		denyButtonText: '<i class="fa fa-google-plus-circle"></i>' + ` Gmail`,
	}).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {
			if (nohp == '-' || nohp == '' || nohp == ' ' || nohp == undefined) {
				Swal.fire('No HP pasien kosong', '', 'error');
			} else {
				$.ajax({
					type: 'POST',
					url: baseurl + "msg/waba/t_hasil_penunjang",
					data: {
						jns_penunjang: jns_penunjang,
						nopnj: nopnj,
						noreg: noreg,
						nomr: nomr,
						nohp: nohp,
						pasienname: pasienname
					},
					dataType: 'json',
					beforeSend: function () {
						Swal.fire({
							title: 'Pengiriman dalam proses',
							html: 'Please wait ...',
							showConfirmButton: false,
							allowOutsideClick: false,
							willOpen: () => {
								Swal.showLoading()
							}
						})
					},
					success: function (json) {
						// console.log(json);
						if (json.status == 'R') {
							Swal.hideLoading();
							if (json.limit == 'Y') {
								Swal.fire({
									icon: 'info',
									title: 'Oops! Limit harian tercapai ...',
									text: 'Mohon maaf saat ini layanan ini telah mencapai limit pengiriman. Silahkan coba kembali besok, Terimakasih'
								});
							} else {
								Swal.fire('Pengiriman Sukses!', '', 'success');
							}
						} else if (json.status == 'M' || json.status == 'D') {
							Swal.hideLoading();
							Swal.fire({
								icon: 'info',
								title: 'Oops! Sorry ...',
								text: 'Layanan ini dalam perbaikan'
							});
						} else {
							Swal.hideLoading();
							Swal.fire({
								icon: 'warning',
								title: 'Warning',
								text: 'Terjadi kesalahan dalam pengiriman, silahkan coba kembali dalam beberapa menit.'
							});
						}

					},
					error: function (xhr, statusText, err) {
						Swal.hideLoading();
						Swal.fire({
							icon: 'error',
							title: 'Error '+xhr.status,
							text: 'Pengiriman gagal.'
						});
					}
				});
			}
		} else if (result.isDenied) {
			Swal.fire('Untuk saat ini pengiriman melalui google mail tidak tersedia', '', 'info')
		}
	});
});
