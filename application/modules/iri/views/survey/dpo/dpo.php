<?php
$this->load->view('layout/header_form');
$data = isset($resep_kio->kio) ? json_decode($resep_kio->kio) : '';
?>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<script>
    function ambilcara_pemberian() {
        $.ajax({
            url: "<?php echo base_url(); ?>iri/rictindakan/obat_cara_pakai",
            success: function(data) {
                let html = '<option value="" selected>Silahkan Pilih Cara Pakai Obat</option>';
                data.map((e) => {
                    html += `
                            <option value="${e.cara_pakai}">${e.cara_pakai}</option>
                            `;
                });
                $("#cara_pakai").empty().html(html);
            },
            error: function(event, textStatus, errorThrown) {

            }
        });
    }

    function ambilcara_pemberian2() {
        $.ajax({
            url: "<?php echo base_url(); ?>iri/rictindakan/obat_cara_pakai",
            success: function(data) {
                let html = '<option value="" selected>Silahkan Pilih Cara Pakai Obat</option>';
                data.map((e) => {
                    html += `
                            <option value="${e.cara_pakai}">${e.cara_pakai}</option>
                            `;
                });
                $("#cara_pakai2").empty().html(html);
            },
            error: function(event, textStatus, errorThrown) {

            }
        });
    }

    function master_obat() {
        $.ajax({
            url: "<?php echo base_url(); ?>iri/rictindakan/get_master_obat_dpo",
            success: function(data) {
                let html = '<option value="" selected>Silahkan Pilih Obat</option>';
                data.map((e) => {
                    html += `
                            <option value="${e.id_obat}">${e.nm_obat}</option>
                            `;
                    // console.log(e)

                    // console.log(e.nm_obat);
                });
                $("#tambah_id_obat").empty().html(html);
                // $("#retur_id_obat").empty().html(html);
            },
            error: function(event, textStatus, errorThrown) {

            }
        });
    }

    function frekuensi() {
        $.ajax({
            url: "<?php echo base_url(); ?>iri/rictindakan/signa_pakai",
            success: function(data) {
                let html = '<option value="" selected>Silahkan Pilih </option>';
                data.map((e) => {
                    html += `
                            <option value="${e.signa}">${e.signa}</option>
                            `;
                });
                $("#signa_tambah").empty().html(html);
            },
            error: function(event, textStatus, errorThrown) {

            }
        });
    }

    $(document).ready(function() {
        $('#tabel_farmasi').DataTable();
        $('#tabel_dpo').DataTable();

        $("#cara_pakai").select2({
            dropdownParent: $("#histori")
        });

        $("#cara_pakai2").select2({
            dropdownParent: $("#tambahobat")
        });

        $("#tambah_id_obat").select2({
            dropdownParent: $("#tambahobat")
        });

        $("#signa_tambah").select2({
            dropdownParent: $("#tambahobat")
        });

        $("#retur_id_obat").select2({
            dropdownParent: $("#returobat")
        });




        $('#form-diagnosa-submit_luar').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>iri/Rictindakan/insert_obat_resep_luar",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    new swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                            willClose: () => {
                                // window.location.reload();
                            }
                        },
                        function() {
                            // window.location.reload();
                        });
                },
                error: function(event, textStatus, errorThrown) {
                    document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
                    new swal("Error", "Data gagal disimpan.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' +
                        errorThrown);
                }
            });
        });

        $('#form-diagnosa-submit-tambah').on('submit', function(e) {
            e.preventDefault();

            // console.log(data);

            $.ajax({
                url: "<?php echo base_url(); ?>iri/Rictindakan/insert_obat_resep_tambah",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    new swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                            willClose: () => {
                                window.location.reload();
                            }
                        },
                        function() {
                            window.location.reload();
                        });
                },
                error: function(event, textStatus, errorThrown) {
                    document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
                    new swal("Error", "Data gagal disimpan.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' +
                        errorThrown);
                }
            });
            // $.ajax({
            //     url: "<?php echo base_url(); ?>iri/Rictindakan/insert_obat_resep_tambah",
            //     type: "POST",
            //     dataType: "JSON",
            //     data: $('#form-diagnosa-submit-tambah').serialize(),
            //     success: function(data) {

            //         new swal({
            //                 title: "Selesai",
            //                 text: "Data berhasil disimpan",
            //                 type: "success",
            //                 showCancelButton: false,
            //                 closeOnConfirm: false,
            //                 showLoaderOnConfirm: true,
            //                 willClose: () => {
            //                     window.location.reload();
            //                 }
            //             },
            //             function() {
            //                 window.location.reload();
            //             });
            //     },
            //     error: function(event, textStatus, errorThrown) {
            //         document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
            //         new swal("Error", "Data gagal disimpan.", "error");
            //         console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
            //     }
            // });
        });


        $('#form-retur-submit').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>iri/Rictindakan/insert_obat_resep_retur",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    new swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                            willClose: () => {
                                window.location.reload();
                            }
                        },
                        function() {
                            window.location.reload();
                        });
                },
                error: function(event, textStatus, errorThrown) {
                    document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
                    new swal("Error", "Data gagal disimpan.", "error");
                    console.log('Error Message: ' + textStatus + ' , HTTP Error: ' +
                        errorThrown);
                }
            });

        });

        ambilcara_pemberian();
        ambilcara_pemberian2();
        master_obat();
        frekuensi();
    });


    function edit_obat_farmasi_racikan(data) {
        let html = `
        <input type="hidden" name="nama_racikan" value="${data.obat_racikan_header[0].nama_racikan}">
        <input type="hidden" name="cara_pakai" value="${data.obat_racikan_header[0].cara_pakai}">
        <input type="hidden" name="qtx" value="${data.obat_racikan_header[0].qtx}">
        <input type="hidden" name="satuan" value="${data.obat_racikan_header[0].satuan}">
        <input type="hidden" name="signa" value="${data.obat_racikan_header[0].signa}">
        <input type="hidden" name="qty_total" value="${data.obat_racikan_header[0].qty_total}">
        `;
        data.item_racikan.map((e) => {
            var batch = '';
            html += `
            <tr>
                <td>${e.nm_obat.split('-')[0]}</td>
                <td>
                    
                    <input type="hidden" name="obat[]" value="${e.nm_obat.split('-')[1]}">
                    <input type="hidden" name="nama_obat[]" value="${e.nm_obat.split('-')[0]}">
                    <input type="text" name="qty[]" class="form-control">
                </td>
                <td>
                    <select class="form-control" name="batch[]" id="batch${e.nm_obat.split('-')[1]}">
                        ${batch}
                    </select>
                </td>
            </tr>
            `;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: "<?php echo base_url('iri/Rictindakan/get_data_edit_obat_farmasi') ?>",
                data: {
                    id_obat: e.nm_obat.split('-')[1]
                },
                success: function(data) {
                    // $('#edit_id_obat_farmasi_hidden').val(data[0].id_obat);
                    // $('#edit_nama_obat_farmasi').val(data[0].nm_obat);
                    //  $('#edit_biaya_obat').val(data[0].hargajual);
                    // $('#edit_qty_farmasi').val(data[0].qty);
                    // $('#edit_qty_farmasi_hidden').val(data[0].qty);
                    // $('#edit_id_resep_dokter_far').val(data[0].id_resep_dokter);
                    // $('#edit_signa_farmasi').val(data[0].kali_harian).change();
                    // $('#edit_qtx_farmasi').val(data[0].qtx).change();
                    // $('#edit_satuan_farmasi').val(data[0].satuan).change();
                    // $('#edit_cara_pakai_farmasi').val(data[0].cara_pakai).change();
                    // let html = '';
                    if (data.dpo.length) {
                        $(`#batch${e.nm_obat.split('-')[1]}`).append(
                            '<option value="" selected>Pilih Batch</option>');
                        data.dpo.map((i) => {
                            $(`#batch${e.nm_obat.split('-')[1]}`).append(`
                                <option value="${i.id_inventory}">${'(batch -'+i.batch_no+','+i.expire_date+','+i.qty+')'}</option>
                                `);
                        })
                    }
                },
                error: function() {
                    // alert("error");
                }
            });
        });
        $("#table-item-racikan").html(html)
        $("#racikanobat").modal('toggle');
        console.log(data);
    }



    // function edit_obat_farmasi(id_obat, frek, dokter, farmasi, cara_pakai = '',resep_dokter) {

    //     $.ajax({
    //         type: 'POST',
    //         dataType: 'json',
    //         url: "<?php echo base_url('iri/Rictindakan/get_data_edit_obat_farmasi') ?>",
    //         data: {
    //             id_obat: id_obat,
    //             frek: frek,
    //             dokter: dokter,
    //             farmasi: farmasi
    //         },
    //         success: function(data) {
    //             console.log(data);
    //             $("#cara_pakai").val(cara_pakai).trigger('change');
    //             $('#edit_id_obat_farmasi').val(data.dpo[0].id_obat);
    //             $('#edit_nama_obat_farmasi').val(data.dpo[0].nm_obat);
    //             $('#dokter_pemeriksa').val(data.dokter);
    //             $('#farmasi_pemeriksa').val(data.farmasi);
    //             $('#edit_signa').val(data.qty);
    //             let html = '';
    //             if (data.dpo.length) {
    //                 $('#pilihbatch').empty();
    //                 html += '<option value="" selected>Pilih Batch</option>';
    //                 data.dpo.map((i) => {
    //                     html += `
    //                         <option value="${i.id_inventory}">${'(batch -'+i.batch_no+','+i.expire_date+','+i.qty+')'}</option>
    //                         `;
    //                     console.log(i)
    //                 })

    //                 $('#pilihbatch').html(html);

    //                 console.log(data)

    //             }
    //             let html2 = '';
    //             if (data.sub.length) {
    //                 $('#obatsubtitusi').empty();
    //                 html2 += '<option value="" selected>Pilih Substitusi</option>';
    //                 data.sub.map((a) => {
    //                     html2 += `
    //                         <option value="${a.id_obat_sub}">${a.nm_obat}</option>
    //                         `;
    //                     console.log(a)
    //                 })

    //                 $('#obatsubtitusi').html(html2);

    //                 console.log(data)
    //                 return true;
    //             }
    //         },
    //         error: function() {
    //             alert("error");
    //         }
    //     });
    // }
    // onclick="edit_obat_farmasi(<?php //echo isset($idobat) ? $idobat : null 
                                    ?>,'<?php //echo isset($row->frekuensi) ? $row->frekuensi : '' 
                                                                                    ?>',
    // '<?php //echo isset($row->paraf_dok) ? $row->paraf_dok : '' 
        ?>','<?php //echo isset($data->matriks_telaah_obat[0]->disiapkan) ? $data->matriks_telaah_obat[0]->disiapkan : '' 
                                                                        ?>'
    // ,'<?php //echo $row->cara_pakai??'' 
            ?>')">Detail





    function edit_obat_farmasi_luar(nm_obat, frek, dokter, farmasi) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('iri/Rictindakan/get_data_edit_obat_farmasi_obat_luar') ?>",
            data: {
                nm_obat: nm_obat,
                frek: frek,
                dokter: dokter,
                farmasi: farmasi
            },
            success: function(data) {
                $('#edit_nama_obat_farmasi_luar').val(data.nm_obat);
                // $('#edit_nama_obat_farmasi').val(data.dpo[0].nm_obat);
                // $('#edit_qty').val(data.qty);
                $('#edit_signa_luar').val(data.qty);
                $('#dokter_pemeriksa_luar').val(data.dokter);
                $('#farmasi_pemeriksa_luar').val(data.farmasi);
                // $('#nm_gudang').val(data.gudang);
                // $('#edit_id_resep_dokter_far').val(data[0].id_resep_dokter);
                // $('#edit_signa_farmasi').val(data[0].kali_harian).change();
                // $('#edit_qtx_farmasi').val(data[0].qtx).change();
                // $('#edit_satuan_farmasi').val(data[0].satuan).change();
                // $('#edit_cara_pakai_farmasi').val(data[0].cara_pakai).change();

            },
            error: function() {
                alert("error");
            }
        });
    }

    function ajaxbiayaobat(id) {
        let idobat = $('#pilihbatch').val();
        // console.log(idobat);
        $.ajax({
            url: '<?= base_url('farmasi/Frmcdaftar/get_biaya_obat/') ?>' + idobat,
            beforeSend: function() {},
            success: function(data) {
                // console.log(data)
                $('#edit_biaya_obat').val(data.hargajual);
                //    $('#biaya_obat_hide').val(data.hargajual);
                //    $('#idtindakansub').val(data.nm_obat_substitusi);
                // set_total_new();

            },
            error: function(xhr) { // if error occured
                $('#obatsubtitusi').empty();
                let html = '<option>Silahkan Kontak Admin IT</option>';
                $('#obatsubtitusi').html(html)
            },
            complete: function() {

            },
        });


    }

    function set_total_new() {
        console.log('masuk sini');
        var total = ($("#edit_biaya_obat").val() * $("#edit_qty").val());
        var emblasi = $("#emblasi").val();
        var tot_akhir = (parseInt(total) + parseInt(emblasi));
        // console.log( $("#emblasi").val());
        // console.log(tot_akhir);

        $('#edit_total_akhir').val(tot_akhir.toFixed(0));
    }

    function ajaxdokterkonsul3(id) {
        let idobat = $('#obatsubtitusi').val();
        console.log(idobat);
        $.ajax({
            url: '<?= base_url('iri/Rictindakan/data_obat_sub3/') ?>' + idobat,
            beforeSend: function() {},
            success: function(data) {
                console.log(data)
                let html = '';
                if (data.length) {
                    $('#pilihbatch').empty();
                    html += '<option value="" selected>Pilih Batch</option>';
                    data.map((i) => {
                        html += `
                            <option value="${i.id_inventory}">${'(batch -'+i.batch_no+','+i.expire_date+','+i.qty+')'}</option>
                            `;
                        console.log(i)
                        $('#idtindakansub').val(i.nm_obat);
                    })

                    $('#pilihbatch').html(html);

                    console.log(data)

                }

            },
            error: function(xhr) { // if error occured
                $('#obatsubtitusi').empty();
                let html = '<option>Silahkan Kontak Admin IT</option>';
                $('#obatsubtitusi').html(html)
            },
            complete: function() {

            },
        });



    }

    function tambahobatdetail(id) {
        let idobat = $('#tambah_id_obat').val();
        console.log(idobat);
        $.ajax({
            url: '<?= base_url('iri/Rictindakan/data_obat_sub3/') ?>' + idobat,
            beforeSend: function() {},
            success: function(data) {
                console.log(data)
                let html = '';
                if (data.length) {
                    $('#pilihbatchtambah').empty();
                    html += '<option value="" selected>Pilih Batch</option>';
                    data.map((i) => {
                        html += `
                            <option value="${i.id_inventory}">${'(batch -'+i.batch_no+','+i.expire_date+','+i.qty+')'}</option>
                            `;
                        console.log(i)
                        // $('#nm_obat_tambah').val(e.nm_obat);
                        $('#nm_obat_tambah').val(i.nm_obat);
                    })

                    $('#pilihbatchtambah').html(html);

                    console.log(data)

                }
            },
            error: function(xhr) { // if error occured
                $('#tambah_id_obat').empty();
                let html = '<option>Silahkan Kontak Admin IT</option>';
                $('#tambah_id_obat').html(html)
            },
            complete: function() {

            },
        });
    }

    function ajaxbiayaobattambah(id) {
        let idobat = $('#pilihbatchtambah').val();
        console.log(idobat);
        $.ajax({
            url: '<?= base_url('farmasi/Frmcdaftar/get_biaya_obat/') ?>' + idobat,
            beforeSend: function() {},
            success: function(data) {
                console.log(data)
                $('#edit_biaya_obat_tambah').val(data.hargajual);
                // set_total_new();

            },
            error: function(xhr) { // if error occured
                $('#obatsubtitusi').empty();
                let html = '<option>Silahkan Kontak Admin IT</option>';
                $('#obatsubtitusi').html(html)
            },
            complete: function() {

            },
        });


    }

    function set_total_new2() {
        console.log($("#edit_biaya_obat_tambah").val());
        var total = ($("#edit_biaya_obat_tambah").val() * $("#edit_qty_tambah").val());
        $('#edit_total_akhir_tambah').val(total.toFixed(0));
        console.log(total);
    }
