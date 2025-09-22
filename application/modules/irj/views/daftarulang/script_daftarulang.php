<script>
    function isjamkordat(val) {
        if (val == '1') {
            $('#rujukjamkordat').show();
            $('#ppkrujukjarkomdat').show();
            $('.faskesjamkordat').show();
            return;
        }
        $('#rujukjamkordat').hide();
        $('#ppkrujukjarkomdat').show();
    }

    function gantifaskestingkat(val) {
        $('#asalrujukan').val(val);
        if (val == '1') {
            $('#ppkrujukjarkomdat').select2({
                placeholder: 'Ketik kode atau nama PPK Faskes 1',
                minimumInputLength: 1,
                language: {
                    inputTooShort: function(args) {
                        return "Ketik kode atau nama PPK Faskes 1";
                    },
                    noResults: function() {
                        return "PPK tidak ditemukan.";
                    },
                    searching: function() {
                        return "Sedang Dicari.....";
                    }
                },
                ajax: {
                    type: 'GET',
                    url: '<?php echo base_url() . 'bpjs/rujukan/ppa_rujukan_nama?kodefaskes='; ?>' + val,
                    dataType: 'JSON',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
            return;
        }
        $('#ppkrujukjarkomdat').select2({
            placeholder: 'Ketik kode atau nama PPK Faskes 2',
            minimumInputLength: 1,
            language: {
                inputTooShort: function(args) {
                    return "Ketik kode atau nama PPK Faskes 2";
                },
                noResults: function() {
                    return "PPK tidak ditemukan.";
                },
                searching: function() {
                    return "Sedang Dicari.....";
                }
            },
            ajax: {
                type: 'GET',
                url: '<?php echo base_url() . 'bpjs/rujukan/ppa_rujukan_nama?kodefaskes='; ?>' + val,
                dataType: 'JSON',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }

    function isinamafaskes(val) {
        $('#namafaskes').val(val.split('@')[1]);
        ambilriwayatsep($('#no_bpjs').val(), 0);

    }


    function cek_no_rujukan(norujukan) {
        let type = $('input[name="cara_kunj"]:checked').val();
        $.ajax({
            url: '<?= base_url('bpjs/rujukan/cari_rujukan?pencarian=rujukan') ?>' + `&nomor=${norujukan}` + (type === 'RUJUKAN RS' ? `&type=RS` : ''),
            beforeSend: function() {
                $("#btn-rujukan").prop('disabled', true);
                $("#btn-rujukan").html('Loading....');

            },
            success: function(data) {
                if (data.metaData.code === '200') {
                    $('#rujukan_nomor').html(data.response.rujukan.noKunjungan);
                    $('#rujukan_tgl').html(data.response.rujukan.tglKunjungan);
                    $('#rujukan_faskes').html(data.response.rujukan.provPerujuk.nama);
                    $('#rujukan_poli').html(data.response.rujukan.poliRujukan.nama);
                    $('#rujukan_nama').html(data.response.rujukan.peserta.nama);
                    $('#rujukan_noka').html(data.response.rujukan.peserta.noKartu);
                    $('#rujukan_diagnosa').html(data.response.rujukan.diagnosa.nama);
                    $('#rujukan_gender').html(data.response.rujukan.peserta.sex);
                    $('#rujukan_jenis_rawat').html(data.response.rujukan.pelayanan.nama);
                    $('.modal_norujukan').modal('show');

                } else {
                    swal("Peringatan!", data.metaData.message, "warning");
                }
            },
            error: function(xhr) {
                swal("Peringatan!", 'Hubungi Admin IT', "warning");

            },
            complete: function() {
                $("#btn-rujukan").prop('disabled', false);
                $("#btn-rujukan").html('Lihat Rujukan');
            }
        });
    }

    function parsingnorujukannew(data,type)
    {
        Swal.fire({
            title: "Nomor Rujukan berbeda dengan Surat kontrol, Beralih Nomor Rujukan?",
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: "Ya, Ganti Rujukan",
            icon: "warning",
            cancelButtonText: `Tidak`
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href="<?= base_url('irj/rjcregistrasi/daftarulangnew/'.$no_medrec) ?>"
            } else if (result.isDenied) {
            }
        });
    }


    function parsingnorujukan(data, type) {
        if (type == 3) {
            $('#no_rujukan').val(data.no_sep);
            var datanya = {
                id: data.diagawal + '@' + data.diagawal,
                text: data.diagawal + '-' + data.diagawal
            }
            var newOption = new Option(datanya.text, datanya.id, false, false);
            $('#diagnosa').append(newOption).trigger('change');
            $('#kelasrawat').val(data.kelasrawat);
            $('#asalrujukan').val(data.asalrujukan);
            $('#tglrujukan').val(data.tglrujukan);
            $('#ppkrujukan').val(data.ppkrujukan);
            ambilriwayatsep(data.no_kartu, 1);
            $('.modal_list_rujukan').modal('hide');
            return;
        }
        $('#no_rujukan').val(data.noKunjungan);
        ambilJumlahSep(data.noKunjungan, type);

        var datanya = {
            id: data.diagnosa.kode + '@' + data.diagnosa.nama,
            text: data.diagnosa.kode + '-' + data.diagnosa.nama
        }
        var newOption = new Option(datanya.text, datanya.id, false, false);
        // console.log(data.asalFaskes);
        $('#diagnosa').append(newOption).trigger('change');
        $('#kelasrawat').val(data.peserta.hakKelas.kode);

        // asal rujukan jika dari list rujukan maka ambil dari cara kunjungan
        if (data.asalFaskes == undefined) {
            // console.log(type);
            $('#asalrujukan').val(type);
        } else {
            $('#asalrujukan').val(data.asalFaskes);
        }
        $('#tglrujukan').val(data.tglKunjungan);
        $('#ppkrujukan').val(data.provPerujuk.kode);
        ambilriwayatsep(data.noKunjungan);
        $('.modal_list_rujukan').modal('hide');
        caripoliberdasarbpjs(data.poliRujukan.kode);
        // console.log(data);
        return;
    }

    function lihatlistrujukannew(no_bpjs,type,id){
        if (type == 3) {
            $.ajax({
                url: '<?= base_url("irj/rjcregistrasi/bpjs_sep/") ?>' + '/' + no_bpjs + '/1',
                beforeSend: function() {
                    $('#' + id).html('Silahkan Ditunggu..');
                },
                success: function(data) {
                    let html = '<table class="table table-hover">';
                    index = 1;
                    if (data.length > 0) {
                        html += `<tr><th>No.</th><th>No. Rujukan</th><th>Poli Tujuan</th><th>Aksi</th></tr>`;
                        data.map((e) => {
                            html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.no_sep}</td>
                            <td>Rawat Inap</td>
                            <td>
                            <button type="button" class="btn btn-primary" onclick='parsingnorujukannew(${JSON.stringify(e)},${type})'>Pilih</button>
                            </td>
                        </tr>
                        `;
                            index++;
                        })
                    }
                    html += '</table>';
                    $("#" + id).html(html);
                },
                error: function(xhr) {},
                complete: function() {

                }
            });
            return;
        }
        $.ajax({
            url: '<?= base_url('bpjs/rujukan/cari_rujukan?pencarian=kartu&multi=1') ?>' + `&nomor=${no_bpjs}` + (type == 2 ? `&type=RS` : ''),
            beforeSend: function() {
                $('#' + id).html('Silahkan Ditunggu..');
            },
            success: function(data) {
                let html = '<table class="table table-hover">';
                if (data.metaData.code === '200') {
                    html += `<tr><th>No.</th><th>No. Rujukan</th><th>Tanggal Terbit</th><th>Poli Tujuan</th><th>Aksi</th></tr>`;
                    let index = 1;
                    data.response.rujukan.map((e) => {
                        html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.noKunjungan}</td>
                            <td>${e.tglKunjungan}</td>
                            <td>${e.poliRujukan.nama}</td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick='parsingnorujukannew(${JSON.stringify(e)},${type})'>Pilih</button>
                            </td>
                        </tr>
                        `;
                        index++;
                    })
                } else {
                    html += `
                    <tr>
                        <td colspan="4">Data Tidak Tersedia</td>
                    </tr>
                    `;
                }
                html += '</table>';
                $('#' + id).html(html);
            },
            error: function(xhr) {
                swal("Peringatan!", 'Hubungi Admin IT', "warning");

            },
            complete: function() {

            }
        });
    }

    function lihatlistrujukan(no_bpjs, type, id) {
        if (type == 3) {
            $.ajax({
                url: '<?= base_url("irj/rjcregistrasi/bpjs_sep/") ?>' + '/' + no_bpjs + '/1',
                beforeSend: function() {
                    $('#' + id).html('Silahkan Ditunggu..');
                },
                success: function(data) {
                    let html = '<table class="table table-hover">';
                    index = 1;
                    if (data.length > 0) {
                        html += `<tr><th>No.</th><th>No. Rujukan</th><th>Poli Tujuan</th><th>Aksi</th></tr>`;
                        data.map((e) => {
                            html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.no_sep}</td>
                            <td>Rawat Inap</td>
                            <td>
                            <button type="button" class="btn btn-primary" onclick='parsingnorujukan(${JSON.stringify(e)},${type})'>Pilih</button>
                            </td>
                        </tr>
                        `;
                            index++;
                        })
                    }
                    html += '</table>';
                    $("#" + id).html(html);
                },
                error: function(xhr) {},
                complete: function() {

                }
            });
            return;
        }
        $.ajax({
            url: '<?= base_url('bpjs/rujukan/cari_rujukan?pencarian=kartu&multi=1') ?>' + `&nomor=${no_bpjs}` + (type == 2 ? `&type=RS` : ''),
            beforeSend: function() {
                $('#' + id).html('Silahkan Ditunggu..');
            },
            success: function(data) {
                let html = '<table class="table table-hover">';
                if (data.metaData.code === '200') {
                    html += `<tr><th>No.</th><th>No. Rujukan</th><th>Tanggal Terbit</th><th>Poli Tujuan</th><th>Aksi</th></tr>`;
                    let index = 1;
                    data.response.rujukan.map((e) => {
                        html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.noKunjungan}</td>
                            <td>${e.tglKunjungan}</td>
                            <td>${e.poliRujukan.nama}</td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick='parsingnorujukan(${JSON.stringify(e)},${type})'>Pilih</button>
                            </td>
                        </tr>
                        `;
                        index++;
                    })
                } else {
                    html += `
                    <tr>
                        <td colspan="4">Data Tidak Tersedia</td>
                    </tr>
                    `;
                }
                html += '</table>';
                $('#' + id).html(html);
            },
            error: function(xhr) {
                swal("Peringatan!", 'Hubungi Admin IT', "warning");

            },
            complete: function() {

            }
        });
    }
    $(function() {

        $("#btn-rujukan-kartu").click(function() {
            let no_bpjs = $('#no_bpjs').val();
            lihatlistrujukan(no_bpjs, 1, 'fk1');
            $('.modal_list_rujukan').modal('show');
        });

        
        $("#btn-rujukan-kartu-new").click(function() {
            let no_bpjs = $('#no_bpjs').val();
            lihatlistrujukannew(no_bpjs, 1, 'fk1');
            $('.modal_list_rujukan').modal('show');
        });

        var radiostujuanKunj = document.querySelectorAll('input[type=radio][name="tujuan_kunj"]');
        Array.prototype.forEach.call(radiostujuanKunj, function(r) {
            r.addEventListener('change', changeHandleTujuanKunj);
        });

        function changeHandleTujuanKunj(event) {
            // console.log(event);
            switch (this.value) {
                case '0':
                    $('#nosurat_skdp_sep').attr('disabled', true);
                    $('#prosedur_tidak_berkelanjutan').attr("disabled", true);
                    $('#prosedur_berkelanjutan').attr("disabled", true);
                    $('#kode_penunjang').attr("disabled", true);
                    $('#assesment_pel').attr("disabled", false);
                    get_master_poli();
                    break;
                case '1':
                    $('#nosurat_skdp_sep').attr('disabled', false);
                    $('#prosedur_tidak_berkelanjutan').attr("disabled", false);
                    $('#prosedur_berkelanjutan').attr("disabled", false);
                    $('#kode_penunjang').attr("disabled", false);
                    $('#assesment_pel').attr("disabled", true);

                    break;
                case '2':
                    $('#nosurat_skdp_sep').attr('disabled', false);
                    $('#prosedur_tidak_berkelanjutan').attr("disabled", true);
                    $('#prosedur_berkelanjutan').attr("disabled", true);
                    $('#kode_penunjang').attr("disabled", true);
                    $('#assesment_pel').attr("disabled", false);
                    break;

            }
        }

    });

    function buatsuratkontrol() {
        $.ajax({
            method: 'POST',
            type: 'JSON',
            data: {
                'sep': $('#no_sep_surat_bikin').val(),
                'dokter': $('#dpjp_suratkontrol_bikin').val().split('-')[0],
                'poli': 'A -' + $('#poli_suratkontrol_bikin').val(),
                'tglrencanakontrol': $('#tgl_surat_bikin').val(),
                'user': 'ADMIN',
                'nama_dokter': $('#dpjp_suratkontrol_bikin').val().split('-')[1]
            },
            url: '<?= base_url('bpjs/rencanakontrol/insert_surat_kontrol') ?>',
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if (data.metaData.code === '200') {
                    $('#no_surat_kontrol_skdp').val(data.response.noSuratKontrol);
                    $('#dpjp_suratkontrol').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
                    $('.modal_suratkontrol').modal('hide');
                } else {
                    swal("Peringatan!", data.metaData.message, "warning");

                }
            },
            error: function(xhr) {
                swal("Peringatan!", 'Hubungi Admin IT', "warning");

            },
            complete: function() {

            }
        });
    }


    function ambildoktersuratkontrol(kodepoli) {
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/data_dokter') ?>' + `?jnskontrol=2&poli=${kodepoli}&tglrencanakontrol=${$('#tgl_surat_bikin').val()}`,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if (data.metaData.code === '200') {
                    data.response.list.map((e) => {
                        html += `<option value="${e.kodeDokter}-${e.namaDokter}">${e.namaDokter}</option>`;
                    })
                    $('#dpjp_suratkontrol_bikin').empty();
                    $('#dpjp_suratkontrol_bikin').append('<option value="">Silahkan Pilih Dokter</option>');
                    $('#dpjp_suratkontrol_bikin').append(html);
                }
            },
            error: function(xhr) {},
            complete: function() {

            }
        });
    }

    function ambilpolikontrol(tgl) {
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/data_poli') ?>' + `?jnskontrol=2&nomor=${$('#no_sep_surat_bikin').val()}&tglrencanakontrol=${tgl}`,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if (data.metaData.code === '200') {
                    data.response.list.map((e) => {
                        html += `<option value="${e.kodePoli}">${e.namaPoli}</option>`;
                    })
                    $('#poli_suratkontrol_bikin').empty();
                    $('#poli_suratkontrol_bikin').append('<option value="">Silahkan Pilih Poliklinik..</option>');
                    $('#poli_suratkontrol_bikin').append(html);
                    return;
                }
                new swal("Peringatan!", data.metaData.message, "warning");
            },
            error: function(xhr) {},
            complete: function() {

            }
        });
    }

    /**
     * Feat : baca surkon dari vclaim agar terbit di simrs.
     */

    function getsuratkontrolfromvclaim(noka)
    {
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/getrencanakontrolbyvclaim') ?>' + '/' + noka ,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code !== '200'){
                    swal("Peringatan", data.metaData.message, "warning");
                    return;
                }
                data.response.list.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.noSuratKontrol}</td>
                        <td>${e.tglRencanaKontrol}</td>
                        <td>${e.noSepAsalKontrol}</td>
                        <td>${e.namaDokter}</td>
                        <td>${e.terbitSEP}</td>
                        <td>
                            <button
                            onclick='pilihsuratkontrol(${JSON.stringify(e)})'
                            type="button" class="btn btn-primary"
                            ${e.terbitSEP == 'Belum'?'':'disabled'}
                            >
                            Pilih</button>
                        </td>
                    </tr>
                    `;
                });
                $("#listsuratkontrol").html(html);
                $(".modal_pilihsuratkontrol").modal('show');
            },
            error: function(xhr) {},
            complete: function() {

            }
        });
    }

    function pilihsuratkontrol(data)
    {
        if (data) {
            $('#no_surat_kontrol_skdp').val(data.noSuratKontrol);
            $('#dpjp_suratkontrol').html(`<option value="${data.kodeDokter}" selected>${data.namaDokter}</option>`)
            $('#dokter_bpjs').html(`<option value="${data.kodeDokter}-${data.namaDokter}" selected>${data.namaDokter}</option>`)
            // $('#dokter_bpjs').attr("style", "pointer-events: none;width:100%;");
            // $('#dokter_bpjs').attr("tabindex", "-1");
            $('.modal_pilihsuratkontrol').modal('hide');
        }
    }

    function parsingsepsuratkontrol(no_sep) {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/cek_surat_kontrol_exist') ?>' + '/' + no_sep,
            beforeSend: function() {

            },
            success: function(data) {
                if (data) {
                    $('#no_surat_kontrol_skdp').val(data.surat_kontrol);
                    $('#dpjp_suratkontrol').html(`<option value="${data.dokter_bpjs}" selected>${data.nama_dokter_bpjs}</option>`)
                    $('#dokter_bpjs').html(`<option value="${data.dokter_bpjs}-${data.nama_dokter_bpjs}" selected>${data.nama_dokter_bpjs}</option>`)
                    // $('#dokter_bpjs').attr("style", "pointer-events: none;width:100%;");
                    // $('#dokter_bpjs').attr("tabindex", "-1");
                    $('.modal_suratkontrol').modal('hide');
                } else {
                    $('#no_sep_surat_bikin').val(no_sep);
                }

            },
            error: function(xhr) {},
            complete: function() {

            }
        });
    }

    function ambilriwayatsep(no_rujukan, type = 0) {
        console.log(no_rujukan);
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/bpjs_sep/') ?>' + '/' + no_rujukan + (type ? '/1' : ''),
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                index = 1;
                if (data.length > 0) {
                    data.map((e) => {
                        var datetimeString = e.tgl_sep;
                        var date = new Date(datetimeString);

                        var day = date.getDate();
                        var month = date.getMonth() + 1; // Months are zero-based, so we add 1.
                        var year = date.getFullYear();

                        var formattedDate = `${day}/${month}/${year}`;

                        html += `
                        <tr>
                            <td>${index}</td>
                            <td>${e.no_sep}</td>
                            <td>${formattedDate}</td>
                            <td>${e.politujuan}</td>
                            <td>
                            <button class="btn btn-xs btn-primary" onclick="parsingsepsuratkontrol('${e.no_sep}')">Gunakan SEP</button>
                            </td>
                        </tr>
                        `;
                        index++;
                    })
                    $("#listsep").append(html);
                }
            },
            error: function(xhr) {},
            complete: function() {

            }
        });
    }

    function handleCaraKunj(v)
    {
        console.log(v);
        console.log($("#cara_bayar").val());
        console.log("SADASDASD");
        if ($("#cara_bayar").val() == 'BPJS') {

            switch (v) {
                case 'DATANG SENDIRI':
                    $('.jamkordatbukan').show();
                    $('#tglrujukan').val('<?= date('Y-m-d') ?>');
                    $('#rujukjamkordat').show();
                    $('#ppkrujukjarkomdat').show();
                    // $('#ppkrujukan').val();

                    $('.div_bpjs_thp2').show();
                    $('.div_bpjs_thp').show();
                    break;
                case 'RUJUKAN PUSKESMAS':
                    console.log("MASUK SINI")
                    $('.jamkordatbukan').hide();
                    $('#rujukjamkordat').hide();
                    $('#ppkrujukjarkomdat').hide();
                    $('.div_bpjs_thp2').hide();
                    $('.div_bpjs_thp').show();
                    ambilRujukan();
                    break;
                case 'DIKIRIM DOKTER':
                    $('.jamkordatbukan').hide();

                    $('#rujukjamkordat').hide();
                    $('#ppkrujukjarkomdat').hide();
                    $('.div_bpjs_thp2').hide();
                    $('.div_bpjs_thp').hide();
                    break;
                case 'RUJUKAN RS':
                    $('.jamkordatbukan').hide();
                    $('#rujukjamkordat').hide();
                    $('#ppkrujukjarkomdat').hide();
                    $('.div_bpjs_thp2').hide();
                    $('.div_bpjs_thp').show();
                    ambilRujukan('RS');

                    break;
            }
        }
    }


    $(document).ready(function() {
        $(".select2").select2();

        $('.faskesjamkordat').hide();
        $('.jamkordatbukan').hide();
        $('#rujukjamkordat').hide();
        $('#ppkrujukjarkomdat').hide();


        $('#div_katarak').hide();

        $('#btn-suratkontrol').click(function() {
            $('.modal_suratkontrol').modal('show');
            // $("#listsep").

        });

        $('.autocomplete_diagnosa').select2({
            placeholder: 'Ketik kode atau nama diagnosa',
            minimumInputLength: 1,
            language: {
                inputTooShort: function(args) {
                    return "Ketik kode atau nama diagnosa";
                },
                noResults: function() {
                    return "Diagnosa tidak ditemukan.";
                },
                searching: function() {
                    return "Searching.....";
                }
            },
            ajax: {
                type: 'GET',
                url: '<?php echo base_url() . 'irj/Diagnosa/select2'; ?>',
                dataType: 'JSON',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });




        $("input[name='cara_bayar']").change(function() {
            console.log(this.value);
            switch (this.value) {
                case 'BPJS':
                    get_all_kontraktor('BPJS');
                    $(".div_bpjs").show();
                    $(".div_bpjs_kerjasama").show();
                    break;
                case 'UMUM':
                    $(".div_bpjs").hide();
                    $(".div_bpjs_kerjasama").hide();

                    break;
                case 'KERJASAMA':
                    $(".div_bpjs").hide();
                    get_all_kontraktor('KERJASAMA');
                    $(".div_bpjs_kerjasama").show();
                    break;
            }
        });


        $("input[name='cara_kunj']").change(function() {
            if ($("#cara_bayar").val() == 'BPJS') {

                switch (this.value) {
                    case 'DATANG SENDIRI':
                        $('.jamkordatbukan').show();
                        $('#tglrujukan').val('<?= date('Y-m-d') ?>');
                        $('#rujukjamkordat').show();
                        $('#ppkrujukjarkomdat').show();
                        // $('#ppkrujukan').val();

                        $('.div_bpjs_thp2').show();
                        $('.div_bpjs_thp').show();
                        break;
                    case 'RUJUKAN PUSKESMAS':
                        console.log("MASUK SINI")
                        $('.jamkordatbukan').hide();
                        $('#rujukjamkordat').hide();
                        $('#ppkrujukjarkomdat').hide();
                        $('.div_bpjs_thp2').hide();
                        $('.div_bpjs_thp').show();
                        ambilRujukan();
                        break;
                    case 'DIKIRIM DOKTER':
                        $('.jamkordatbukan').hide();

                        $('#rujukjamkordat').hide();
                        $('#ppkrujukjarkomdat').hide();
                        $('.div_bpjs_thp2').hide();
                        $('.div_bpjs_thp').hide();
                        break;
                    case 'RUJUKAN RS':
                        $('.jamkordatbukan').hide();
                        $('#rujukjamkordat').hide();
                        $('#ppkrujukjarkomdat').hide();
                        $('.div_bpjs_thp2').hide();
                        $('.div_bpjs_thp').show();
                        ambilRujukan('RS');

                        break;
                }
            }
        });

        $('#id_poli').change(function() {
            var pokpoli = this.value.substr(4, 4);
            if (pokpoli == 'EKSE') {
                $("#eksekutif").prop("checked", true);
                $("#none_class").prop("checked", false);
            } else {
                $("#none_class").prop("checked", true);
                $("#eksekutif").prop("checked", false);
            }

            if (this.value.split('~')[0] == 'BH00') {
                $('#div_katarak').show();
            } else {
                $('#div_katarak').hide();
            }
            get_dokter_praktek(this.value.substr(0, 4));
            if ($("#cara_bayar").val() == 'BPJS') {
                get_dokter_bpjs(this.value.split('~')[1]);
            }
        });

        $.ajax({
            url: '<?php echo site_url('irj/rjcregistrasi/get_wilayah'); ?>',
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';

            },
            error: function(xhr) {},
            complete: function() {

            }
        });

        // $('.load_wilayah').select2({
        //     placeholder: '-- Cari Kota/Kabupaten, Kecamatan atau Kelurahan --',
        //     ajax: {
        //         url: '<?php //echo site_url('irj/rjcregistrasi/get_wilayah'); 
                            ?>',
        //         dataType: 'json',
        //         delay: 250,
        //         processResults: function(data) {
        //             var results = [];

        //             $.each(data, function(index, item) {
        //                 results.push({
        //                     id: item.id_provinsi + '@' + item.id_kota + '@' + item.id_kecamatan + '@' + item.id_kelurahan,
        //                     text: item.nm_kelurahan + ', ' + item.nm_kecamatan + ', ' + item.nm_kota + ', ' + item.nm_provinsi
        //                 });
        //             });
        //             return {
        //                 results: results
        //             };
        //         },
        //         cache: true
        //     }
        // });

    });

    function pilih_cara_bayar_kontraktor(val_cara_bayar){
        console.log(val_cara_bayar);
        if(val_cara_bayar == 'BPJS'){
            get_all_kontraktor('BPJS');
            $(".div_bpjs").show();
            $(".div_bpjs_kerjasama").show();
        }else if(val_cara_bayar == 'UMUM'){
            $(".div_bpjs").hide();
            $(".div_bpjs_kerjasama").hide();
        }else if(val_cara_bayar == 'KERJASAMA'){
            $(".div_bpjs").hide();
            get_all_kontraktor('KERJASAMA');
            $(".div_bpjs_kerjasama").show();
        }
    }


    function get_dokter_bpjs(value) {
        $.ajax({
            url: '<?= base_url('bpjs/referensi/dokter_dpjp?pelayanan=2&tglpelayanan=') ?>' + $('#tgl_kunjungan').val() + '&spesialis=' + value,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if (data.metaData.code === '200') {
                    data.response.list.map((e) => {
                        html += `<option value="${e.kode}-${e.nama}">${e.nama}</option>`;
                    })
                    $('#dokter_bpjs').empty();
                    $('#dokter_bpjs').append(html);
                }
            },
            error: function(xhr) {},
            complete: function() {

            }
        });
    }

    function get_dokter_praktek(value) {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/data_dokter_poli/') ?>' + '/' + value,
            beforeSend: function() {},
            success: function(data) {
                $('#id_dokter').empty();
                $('#id_dokter').append(data);
            },
            error: function(xhr) {},
            complete: function() {

            }
        });
    }

    function ambilJumlahSep(no_rujukan, jnsKunjungan = 1) {
        // if(jnsKunjungan == 'RS'){
        //     console.log('masuk sini');
        //     jnsKunjungan =2;
        // }

        $.ajax({
            url: '<?= base_url('bpjs/rujukan/data_jumlah_sep?jnsrujukan=') ?>' + jnsKunjungan + '&norujukan=' + no_rujukan,
            beforeSend: function() {
                $('#jml_terbit_sep').html('Sedang Mengambil Data...');

            },
            success: function(data) {
                if (data.metaData.code === '200') {
                    $('#jml_terbit_sep').html(data.response.jumlahSEP);
                    if (data.response.jumlahSEP === '0') {
                        $('#tujuan_kunj_normal').attr('checked', true);
                        // $('#tujuan_kunj_prosedur').attr("disabled", true);
                        // $('#tujuan_kunj_konsul').attr("disabled", true);
                        // $('#prosedur_tidak_berkelanjutan').attr("disabled", true);
                        // $('#prosedur_berkelanjutan').attr("disabled", true);
                        // $('#kode_penunjang').attr("disabled", true);
                        // $('#assesment_pel').attr("disabled", true);
                        // $('#no_surat_kontrol_skdp').attr('disabled', true);
                        // $('#dpjp_suratkontrol').attr('disabled', true);
                        return;
                    }
                }
            },
            error: function(xhr) { // if error occured
                $('#jml_terbit_sep').html('Gagal Mengambil Data..');

            },
            complete: function() {

            }
        });
    }



    function ambilRujukan(type = null, nobpjs = null) {
        $.ajax({
            url: '<?= base_url('bpjs/rujukan/cari_rujukan?pencarian=kartu&nomor=') ?>' + (nobpjs == null ? $('#no_bpjs').val() : nobpjs) + (type ? '&type=RS' : ''),
            beforeSend: function() {},
            success: function(data) {
                if (data.metaData.code === '200') {
                    // console.log(data);
                    $('#no_rujukan').val(data.response.rujukan.noKunjungan);
                    $('#namafaskes').val(data.response.rujukan.provPerujuk.nama);
                    ambilJumlahSep(data.response.rujukan.noKunjungan, data.response.asalFaskes);

                    var datanya = {
                        id: data.response.rujukan.diagnosa.kode + '@' + data.response.rujukan.diagnosa.nama,
                        text: data.response.rujukan.diagnosa.kode + '-' + data.response.rujukan.diagnosa.nama
                    }
                    var newOption = new Option(datanya.text, datanya.id, false, false);
                    $('#diagnosa').append(newOption).trigger('change');
                    $('#kelasrawat').val(data.response.rujukan.peserta.hakKelas.kode);
                    $('#asalrujukan').val(data.response.asalFaskes);
                    $('#tglrujukan').val(data.response.rujukan.tglKunjungan);
                    $('#ppkrujukan').val(data.response.rujukan.provPerujuk.kode);
                    ambilriwayatsep(data.response.rujukan.noKunjungan);
                    $("#prb").val(data.response.rujukan.peserta.informasi.prolanisPRB);
                    caripoliberdasarbpjs(data.response.rujukan.poliRujukan.kode);
                    // $('#id_poli').val(data.response.rujukan.poliRujukan.kode); // Select the option with a value of '1'
                    // $('#id_poli').trigger('change'); // Notify any JS components that the value changed

                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            }
        });
    }

    function caripoliberdasarbpjs(bpjs) {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/caripoliberdasarbpjs/') ?>' + '/' + bpjs,
            beforeSend: function() {
                $('#id_poli').empty().append('<option value="">Silahkan ditunggu...</option>');
                $('#id_poli').attr('disabled', true);
            },
            success: function(data) {
                let html = '<option value="" selected> Silahkan Pilih poliklinik </option>';
                data.map((e) => {
                    html += `
                        <option value="${e.id_poli}${e.nm_pokpoli}~${e.poli_bpjs}">${e.nm_poli}</option>
                    `;
                })
                $('#id_poli').empty().append(html);
            },
            error: function(xhr) { // if error occured
                $('#id_poli').empty().append('<option value="">Silahkan Kontak Admin IT</option>');
                $('#id_poli').attr('disabled', true);
            },
            complete: function() {
                $('#id_poli').attr('disabled', false);
            }
        });
    }



    function get_all_kontraktor(data) {
        console.log('masuk sini');

        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/get_all_kontraktor') ?>' + '/' + data,
            beforeSend: function() {
                $('#id_kontraktor').empty();
            },
            success: function(data) {
                var html = ``;
                data.map((e) => {
                    html += `
                    <option value="${e.id_kontraktor}">${e.nmkontraktor}</option>
                    `;
                })
                $('#id_kontraktor').append(html);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            }
        });
    }



    $(document).on("click", "#btn-bpjs-daful", function() {
        var button = $(this);
        var no_bpjs = $("#no_bpjs").val();
        button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
        if (no_bpjs == '') {
            button.html('Data Peserta');
            swal("No. Kartu Kosong", "Harap masukan nomor kartu BPJS.", "warning");
        } else {
            $.ajax({
                url: "<?php echo site_url('bpjs/peserta/cari_peserta?pencarian=nokartu&nomor='); ?>" + no_bpjs,
                dataType: "JSON",
                success: function(result) {
                    var idReplace;

                    if (result) {
                        button.html('Data Peserta');
                        if (result.metaData.code == '200') {
                            data = result.response.peserta;
                            if (data.jenisPeserta.kode === "22") {
                                idReplace = 3;
                            } else if (data.jenisPeserta.kode === '14') {
                                idReplace = 17;
                            } else {
                                idReplace = 60;
                            }
                            $('#id_kontraktor').val(idReplace).trigger('change');

                            $('.modal_nobpjs').modal('show');
                            document.getElementById("bpjs_noka").innerHTML = data.noKartu;
                            document.getElementById("bpjs_nik").innerHTML = data.nik;
                            document.getElementById("bpjs_nama").innerHTML = data.nama;
                            document.getElementById("bpjs_gender").innerHTML = data.sex;
                            document.getElementById("bpjs_tgl_lahir").innerHTML = data.tglLahir;
                            document.getElementById("bpjs_no_telepon").innerHTML = data.mr.noTelepon;
                            document.getElementById("bpjs_kdprovider").innerHTML = data.provUmum.kdProvider;
                            document.getElementById("bpjs_nmprovider").innerHTML = data.provUmum.nmProvider;
                            document.getElementById("bpjs_jnspeserta").innerHTML = data.jenisPeserta.keterangan;
                            document.getElementById("bpjs_nmkelas").innerHTML = data.hakKelas.keterangan;
                            document.getElementById("bpjs_status_keterangan").innerHTML = data.statusPeserta.keterangan;
                            document.getElementById("bpjs_cob_nama").innerHTML = data.cob.nmAsuransi;
                            document.getElementById("bpjs_cob_nomor").innerHTML = data.cob.noAsuransi;
                            document.getElementById("bpjs_cob_tat").innerHTML = data.cob.tglTAT;
                            document.getElementById("bpjs_cob_tmt").innerHTML = data.cob.tglTMT;
                            document.getElementById("bpjs_informasi_dinsos").innerHTML = data.informasi.dinsos;
                            document.getElementById("bpjs_informasi_sktm").innerHTML = data.informasi.noSKTM;
                            document.getElementById("bpjs_informasi_prb").innerHTML = data.informasi.prolanisPRB;
                            $('#prb').val(data.informasi.prolanisPRB);
                        } else {
                            swal("Gagal Data Peserta.", result.metaData.message, "error");
                        }
                    } else {
                        button.html('Data Peserta');
                        swal("Error", "Gagal Data Peserta.", "error");
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    button.html('Data Peserta');
                    swal("Error", formatErrorMessage(event, errorThrown), "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
        }
    });
</script>