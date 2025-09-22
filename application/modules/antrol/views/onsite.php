<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Antrian Onsite</title>
</head>

<body>
    <div class="container mt-2">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Pasien JKN</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Pasien Non JKN</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="baru-tab" data-bs-toggle="tab" data-bs-target="#baru-tab-pane"
                    type="button" role="tab" aria-controls="baru-tab-pane" aria-selected="false">Pasien Baru</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                tabindex="0">
                <form id="formjkn">
                    <div class="form-group">
                        <label for="kodepoli">Kode Poli</label>
                        <select class="form-control" id="kodepoli" name="kodepoli" onchange="cekdokter(this.value)">
                            <option>--Silahkan Pilih Poliklinik--</option>
                            <!-- Add more options here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomorkartu">Nomor Kartu</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nomorkartu" id="nomorkartu" >
                            <button class="btn btn-primary" type="button" onclick="cekpasien()">Cek Pasien</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="norm">NORM</label>
                        <input type="text" class="form-control" id="norm" name="norm">
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik">
                    </div>
                    <div class="form-group">
                        <label for="nohp">No HP</label>
                        <input type="text" class="form-control" id="nohp" name="nohp">
                    </div>
                    <!-- <div class="form-group">
                        <label for="tanggalperiksa">Tanggal Periksa</label>
                        <input type="date" class="form-control" id="tanggalperiksa" >
                    </div> -->
                    <div class="form-group">
                        <label for="kodedokter">Kode Dokter</label>
                        <select class="form-control" id="kodedokter" onchange="parsingjampraktek(this.value)" name="kodedokter">
                            <option value="">--Silahkan Pilih Dokter--</option>
                            <!-- Add more options here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jampraktek">Jam Praktek</label>
                        <select class="form-control" id="jampraktek" name="jampraktek">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jeniskunjungan">Jenis Kunjungan</label>
                        <select class="form-control" id="jeniskunjungan" name="jeniskunjungan">
                            <option value="">--Silahkan Pilih Jenis Kunjungan--</option>
                            <option value="1">Rujukan FKTP</option>
                            <option value="2">Rujukan Internal</option>
                            <option value="3">Kontrol</option>
                            <option value="4">Rujukan RS</option>
                            <!-- Add more options here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomorreferensi">Nomor Referensi</label>
                        <input type="text" class="form-control" id="nomorreferensi" name="nomorreferensi">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitform()">Submit</button>
                </form>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <form id="formnonjkn">
                    <div class="form-group">
                        <label for="kodepoli">Kode Poli</label>
                        <select class="form-control" id="kodepolinonjkn" name="kodepoli" onchange="cekdokternonjkn(this.value)">
                            <option>--Silahkan Pilih Poliklinik--</option>
                            <!-- Add more options here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="norm">NORM</label>
                        <input type="text" class="form-control" id="normnonjkn" name="norm">
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="niknonjkn" name="nik">
                    </div>
                    <div class="form-group">
                        <label for="nohp">No HP</label>
                        <input type="text" class="form-control" id="nohpnonjkn" name="nohp">
                    </div>
                    <div class="form-group">
                        <label for="kodedokter">Kode Dokter</label>
                        <select class="form-control" id="kodedokternonjkn" onchange="parsingjamprakteknonjkn(this.value)" name="kodedokter">
                            <option value="">--Silahkan Pilih Dokter--</option>
                            <!-- Add more options here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jampraktek">Jam Praktek</label>
                        <select class="form-control" id="jamprakteknonjkn" name="jampraktek">
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitformnonjkn()">Submit</button>
                </form>
            </div>
            <div class="tab-pane fade" id="baru-tab-pane" role="tabpanel" aria-labelledby="baru-tab" tabindex="0">
                <form id="formpasienbaru">
                    <div class="form-group col-md-6">
                        <label for="jenispasien">Jenis Pasien</label>
                        <select class="form-control" id="jenispasien" name="jenispasien" required>
                            <option value="1" selected>JKN</option>
                            <option value="">Non-JKN</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nomorkartu">Nomor Kartu</label>
                            <input type="text" class="form-control" id="nomorkartu" name="nomorkartu" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nomorkk">Nomor KK</label>
                            <input type="text" class="form-control" id="nomorkk" name="nomorkk" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jeniskelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jeniskelamin" name="jeniskelamin" required>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggallahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggallahir" name="tanggallahir" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nohp">Nomor HP</label>
                            <input type="text" class="form-control" id="nohp" name="nohp" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="kodeprop">Propinsi</label>
                            <select class="form-control" id="kodeprop" name="kodeprop" onchange="pilihKabupaten(this.value.split('@')[0])"></select>
                        </div>
                        <!-- <div class="form-group col-md-4">
                            <label for="namaprop">Nama Propinsi</label>
                            <input type="text" class="form-control" id="namaprop" name="namaprop" required>
                        </div> -->
                        <div class="form-group col-md-4">
                            <label for="kodedati2">Kabupaten / Kota</label>
                            <select class="form-control" id="kodedati2" name="kodedati2" onchange="pilihKecamatan(this.value.split('@')[0])"></select>
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- <div class="form-group col-md-4">
                            <label for="namadati2">Nama Dati 2</label>
                            <input type="text" class="form-control" id="namadati2" name="namadati2" required>
                        </div> -->
                        <div class="form-group col-md-4">
                            <label for="kodekec">Kecamatan</label>
                            <select class="form-control" id="kodekec" name="kodekec" ></select>
                        </div>
                        <!-- <div class="form-group col-md-4">
                            <label for="namakec">Nama Kecamatan</label>
                            <input type="text" class="form-control" id="namakec" name="namakec" required>
                        </div> -->
                    </div>

                    <div class="form-row">
                        <!-- <div class="form-group col-md-4">
                            <label for="kodekel">Kelurahan</label>
                            <select class="form-control" id="kodekel" name="kodekel"></select>
                        </div> -->
                        <!-- <div class="form-group col-md-4">
                            <label for="namakel">Nama Kelurahan</label>
                            <input type="text" class="form-control" id="namakel" name="namakel" required>
                        </div> -->
                        <div class="form-group col-md-2">
                            <label for="rw">RW</label>
                            <input type="text" class="form-control" id="rw" name="rw" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="rt">RT</label>
                            <input type="text" class="form-control" id="rt" name="rt" required>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="submitformPasienBaru()">Submit</button>
                </form>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(function(){
            get_poliklinik();
            get_provinsi_bpjs();

            // disable function
            $("#norm").attr('disabled',true);
            $("#nik").attr('disabled',true);
            $("#nohp").attr('disabled',true);
            $("#kodedokter").attr('disabled',true);
            $("#jampraktek").attr('disabled',true);
            $("#jeniskunjungan").attr('disabled',true);
            $("#nomorreferensi").attr('disabled',true);
        })

        function submitformPasienBaru()
        {
            let data = $("#formpasienbaru").serialize();
            // console.log(data);
            $.ajax({
                url: '<?= base_url() ?>/antrol/pasienbaru',
                method: 'POST', // Adjust the method as needed
                data: data,
                success: function (response) {
                    // console.log(response);
                    if(response.metadata.code == 200){
                        Swal.fire({
                            title: "Berhasil",
                            text: `Pendaftaran Berhasil dengan kode norm: ${response.response.norm}`,
                            icon: "success"
                        });
                    //     $('#nik').val(response.response.nik);
                    //     $('#nohp').val(response.response.nohp);
                    //     // $('#kodepoli').val(response.response.kodepoli);
                    //     $('#norm').val(response.response.norm == null?'00000000':response.response.norm);
                    //     $('#tanggalperiksa').val(response.response.tanggalperiksa);
                    //     $('#jeniskunjungan').val(response.response.jeniskunjungan);
                    //     $('#nomorreferensi').val(response.response.nomorreferensi);
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: response.metadata.message,
                            icon: "error"
                        });
                    }
                    // if(response.metaData.code == 200){
                    //     $('#nik').val(response.response.nik);
                    //     $('#nohp').val(response.response.nohp);
                    //     // $('#kodepoli').val(response.response.kodepoli);
                    //     $('#norm').val(response.response.norm == null?'00000000':response.response.norm);
                    //     $('#tanggalperiksa').val(response.response.tanggalperiksa);
                    //     $('#jeniskunjungan').val(response.response.jeniskunjungan);
                    //     $('#nomorreferensi').val(response.response.nomorreferensi);
                    // }
                    // Update other fields based on the response
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }

        function get_provinsi_bpjs()
        {
            $.ajax({
				type: "GET",
				url: '<?= base_url('bpjs/referensi/provinsi') ?>',
				beforeSend: function() {
					$('#kodeprop').append('<option selected>Silahkan Ditunggu....</option>');

				},
				success: function(success) {
					if (success.response.list === undefined) {
						$('#kodeprop').empty().append('<option selected>Silahkan Kontak Admin IT</option>');
						return;
					}
					var html = `<option value="" selected>-- Silahkan Pilih Provinsi --</option>`;
					success.response.list.map((val) => {
						html += `
						<option value="${val.kode}@${val.nama}">${val.nama}</option>
					`;
					})
					$('#kodeprop').empty().append(html);
					return;
				},
				error: function(error) {
					$('#kll_provinsi').empty().append('<option selected>Silahkan Kontak Admin IT</option>');
					return;
				},
			});
        }

        function pilihKecamatan(value) {
            $.ajax({
                type: "GET",
                url: '<?= base_url('bpjs/referensi/kecamatan?kabupaten=') ?>' + value,
                success: function(success) {
                    if (success.response.list === undefined) {
                        $('#kodekec').attr('placeholder', 'Gagal Mengambil Data , silahkan masukan kode secara manual');
                        return;
                    }
                    var html = `<option value="" selected>-- Silahkan Pilih Kecamatan --</option>`;
                    success.response.list.map((val) => {
                        html += `
                        <option value="${val.kode}@${val.nama}">${val.nama}</option>
                    `;
                    })
                    $('#kodekec').html(html);
                    return;
                },
                error: function(error) {
                    $('#kodekec').attr('placeholder', 'Gagal Mengambil Data , silahkan masukan kode secara manual');
                    return;
                }
            });
        }

        // function pilihKelurahan(value) {
        //     $.ajax({
        //         type: "GET",
        //         url: '<?= base_url('bpjs/referensi/kelurahan?kecamatan=') ?>' + value,
        //         success: function(success) {
        //             if (success.response.list === undefined) {
        //                 $('#kodekel').attr('placeholder', 'Gagal Mengambil Data , silahkan masukan kode secara manual');
        //                 return;
        //             }
        //             var html = `<option value="" selected>-- Silahkan Pilih Kecamatan --</option>`;
        //             success.response.list.map((val) => {
        //                 html += `
        //                 <option value="${val.kode}@${val.nama}">${val.nama}</option>
        //             `;
        //             })
        //             $('#kodekel').html(html);
        //             return;
        //         },
        //         error: function(error) {
        //             $('#kodekel').attr('placeholder', 'Gagal Mengambil Data , silahkan masukan kode secara manual');
        //             return;
        //         }
        //     });
        // }

	function pilihKabupaten(value) {
		$.ajax({
			type: "GET",
			url: '<?= base_url('bpjs/referensi/kabupaten?provinsi=') ?>' + value,
			success: function(success) {
				if (success.response.list === undefined) {
					$('#kodedati2').attr('placeholder', 'Gagal Mengambil Data , silahkan masukan kode secara manual');
					return;
				}
				var html = `<option value="" selected>-- Silahkan Pilih Kabupaten --</option>`;
				success.response.list.map((val) => {
					html += `
					<option value="${val.kode}@${val.nama}">${val.nama}</option>
				`;
				})
				$('#kodedati2').html(html);
				return;
			},
			error: function(error) {
				$('#kodedati2').attr('placeholder', 'Gagal Mengambil Data , silahkan masukan kode secara manual');
				return;
			}
		});
	}


        function submitformnonjkn()
        {
            let data = $("#formnonjkn").serialize();
            $.ajax({
                url: '<?= base_url() ?>/antrol/onsite?submit=1&nonjkn=1',
                method: 'POST', // Adjust the method as needed
                data: data,
                success: function (response) {
                    console.log(response);
                    if(response.metaData.code == 200){
                        Swal.fire({
                            title: "Berhasil",
                            text: `Pendaftaran Berhasil dengan kode booking: ${response.response.kodebooking}`,
                            icon: "success"
                        });
                    //     $('#nik').val(response.response.nik);
                    //     $('#nohp').val(response.response.nohp);
                    //     // $('#kodepoli').val(response.response.kodepoli);
                    //     $('#norm').val(response.response.norm == null?'00000000':response.response.norm);
                    //     $('#tanggalperiksa').val(response.response.tanggalperiksa);
                    //     $('#jeniskunjungan').val(response.response.jeniskunjungan);
                    //     $('#nomorreferensi').val(response.response.nomorreferensi);
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: response.metaData.message,
                            icon: "error"
                        });
                    }
                    // console.log(response);
                    // if(response.metaData.code == 200){
                    //     $('#nik').val(response.response.nik);
                    //     $('#nohp').val(response.response.nohp);
                    //     // $('#kodepoli').val(response.response.kodepoli);
                    //     $('#norm').val(response.response.norm == null?'00000000':response.response.norm);
                    //     $('#tanggalperiksa').val(response.response.tanggalperiksa);
                    //     $('#jeniskunjungan').val(response.response.jeniskunjungan);
                    //     $('#nomorreferensi').val(response.response.nomorreferensi);
                    // }
                    // Update other fields based on the response
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }

        function submitform()
        {
            let data = $("#formjkn").serialize();
            $.ajax({
                url: '<?= base_url() ?>/antrol/onsite?submit=1',
                method: 'POST', // Adjust the method as needed
                data: data,
                success: function (response) {
                    // console.log(response);
                    if(response.metaData.code == 200){
                        var noref = $("#nomorreferensi").val();
                        var jeniskunj = $("#jeniskunjungan").find(":selected").val();
                        if(jeniskunj === '3' && noref === ''){
                            Swal.fire({
                                title: "Peringatan",
                                text: `Harap Ke admisi untuk pembuatan surat kontrol dengan kode booking : ${response.response.kodebooking}`,
                                icon: "error"
                            });
                        }else{
                            Swal.fire({
                                title: "Berhasil",
                                text: `Pendaftaran Berhasil dengan kode booking: ${response.response.kodebooking}`,
                                icon: "success"
                            });
                        }
                       
                    //     $('#nik').val(response.response.nik);
                    //     $('#nohp').val(response.response.nohp);
                    //     // $('#kodepoli').val(response.response.kodepoli);
                    //     $('#norm').val(response.response.norm == null?'00000000':response.response.norm);
                    //     $('#tanggalperiksa').val(response.response.tanggalperiksa);
                    //     $('#jeniskunjungan').val(response.response.jeniskunjungan);
                    //     $('#nomorreferensi').val(response.response.nomorreferensi);
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: response.metaData.message,
                            icon: "error"
                        });
                    }
                    // Update other fields based on the response
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });

        }

        function parsingjamprakteknonjkn(val)
        {
            let jam = val.split('@');
            let html = '';
            if(jam!='' || jam != null){
                html+=`<option value="${jam[1]}">${jam[1]}</option>`;
            }
            $("#jamprakteknonjkn").html(html)
        }
        function parsingjampraktek(val)
        {
            let jam = val.split('@');
            let html = '';
            if(jam!='' || jam != null){
                html+=`<option value="${jam[1]}">${jam[1]}</option>`;
            }
            $("#jampraktek").html(html)
        }
    
        function get_poliklinik()
        {
            $.ajax({
                url: '<?= base_url() ?>/antrol/onsite?cekpoliklinik=1',
                method: 'POST', 
                success: function (response) {
                    if(response.metaData.code == 200){
                        let html = '<option value="" selected>--Silahkan Pilih Poliklinik--</option>';
                        response.response.map((e)=>{
                            html+=`
                            <option value="${e.poli_bpjs}">${e.nm_poli}</option>  
                            `;
                        })
                        $("#kodepoli").html(html);
                        $("#kodepolinonjkn").html(html);
                    }
                    // Update other fields based on the response
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }

        function cekdokternonjkn(val)
        {
            $.ajax({
                url: '<?= base_url() ?>/antrol/onsite?cekdokter=1&val='+val,
                method: 'POST', 
                success: function (response) {
                    if(response.metadata.code == 200){
                        let html = '<option value="" selected>--Silahkan Pilih Dokter--</option>';
                        response.response.map((e)=>{
                            html+=`
                            <option value="${e.kodedokter}@${e.jadwal}">${e.namadokter} (Jadwal : ${e.jadwal})</option>  
                            `;
                        })
                        $("#kodedokternonjkn").html(html);
                    }
                    // Update other fields based on the response
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }

        function cekdokter(val)
        {
            $.ajax({
                url: '<?= base_url() ?>/antrol/onsite?cekdokter=1&val='+val,
                method: 'POST', 
                success: function (response) {
                    if(response.metadata.code == 200){
                        let html = '<option value="" selected>--Silahkan Pilih Dokter--</option>';
                        response.response.map((e)=>{
                            html+=`
                            <option value="${e.kodedokter}@${e.jadwal}">${e.namadokter} (Jadwal : ${e.jadwal})</option>  
                            `;
                        })
                        $("#kodedokter").html(html);
                    }
                    // Update other fields based on the response
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }

        function cekpasien()
        {
            let nomorkartu = $('#nomorkartu').val();
            $.ajax({
                url: '<?= base_url() ?>/antrol/onsite?ceknokartu=1',
                method: 'POST', // Adjust the method as needed
                data: { nomorkartu: nomorkartu,kodepoli:$("#kodepoli").val() },
                success: function (response) {
                    // console.log(response);
                    if(response.metaData.code == 200){
                        $('#nik').val(response.response.nik);
                        $('#nohp').val(response.response.nohp);
                        // $('#kodepoli').val(response.response.kodepoli);
                        $('#norm').val(response.response.norm == null?'00000000':response.response.norm);
                        $('#tanggalperiksa').val(response.response.tanggalperiksa);
                        $('#jeniskunjungan').val(response.response.jeniskunjungan);
                        $('#nomorreferensi').val(response.response.nomorreferensi);
                        $("#norm").attr('disabled',false);
                        $("#nik").attr('disabled',false);
                        $("#nohp").attr('disabled',false);
                        $("#kodedokter").attr('disabled',false);
                        $("#jampraktek").attr('disabled',false);
                        $("#jeniskunjungan").attr('disabled',false);
                        $("#nomorreferensi").attr('disabled',false);
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: response.metaData.message,
                            icon: "error"
                        });
                    }
                    // Update other fields based on the response
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }
    </script>
</body>

</html>