</script>


<div class="card m-5">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5>Daftar Obat</h5>
        </div>
    </div>


    <div class="card-body">
        <div class="body">
            <div class="table-responsive">
                <table id="tabel_farmasi" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Obat dari Luar</th>
                            <th>Nama Obat</th>
                            <th>Dosis</th>
                            <th>Frekuensi</th>
                            <th>Cara Pakai</th>
                            <th>Rute</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (isset($data->obat_racikan)) {
                            foreach ($data->obat_racikan as $v) {
                        ?>

                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo 'Tidak' ?></td>
                                    <td colspan="6">
                                        <?php echo $v->obat_racikan_header[0]->nama_racikan . '<br>'; ?>
                                        <?php
                                        foreach ($v->item_racikan as $w) {
                                            echo $w->nm_obat . ' (Dosis : ' . $w->dosis . ') ' . $w->satuan;
                                            echo '<br>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick='edit_obat_farmasi_racikan(<?= json_encode($v) ?>)'>Detail
                                            Obat</button>
                                    </td>

                                </tr>

                        <?php }
                        }
                        ?>
                        <?php
                        if (isset($data->question2)) {
                            foreach ($data->question2 as $row) {
                                // var_dump($row);
                                if (!isset($row->stop)) :
                                    if (isset($row->nm_obat)) {
                                        $obats = explode("-", $row->nm_obat);
                                        $idobat = end($obats);
                                        array_pop($obats);
                                        $nmobat = join(' ', $obats);
                                    } else {
                                        $nmobat = $row->obat_luar ?? '-';
                                        $idobat = null;
                                    }

                        ?>

                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo (isset($row->nm_obat)) ? 'Tidak' : 'Ya' ?></td>
                                        <td><?php echo isset($nmobat) ? $nmobat : '' ?></td>
                                        <td><?php echo isset($row->dosis) ? $row->dosis : '' ?></td>
                                        <td><?php echo isset($row->frekuensi) ? $row->frekuensi : '' ?></td>
                                        <td><?php echo isset($row->cara_pakai) ? $row->cara_pakai : '' ?></td>
                                        <td><?php echo isset($row->rute) ? $row->rute : '' ?></td>
                                        <td><?php echo isset($row->catatan) ? $row->catatan : '' ?></td>
                                        <td>
                                            <?php if (isset($idobat)) { ?>
                                                <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#histori" onclick='edit_obat_farmasi(<?= json_encode($row); ?>)'>Detail
                                                    Obat</button>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#histori_obat_luar" onclick="edit_obat_farmasi_luar('<?php echo isset($nmobat) ? $nmobat : null ?>','<?php echo isset($row->frekuensi) ? $row->frekuensi : '' ?>','<?php echo isset($row->paraf_dok) ? $row->paraf_dok : '' ?>','<?php echo isset($data->matriks_telaah_obat[0]->disiapkan) ? $data->matriks_telaah_obat[0]->disiapkan : '' ?>')">Detail
                                                    Obat Luar</button>
                                            <?php } ?>
                                        </td>

                                    </tr>
                            <?php endif;
                            }
                        } else { ?>
                            <td colspan="5" style="text-align:center">Tidak ada data</td>
                        <?php } ?>
                    </tbody>
                </table>
            </div><br><br>

            <div class="table-responsive">
                <table id="tabel_farmasi" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Obat dari Luar</th>
                            <th>Nama BMHP</th>
                            <th>Dosis</th>
                            <th>Frekuensi</th>
                            <th>Cara Pakai</th>
                            <th>Rute</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($data->question1)) {
                            foreach ($data->question1 as $row) {
                                // var_dump($row);
                                if (!isset($row->stop)) :
                                    if (isset($row->nm_obat)) {
                                        $obats = explode("-", $row->nm_obat);
                                        $idobat = end($obats);
                                        array_pop($obats);
                                        $nmobat = join(' ', $obats);
                                    } else {
                                        $nmobat = $row->obat_luar ?? '-';
                                        $idobat = null;
                                    }

                        ?>

                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo (isset($row->nm_obat)) ? 'Tidak' : 'Ya' ?></td>
                                        <td><?php echo isset($nmobat) ? $nmobat : '' ?></td>
                                        <td><?php echo isset($row->dosis) ? $row->dosis : '' ?></td>
                                        <td><?php echo isset($row->frekuensi) ? $row->frekuensi : '' ?></td>
                                        <td><?php echo isset($row->cara_pakai) ? $row->cara_pakai : '' ?></td>
                                        <td><?php echo isset($row->rute) ? $row->rute : '' ?></td>
                                        <td><?php echo isset($row->catatan) ? $row->catatan : '' ?></td>
                                        <td>
                                            <?php if (isset($idobat)) { ?>
                                                <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#histori" onclick='edit_obat_farmasi(<?= json_encode($row); ?>)'>Detail
                                                    Obat</button>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#histori_obat_luar" onclick="edit_obat_farmasi_luar('<?php echo isset($nmobat) ? $nmobat : null ?>','<?php echo isset($row->frekuensi) ? $row->frekuensi : '' ?>','<?php echo isset($row->paraf_dok) ? $row->paraf_dok : '' ?>','<?php echo isset($data->matriks_telaah_obat[0]->disiapkan) ? $data->matriks_telaah_obat[0]->disiapkan : '' ?>')">Detail
                                                    Obat Luar</button>
                                            <?php } ?>
                                        </td>

                                    </tr>
                            <?php endif;
                            }
                        } else { ?>
                            <td colspan="5" style="text-align:center">Tidak ada data</td>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>


<div class="card m-5">


    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5>DAFTAR PEMBERIAN OBAT</h5>
            <div class="d-flex">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#histori" onclick="edit_obat_farmasi('')">Tambah Obat</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#returobat" onclick="get_resep_pasien()">Retur Obat</button>
            </div>
        </div>
    </div>

    <form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/insert_dpo'); ?>" method="post">
        <div class="card-body">
            <div class="body">
                <div class="table-responsive">
                    <table id="tabel_dpo" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Obat</th>
                                <th>Frekuensi/Rute</th>
                                <th>Cara Pakai</th>
                                <th>Dokter</th>
                                <th>Farmasi</th>
                                <th>Perawat</th>
                                <th>Waktu Pemberian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $i = 1;
                            foreach ($dpo as $row) {
                            ?>

                                <tr>

                                    <td><?php echo $i++; ?></td>
                                    <!-- <td> -->
                                    <input type="hidden" class="form-control" name="id_obat_dpo[]" id="id_obat_dpo" readonly value="<?php echo $row->id_obat ?>">
                                    <input type="hidden" class="form-control" name="id_dpo[]" id="id_dpo" readonly value="<?php echo $row->id ?>">
                                    <!-- </td> -->

                                    <td>
                                        <input type="text" class="form-control" name="nmobat-<?php echo $row->id; ?>" id="nm_obat_dpo" readonly value="<?php echo $row->nm_obat ?>">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="frek-<?php echo $row->id; ?>" id="frek_dpo" readonly value="<?php echo $row->frekuensi ?>">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="cara_pakai-<?php echo $row->id; ?>" id="cara_pakai_dpo" readonly value="<?php echo $row->cara_pakai ?>">
                                    </td>

                                    <td>
                                        <select class="form-control js-example-basic-single" name="nm_dokter-<?php echo $row->id; ?>" id="nm_dokter">
                                            <option value="<?php echo $row->dokter ?>">-Pilih Dokter-</option>

                                            <?php
                                            foreach ($dokter as $row2) {
                                                if ($row2->nm_dokter . '-' . $row2->userid == $row->dokter) {

                                            ?>
                                                    <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>" selected="">
                                                        <?= $row2->nm_dokter ?></option>
                                                <?php } ?>
                                                <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>">
                                                    <?= $row2->nm_dokter ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control js-example-basic-single" name="nm_farmasi-<?php echo $row->id; ?>" id="nm_farmasi">
                                            <option value="">-Pilih Farmasi-</option>

                                            <?php
                                            foreach ($farmasi as $row2) {
                                                if ($row2->nm_dokter . '-' . $row2->userid == $row->farmasi) {

                                            ?>
                                                    <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>" selected>
                                                        <?= $row2->nm_dokter ?></option>
                                                <?php } ?>
                                                <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>">
                                                    <?= $row2->nm_dokter ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control js-example-basic-single" name="nm_perawat-<?php echo $row->id; ?>" id="nm_perawat">
                                            <option value="<?php echo $row->perawat ?>">-Pilih perawat-</option>

                                            <?php
                                            foreach ($perawat as $row2) {
                                                if ($row2->nm_dokter . '-' . $row2->userid == $row->perawat) {

                                            ?>
                                                    <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>" selected>
                                                        <?= $row2->nm_dokter ?></option>
                                                <?php } ?>
                                                <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>">
                                                    <?= $row2->nm_dokter ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="pagi" value="pagi" name="pagi-<?php echo $row->id; ?>" <?= isset($row->pagi) ? $row->pagi == "pagi" ? 'checked' : '' : '' ?>>
                                            <label class="form-check-label" for="pagi">P</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="siang" value="siang" name="siang-<?php echo $row->id; ?>" <?= isset($row->siang) ? $row->siang == "siang" ? 'checked' : '' : '' ?>>
                                            <label class="form-check-label" for="siang">S</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="sore" value="sore" name="sore-<?php echo $row->id; ?>" <?= isset($row->sore) ? $row->sore == "sore" ? 'checked' : '' : '' ?>>
                                            <label class="form-check-label" for="sore">S</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="malam" value="malam" name="malam-<?php echo $row->id; ?>" <?= isset($row->malam) ? $row->malam == "malam" ? 'checked' : '' : '' ?>>
                                            <label class="form-check-label" for="malam">M</label>
                                            <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd'] ?>">
                                        </div>
                                        <div id="waktupemberian-<?php echo $row->id; ?>">
                                            <?php
                                            if ($row->waktupemberian) {
                                                $datawaktupemberian = json_decode($row->waktupemberian);
                                                foreach ($datawaktupemberian as $vwaktu) {
                                                    echo '
                                                    <div>
                                                        <label class="form-check-label" for="malam">Waktu Pemberian</label>
                                                        <input type="time" name="waktupemberian-' . $row->id . '[]" value="' . $vwaktu . '">
                                                    </div>';
                                                    echo '
                                                    <div>
                                                        <select class="form-control js-example-basic-single" name="disiapkan_oleh-'.$row->id.'[]">
                                                            <option value="">-Disiapkan Oleh-</option>';
                                                                foreach ($farmasi as $row2) {
                                                                    echo '<option value="'.$row2->nm_dokter . '-' . $row2->userid.'>'.$row2->nm_dokter.'</option>';
                                                                }
                                                    echo '</select>
                                                    </div>';
                                                    
                                                }
                                            } else {

                                            ?>
                                                <div>
                                                    <label class="form-check-label" for="malam">Waktu Pemberian</label>
                                                    <input type="time" name="waktupemberian-<?php echo $row->id; ?>[]">
                                                </div>
                                                <div>
                                                        <select class="form-control js-example-basic-single" name="disiapkan_oleh-<?php echo $row->id; ?>[]">
                                                            <option value="">-Disiapkan Oleh-</option>
                                                                <?php
                                                                foreach ($farmasi as $row2) {?>
                                                                    <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>"><?= $row2->nm_dokter ?></option>
                                                                <?php } ?>
                                                        </select>
                                                    <!--  -->
                                                    <!-- <label class="form-check-label" for="malam">Disiapkan Oleh</label>
                                                    <input type="text" name="disiapkanoleh-<?php echo $row->id; ?>[]"> -->
                                                </div>
                                                <div>
                                                        <select class="form-control js-example-basic-single" name="diberikan_oleh-<?php echo $row->id; ?>[]">
                                                            <option value="">-Diberikan Oleh-</option>
                                                                <?php
                                                                foreach ($dokter as $row2) {?>
                                                                    <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>"><?= $row2->nm_dokter ?></option>
                                                                <?php } ?>
                                                        </select>
                                                    <!--  -->
                                                    <!-- <label class="form-check-label" for="malam">Diberikan Oleh</label>
                                                    <input type="text" name="diberikanoleh-<?php echo $row->id; ?>[]"> -->
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-xs btn-primary" onclick="tambahjampemberian(<?php echo $row->id; ?>)">Tambah
                                                Pemberian</button>
                                        </div>

                </div>
                </td>
                <td>
                    <a href="<?php echo site_url("iri/rictindakan/hapus_data_obat_dpo/" . $row->id . '/' . $row->no_ipd); ?>" class="btn btn-danger btn-xs">Hapus</a>
                </td>
                </tr>
            <?php } ?>
            </tbody>
            </table>

            </div>
        </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan Data</button>
</div>
</form>

</div>

<div class="modal fade" id="tambahobat" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-diagnosa-submit-tambah" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Obat</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Nama Obat</p>
                        <div class="col-sm-6">
                            <select id="tambah_id_obat" name="tambah_id_obat" class="form-control tambah_id_obat" style="width:100%;" onchange="tambahobatdetail(this.value)">
                            </select>
                            <input type="hidden" name="nm_obat_tambah" id="nm_obat_tambah">
                        </div>
                    </div>


                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Batch</p>
                        <div class="col-sm-6">
                            <select id="pilihbatchtambah" name="batch_farmasi_tambah" class="form-control" width="100%" onchange="ajaxbiayaobattambah(this.value)">

                                <option value="">Pilih batch</option>
                            </select>

                        </div>
                    </div>


                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Biaya Obat</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_biaya_obat_tambah" id="edit_biaya_obat_tambah" min="0" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Frekuensi</p>
                        <div class="col-sm-6">
                            <select id="signa_tambah" name="signa_tambah" class="form-control signa_tambah" style="width:100%;">
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Cara Pakai</p>
                        <div class="col-sm-6">
                            <select id="cara_pakai2" name="cara_pakai2" class="form-control cara_pakai2" style="width:100%;">
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Qty</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_qty_tambah" id="edit_qty_tambah" min="0" onchange="set_total_new2(this.value)" required>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Total Akhir</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_total_akhir_tambah" id="edit_total_akhir_tambah" min="0" readonly>
                            <input type="hidden" class="form-control" name="idrg" id="idrg" value="<?php echo $data_pasien[0]['idrg'] ?>">
                            <input type="hidden" class="form-control" name="bed" id="bed" value="<?php echo $data_pasien[0]['bed'] ?>">
                            <input type="hidden" class="form-control" name="cara_bayar" id="cara_bayar" value="<?php echo $data_pasien[0]['carabayar'] ?>">
                            <input type="hidden" class="form-control" name="kelas" id="kelas" value="<?php echo $data_pasien[0]['jatahklsiri'] ?>">
                            <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd'] ?>">
                            <input type="hidden" class="form-control" name="no_medrec" id="no_medrec" value="<?php echo $data_pasien[0]['no_medrec'] ?>">
                            <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>">
                            <!-- <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>"> -->
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Waktu Pemberian</p>
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="pagi" value="pagi" name="pagi">
                                <label class="form-check-label" for="pagi">P</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="siang" value="siang" name="siang">
                                <label class="form-check-label" for="siang">S</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="sore" value="sore" name="sore">
                                <label class="form-check-label" for="sore">S</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="malam" value="malam" name="malam">
                                <label class="form-check-label" for="malam">M</label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="returobat" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-retur-submit" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Obat</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Nama Obat</p>
                        <div class="col-sm-6">
                            <select id="retur_id_obat" name="retur_id_obat" class="form-control retur_id_obat" style="width:100%;" onchange='pilihbatchretur(this.value)'>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Batch</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="retur_batch" id="retur_batch">
                            <!-- <select name="retur_batch" id="retur_batch" class="form-control">
                            </select> -->
                            <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd'] ?>">

                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Expire Date</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="retur_expire_date" id="retur_expire_date" readonly>

                        </div>
                    </div>


                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Biaya Obat</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="retur_biaya_obat" id="retur_biaya_obat">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Qty</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="qty_retur" id="qty_retur" min="0" required onchange="hitungvtotretur(this.value)" onkeyup="hitungvtotretur(this.value)">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Total Akhir</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="vtot_retur" id="vtot_retur" min="0" readonly>
                        </div>
                    </div>





                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="histori" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-diagnosa-submit" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Obat</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Obat</p>
                        <div class="col-sm-6">
                            <select name="obat" class="form-control select2obat" onchange="handlerchangeobat(this.value)" style="width:100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Batch</p>
                        <div class="col-sm-6">
                            <select name="batch" class="form-control select2batch">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Qty</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_qty" id="edit_qty" min="0" required>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Frekuensi</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="edit_signa" id="edit_signa">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Cara Pakai</p>
                        <div class="col-sm-6">
                            <select id="cara_pakai" name="cara_pakai" class="form-control cara_pakai" style="width:100%;">
                            </select>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="idrg" id="idrg" value="<?php echo $data_pasien[0]['idrg'] ?>">
                    <input type="hidden" class="form-control" name="bed" id="bed" value="<?php echo $data_pasien[0]['bed'] ?>">
                    <input type="hidden" class="form-control" name="cara_bayar" id="cara_bayar" value="<?php echo $data_pasien[0]['carabayar'] ?>">
                    <input type="hidden" class="form-control" name="kelas" id="kelas" value="<?php echo $data_pasien[0]['jatahklsiri'] ?>">
                    <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd'] ?>">
                    <input type="hidden" class="form-control" name="no_medrec" id="no_medrec" value="<?php echo $data_pasien[0]['no_medrec'] ?>">
                    <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>">



                    <!-- <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Total Akhir</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_total_akhir" id="edit_total_akhir"
                                min="0" readonly>
                            
                        </div>
                    </div> -->

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Waktu Pemberian</p>
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="pagi" value="pagi" name="pagi">
                                <label class="form-check-label" for="pagi">P</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="siang" value="siang" name="siang">
                                <label class="form-check-label" for="siang">S</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="sore" value="sore" name="sore">
                                <label class="form-check-label" for="sore">S</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="malam" value="malam" name="malam">
                                <label class="form-check-label" for="malam">M</label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button onclick="simpanresep()" type="button" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="histori_obat_luar" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-diagnosa-submit_luar" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Obat</h4>
                </div>
                <div class="modal-body">
                    <!-- <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Gudang</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="nm_gudang" id="nm_gudang" readonly>
                        </div>
                    </div> -->

                    <!-- <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Id Obat</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="edit_id_obat_farmasi" id="edit_id_obat_farmasi" readonly>
                        </div>
                    </div> -->

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Nama Obat</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="edit_nama_obat_farmasi_luar" id="edit_nama_obat_farmasi_luar" readonly>
                        </div>
                    </div>

                    <!-- <div class="form-group row mb-2 ms-5">
                        <div class="col-sm-1"></div>
                        <i>*pilih hanya jika obat akan diganti (substitusi)</i>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Obat Substitusi</p>
                        <div class="col-sm-6">
                            <select id="obatsubtitusi" name="cari_obat_sub" class="form-control" width="100%" onchange="ajaxdokterkonsul3(this.value)">
                                <option value="">Obat substitusi tidak tersedia</option>
                            </select>
                            <input type="hidden" name="nm_sub" id="idtindakansub">
                            

                        </div>
                    </div> -->

                    <!-- <div class="form-group row mb-2 ms-5">
                        <div class="col-sm-1"></div>
                        <i>**********************************</i>
                    </div> -->


                    <!-- <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Batch</p>
                        <div class="col-sm-6">
                            <select id="pilihbatch" name="batch_farmasi" class="form-control" width="100%" onchange="ajaxbiayaobat(this.value)">

                                <option value="">Pilih batch</option>
                            </select>

                        </div>
                    </div> -->


                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Biaya Obat</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_biaya_obat_luar" id="edit_biaya_obat_luar" min="0">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Frekuensi</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="edit_signa_luar" id="edit_signa_luar">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Qty</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_qty" id="edit_qty" min="0" onchange="set_total_new(this.value)" required>
                        </div>
                    </div>



                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Total Akhir</p>
                        <div class="col-sm-6">
                            <input type="hidden" name="dokter_luar" id="dokter_pemeriksa_luar">
                            <input type="hidden" name="farmasi_luar" id="farmasi_pemeriksa_luar">
                            <input type="number" class="form-control" name="edit_total_akhir" id="edit_total_akhir" min="0">
                            <input type="hidden" class="form-control" name="idrg" id="idrg" value="<?php echo $data_pasien[0]['idrg'] ?>">
                            <input type="hidden" class="form-control" name="bed" id="bed" value="<?php echo $data_pasien[0]['bed'] ?>">
                            <input type="hidden" class="form-control" name="cara_bayar" id="cara_bayar" value="<?php echo $data_pasien[0]['carabayar'] ?>">
                            <input type="hidden" class="form-control" name="kelas" id="kelas" value="<?php echo $data_pasien[0]['jatahklsiri'] ?>">
                            <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd'] ?>">
                            <input type="hidden" class="form-control" name="no_medrec" id="no_medrec" value="<?php echo $data_pasien[0]['no_medrec'] ?>">
                            <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>">
                            <!-- <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>"> -->
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Waktu Pemberian</p>
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="pagi" value="pagi" name="pagi">
                                <label class="form-check-label" for="pagi">P</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="siang" value="siang" name="siang">
                                <label class="form-check-label" for="siang">S</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="sore" value="sore" name="sore">
                                <label class="form-check-label" for="sore">S</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="malam" value="malam" name="malam">
                                <label class="form-check-label" for="malam">M</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card m-5">
    <div class="card-header">
        <h5>Riwayat Kartu Intruksi Obat</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered datatable" id="dataTables-assesment" style="width:100%;" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Obat</th>
                    <th>qty</th>
                    <th>Frekuensi</th>
                    <th>Cara Pakai</th>
                    <th>Harga Obat</th>
                    <th>Total</th>
                    <th>Dokter</th>
                    <th>Farmasi</th>
                    <th>Perawat</th>
                    <th>Tgl Mulai</th>
                    <th>Stop</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if ($history->num_rows()) {
                    foreach ($history->result() as $val) {
                        //         $json_value = json_decode($value->kio);
                        // var_dump($json_value->question2);
                        // die();
                ?>
                        <?php //foreach ($json_value->question2 as $val) {
                        //var_dump($val);die();
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= isset($val->nm_obat) ? $val->nm_obat : '-' ?></td>
                            <td><?= isset($val->qty) ? $val->qty : '-' ?></td>
                            <td><?= isset($val->frekuensi) ? $val->frekuensi : '-' ?></td>
                            <td><?= isset($val->cara_pakai) ? $val->cara_pakai : '-' ?></td>
                            <td><?= isset($val->biaya_obat) ? $val->biaya_obat : '-' ?></td>
                            <td><?= isset($val->vtot) ? $val->vtot : '-' ?></td>
                            <td><?= isset($val->nmdokter) ? $val->nmdokter : '-' ?></td>
                            <td><?= isset($val->nmfarmasi) ? $val->nmfarmasi : '-' ?></td>
                            <td><?= isset($val->nmperawat) ? $val->nmperawat : '-' ?></td>
                            <td><?= isset($val->tgl_dpo) ? $val->tgl_dpo : '-' ?></td>
                            <td></td>
                        </tr>
                        <?php //} 
                        ?>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td style="text-align:center;" colspan="6">Tidak ada Data</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="racikanobat" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-diagnosa-submit-tambah-racikan" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Obat</h4>
                </div>
                <div class="modal-body">

                    <div>
                        <table class="table" width="100%">
                            <tr>
                                <th>Nama Obat</th>
                                <th>Qty</th>
                                <th>Batch</th>
                            </tr>
                            <tbody id="table-item-racikan">

                            </tbody>
                        </table>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>

                        <div class="col-sm-6">
                            <input type="hidden" class="form-control" name="idrg" id="idrg" value="<?php echo $data_pasien[0]['idrg'] ?>">
                            <input type="hidden" class="form-control" name="bed" id="bed" value="<?php echo $data_pasien[0]['bed'] ?>">
                            <input type="hidden" class="form-control" name="cara_bayar" id="cara_bayar" value="<?php echo $data_pasien[0]['carabayar'] ?>">
                            <input type="hidden" class="form-control" name="kelas" id="kelas" value="<?php echo $data_pasien[0]['jatahklsiri'] ?>">
                            <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd'] ?>">
                            <input type="hidden" class="form-control" name="no_medrec" id="no_medrec" value="<?php echo $data_pasien[0]['no_medrec'] ?>">
                            <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>">
                            <!-- <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>"> -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="simpan_racikan()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function simpan_racikan() {
        $.ajax({
            url: "<?php echo base_url(); ?>iri/Rictindakan/insert_obat_resep_tambah_racikan",
            method: "POST",
            data: $("#form-diagnosa-submit-tambah-racikan").serialize(),
            success: function(data) {

                new swal({
                        title: "Selesai",
                        text: "Data berhasil disimpan",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                        willClose: () => {
                            // window.location.reload();
                        }
                    },
                    function() {
                        // window.location.reload();
                    });
            },
            error: function(event, textStatus, errorThrown) {
                document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
                new swal("Error", "Data gagal disimpan.", "error");
                console.log('Error Message: ' + textStatus + ' , HTTP Error: ' +
                    errorThrown);
            }
        });
    }

    // $('.waktupemberian').val
    function tambahjampemberian(id) {
        $('#waktupemberian-' + id).append(`
    <div>
        <label class="form-check-label" for="malam">Waktu Pemberian</label>
        <input type="time" name="waktupemberian-${id}[]">
    </div>

    <div>
        <label class="form-check-label" for="malam">Disiapkan Oleh</label>
        <input type="text" name="disiapkanoleh-${id}[]">
    </div>

    <div>
        <label class="form-check-label" for="malam">Diberikan Oleh</label>
        <input type="text" name="diberikanoleh-${id}[]">
    </div>
    `);

    }

    $(".js-example-basic-single").select2();

    function get_resep_pasien() {
        $("#retur_id_obat").empty();
        $("#retur_batch").val('');
        $("#retur_expire_date").val('');
        $("#retur_biaya_obat").val('');
        $("#qty_retur").val('');
        $("#vtot_retur").val('');
        $.ajax({
            url: "<?php echo base_url(); ?>iri/rictindakan/get_resep_pasien_last_day/" + '<?= $no_ipd ?>',
            success: function(data) {
                // console.log(data);
                let html = '<option value="" selected>Silahkan Pilih Obat</option>';
                data.map((e) => {
                    html += `
                    <option value='${JSON.stringify(e)}'>${e.nama_obat}</option>
                    `;
                });
                $("#retur_id_obat").empty().html(html);

                // $("#cara_pakai").empty().html(html);
            },
            error: function(event, textStatus, errorThrown) {

            }
        });
    }

    function pilihbatchretur(v) {
        // console.log(v);
        v = JSON.parse(v);
        $.ajax({
            url: "<?php echo base_url(); ?>iri/rictindakan/get_batch_pasien_retur/" + v.id_inventory +
                `/${v.id_resep_pasien}`,
            success: function(data) {
                // console.log(data);
                if (data.batch) {
                    $("#retur_batch").val(data.batch.batch_no);
                }
                if (data.resep) {
                    $('#retur_expire_date').val(data.batch.expire_date)
                    $('#retur_biaya_obat').val(data.resep.biaya_obat)
                    // $("#retur_batch").val(data.batch.batch_no);
                }
                // let html = '<option value="" selected>Silahkan Pilih Obat</option>';
                // data.map((e)=>{
                //     html+=`
                //     <option value="${e.id_obat}@${e.id_inventory}">${e.nm_obat}</option>
                //     `;
                // });
                // $("#retur_id_obat").empty().html(html);

                // $("#cara_pakai").empty().html(html);
            },
            error: function(event, textStatus, errorThrown) {

            }
        });
    }

    function hitungvtotretur(qty) {
        var biayaobat = $('#retur_biaya_obat').val() * qty;
        $("#vtot_retur").val(biayaobat);
    }

    function setvtot(qty) {
        let vtot = $("#edit_biaya_obat").val() * qty;
        $("#edit_total_akhir").val(vtot);

    }

    // $('#histori').on('shown.bs.modal', function () {
    // $(".select2obat").val(null).trigger('change');
    // $(".select2batch").val(null).trigger('change');
    // $("#edit_qty").val('');
    // $("#edit_signa").val('');
    // $("#cara_pakai").val('');

    // $(".select2obat").select2({
    //     dropdownParent: $("#histori"),
    //     placeholder: 'Pencarian Obat',
    //     minimumInputLength: 3, // Adjust this based on your requirements
    //     language: {
    //         searching: function() {
    //             return "Sedang Mencari Data...";
    //         },
    //         inputTooShort: function() {
    //             return "Minimal 3 huruf..";
    //         }
    //     },
    //     ajax: {
    //         url: '<?php //echo base_url('farmasi/Frmcdaftar/select_caridataobat') 
                        ?>', // Replace with your server endpoint
    //         dataType: 'json',
    //         delay: 250, // Delay in milliseconds before sending the request
    //         processResults: function(data) {
    //             // Process the data received from the server
    //             return {
    //                 results: data
    //             };
    //         },
    //         cache: true // Cache AJAX requests to reduce server load
    //     }

    // });
    // });



    function handlerchangeobat(val = '') {
        // console.log(val);
        if (val) {
            $.ajax({
                url: "<?php echo base_url('farmasi/Frmcdaftar/check_gudang_berdasarkan_id/') ?>" + val.split('@')[0],
                success: function(data) {
                    let html = '';
                    let subs = '';
                    $(".select2batch").html(html);
                    data.batch.map((e) => {
                        html += `
                    <option value="${e.id_inventory}@${e.hargajual}">${e.batch_no}(stok:${e.qty},exp:${e.expire_date})</option>
                    `;
                    })

                    $(".select2batch").html(html);
                    // $("#select2substitusi" + i).html(html);


                },
                error: function() {
                    //alert("error");
                }
            });
        }
        // $("#nama_obat-" + i).val(val.split('@')[1]);
    }

    function edit_obat_farmasi(resep_dokter) {
        if (resep_dokter) {

            var resep_new = resep_dokter.nm_obat.replace(/-/g, "@");
            var handleobat = `${resep_new.split('@')[1]}@${resep_new.split('@')[0]}`;
            if (resep_dokter) {
                $(".select2obat").html(`<option value="${resep_new.split('@')[1]}@${resep_new.split('@')[0]}">${resep_new.split('@')[0]}</option>`);
            } else {
                $(".select2obat").val(null).trigger('change');
            }

            $(".select2batch").val(null).trigger('change');
            $("#edit_qty").val('');
            $("#edit_signa").val('');
            $("#cara_pakai").val('');

            $(".select2obat").select2({
                dropdownParent: $("#histori"),
                placeholder: 'Pencarian Obat',
                minimumInputLength: 3, // Adjust this based on your requirements
                language: {
                    searching: function() {
                        return "Sedang Mencari Data...";
                    },
                    inputTooShort: function() {
                        return "Minimal 3 huruf..";
                    }
                },
                ajax: {
                    url: '<?= base_url('farmasi/Frmcdaftar/select_caridataobat') ?>', // Replace with your server endpoint
                    dataType: 'json',
                    delay: 250, // Delay in milliseconds before sending the request
                    processResults: function(data) {
                        // Process the data received from the server
                        return {
                            results: data
                        };
                    },
                    cache: true // Cache AJAX requests to reduce server load
                }

            });

            // console.log(handleobat);
            handlerchangeobat(handleobat);
        } else {
            $(".select2obat").val(null).trigger('change');
            $(".select2batch").val(null).trigger('change');
            $("#edit_qty").val('');
            $("#edit_signa").val('');
            $("#cara_pakai").val('');

            $(".select2obat").select2({
                dropdownParent: $("#histori"),
                placeholder: 'Pencarian Obat',
                minimumInputLength: 3, // Adjust this based on your requirements
                language: {
                    searching: function() {
                        return "Sedang Mencari Data...";
                    },
                    inputTooShort: function() {
                        return "Minimal 3 huruf..";
                    }
                },
                ajax: {
                    url: '<?= base_url('farmasi/Frmcdaftar/select_caridataobat') ?>', // Replace with your server endpoint
                    dataType: 'json',
                    delay: 250, // Delay in milliseconds before sending the request
                    processResults: function(data) {
                        // Process the data received from the server
                        return {
                            results: data
                        };
                    },
                    cache: true // Cache AJAX requests to reduce server load
                }

            });
        }
    }

    function simpanresep() {
        $.ajax({
            url: "<?php echo base_url(); ?>iri/Rictindakan/insert_obat_new",
            method: "POST",
            data: $("#form-diagnosa-submit").serialize(),
            success: function(data) {

                new swal({
                        title: "Selesai",
                        text: "Data berhasil disimpan",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                        willClose: () => {
                            window.location.reload();
                        }
                    },
                    function() {
                        window.location.reload();
                    });
            },
            error: function(event, textStatus, errorThrown) {
                document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
                new swal("Error", "Data gagal disimpan.", "error");
                console.log('Error Message: ' + textStatus + ' , HTTP Error: ' +
                    errorThrown);
            }
        });
    }
</script>