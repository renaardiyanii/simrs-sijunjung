<script>
    let no_cm = '';
    var table_pelayanan;


    function show_modal() {
        $('#modal_sep').modal('show');
    }

    function delete_procedure(id) {
        swal({
            title: "Hapus Prosedur",
            text: "Hapus prosedur tersebut?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya (hapus)",
            showCancelButton: true,
            // closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'procedure/delete'; ?>",
                dataType: "JSON",
                data: {
                    "id": id,
                    "no_register": no_register
                },
                success: function(data) {
                    if (data == true) {
                        table_procedure.ajax.reload();
                        get_procedure();
                        toastr.success('Prosedur berhasil dihapus.', 'Sukses!');
                    } else {
                        toastr.error('Gagal menghapus prosedur. Silahkan coba lagi.', 'Error!');
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    toastr.error(formatErrorMessage(event, errorThrown), 'Error!');
                }
            });
        });
    }

    function delete_diagnosa(id) {
        swal({
            title: "Hapus Diagnosa",
            text: "Hapus diagnosa tersebut?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya (hapus)",
            showCancelButton: true,
            // closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function() {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'inacbg/pasien/delete_diagnosa_inacbg'; ?>",
                dataType: "JSON",
                data: {
                    "id_diagnosa_pasien": id,
                    "no_register": no_register
                },
                success: function(data) {
                    if (data == true) {
                        table_diagnosa.ajax.reload();
                        get_diagnosa();
                        toastr.success('Diagnosa berhasil dihapus.', 'Sukses!');
                    } else {
                        toastr.error('Gagal menghapus diagnosa. Silahkan coba lagi.', 'Error!');
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    toastr.error(formatErrorMessage(event, errorThrown), 'Error!');
                }
            });
        });
    }

    function get_diagnosa() {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'inacbg/klaim/get_diagnosa/'; ?>" + no_register,
            dataType: "json",
            success: function(data) {
                console.log(data);
                var diags = [];
                var diagnosa;
                var diagnosa_inagrouper = '';

                // $.each(data.diagnosa_inagrouper, function(i, item) {
                //   // diags.push(item);
                // });          

                // diagnosa_inagrouper = data.diagnosa_inagrouper.join('#');
                // console.log(diagnosa_inagrouper);

                if (data.diagnosa_utama == '') {
                    diagnosa = '';
                } else {
                    diags.push(data.diagnosa_utama);
                    $.each(data.diagnosa_tambahan, function(i, item) {
                        diags.push(item);
                    });
                    diagnosa = diags.join('#');
                }

                if (diagnosa == '' || diagnosa == null) {
                    $('#diagnosa').val('#');
                } else {
                    $('#diagnosa').val(diagnosa);
                }
                // $("#diagnosa_inagrouper").val(diagnosa_inagrouper);
            },
            error: function(event, textStatus, errorThrown) {
                console.log(formatErrorMessage(event, errorThrown));
            }
        });
    }

    function get_procedure() {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() . 'inacbg/klaim/get_procedure/'; ?>" + no_register,
            dataType: "JSON",
            success: function(result) {
                // console.log(result);
                var procedures = [];
                var procedure;
                var procedure_inagroup = [];
                var procedureinagroup;

                $.each(result, function(i, item) {
                    // penambahan jika procedure sudah ada , maka jgn ditambahkan lagi ( di bpjs tidak boleh berulang )
                    if (procedures.indexOf(item.id_procedure) === -1) {
                        procedures.push(item.id_procedure);
                    }
                    // jika inagrouper , maka masukan ke inagrouper
                    if (item.inagrouper == 1) {
                        procedure_inagroup.push(item.id_procedure);
                    }
                });

                procedureinagroup = procedure_inagroup.join('#');
                // console.log(procedureinagroup+' inagrouper');
                $("#procedure_inagrouper").val(procedureinagroup);

                procedure = procedures.join('#');
                // console.log(procedure+' biasa');
                // }                   
                if (procedure == '' || procedure == null) {
                    $('#procedure').val('#');
                } else {
                    $('#procedure').val(procedure);
                }
            },
            error: function(event, textStatus, errorThrown) {
                toastr.error(formatErrorMessage(event, errorThrown), 'Gagal load data procedure!');
            }
        });
    }

    function tarif_rs() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('inacbg/pasien/tarif_rs'); ?>" + "/" + no_register,
            dataType: "JSON",
            beforeSend: function() {
                // check_login();
                $(".input_tarif_rs").addClass("load_input");
                $('#total_tarif_rs').html('<img src="<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>">');
            },
            success: function(result) {
                var total = 0;
                if (result) {
                    $(".input_tarif_rs").removeClass("load_input");
                    $('#prosedur_non_bedah').val(result.tarif_prosedur_non_bedah);
                    $('#prosedur_bedah').val(result.tarif_prosedur_bedah);
                    $('#konsultasi').val(result.tarif_konsultasi);
                    $('#tenaga_ahli').val(result.tarif_tenaga_ahli);
                    $('#keperawatan').val(result.tarif_keperawatan);
                    $('#penunjang').val(result.tarif_penunjang);
                    $('#radiologi').val(result.tarif_radiologi); // daftar_ulang_irj
                    $('#laboratorium').val(result.tarif_laboratorium); // daftar_ulang_irj 
                    $('#pelayanan_darah').val(result.tarif_pelayanan_darah);
                    $('#rehabilitasi').val(result.tarif_rehabilitasi);
                    $('#kamar').val(result.tarif_kamar);
                    $('#rawat_intensif').val(result.tarif_rawat_intensif);
                    $('#obat').val(result.tarif_obat); // daftar_ulang_irj
                    $('#obat_kronis').val(result.tarif_obat_kronis); // daftar_ulang_irj
                    $('#obat_kemoterapi').val(result.tarif_obat_kemoterapi); // daftar_ulang_irj
                    $('#alkes').val(result.tarif_alkes); // daftar_ulang_irj
                    $('#bmhp').val(result.tarif_bmhp);
                    $('#sewa_alat').val(result.tarif_sewa_alat);
                    total_tarif_rs();
                } else {
                    $(".input_tarif_rs").removeClass("load_input");
                    $('#total_tarif_rs').html(total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#prosedur_non_bedah').val(0);
                    $('#prosedur_bedah').val(0);
                    $('#konsultasi').val(0);
                    $('#tenaga_ahli').val(0);
                    $('#keperawatan').val(0);
                    $('#penunjang').val(0);
                    $('#radiologi').val(0);
                    $('#laboratorium').val(0);
                    $('#pelayanan_darah').val(0);
                    $('#rehabilitasi').val(0);
                    $('#kamar').val(0);
                    $('#rawat_intensif').val(0);
                    $('#obat').val(0);
                    $('#obat_kronis').val(0);
                    $('#obat_kemoterapi').val(0);
                    $('#alkes').val(0);
                    $('#bmhp').val(0);
                    $('#sewa_alat').val(0);
                }
            },
            error: function(event, textStatus, errorThrown) {
                $(".input_tarif_rs").removeClass("load_input");
                swal("Gagal load data tarif rs", formatErrorMessage(event, errorThrown), "error");
            }
        });
    }

    function total_tarif_rs() {
        $('#total_tarif_rs').html('<img src="<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>">');
        var total = parseInt($('#prosedur_non_bedah').val()) +
            parseInt($('#prosedur_bedah').val()) +
            parseInt($('#konsultasi').val()) +
            parseInt($('#tenaga_ahli').val()) +
            parseInt($('#keperawatan').val()) +
            parseInt($('#penunjang').val()) +
            parseInt($('#radiologi').val()) +
            parseInt($('#laboratorium').val()) +
            parseInt($('#pelayanan_darah').val()) +
            parseInt($('#rehabilitasi').val()) +
            parseInt($('#kamar').val()) +
            parseInt($('#rawat_intensif').val()) +
            parseInt($('#obat').val()) +
            parseInt($('#obat_kronis').val()) +
            parseInt($('#obat_kemoterapi').val()) +
            parseInt($('#alkes').val()) +
            parseInt($('#bmhp').val()) +
            parseInt($('#sewa_alat').val());
        $('#total_tarif_rs').html(total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
    }

    function gantiRajal(value) {
        if (value == '2') {
            $(".ranap_naikturunkelas").hide();
            $("#rawat_kelas_hak").show();
        } else {
            $(".ranap_naikturunkelas").show();
            $("#rawat_kelas_hak").hide();
        }
    }

    //   function naik_kelas(val)
    //   {
    //     console.log(val);
    //     if(val.is(':checked'))
    //     {
    //         $("#naik_kelas").show();
    //         return;
    //     }
    //     $("#naik_kelas").hide();

    //   }

    $(function() {

        $("#form_sep_manual").submit(function(event) {
            event.preventDefault();
            if ($('#no_sep_manual').val() === $('#no_sep').val()) {
                toastr.warning('No. SEP sudah digunakan.', 'Perhatian!');
            } else {
                $('#btn-sep-manual').prop('disabled', true).css('cursor', 'wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'bpjs/sep/insert_manual'; ?>",
                    dataType: "JSON",
                    data: {
                        "no_register": $('#no_register').val(),
                        "no_sep_manual": $('#no_sep_manual').val()
                    },
                    success: function(result) {
                        $('#btn-sep-manual').prop('disabled', false).css('cursor', 'pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
                        if (result.metaData.code == '200') {
                            load_data_pasien();
                            $('#modal_sep').modal('hide');
                            toastr.success('Data SEP berhasil disimpan.', 'Sukses!');
                        } else {
                            toastr.warning(result.metadata.message, 'Perhatian!');
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                        $('#btn-sep-manual').prop('disabled', false).css('cursor', 'pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
                        toastr.error(formatErrorMessage(event, errorThrown), 'Gagal Simpan SEP');
                    }
                });
            }
            event.preventDefault();
        });

        $(document).on("click", "#btn-cek-sep", function() {
            var button = $(this);
            var no_sep = $("#no_sep_manual").val();
            button.prop('disabled', true).css('cursor', 'wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
            if (no_sep == '') {
                $(this).prop('disabled', false).css('cursor', 'pointer').html('<i class="fa fa-eye"></i> Data SEP');
                swal("No. SEP Kosong", "Silahkan masukan nomor sep.", "warning");
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('bpjs/sep/cari_sep'); ?>/" + no_sep,
                    dataType: "JSON",
                    success: function(result) {
                        button.prop('disabled', false).css('cursor', 'pointer').html('<i class="fa fa-eye"></i> Data SEP');
                        if (result != '') {
                            if (result.metaData.code == '200') {
                                data = result.response;
                                $('#show_sep').html(data.noSep);
                                $('#show_tgl_sep').html(data.tglSep);
                                $('#show_no_rujukan').html(data.noRujukan);
                                $('#show_jns_pelayanan').html(data.jnsPelayanan);
                                $('#show_kls_rawat').html(data.kelasRawat);
                                $('#show_poli').html(data.poli);
                                $('#show_nama').html(data.peserta.nama);
                                $('#show_no_bpjs').html(data.peserta.noKartu);
                                $('#show_diagnosa').html(data.diagnosa);
                                $('#show_catatan').html(data.catatan);
                                $('#show_result_sep').fadeIn(1000);
                            } else if (result.metaData.code == 'No.SEP Harus Diisi 19 digit') {
                                toastr.warning('No. SEP Harus 19 digit.', 'SEP Tidak Ditemukan!');
                            } else {
                                toastr.warning(result.metaData.message, 'Gagal Lihat Data SEP!');
                            }
                        } else {
                            toastr.error('Koneksi Service Gagal.', 'Error!');
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                        button.prop('disabled', false).css('cursor', 'pointer').html('<i class="fa fa-eye"></i> Data SEP');
                        toastr.error(formatErrorMessage(event, errorThrown), "Error!");
                    }
                });
            }
        });
        $(document).on("click", "#btn-final-claim", function() {
            swal({
                title: "Finalisasi Klaim",
                text: "Yakin finalisasi klaim tersebut?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya (finalisasi)",
                showCancelButton: true,
                // closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'inacbg/klaim/claim_final'; ?>",
                    dataType: "JSON",
                    data: {
                        "no_sep": no_sep
                    },
                    success: function(result) {
                        if (result.metadata.code) {
                            if (result.metadata.code == '200') {
                                get_claim_data();
                                toastr.success('Berhasil Final Klaim.', 'Sukses!');
                            } else {
                                toastr.error(result.metadata.message, 'Error!');
                            }
                        } else {
                            toastr.error('Koneksi Service Gagal.', 'Error!');
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                        toastr.error(formatErrorMessage(event, errorThrown), "Error!");
                    }
                });
            });
            return false;
        });

        $(document).on("click","#reedit_claim",function() {
      swal({
        title: "Edit Ulang Klaim",
        text: "Batalkan status final dan edit ulang klaim?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (edit ulang)",
        showCancelButton: true,
        // closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url().'inacbg/klaim/reedit_claim'; ?>",
            dataType: "JSON",
            data: {"no_sep" : no_sep},
            success: function(result){  
              if (result.metadata.code) {                  
                if (result.metadata.code == '200') {
                  get_claim_data(); 
                  toastr.success('Berhasil Edit Ulang Klaim.', 'Sukses!');
                } else {
                  toastr.warning(result.metadata.message, 'Perhatian!');
                }
              } else {
                swal("Error", "Koneksi Service Gagal.", "error");
              }
            },
            error:function(event, textStatus, errorThrown) {    
              toastr.error(formatErrorMessage(event, errorThrown), "Error!");  
            }
          });                          
      });
      return false;
    });

        $(document).on("click","#delete_claim",function() {      
            swal({
                title: "Hapus Klaim",
                text: "Yakin akan menghapus klaim tersebut?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya (hapus)",
                showCancelButton: true,
                // closeOnConfirm: false,
                showLoaderOnConfirm: true,
                }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'inacbg/klaim/delete_claim'; ?>",
                    dataType: "JSON",
                    data: {"nomor_sep" : no_sep},
                    success: function(result){  
                    if (result.metadata.message) {                    
                        if (result.metadata.code == '200') {
                        get_claim_data(); 
                        toastr.success('Berhasil Hapus Klaim.', 'Sukses!');
                        } else {
                        toastr.warning(result.metadata.message, 'Perhatian!');
                        }
                    } else {
                        toastr.error('Koneksi Service Gagal.', 'Error!');
                    }
                    },
                    error:function(event, textStatus, errorThrown) {    
                    swal("Gagal menghapus klaim.",formatErrorMessage(event, errorThrown), "error");
                    }
                });           
            });
            return false;
            });
        $(document).on("click", "#btn-new-claim", function() {                                                            
            swal({
                title: "Buat Klaim",
                text: "Yakin membuat klaim tersebut?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya (buat klaim)",
                showCancelButton: true,
                // closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'inacbg/klaim/new_claim'; ?>",
                    dataType: "JSON",
                    data: $('#claim_form').serialize(),
                    success: function(result) {
                        if (result.metadata.code) {
                            if (result.metadata.code == '200') {
                                get_claim_data();
                                toastr.success('Berhasil membuat klaim.', 'Sukses!');
                            } else {
                                toastr.error(result.metadata.message, 'Error!');
                            }
                        } else {
                            toastr.error('Koneksi Service Gagal.', 'Error!');
                        }
                    },
                    error: function(event, textStatus, errorThrown) {
                        toastr.error(formatErrorMessage(event, errorThrown), 'Gagal membuat klaim!');
                    }
                });
            });
            return false;
        });

        $('[data-toggle="tooltip"]').tooltip();
        $("#show-loading").hide();
        $("#show-pasien").hide();
        $("#load_pelayanan").hide();
        // $("#buat-klaim").hide();
        // $("#grouper-1").hide();

        table_pelayanan = $('#table-pelayanan').DataTable({
            autoWidth: false,
            columns: [{
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {
                    data: "no_register"
                },
                {
                    data: "tgl_kunjungan"
                },
                {
                    data: "tgl_pulang"
                },
                {
                    data: "no_sep"
                },
                {
                    data: "tipe"
                },
            ],
            columnDefs: [{
                    targets: [0],
                    visible: true,
                    orderable: false,
                    className: "text-center"
                },
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: [2],
                    visible: true
                },
                {
                    targets: [3],
                    visible: true
                },
                {
                    targets: [4],
                    visible: true
                },
            ],
            drawCallback: function(settings) {
                // $("#table-pelayanan").wrap( "<div class='table-responsive'></div>" );
            }
        });

        function closeOpenedRows(table, selectedRow) {
            $.each(openRows, function(index, openRow) {
                if ($.data(selectedRow) !== $.data(openRow)) {
                    var rowToCollapse = table.row(openRow);
                    rowToCollapse.child.hide();
                    openRow.removeClass('shown');
                    var index = $.inArray(selectedRow, openRows);
                    openRows.splice(index, 1);
                }
            });
        }

        function cek_sep_bpjs(no_sep) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('bpjs/sep/cari_sep'); ?>/" + no_sep,
                dataType: "JSON",
                success: function(result_sep) {
                    // console.log(result_sep); 
                    // return;
                    if (result_sep.metaData.code == '200') {
                        if (result_sep.response.jnsPelayanan == 'Rawat Jalan') {
                            $("#rawat_jalan").attr('checked', true);
                        } else {
                            // ranap
                            $("#rawat_inap").attr('checked', true);

                        }
                        // if (jenis_rawat === 'RI' && result_sep.response.peserta.hakKelas === 'Kelas 3') {
                        //     $('#kelas_rawat_3').prop("checked", true).trigger("change");
                        // } else if (jenis_rawat === 'RI' && result_sep.response.peserta.hakKelas === 'Kelas 2') {
                        //     $('#kelas_rawat_2').prop("checked", true).trigger("change");
                        // } else if (jenis_rawat === 'RI' && result_sep.response.peserta.hakKelas === 'Kelas 1') {
                        //     $('#kelas_rawat_1').prop("checked", true).trigger("change");
                        // } else {
                        //     $('#kelas_rawat_3').prop("checked", true).trigger("change");
                        //     $("input[name='kelas_rawat']").prop("disabled", true);
                        // }


                    }
                },
                error: function(event, textStatus, errorThrown) {
                    console.log(formatErrorMessage(event, errorThrown));
                }
            });
        }

        function calculateAge(birthday) { // birthday is a date
            birthday = new Date(birthday);
            var ageDifMs = Date.now() - birthday.getTime();
            var ageDate = new Date(ageDifMs); // miliseconds from epoch
            return Math.abs(ageDate.getUTCFullYear() - 1970);
        }

        function get_pasien() {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('inacbg/pasien/get_pasien') ?>",
                dataType: "JSON",
                data: {
                    "no_register": no_register
                },
                success: function(result_pasien) {
                   
                    $("#sex").val(result_pasien.gender == 'L' ? '1' : '2');
                    $("#nama").val(result_pasien.nama);
                    $("#tgl_lahirr").val(result_pasien.tgl_lahir);
                    $('#no_bpjs').val(result_pasien.no_kartu);
                    $('#no_sep').val(result_pasien.no_sep);
                    $('#tgl_masuk').val(result_pasien.tgl_masuk);
                    $('#tgl_pulang').val(result_pasien.tgl_pulang);
                    $('#nama_dokter').val(result_pasien.nm_dokter).trigger("change");
                    $("#discharge_status").prop("selectedIndex", 0);
                    // umur
                    $("#umurPasien").html(calculateAge(result_pasien.tgl_lahir));
                    // end umur
                    cek_sep_bpjs(result_pasien.no_sep);
                    // return;

                    if (jenis_rawat === 'RJ') {
                        $('#kelas_rawat_3').prop("checked", true).trigger("change");
                        if (result_pasien.tgl_pulang === '' || result_pasien.tgl_pulang === null) {
                            $('#tgl_pulang').val(result_pasien.tgl_masuk);
                        } else {
                            $('#tgl_pulang').val(result_pasien.tgl_pulang);
                        }
                        $('#div_upgrade_class_ind,#div_icu_indicator').hide();
                    }
                    if (jenis_rawat === 'RI') {
                        if (result_pasien.klsiri === '' || result_pasien.klsiri === null) {
                            $('input[name=kelas_rawat]').prop('checked', false).trigger("change");
                        } else if (result_pasien.klsiri === 'III') {
                            $('#kelas_rawat_3').prop("checked", true).trigger("change");
                        } else if (result_pasien.klsiri === 'II') {
                            $('#kelas_rawat_2').prop("checked", true).trigger("change");
                        } else {
                            $('#kelas_rawat_1').prop("checked", true).trigger("change");
                        }
                        $('#div_rawat_inap').fadeIn(300);
                        $('#div_upgrade_class_ind,#div_icu_indicator').fadeIn(300);
                    }

                    $('.input_data_pasien').removeClass('load_input');
                },
                error: function(event, textStatus, errorThrown) {
                    $('.input_data_pasien').removeClass('load_input');
                    console.log(formatErrorMessage(event, errorThrown));
                }
            });
        }



        function load_data_pasien() {
            $("input[name='no_rm']").val($('#no_rm').text());
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('inacbg/pasien/get_inacbg') ?>",
                dataType: "JSON",
                data: {
                    "no_register": no_register
                },
                beforeSend: function() {
                    // check_login();
                    $('.input_data_pasien').addClass('load_input');
                },
                success: function(result_inacbg) {
                    // console.log(result_inacbg);
                    if (result_inacbg === null) {
                        $("#klaim_exist_db").val('0');
                        get_pasien(no_register);
                    } else {
                        $("#klaim_exist_db").val('1');
                        if (jenis_rawat === 'RJ') {
                            //     $('#div_rawat_inap').fadeOut(300);
                            //     $('#div_upgrade_class_ind,#div_icu_indicator').fadeOut(300);
                        }
                        if (jenis_rawat === 'RI') {
                            //     $('#div_rawat_inap').fadeIn(300);
                            //     $('#div_upgrade_class_ind,#div_icu_indicator').fadeIn(300);
                        }
                        $('#nama').val(result_inacbg.nama_pasien);
                        $('#tgl_lahir_pasien').val(result_inacbg.tgl_lahir);
                        $('#no_bpjs').val(result_inacbg.nomor_kartu);
                        $('#no_sep').val(result_inacbg.no_sep);
                        $('#tgl_masuk').val(result_inacbg.tgl_masuk);
                        $('#tgl_pulang').val(result_inacbg.tgl_pulang);
                        $('#nama_dokter').val(result_inacbg.nama_dokter).trigger("change");
                        $("#discharge_status").val(result_inacbg.discharge_status).trigger("change");
                        $('#kelas_rawat_' + result_inacbg.kelas_rawat).prop("checked", true).trigger("change");

                        /**
                         * cek jika kondisi result inacbg itu rawat jalan 
                         */
                        if (result_inacbg.jenis_rawat == '2') {
                            $("#rawat_jalan").attr('checked', true);
                        } else {
                            $("#rawat_inap").attr('checked', true);
                        }

                        // tgl lahir ,, validasi umur

                        $("#umurPasien").html(calculateAge(result_inacbg.tgl_lahir));


                        if (result_inacbg.upgrade_class_ind === '1') {
                            $('#upgrade_class_ind').prop("checked", true).trigger("change");
                            $('#div_upgrade_class_class,#div_upgrade_class_los').fadeIn(300);
                            $('#upgrade_class_class').val(result_inacbg.upgrade_class_class).trigger('change');
                            $('#upgrade_class_los').val(result_inacbg.upgrade_class_los);
                        }
                        if (result_inacbg.icu_indicator === '1') {
                            $('#icu_indicator').prop("checked", true).trigger("change");
                            $('#div_icu_los,#div_ventilator_hour').fadeIn(300);
                            $('#icu_los').val(result_inacbg.icu_los);
                            $('#ventilator_hour').val(result_inacbg.ventilator_hour);
                        }
                        $('#discharge_status').val(result_inacbg.discharge_status).trigger("change");
                        $('.input_data_pasien').removeClass('load_input');
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    $('.input_data_pasien').removeClass('load_input');
                    toastr.error(formatErrorMessage(event, errorThrown), "Error!");
                }
            });
        }

        $('.date_picker').datetimepicker({
            format: 'Y-m-d H:i:s',
        });

        function form_klaim(row) {
            no_register = row.no_register;
            jenis_rawat = row.tipe;
            no_sep = row.no_sep;
            return `
                <form id="claim_form" class="form-horizontal">
                    <input type="hidden" class="form-control" id="no_register" name="no_register">
                    <input type="hidden" class="form-control" name="no_rm">
                    <input type="hidden" class="form-control" name="klaim_exist_db" id="klaim_exist_db" value="0">
                    <input type="hidden" class="form-control" name="diagnosa" id="diagnosa">
                    <input type="hidden" class="form-control" name="diagnosa_inagrouper" id="diagnosa_inagrouper">
                    <input type="hidden" class="form-control" name="procedure" id="procedure">
                    <input type="hidden" class="form-control" name="procedure_inagrouper" id="procedure_inagrouper">
                    <input type="hidden" class="form-control" name="nama" id="nama">
                    <input type="hidden" name="tgl_lahirr" id="tgl_lahirr">
                    <input type="hidden" name="sex" id="sex">

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="payor" style="font-size:8pt;font-style:italic">Jaminan / Cara Bayar</label>
                                <select class="form-control col-sm-12 form-control-sm" id="payor" name="payor">
                                    <option value="3#JKN">JKN</option>
                                    <option value="71#COVID-19">JAMINAN COVID-19</option>
                                    <option value="72#KIPI">JAMINAN KIPI</option>
                                    <option value="73#BBL">JAMINAN BAYI BARU LAHIR</option>
                                    <option value="74#PMR">JAMINAN PERPANJANGAN MASA RAWAT</option>
                                    <option value="75#CO-INS">JAMINAN CO-INSIDENSE</option>
                                    <option value="5#001">JAMKESDA</option>
                                    <option value="6#JKS">JAMKESOS</option>
                                    <option value="1#999">PASIEN BAYAR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="no_bpjs" style="font-size:8pt;font-style:italic">No. Peserta</label>
                                <input type="text" class="form-control col-sm-12 form-control-sm" id="no_bpjs" name="no_bpjs">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="no_sep" style="font-size:8pt;font-style:italic" >No. SEP</label>
                            <div class="">
                                <div class="input-group">
                                    <input type="text" class="form-control col-sm-12 form-control-sm" id="no_sep" name="no_sep">
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger btn-xs" type="button" onclick="show_modal()"><i class="fa fa-pencil-square-o"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="cob_cd" style="font-size:8pt;font-style:italic">COB</label>
                                <select class="form-control col-sm-12 form-control-sm" id="cob_cd" name="cob_cd">
                                    <option value="#" selected>-</option>
                                    <option value="0001">MANDIRI INHEALTH</option>
                                    <option value="0005">ASURANSI SINAR MAS</option>
                                    <option value="0006">ASURANSI TUGU MANDIRI</option>
                                    <option value="0007">ASURANSI MITRA MAPARYA</option>
                                    <option value="0008">ASURANSI AXA MANDIRI FINANSIAL SERVICE</option>
                                    <option value="0009">ASURANSI AXA FINANSIAL INDONESIA</option>
                                    <option value="0010">LIPPO GENERAL INSURANCE</option>
                                    <option value="0011">ARTHAGRAHA GENERAL INSURANSE</option>
                                    <option value="0012">TUGU PRATAMA INDONESIA</option>
                                    <option value="0013">ASURANSI BINA DANA ARTA</option>
                                    <option value="0014">ASURANSI JIWA SINAR MAS MSIG</option>
                                    <option value="0015">AVRIST ASSURANCE</option>
                                    <option value="0016">ASURANSI JIWA SRAYA</option>
                                    <option value="0017">ASURANSI JIWA CENTRAL ASIA RAYA</option>
                                    <option value="0018">ASURANSI TAKAFUL KELUARGA</option>
                                    <option value="0019">ASURANSI JIWA GENERALI INDONESIA</option>
                                    <option value="0020">ASURANSI ASTRA BUANA</option>
                                    <option value="0021">ASURANSI UMUM MEGA</option>
                                    <option value="0022">ASURANSI MULTI ARTHA GUNA</option>
                                    <option value="0023">ASURANSI AIA INDONESIA</option>
                                    <option value="0024">ASURANSI JIWA EQUITY LIFE INDONESIA</option>
                                    <option value="0025">ASURANSI JIWA RECAPITAL</option>
                                    <option value="0026">GREAT EASTERN LIFE INDONESIA</option>
                                    <option value="0027">ASURANSI ADISARANA WANAARTHA</option>
                                    <option value="0028">ASURANSI JIWA BRINGIN JIWA SEJAHTERA</option>
                                    <option value="0029">BOSOWA ASURANSI</option>
                                    <option value="0030">MNC LIFE ASSURANCE</option>
                                    <option value="0031">ASURANSI AVIVA INDONESIA</option>
                                    <option value="0032">ASURANSI CENTRAL ASIA RAYA</option>
                                    <option value="0033">ASURANSI ALLIANZ LIFE INDONESIA</option>
                                    <option value="0034">ASURANSI BINTANG</option>
                                    <option value="0035">TOKIO MARINE LIFE INSURANCE INDONESIA</option>
                                    <option value="0036">MALACCA TRUST WUWUNGAN</option>
                                    <option value="0037">ASURANSI JASA INDONESIA</option>
                                    <option value="0038">ASURANSI JIWA MANULIFE INDONESIA</option>
                                    <option value="0039">ASURANSI BANGUN ASKRIDA</option>
                                    <option value="0040">ASURANSI JIWA SEQUIS FINANCIAL</option>
                                    <option value="0041">ASURANSI AXA INDONESIA</option>
                                    <option value="0042">BNI LIFE</option>
                                    <option value="0043">ACE LIFE INSURANCE</option>
                                    <option value="0044">CITRA INTERNATIONAL UNDERWRITERS</option>
                                    <option value="0045">ASURANSI RELIANCE INDONESIA</option>
                                    <option value="0046">HANWHA LIFE INSURANCE INDONESIA</option>
                                    <option value="0047">ASURANSI DAYIN MITRA</option>
                                    <option value="0048">ASURANSI ADIRA DINAMIKA</option>
                                    <option value="0049">PAN PASIFIC INSURANCE</option>
                                    <option value="0050">ASURANSI SAMSUNG TUGU</option>
                                    <option value="0051">ASURANSI UMUM BUMI PUTERA MUDA 1967</option>
                                    <option value="0052">ASURANSI JIWA KRESNA</option>
                                    <option value="0053">ASURANSI RAMAYANA</option>
                                    <option value="0054">VICTORIA INSURANCE</option>
                                    <option value="0055">ASURANSI JIWA BERSAMA BUMIPUTERA 1912</option>
                                    <option value="0056">FWD LIFE INDONESIA</option>
                                    <option value="0057">ASURANSI TAKAFUL KELUARGA</option>
                                    <option value="0058">ASURANSI TUGU KRESNA PRATAMA</option>
                                    <option value="0059">SOMPO INSURANCE</option>
                                </select>
                            </div>
                        </div>     
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-right">
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Jenis Rawat</label>
                                </td>
                                <td>
                                    <input type="radio" id="rawat_jalan" name="rawat" class="custom-control-input form-control-sm" value="2" onchange="gantiRajal(this.value)">
                                    <label class="custom-control-label" for="rawat_jalan" style="font-size:10pt;">Jalan</label>
                                    <input type="radio" id="rawat_inap" name="rawat" class="custom-control-input form-control-sm" value="1" onchange="gantiRajal(this.value)">
                                    <label class="custom-control-label" for="rawat_inap" style="font-size:10pt;">Inap</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Check jika mendapatkan pelayanan kelas eksekutif.">
                                    <input type="checkbox" class="custom-control-input form-control-sm" id="customCheck1">
                                    <label class="custom-control-label " for="customCheck1" style="font-size:10pt;" >Eksekutif</label>
                                    
                                    <!-- Rawat Inap -->
                                    <div class="ranap_naikturunkelas">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Check jika mendapatkan pelayanan kelas eksekutif.">
                                        <input type="checkbox" class="custom-control-input form-control-sm" id="naik_turun_kelas" value="1" name="upgrade_class_ind">
                                        <label class="custom-control-label " for="naik_turun_kelas" style="font-size:10pt;" >Naik / Turun Kelas</label>
                                    </div>
                                    <!-- End Rawat Inap -->
                                </td>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Kelas Hak</label>
                                </td>
                                <td>
                                    <p class="custom-control-label" id="rawat_kelas_hak" style="font-size:10pt;float:left;">-</p>
                                    <!-- Rawat Inap -->
                                    <div class="ranap_naikturunkelas">
                                        <input type="radio" id="kelas_3_naikkelas" name="kelas_rawat" class="custom-control-input form-control-sm" value="3" checked>
                                        <label class="custom-control-label" for="kelas_3_naikkelas" style="font-size:10pt;">Kelas 3</label>
                                        <input type="radio" id="kelas_2_naikkelas" name="kelas_rawat" class="custom-control-input form-control-sm" value="2">
                                        <label class="custom-control-label" for="kelas_2_naikkelas" style="font-size:10pt;">Kelas 2</label>
                                        <input type="radio" id="kelas_1_naikkelas" name="kelas_rawat" class="custom-control-input form-control-sm" value="1">
                                        <label class="custom-control-label" for="kelas_1_naikkelas" style="font-size:10pt;">Kelas 1</label>
                                    </div>
                                    <!-- End Rawat Inap -->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Tanggal Rawat</label>
                                </td>
                                <td>
                                    <div class="form-group flex">
                                        <label class="custom-control-label" for="tgl_masuk" style="font-size:10pt;">Masuk : </label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="tgl_masuk" name="tgl_masuk" class="form-control form-control-sm date_picker" style="width:30%">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" for="tgl_pulang" style="font-size:10pt;">Pulang :</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="tgl_pulang" name="tgl_pulang" class="form-control form-control-sm date_picker" style="width:30%">
                                    </div>
                                </td>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Umur</label>
                                </td>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:left;"><label id="umurPasien"></label> &nbsp;tahun</label>
                                </td>
                            </tr>
                            
                            <!-- Naik Kelas -->
                            <tr id="naik_kelas">
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Kelas Pelayanan</label>
                                </td>
                                <td>
                                    <input type="radio" id="upgrade_class_class_2" name="upgrade_class_class" class="custom-control-input form-control-sm" value="kelas_2">
                                    <label class="custom-control-label" for="upgrade_class_class_2" style="font-size:10pt;">Kelas 2</label>
                                    <input type="radio" id="upgrade_class_class_1" name="upgrade_class_class" class="custom-control-input form-control-sm" value="kelas_1">
                                    <label class="custom-control-label" for="upgrade_class_class_1" style="font-size:10pt;">Kelas 1</label>
                                    <input type="radio" id="upgrade_class_class_vip" name="upgrade_class_class" class="custom-control-input form-control-sm" value="vip">
                                    <label class="custom-control-label" for="upgrade_class_class_vip" style="font-size:10pt;">Kelas VIP</label>
                                    <input type="radio" id="upgrade_class_class_vvip" name="upgrade_class_class" class="custom-control-input form-control-sm" value="vvip">
                                    <label class="custom-control-label" for="upgrade_class_class_vvip" style="font-size:10pt;">Kelas VVIP</label>
                                </td>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Lama ( hari )</label>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" id="upgrade_class_los" name="upgrade_class_los">
                                </td>
                            </tr>

                            <!-- End - Naik Kelas -->
                            


                            <tr>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">LOS</label>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label style="font-size:10pt;"><label id="icu_los_show">0</label> &nbsp;Hari </label>&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" for="tgl_masuk" style="font-size:10pt;">( 00:00 jam) </label>
                                    </div>
                                </td>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Berat Lahir ( gram )</label>
                                </td>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:left;">-</label>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">ADL Score</label>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="custom-control-label" for="tgl_masuk" style="font-size:10pt;">&nbsp;&nbsp;&nbsp;Sub Acute : - </label>&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" for="tgl_masuk" style="font-size:10pt;">Chronic : -</label>
                                    </div>
                                </td>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Cara Pulang</label>
                                </td>
                                <td>
                                    <select class="form-control col-sm-12 form-control-sm" id="discharge_status" name="discharge_status">
                                        <option value="1">Atas Persetujuan Dokter</option>
                                        <option value="2">Dirujuk</option>
                                        <option value="3">Atas Permintaan Sendiri</option>
                                        <option value="4">Meninggal</option>
                                        <option value="5">Lain-lain</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">DPJP</label>
                                </td>
                                <td>
                                    <select class="form-control col-sm-12 form-control-sm" id="nama_dokter" name="nama_dokter" style="width:100%" >
                                    </select>
                                </td>
                                <td>
                                    <label class="custom-control-label" style="font-size:10pt;float:right;">Jenis Tarif</label>
                                </td>
                                <td>
                                    <select class="form-control col-sm-12 form-control-sm" name="jenis_tarif" id="jenis_tarif">
                                        <option value="AP">TARIF RS KELAS A PEMERINTAH</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-center" style="float:center;">
                            <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total nilai tertagih pada perawatan dalam satu episode, tidak termasuk item tagihan pada Tarif Non INA-CBG yang tersebut dibawah.">
                            <label class="custom-control-label" style="font-size:10pt;float:center;font-style:italic">Tarif Rumah Sakit : </label>
                        </div>
                        <div class="d-flex justify-content-center" style="float:center;">
                            <label id="total_tarif_rs" style="font-weight:bold;font-size:14pt">0</label>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <div class="form-group row rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:8pt;">Prosedur Non Bedah</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="prosedur_non_bedah" name="prosedur_non_bedah" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group row rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:8pt;">Prosedur Bedah</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="prosedur_bedah" name="prosedur_bedah" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group row rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:8pt;">Konsultasi</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="konsultasi" name="konsultasi" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Tenaga Ahli</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="tenaga_ahli" name="tenaga_ahli" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Keperawatan</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="keperawatan" name="keperawatan" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Penunjang</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="penunjang" name="penunjang" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Radiologi</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="radiologi" name="radiologi" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Laboratorium</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="laboratorium" name="laboratorium" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Pelayanan Darah</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="pelayanan_darah" name="pelayanan_darah" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Rehabilitasi</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="rehabilitasi" name="rehabilitasi" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Kamar / Akomodasi</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="kamar" name="kamar" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Rawat Intensif</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="rawat_intensif" name="rawat_intensif" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Obat</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="obat" name="obat" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Obat Kronis</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="obat_kronis" name="obat_kronis" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Obat Kemoterapi</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="obat_kemoterapi" name="obat_kemoterapi" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Alkes</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="alkes" name="alkes" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">BMHP</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="bmhp" name="bmhp" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group rowtabledetail">
                                        <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label" style="font-size:10pt;float:right;">Sewa Alat</label>&nbsp;&nbsp;&nbsp;
                                        <input type="text" id="sewa_alat" name="sewa_alat" class="form-control form-control-sm"  style="text-align:center;width:30%">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-sm-12 text-center">
                        <input type="checkbox" class="custom-control-input form-control-sm" id="menyatakan" value="1" checked disabled>
                        <label class="custom-control-label " for="menyatakan" style="font-size:9pt;font-style:italic;" >Menyatakan benar bahwa data tarif yang tersebut di atas adalah benar sesuai dengan kondisi yang sesungguhnya.</label>
                    </div>
                    <hr>
                    <div style="border:1px solid #000;" class="p-4">
                        <div class="d-flex justify-content-between">
                            <label class="custom-control-label" for="menyatakan" style="font-size:10pt;" >Diagnosa (ICD-10)</label>
                            <select class="form-control form-control-sm" name="id_diagnosa" id="id_diagnosa" style="width: 30%;"></select>
                        </div>
                        <table id="table_diagnosa" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Diagnosa</th>
                                <th>Catatan</th>
                                <th>Diagnosa Inagrouper</th>
                                <th>Klasifikasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        
                        <hr>
                        <div class="d-flex justify-content-between">
                            <label class="custom-control-label" for="menyatakan" style="font-size:10pt;" >Procedure (ICD-9)</label>
                            <select class="form-control form-control-sm" name="id_procedure" id="id_procedure" style="width: 30%;"></select>
                        
                        </div>

                        <table id="table_procedure" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Prosedur</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div id="grouper_1">
                    </div>
                    <div id="grouper_result">
                        <h4 class="text-center" style="margin-bottom: 20px;margin-top:20px;">Hasil Grouper E-Klaim v5</h4>
                        <table class="table table-hover m-b-0 table-bordered" id="table-grouper-result">
                            <tbody>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Info 0</td>
                                <td>INACBG @ <span id="grouper_at"></span> •• Kelas <span id="kelas_rs_result"></span> •• Tarif : TARIF RS KELAS <span id="tarif_kelas_result"></span></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Jenis Rawat</td>
                                <td><span id="jenis_rawat_result"></span> Kelas <span id="kelas_rawat_result"></span></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Group</td>
                                <td id="description_cbg"></td>
                                <td class="text-center" id="code_cbg"></td>
                                <td class="text-right">Rp</td>
                                <td class="text-right tarif_result" id="tarif_cbg"></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Sub Acute</td>
                                <td id="sub_acute_description"></td>
                                <td class="text-center" id="sub_acute_code"></td>
                                <td class="text-right">Rp</td>
                                <td class="text-right tarif_result" id="sub_acute_tarif"></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Chronic</td>
                                <td id="chronic_description"></td>
                                <td class="text-center" id="chronic_code"></td>
                                <td class="text-right">Rp</td>
                                <td class="text-right tarif_result" id="chronic_tarif"></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Special Procedure</td>
                                <td id="special_procedure_description"></td>
                                <td class="text-center" id="special_procedure_code"></td>
                                <td class="text-right">Rp</td>
                                <td class="text-right tarif_result" id="special_procedure_tarif"></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Special Prosthesis</td>
                                <td id="special_prosthesis_description"></td>
                                <td class="text-center" id="special_prosthesis_code"></td>
                                <td class="text-right">Rp</td>
                                <td class="text-right tarif_result" id="special_prosthesis_tarif"></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Special Investigation</td>
                                <td id="special_investigation_description"></td>
                                <td class="text-center" id="special_investigation_code"></td>
                                <td class="text-right">Rp</td>
                                <td class="text-right tarif_result" id="special_investigation_tarif"></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 1px solid #ededed;">Special Drug</td>
                                <td id="special_drug_description"></td>
                                <td class="text-center" id="special_drug_code"></td>
                                <td class="text-right">Rp</td>
                                <td class="text-right tarif_result" id="special_drug_tarif"></td>
                            </tr>
                            <tr id="tr_status_klaim">
                                <td class="text-right" style="border-right: 1px solid #ededed;">Status Data Klaim</td>
                                <td id="status_data_klaim"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="4"><h4>Total Rp</h4></td>
                                <td class="text-right"><h4 id="total_tarif"></h4></td>
                            </tr>
                            <tr class="tambahan_biaya_result"><td class="text-center" colspan="5" style="font-weight:bold;">Tambahan Biaya Yang Dibayar Pasien Untuk Naik Kelas 2</td></tr>
                            <tr class="tambahan_biaya_result">
                                <td>Tambahan Biaya</td>
                                <td colspan="2" class="text-right">
                                <span style="cursor:default;" data-tooltip="Tarif Kelas 2">
                                <span>Rp</span> 6,299,700</span> -
                                <span style="cursor:default;" data-tooltip="Tarif Kelas 3"><span class="">Rp</span> 5,249,700</span>
                                </td>
                                <td>=&nbsp;Rp</td>
                                <td class="text-right" id="td_add_payment_amt"></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        <hr>
                        <div id="div-btn-service2">
                        </div>
                    </div>
                    
                </form>
                `;
        }
        var openRows = new Array();

        function get_claim_data() {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() . 'inacbg/klaim/get_claim_data/'; ?>" + no_sep,
                dataType: "JSON",
                beforeSend: function() {

                },
                success: function(result) {
                    $('.input_tarif_rs').prop('readonly', false);
                    $('#id_diagnosa,#id_procedure').prop('disabled', false);
                    $("#card-result").css({
                        "background-color": "#ffffff"
                    });
                    $('#div-btn-service1,#div-btn-service2').empty();
                    $('#tr_status_klaim').hide();
                    $('#grouper_result').hide();
                    $('#cbg_code_' + no_register).html('-');
                    $('#cbg_status_' + no_register).html('-');
                    if (result.metadata.code == 200) {
                        // $("#buat_klaim").show();
                        $('#cbg_status_' + no_register).html(result.response.data.klaim_status_cd.toUpperCase());
                        if (result.response.data.grouper.response == null) {
                            $('.div-non-final').show();
                            // $("#grouper-1").show();
                            $("#grouper_1").addClass('mt-2 p-2 d-flex justify-content-between');
                            $("#grouper_1").css('border', '1px solid #000');
                            $('#grouper_1').html(`
                                <button id="delete_claim" class="btn btn-danger btn-sm">Hapus Claim</button>
                                <div>
                                    <button class="btn btn-info btn-sm">Simpan</button>
                                    <button id="btn-grouper" type="button" class="btn btn-primary btn-sm">Grouper</button>
                                </div>
                            `);
                        } else {
                            // $("#grouper-1").hide();
                            $('#cbg_code_' + no_register).html(result.response.data.grouper.response.cbg.code);
                            $('.div-non-final').hide();
                            $('#grouper_result').fadeIn(1000);
                            $('#kelas_rs_result').html(result.response.data.kelas_rs);

                            if (result.response.data.jenis_rawat == 1) {
                                $('#jenis_rawat_result').html('Rawat Inap');
                            }
                            if (result.response.data.jenis_rawat == 2) {
                                $('#jenis_rawat_result').html('Rawat Jalan');
                            }

                            $('#kelas_rawat_result').html(result.response.data.kelas_rawat);
                            $('#kelas_rs_result').html(result.response.data.kelas_rs);

                            if (result.response.data.kode_tarif == "AP") {
                                $('#tarif_kelas_result').html("A PEMERINTAH");
                            }
                            $('#description_cbg').html(result.response.data.grouper.response.cbg.description);
                            $('#code_cbg').html(result.response.data.grouper.response.cbg.code);
                            $('#tarif_cbg').html(result.response.data.grouper.response.cbg.tariff);

                            if (result.response.data.grouper.response.sub_acute) {
                                $('#sub_acute_description').html(result.response.data.grouper.response.sub_acute.description);
                                $('#sub_acute_code').html(result.response.data.grouper.response.sub_acute.code);
                                $('#sub_acute_tarif').html(result.response.data.grouper.response.sub_acute.tariff);
                            } else {
                                $('#sub_acute_description').html('-');
                                $('#sub_acute_code').html('-');
                                $('#sub_acute_tarif').html(0);
                            }
                            if (result.response.data.grouper.response.chronic) {
                                $('#chronic_description').html(result.response.data.grouper.response.chronic.description);
                                $('#chronic_code').html(result.response.data.grouper.response.chronic.code);
                                $('#chronic_tarif').html(result.response.data.grouper.response.chronic.tariff);
                            } else {
                                $('#chronic_description').html('-');
                                $('#chronic_code').html('-');
                                $('#chronic_tarif').html(0);
                            }
                            if (result.response.data.grouper.response.special_cmg) {
                                $.each(result.response.data.grouper.response.special_cmg, function(key, value) {
                                    if (key.type == 'Special Procedure') {
                                        $('#special_procedure_description').html(key.description);
                                        $('#special_procedure_code').html(key.code);
                                        $('#special_procedure_tarif').html(key.tariff);
                                    }
                                    if (key.type == 'Special Prosthesis') {
                                        $('#special_prosthesis_description').html(key.description);
                                        $('#special_prosthesis_code').html(key.code);
                                        $('#special_prosthesis_tarif').html(key.tariff);
                                    }
                                    if (key.type == 'Special Investigation') {
                                        $('#special_investigation_description').html(key.description);
                                        $('#special_investigation_code').html(key.code);
                                        $('#special_investigation_tarif').html(key.tariff);
                                    }
                                    if (key.type == 'Special Drug') {
                                        $('#special_drug_description').html(key.description);
                                        $('#special_drug_code').html(key.code);
                                        $('#special_drug_tarif').html(key.tariff);
                                    }
                                });
                            } else {
                                $('#special_procedure_description,#special_prosthesis_description,#special_investigation_description,#special_drug_description,#special_procedure_code,#special_prosthesis_code,#special_investigation_code,#special_drug_code').html('-');
                                $('#special_procedure_tarif,#special_prosthesis_tarif,#special_investigation_tarif,#special_drug_tarif').html(0);
                            }

                            if (result.response.data.klaim_status_cd == 'normal') {
                                $('.div-non-final').show();
                                $('#header_grouper_result').html('Hasil Grouper');
                                $('#div-btn-service1').html('<button type="button" class="btn btn-danger waves-effect waves-light m-r-10" id="delete_claim"><i class="fa fa-trash"></i> Hapus Klaim</button><button type="submit" class="btn btn-info pull-right" id="btn-grouper"><i class="fa fa-check"></i> Grouper</button>');
                                $('#div-btn-service2').html('<button type="button" class="btn btn-primary waves-effect waves-light pull-right" id="btn-final-claim" style="padding-right: 25px;padding-left: 25px;"><i class="fa fa-check"></i> Final Klaim</button>');
                            }

                            if (result.response.data.klaim_status_cd == 'final') {
                                $('.input_tarif_rs').prop('readonly', true);
                                $('#id_diagnosa,#id_procedure').prop('disabled', true);
                                $("#card-result").css({
                                    "background-color": "#eeffee"
                                });
                                $('#header_grouper_result').html('Hasil Grouper - Final');
                                $('#div-btn-service2').html('<button data-no_sep="' + no_sep + '" class="btn btn-primary pull-right" id="reedit_claim"><i class="fa fa-pencil-square-o"></i> Edit Ulang Klaim</button><a href="<?php echo site_url('inacbg/klaim/claim_print') ?>/' + no_sep + '" target="_blank" class="btn btn-warning waves-effect waves-light" id="cetak_klaim" style="margin-right: 10px;"><i class="fa fa-print"></i> Cetak Klaim</a><button type="button" class="btn btn-info waves-effect waves-light m-r-10" id="send_claim_individual"><i class="fa fa-paper-plane"></i> Kirim Klaim Online</button>');
                                if (result.response.data.kemenkes_dc_status_cd == 'unsent') {
                                    $('#tr_status_klaim').show();
                                    $('#status_data_klaim').html('Klaim belum terkirim ke Pusat Data Kementerian Kesehatan');
                                }
                                if (result.response.data.kemenkes_dc_status_cd == 'sent') {
                                    $('#tr_status_klaim').show();
                                    $('#status_data_klaim').html('Terkirim');
                                }
                            }

                            var total_tarif = 0;
                            $('.tarif_result').each(function() {
                                total_tarif += parseInt($(this).text() == '' ? 0 : $(this).text());
                            });


                            $('#total_tarif').html(total_tarif.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
                        }
                    } else {
                        $("#grouper_1").addClass('mt-2 p-2 d-flex justify-content-between');
                        $("#grouper_1").css('border', '1px solid #000');
                        $('#grouper_1').html(`
                            <div></div>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm" id="btn-new-claim">Buat Klaim</button>
                            </div>
                        `);
                        // $("#buat_klaim").show().css('visibility','block');
                        // $("#grouper-1").show();
                        // $('#grouper_result').fadeOut(1000);
                        // $('#div-btn-service1').html('<button type="button" class="btn btn-info waves-effect waves-light pull-right" id="btn-new-claim" style="padding-right: 25px;padding-left: 25px;">Buat Klaim</button>');
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    swal("Gagal Load Klaim.", formatErrorMessage(event, errorThrown), "error");
                }
            });
        }



        $(document).on("click", "#btn-grouper", function() {
            // $('#btn-grouper').prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'inacbg/klaim/set_claim_data_new'; ?>",
                dataType: "JSON",
                data: $('#claim_form').serialize(),
                success: function(result) {
                    console.log(result);
                    $('#btn-grouper').prop('disabled', false).css('cursor', 'pointer').html('Grouper');
                    if (result.metadata.code) {
                        if (result.metadata.code == '200') {
                            get_claim_data();
                            $('html, body').animate({
                                scrollTop: $("#grouper_result").offset().top
                            }, 2000);
                            toastr.success('Klaim berhasil digrouper.', 'Sukses!');
                        } else {
                            toastr.warning(result.metadata.message, 'Perhatian!');
                        }
                    } else {
                        toastr.error('Koneksi Service Gagal.', 'Error!');
                    }
                },
                error: function(event, textStatus, errorThrown) {
                    // $('#btn-grouper').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-check"></i> GROUPER');        
                    // console.log(formatErrorMessage(event, errorThrown)); 
                }
            });
            event.preventDefault();
        });



        $('#table-pelayanan tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table_pelayanan.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                closeOpenedRows(table_pelayanan, tr);
                row.child(form_klaim(row.data())).show();
                tr.addClass('shown');
                openRows.push(tr);

                /// Reinitialize for klaim ///
                $('#no_register').val(no_register);

                // added for show hide si naik kelas 
                $("#naik_turun_kelas").change(function() {
                    if ($(this).is(':checked')) {
                        $("#naik_kelas").show();
                    } else {
                        $("#naik_kelas").hide();
                    }
                })

                $('#show_result_sep').hide();
                $(document).on('hidden.bs.modal', '#modal_sep', function() {
                    reset_result_sep();
                });

                $(document).on('show.bs.modal', '#modal_sep', function() {
                    $('#no_sep_manual').val($('#no_sep').val());
                });

                $('.date_picker').datetimepicker({
                    format: 'Y-m-d H:i:s',
                });
                $('#nama_dokter').select2({
                    placeholder: 'Silahkan Pilih DPJP',
                });

                $.ajax({
                    // old
                    // url: '<?php // echo site_url('inacbg/master/data_dokter'); ?>',
                    
                    // new
                    url: '<?php echo site_url('inacbg/master/data_dokter_noreg/'); ?>' + no_register,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        $('#nama_dokter').empty();
                        $('#nama_dokter').append('<option value="">-- Silahkan Pilih DPJP --</option>');
                        $.each(data, function(key, value) {
                            $('#nama_dokter').append('<option value="' + value.nm_dokter + '" selected>' + value.nm_dokter + '</option>');
                        });
                        // load_data_pasien();
                    }
                });
                $('.tambahan_biaya_result').hide();
                $('#grouper_result').hide();
                $('#div_upgrade_class_ind,#div_upgrade_class_class,#div_upgrade_class_los,#div_icu_indicator,#div_icu_los,#div_ventilator_hour').hide();
                $('#div_add_payment_pct').hide();
                $('#div_rawat_inap').hide();
                $(".ranap_naikturunkelas").hide();
                $("#naik_kelas").hide();


                load_data_pasien();
                get_claim_data();
                get_diagnosa();

                $('#id_diagnosa').select2({
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
                        url: '<?php echo base_url() . 'inacbg/pasien/select2_diagnosa_inacbg'; ?>',
                        dataType: 'JSON',
                        delay: 250,
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                }).on("change", function() {
                    $('.select2-selection__rendered').removeAttr('title');
                    var data = $('#id_diagnosa').select2('data');
                    if (data.length > 0) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('inacbg/pasien/insert_diagnosa_inacbg') ?>",
                            dataType: "JSON",
                            data: {
                                "no_register": no_register,
                                "tgl_masuk": $('#tgl_masuk').val(),
                                "diagnosa": data[0].id
                            },
                            success: function(result) {
                                $('#id_diagnosa').val(null).trigger('change');
                                if (result.metadata.code) {
                                    if (result.metadata.code == '200') {
                                        table_diagnosa.ajax.reload();
                                        get_diagnosa();
                                        toastr.success('Diagnosa berhasil disimpan.', 'Sukses!');
                                    } else if (result.metadata.code == '422') {
                                        toastr.warning('Silahkan pilih diagnosa yang lain.', 'Diagnosa sudah ada.');
                                    } else {
                                        toastr.error(result.metadata.message, 'Gagal menginput diagnosa.');
                                    }
                                } else toastr.error('Silahkan coba kembali.', 'Gagal menginput diagnosa.');
                            },
                            error: function(event, textStatus, errorThrown) {
                                $('#id_diagnosa').val(null).trigger('change');
                                toastr.error(formatErrorMessage(event, errorThrown), 'Gagal menginput diagnosa.');
                            }
                        });
                    }
                });

                table_diagnosa = $('#table_diagnosa').DataTable({
                    "lengthChange": false,
                    "language": {
                        "emptyTable": "Diagnosa belum diinput."
                    },
                    "searching": false,
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        ['10 rows', '25 rows', '50 rows', 'Show all']
                    ],
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    "ajax": {
                        "url": "<?php echo site_url('inacbg/diagnosa/get_diagnosa_inacbg_new') ?>",
                        "type": "POST",
                        "dataType": 'JSON',
                        "data": function(data) {
                            data.no_register = no_register;
                        }
                    },
                    "columnDefs": [{
                            "width": "8%",
                            "targets": 0
                        },
                        {
                            "width": "13%",
                            "targets": [3, 4, 5]
                        },
                        {
                            "orderable": false,
                            "targets": [0, 1, 2, 3, 4, 5]
                        }
                    ],
                    "drawCallback": function(settings) {
                        $("#table_diagnosa").wrap("<div class='table-responsive'></div>");
                    }
                });
                get_procedure();
                $('#id_procedure').select2({
                    placeholder: 'Ketik kode atau nama prosedur',
                    minimumInputLength: 1,
                    language: {
                        inputTooShort: function(args) {
                            return "Ketik kode atau nama prosedur";
                        },
                        noResults: function() {
                            return "Prosedur tidak ditemukan.";
                        },
                        searching: function() {
                            return "Searching.....";
                        }
                    },
                    ajax: {
                        type: 'GET',
                        url: '<?php echo base_url() . 'procedure/select2_inacbg'; ?>',
                        dataType: 'JSON',
                        delay: 250,
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                }).on("change", function() {
                    $('.select2-selection__rendered').removeAttr('title');
                    var data = $('#id_procedure').select2('data');
                    if (data.length > 0) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('procedure/insert') ?>",
                            dataType: "JSON",
                            data: {
                                "no_register": no_register,
                                "tgl_masuk": $('#tgl_masuk').val(),
                                "procedure": data[0].id
                            },
                            success: function(result) {
                                $('#id_procedure').val(null).trigger('change');
                                if (result.metadata.code) {
                                    if (result.metadata.code == '200') {
                                        table_procedure.ajax.reload();
                                        get_procedure();
                                        toastr.success('Prosedur berhasil disimpan.', 'Sukses!');
                                    } else if (result.metadata.code == '422') {
                                        toastr.warning('Silahkan pilih prosedur yang lain.', 'Prosedur sudah ada.');
                                    } else {
                                        toastr.error(result.metadata.message, 'Gagal menginput prosedur.');
                                    }
                                } else toastr.error('Silahkan coba kembali.', 'Gagal menginput prosedur.');
                            },
                            error: function(event, textStatus, errorThrown) {
                                $('#id_procedure').val(null).trigger('change');
                                toastr.error(formatErrorMessage(event, errorThrown), 'Gagal menginput prosedur.');
                            }
                        });
                    }
                });



                table_procedure = $('#table_procedure').DataTable({
                    "lengthChange": false,
                    "language": {
                        "emptyTable": "Procedure belum diinput."
                    },
                    "searching": false,
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        ['10 rows', '25 rows', '50 rows', 'Show all']
                    ],
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    "ajax": {
                        "url": "<?php echo site_url('procedure/get_procedure') ?>",
                        "type": "POST",
                        "dataType": 'JSON',
                        "data": function(data) {
                            data.no_register = no_register;
                        }
                    },
                    "columnDefs": [{
                            "width": "8%",
                            "targets": 0
                        },
                        {
                            "width": "13%",
                            "targets": [2]
                        },
                        {
                            "orderable": false,
                            "targets": [0, 2]
                        }
                    ],
                    "drawCallback": function(settings) {
                        $("#table_procedure").wrap("<div class='table-responsive'></div>");
                    }
                });
                tarif_rs();


                $('#upgrade_class_ind').change(function() {
                    if ($(this).is(':checked')) {
                        $('#div_upgrade_class_class,#div_upgrade_class_los').fadeIn(300);
                    } else {
                        $('#upgrade_class_class').val(null).trigger('change');
                        $('#upgrade_class_los').val('0');
                        $('#div_upgrade_class_class,#div_upgrade_class_los').fadeOut(300);
                    }
                });

                $('#icu_indicator').change(function() {
                    if ($(this).is(':checked')) {
                        $('#div_icu_los,#div_ventilator_hour').fadeIn(300);
                    } else {
                        $('#div_icu_los').val('0');
                        $('#div_ventilator_hour').val('0');
                        $('#div_icu_los,#div_ventilator_hour').fadeOut(300);
                    }
                });

                $(".input_tarif_rs").on("keypress keyup blur", function(event) {
                    $(this).val($(this).val().replace(/[^\d].+/, ""));
                    if ((event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });

                /// Reinitialize for klaim ///
            }
        });

        $("#cari_pasien").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: "<?php echo site_url('inacbg/pasien/get_autocomplete_new') ?>",
                    dataType: "JSON",
                    beforeSend: function() {
                        check_login();
                    },
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        if (!data.length) {
                            var result = [{
                                label: 'Data tidak ditemukan'
                            }];
                            $.ui.autocomplete.prototype._renderItem = function(ul, item) {
                                return $("<li></li>")
                                    .data("item.autocomplete", item)
                                    .append("<a style='display:inline-block;width: 100%;'><p style='font-size: 14px;margin-bottom: 3px;font-style: italic'>" + item.label + "</p></a>")
                                    .appendTo(ul);
                            };
                            response(result);
                        } else {
                            $.ui.autocomplete.prototype._renderItem = function(ul, item) {
                                no_cm = String(item.no_cm).replace(
                                    new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                                    "<span class='ui-state-highlight'>$&</span>"
                                );
                                var nama = String(item.nama).replace(
                                    new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                                    "<span class='ui-state-highlight'>$&</span>"
                                );
                                var tgl_lahir = String(item.tgl_lahir).replace(
                                    new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                                    "<span class='ui-state-highlight'>$&</span>"
                                );
                                var no_kartu = String(item.no_kartu).replace(
                                    new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                                    "<span class='ui-state-highlight'>$&</span>"
                                );
                                return $("<li></li>")
                                    .data("item.autocomplete", item)
                                    .append("<a style='display:inline-block;width: 100%;'><p class='pull-right' style='font-size: 14px;font-weight: 600;'>RM : " + no_cm + "</p><p style='font-size: 14px;font-weight: 600;margin-bottom: 3px;'>" + nama + "</p><p style='font-size: 14px;margin-bottom: 3px;'>No. Kartu : " + no_kartu + "</p><span style='font-size: 14px;'>Tgl. Lahir : " + tgl_lahir + "</span></a>")
                                    .appendTo(ul);
                            };
                            response(data);
                        }
                    }
                });
            },
            select: function(event, ui) {
                if (ui.item == null) {
                    $('#show-pasien').hide();
                } else $('#show-pasien').show();

                if (ui.item.no_cm != '' && ui.item.nama != '') {
                    $('#separate_rm').show();
                }
                if (ui.item.nama != '' && ui.item.gender != '') {
                    $('#separate_nama').show();
                }
                if (ui.item.gender != '' && ui.item.tgl_lahir != '') {
                    $('#separate_gender').show();
                }
                $('#no_cm').val(ui.item.no_cm);
                $('#no_rm').html(ui.item.no_cm);
                $('#nama_pasien').html(ui.item.nama);
                $('#tgl_lahir').html(ui.item.tgl_lahir);
                $('#gender').html(ui.item.gender == 'L' ? 'Laki - Laki' : "Perempuan");
                load_pelayanan();
            }
        }).on("focus", function() {
            $(this).autocomplete("search", $(this).val());
        });
    })





    function check_login() {
        // $.ajax({
        //   type: "GET",
        //   url: "<?php echo site_url('login/ajax_check') ?>",
        //   dataType: "JSON",
        //   success: function(result) {
        //     if (result === 0) {
        //       swal({
        //           title: "Perhatian",
        //           text: "Sesi Anda Sudah Habis. Silahkan Login Kembali.",
        //           type: "warning"
        //       }, function() {
        //           window.location.href = "<?php echo site_url('/login'); ?>";
        //       });
        //     }
        //   }
        // });
    }

    function load_pelayanan() {
        // console.log(no_cm);
        // return;
        var data_no_cm = '';
        if (no_cm.includes(`<span class='ui-state-highlight'>`)) {
            data_no_cm = no_cm.split(`<span class='ui-state-highlight'>`);
            data_no_cm = data_no_cm[1].split('</span>')[0];
        } else {
            data_no_cm = no_cm;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('inacbg/pasien/get_pelayanan_new') ?>",
            dataType: "JSON",
            data: {
                no_cm: data_no_cm
            },
            beforeSend: function() {
                check_login();
                $('#show-table-pelayanan').hide();
                $('#show-loading').show();
            },
            success: function(result) {
                $('#show-loading').fadeOut("slow", function() {
                    $('#load_pelayanan').fadeIn("slow");
                });
                table_pelayanan.clear().draw();
                table_pelayanan.rows.add(result);
                table_pelayanan.columns.adjust().draw();
            },
            error: function(event, textStatus, errorThrown) {
                swal("Gagal", formatErrorMessage(event, errorThrown), "error");
            }
        });
    }
</script>