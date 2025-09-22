<script>
    function validateAlamat() {
        $('#alamat2').val($('#alamats').val());
        $('#rt2').val($('#rt').val());
        $('#rw2').val($('#rw').val());
    }



    $(function() {

        $('#form_biodata').on("submit", function(e) {
            e.preventDefault();
            $("#btn-form-biodata-insert").attr('disabled', true);
            document.getElementById("btn-form-biodata-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
            $.ajax({
                url: "<?php echo base_url(); ?>irj/rjcregistrasi/update_data_pasien?returnjson=true",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    document.getElementById("form_biodata").reset();
                    swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function() {
                            window.location.reload();
                        });


                },
                error: function(event, textStatus, errorThrown) {
                    swal("Error", "Data gagal disimpan.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                },
                complete: function() {
                    $("#btn-form-biodata-insert").attr('disabled', false);
                }
            });
        });
        $('#load_wilayah').select2({
            placeholder: '-- Cari Kota/Kabupaten, Kecamatan atau Kelurahan --',
            ajax: {
                url: '<?php echo site_url('irj/rjcregistrasi/get_wilayah'); ?>',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    var results = [];

                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id_provinsi + '@' + item.id_kota + '@' + item.id_kecamatan + '@' + item.id_kelurahan,
                            text: item.nm_kelurahan + ', ' + item.nm_kecamatan + ', ' + item.nm_kota + ', ' + item.nm_provinsi
                        });
                    });
                    return {
                        results: results
                    };
                },
                cache: true
            }
        });
    })




    function cekbpjs_nokartu() {
        var button = $('#cekbtnbpjsbiodata');
        var no_bpjs = $("#no_kartu_bpjs").val();
        button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
        if (no_bpjs == '') {
            button.html('Cek Peserta BPJS');
            swal("No. Kartu Kosong", "Harap masukan nomor kartu BPJS.", "warning");
        } else {
            $.ajax({
                url: "<?php echo site_url('bpjs/peserta/cari_peserta?pencarian=nokartu&nomor='); ?>" + no_bpjs,
                dataType: "JSON",
                success: function(result) {
                    var idReplace;

                    if (result) {
                        button.html('Cek Peserta BPJS');
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
                        button.html('Cek Peserta BPJS');
                        swal("Error", "Gagal Data Peserta.", "error");
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    button.html('Cek Peserta BPJS');
                    swal("Error", formatErrorMessage(event, errorThrown), "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
        }
    }

    function cekbpjs_nik() {
        document.getElementById("btn_cek_nik").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
        no_nik = $("#no_identitas").val();
        if (no_nik == '') {
            swal("NIK Kosong", "Mohon masukkan NIK yang valid.", "warning");
            document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
        } else {
            $.ajax({
                url: "<?php echo site_url('bpjs/peserta/cari_peserta?pencarian=nik&nomor='); ?>" + no_nik,
                success: function(result) {
                    if (result) {
                        document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
                        if (result.metaData.code == '200') {
                            data = result.response.peserta;
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
                        } else {
                            swal("Gagal Cek Peserta BPJS", result.metaData.message, "error");
                        }
                    } else {
                        document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
                        swal("Error", "Gagal Cek Peserta BPJS.", "error");
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
                    swal("Gagal Cek Peserta BPJS.", textStatus, "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
                }
            });
        }
    }

    /**
     * Pengambilan Data Pasien Berdasarkan no_medrec
     */

    function data_pasien() {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/get_data_pasien_by_no_cm_baru/' . $no_medrec) ?>',
            beforeSend: function() {

            },
            success: function(data) {
                $('#cetak_kartu').val(data.no_cm);
                $('#cm_baru').val(data.no_cm);
                if (data.suku_bangsa == null || data.suku_bangsa === '') {
                    get_master_sukubangsa();

                } else {
                    $('#suku_bangsa').html(
                        `<option value="${data.suku_bangsa}" selected>${data.suku_bangsa}</option>`);
                }

                if (data.tgl_daftar) {
                    $('#tgl_daftar_pasien').val(new Date(data.tgl_daftar).toISOString().split('T')[0]);
                    let yourDate = new Date(data.tgl_daftar)
                    const offset = yourDate.getTimezoneOffset()
                    yourDate = new Date(yourDate.getTime() - (offset * 60 * 1000)).toISOString().split('T')[0];
                    if (yourDate === new Date().toISOString().split('T')[0]) {
                        $('#jnskunjbaru').prop('checked', true);
                        $("#check_cetak_kartu").prop('checked', true);
                    } else {
                        $('#jnskunjlama').prop('checked', true);

                    }
                    // if(new Date(data.tgl_daftar.toISOString()).slice(0, 10) == new Date().toISOString().slice(0, 10))
                } else {
                    $('#jnskunjlama').prop('checked', true);
                }
                $('#nama_pasien').val(data.nama);

                /**
                 * Handle JK
                 */
                if (data.sex === 'L' && data.sex !== null) {
                    $('#laki_laki').prop('checked', true);
                } else {
                    $('#perempuan').prop('checked', true);
                }
                if (data.jenis_identitas !== '' && data.jenis_identitas !== null) {
                    $('#' + data.jenis_identitas).prop('checked', true);
                }
                $('#no_identitas').val(data.no_identitas);
                $("#no_kartu_bpjs").val(data.no_kartu);
                $('#tmpt_lahirval').val(data.tmpt_lahir);

                // var dateString = data.tgl_lahir;
                // var datesekarang = Date.parse(dateString, "yyyy-MM-dd");
                // console.log(datesekarang);
                // console.log(data.tgl_lahir.splice(0, 10));
                document.getElementById("tgl_lahir_pasien").value = data.tgl_lahir.substring(0, 10);
                // $('#tgl_lahir_pasien').val(Date.parse(datesekarang,'dd/MM/yyyy'));

                if (data.agama !== '' && data.agama !== null) {
                    $('#' + data.agama).prop('checked', true);
                }

                if (data.status !== '' && data.status !== null && data.status !== ' ') {
                    $("#" + data.status).prop('checked', true);
                }

                if (data.wnegara !== '' && data.wnegara !== null) {
                    $('#' + data.wnegara).prop('checked', true);
                }

                if (data.bahasa === 'INDONESIA') {
                    $('#WNI-bahasa').prop('checked', true);
                } else if (data.bahasa === 'Daerah') {
                    $('#WNI-bahasaD').prop('checked', true);
                } else {
                    $('#lainnyaBahasa').prop('checked', true);
                    $('#bahasalainnya').val(data.bahasa);
                }

                $('#alamats').val(data.alamat);
                $('#rt').val(data.rt);
                $('#rw').val(data.rt);
                $('#alamat2').val(data.alamat2);
                $('#rt2').val(data.rt_alamat2);
                $('#rw2').val(data.rw_alamat2);

                if (data.kelurahandesa) {
                    $('#load_wilayahs').append(`<option value="${data.id_provinsi}@${data.id_kotakabupaten}@${data.id_kecamatan}@${data.id_kelurahandesa}" selected>${data.kelurahandesa}, ${data.kecamatan}, ${data.kotakabupaten}, ${data.provinsi}</option>`);
                }
                // loadWilayah();

                $("#kodepos").val(data.kodepos);
                if (data.pendidikan !== '' && data.pendidikan !== null) {
                    $("#" + data.pendidikan).prop('checked', true);
                }
                $('#no_telpval').val(data.no_telp);
                $('#no_hpval').val(data.no_hp);
                $('#no_telp_kantorval').val(data.no_telp_kantor);
                $('#nama_ayah').val(data.nama_ayah);
                $('#nama_ibu').val(data.nama_ibu);
                $("#nama_suami_istri").val(data.nama_suami_istri);

                if (data.ttd_pasien) {
                    var html = `
                    <img width="120px" src="${data.ttd_pasien}" alt="" srcset="">
                    `;
                    $('#ttdpasien').append(html);
                }


                // Daftar Ulang

                $("#no_bpjs").val(data.no_kartu.trim() ?? "");

                $("#cetak_kartu1").val(data.no_cm);
                $('#no_telpdaftar').val(data.no_hp);
                if (data.pekerjaan != null || data.pekerjaan != '') {
                    $("input[name=pekerjaan][value='" + data.pekerjaan + "']").attr('checked', 'checked');
                }
                $("#nama_suami_istri").val(data.suami_istri);

                if (data.goldarah != null || data.goldarah != '') {
                    $("input[name=goldarah][value='" + data.goldarah + "']").attr('checked', 'checked');

                    // 
                }
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            }
        });
    }



    /**
     * Cetak Kartu Pasien
     */

    function cetakkartupasien() {
        window.open("<?php echo site_url('irj/rjcregistrasi/st_cetak_kartu_pasien/') ?>" + $('#cetak_kartu').val(), "_blank");
    }

    function cetakidentitaspasien() {
        window.open("<?php echo site_url('irj/rjcregistrasi/cetak_identitas/') ?>" + $('#cetak_kartu').val(), "_blank");
    }


    /**
     * Grab Master Suku Bangsa
     */

    function get_master_sukubangsa() {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/get_master_sukubangsa') ?>',
            beforeSend: function() {

            },
            success: function(data) {
                var html = ``;
                data.map((e) => {
                    html += `
                    <option value="${e.nm_sukubangsa}">${e.nm_sukubangsa}</option>
                    `;
                })
                $('#suku_bangsa').append(html);

            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            }
        });
    }

    /**
     * Grab All Wilayah
     */

    /**
     * Grab Master Pekerjaan
     */

    function get_master_pekerjaan() {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/get_master_pekerjaan') ?>',
            beforeSend: function() {

            },
            success: function(data) {
                var html = ``;
                data.map((e) => {
                    html += `
                    <input name="pekerjaan" type="radio" onClick="validatePekerjaan()" id="${e.pekerjaan}"  class="with-gap" value="${e.pekerjaan}" />
                    <label for="${e.pekerjaan}" >${e.pekerjaan}</label>
                    `;
                })
                $('#pilih_pekerjaan').append(html);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            }
        });
    }


    /**
     * Grab Semua Poliklinik
     */

    function get_master_poli() {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/get_master_poli') ?>',
            beforeSend: function() {

            },
            success: function(data) {
                var html = ``;
                data.map((e) => {
                    html += `
                    <option value="${e.id_poli}${e.nm_pokpoli}~${e.poli_bpjs}">${e.nm_poli}</option>
                    `;
                })
                $('#id_poli').append(html);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            }
        });
    }


    /**
     * Grab Semua Poliklinik
     */

    function get_master_kecelakaan() {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/get_data_kecelakaan') ?>',
            beforeSend: function() {

            },
            success: function(data) {
                var html = ``;
                data.map((e) => {
                    html += `
                    <option value="${e.id}">${e.nm_kecelakaan}</option>
                    `;
                })
                $('#jenis_kecelakaan').append(html);
            },
            error: function(xhr) { // if error occured

            },
            complete: function() {

            }
        });
    }


    function handleTipeRujukanOnline(tiperujukan, nokartu = '') {
        // console.log(tiperujukan);
        switch (tiperujukan) {
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
                $('.jamkordatbukan').hide();
                $('#rujukjamkordat').hide();
                $('#ppkrujukjarkomdat').hide();
                $('.div_bpjs_thp2').hide();
                $('.div_bpjs_thp').show();
                ambilRujukan('', nokartu);
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
                ambilRujukan('RS', nokartu);

                break;
        }
    }

    function handleCaraBayarOnline(carabayar) {
        switch (carabayar) {
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
    }

    $(document).ready(function() {
        $(".div_bpjs").hide();
        $('.div_bpjs_kerjasama').hide();
        $(".ird").hide();
        $('.div_bpjs_igd').hide();
        $('.div_bpjs_thp').hide();
        $('.div_bpjs_thp2').hide();
        get_master_pekerjaan();
        data_pasien();

        let idpoliklinikexist = '<?= $online ? $online['poliklinik'] : '' ?>';
        let iddokterexist = '<?= $online ? $online['iddokter'] : '' ?>';
        if (idpoliklinikexist != '') {
            <?php if ($online) : ?>
                if ('<?= $online['carabayar'] ?>' == 'BPJS') {
                    handleCaraBayarOnline('BPJS');
                    get_master_poli();
                    if ('<?= $online['tiperujukan'] ?>' != 'null') {

                        if ('<?= $online['tiperujukan'] ?>' == '1') {
                            handleTipeRujukanOnline('RUJUKAN PUSKESMAS', '<?= $online['nokartu'] ?>');
                            $(`input[name=cara_kunj][value='RUJUKAN PUSKESMAS']`).prop("checked", true)
                        } else {
                            handleTipeRujukanOnline('RUJUKAN RS', '<?= $online['nokartu'] ?>');
                            $(`input[name=cara_kunj][value='RUJUKAN RS']`).prop("checked", true)
                        }
                    }

                } else {
                    handleCaraBayarOnline('<?= $online['carabayar'] ?>');
                }
            <?php endif; ?>
            var data = {
                id: idpoliklinikexist,
                text: idpoliklinikexist.split('~')[1]
            };

            var newOption = new Option(data.text, data.id, true, true);
            $('#id_poli').append(newOption).trigger('change');
            <?= $online ? ($online['carabayar'] == 'UMUM' ? '$("input[name=cara_kunj][value=\'DATANG SENDIRI\']").prop("checked",true)' : '') : ''; ?>
        } else {
            get_master_poli();
        }
        if (iddokterexist != '') {

            var data = {
                id: iddokterexist,
                text: iddokterexist.split('-')[1]
            };

            var newOption = new Option(data.text, data.id, true, true);
            $('#id_dokter').append(newOption).trigger('change');
        }

        get_master_kecelakaan();
        // get_all_dokter();

        // load wilayah

        // $('#load_wilayah').val();
    })
</script>