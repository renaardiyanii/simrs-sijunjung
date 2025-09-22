<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}
?>

<style type="text/css">
    .demo-radio-button label {
        min-width: 90px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        var id_poli = $('#id_poli_rujuk').val();

        $(".js-example-basic-single").select2();
    });
</script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<style type="text/css">
    .table-wrapper-scroll-y {
        display: block;
        max-height: 350px;
        overflow-y: auto;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    input:focus::-webkit-input-placeholder { color:transparent; }
    input:focus:-moz-placeholder { color:transparent; } /* FF 4-18 */
    input:focus::-moz-placeholder { color:transparent; } /* FF 19+ */
    input:focus:-ms-input-placeholder { color:transparent; } /* IE 10+ */
    ::-webkit-input-placeholder {
        font-style: italic;
    }
    :-moz-placeholder {
       font-style: italic;
    }
    ::-moz-placeholder {
       font-style: italic;
    }
    :-ms-input-placeholder {
       font-style: italic;
    }
    .demo-radio-button label{
        min-width:120px;
    }
    .ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
        border: 1px solid #dad55e;
        background: #fffa90;
        color: #777620;
        font-weight: normal;
    }
    .ui-widget-content {
        font-size: 15px;
    }
    .ui-widget-content .ui-state-active {
        font-size: 15px;
    }
    .ui-autocomplete-loading {
        background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
    }
    .ui-autocomplete {
        max-height: 270px; overflow-y: scroll; overflow-x: scroll;
    }
</style>
<script type='text/javascript'>


    //-----------------------------------------------Data Table
    $(document).ready(function () {
        // document.getElementById("cari_obat").focus();
        var id_poli = $('#id_poli_rujuk').val();
        loadCbMargin("<?php echo $cara_bayar; ?>");
        loadCbMarginRacik("<?php echo $cara_bayar; ?>");

        $('#selesai_racik_petugas').hide();
        $('.obat-igd').hide();
        $('#cek_obat_igd').prop('disabled',true);
            $('.manual').hide();
            $('.jenis_signa').val('OTOMATIS');


        $(document).on("change", "input[type=radio]", function () {
            var cap = $('[name="bpjs"]:checked').length > 0 ? $('[name="bpjs"]:checked').val() : "";

            if (cap != 1) {
                loadCbMargin("UMUM");
            } else {
                loadCbMargin("BPJS");
            }
            //alert(cap);
        });

        $(document).on("change", "input[type=radio]", function () {
            var caps = $('[name="bpjs_racik"]:checked').length > 0 ? $('[name="bpjs_racik"]:checked').val() : "";

            if (caps != 1) {
                loadCbMarginRacik("UMUM");
            } else {
                loadCbMarginRacik("BPJS");
            }
            //alert(cap);
        });

        $('#tabel_tindakan').DataTable();
        $('#tabel_diagnosa').DataTable();
        $('#obat_neuro').DataTable( {
            "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]]
        });
        // $('#table_obat_poli').DataTable();

        // $('#cari_obat').autocomplete({
        //     serviceUrl: '<?php echo site_url();?>farmasi/Frmcdaftar/cari_data_obat',
        //     onSelect: function (suggestion) {
        //         $('#cari_obat').val('' + suggestion.nama);
        //         $('#idtindakan').val(suggestion.idinventory);
        //         $('#biaya_obat').val(suggestion.harga);
        //         $('#biaya_obat_hide').val(suggestion.harga);
        //         $('#qty').val('1');
        //         set_total();
        //     }
        // });


            // $(document).on("change", "input[type=radio]", function () {
            // var cap = $('[name="jenis_obat"]:checked').length > 0 ? $('[name="jenis_obat"]:checked').val() : "";

            // if (cap != 1) {
            // $url="farmasi/Frmcdaftar/cari_data_obat_konsinyasi";
            // } else {
            // $url="farmasi/Frmcdaftar/cari_data_obat";
            // }
            //alert(cap);
        $('#cari_diag').autocomplete({

            source : function( request, response ) {
                $.ajax({
                    url: '<?php echo site_url('farmasi/Frmcdaftar/cari_data_diagnosa')?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function (data) {
                      if(!data.length){
                        var result = [{
                            label: 'Data tidak ditemukan',
                            value: response.data
                            }];
                        response(result);
                      } else {
                        response(data);
                      }
                    }
                });
            },
            select: function (event, ui) {
                $('#cari_diag').val('' + ui.item.nama);
                $('#id_diag').val(ui.item.id_diag);
            }
        });

        $('#cari_obat').autocomplete({

            source : function( request, response ) {
                $.ajax({
                    url: '<?php echo site_url('farmasi/Frmcdaftar/cari_data_obat')?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        jenis_obat: $("input[name=jenis_obat]:checked").val()
                    },
                    success: function (data) {
                      if(!data.length){
                        var result = [{
                         label: 'Data tidak ditemukan',
                         value: response.data
                        }];
                        response(result);
                      } else {
                        response(data);
                      }
                    }
                });
            },
            select: function (event, ui) {
                $('#cari_obat').val('' + ui.item.nama);
                $('#idtindakan').val(ui.item.idinventory);
                if(ui.item.harga === null) {
                    $('#biaya_obat').val(0);
                    $('#biaya_obat_hide').val(0);
                } else {
                    $('#biaya_obat').val(ui.item.harga);
                    $('#biaya_obat_hide').val(ui.item.harga);
                }
                $('#biaya_obat_hide').val(ui.item.harga);
                $('#ket').val(ui.item.ket);
                $('#qty').val('1');
                set_total();
            }
        });
        // });
        $('#cari_obat2').autocomplete({

            source : function( request, response ) {
                $.ajax({
                    url: '<?php echo site_url('farmasi/Frmcdaftar/cari_data_obat')?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        jenis_obat: $("input[name=jenis_obat_racik]:checked").val()
                    },
                    success: function (data) {
                      if(!data.length){
                        var result = [{
                         label: 'Data tidak ditemukan',
                         value: response.data
                        }];
                        response(result);
                      } else {
                        response(data);
                      }
                    }
                });
            },
            select: function (event, ui) {
                $('#cari_obat2').val('' + ui.item.nama);
                $('#idracikan').val(ui.item.idobat);
                $('#idtindakanracik').val(ui.item.idinventory);
                $('#biaya_racikan').val(ui.item.harga);
                $('#biaya_racikan_hide').val(ui.item.harga);
                $('#ket2').val(ui.item.ket);
                $('#qty_racikan').val('1');
                set_total_racikan();
            }
        });

        $('#obatall').on('show.bs.collapse', function () {
            $('#obatdiag').collapse('hide');
            $('#obatpoli').collapse('hide');
            $('#obatluar').collapse('hide');
        })

        $('#obatpoli').on('show.bs.collapse', function () {
            $('#obatdiag').collapse('hide');
            $('#obatall').collapse('hide');
            $('#obatluar').collapse('hide');
        })

        $('#obatdiag').on('show.bs.collapse', function () {
            $('#obatpoli').collapse('hide');
            $('#obatall').collapse('hide');
            $('#obatluar').collapse('hide');
        })

        $('#obatluar').on('show.bs.collapse', function () {
            $('#obatpoli').collapse('hide');
            $('#obatall').collapse('hide');
            $('#obatdiag').collapse('hide');
        })
        // $('#cari_obat2').autocomplete({
        //     serviceUrl: '<?php echo site_url();?>farmasi/Frmcdaftar/cari_data_obat',
        //     onSelect: function (suggestion) {
        //         $('#cari_obat2').val('' + suggestion.nama);
        //         $('#idracikan').val(suggestion.idobat);
        //         $('#biaya_racikan').val(suggestion.harga);
        //         $('#biaya_racikan_hide').val(suggestion.harga);
        //         $('#qty_racikan').val('1');
        //         set_total_racikan();
        //     }
        // });
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_poli'); ?>";
        url=url+"/"+id_poli;
        url=url+"/"+Math.random();
        ajaxku.onreadystatechange=stateChangedObat;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    });
    //---------------------------------------------------------

    var site = "<?php echo site_url();?>";


    function loadCbMargin(carabayar) {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_margin_carabayar')?>",
            data: {
                carabayar: carabayar
            },
            success: function (data) {
                //alert(data);
                $('#cb_margin').html(data);
            },
            error: function () {
                alert("error");
            }
        });
    }

    function loadCbMarginRacik(carabayar) {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_margin_carabayar_racik')?>",
            data: {
                carabayar: carabayar
            },
            success: function (data) {
                //alert(data);
                $('#cb_margin_racik').html(data);
            },
            error: function () {
                alert("error");
            }
        });
    }

    function pilih_tindakan(id_resep) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_biaya_tindakan')?>",
            data: {
                id_resep: id_resep
            },
            success: function (data) {
                //alert(data);
                $('#biaya_obat').val(data);
                $('#biaya_obat_hide').val(data);
                $('#qty').val('1');
                set_total();
            },
            error: function () {
                alert("error");
            }
        });
    }

    function pilih_racikan(id_resep) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_biaya_tindakan')?>",
            data: {
                id_resep: id_resep
            },
            success: function (data) {
                //alert(data);
                $('#biaya_racikan').val(data);
                $('#biaya_racikan_hide').val(data);
                $('#qty_racikan').val('1');
                set_total_racikan();
            },
            error: function () {
                alert("error");
            }
        });
    }

    function pilih_kebijakan(kodemarkup) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_biaya_kebijakan')?>",
            data: {
                kodemarkup: kodemarkup
            },
            success: function (data) {
                //alert(data);
                $('#fmarkup').val(data);
                set_total();
            },
            error: function () {
                alert("error");
            }
        });
    }

    function set_total() {
        var fmarkup = $("#fmarkup").val();
        // var tuslah_non = $("#tuslah_non").val();
        var cara_bayar = "<?php echo $cara_bayar; ?>";
        var ppn = $("#ppn").val();
        var margin = $("#margin").val();

        // var checked= $("#tuslah_cek").prop('checked');
        //alert ("tes"+ checked);
        if (cara_bayar == "BPJS") {
            var total = ($("#biaya_obat").val() * $("#qty").val());
        } else {
            // if (checked == true){
            // 	//alert ("tes"+ checked);
            // 	var total = ($("#biaya_obat").val() * $("#qty").val() * fmarkup * ppn + parseInt(tuslah_non)) ;
            // } else {
            // 	var total = ($("#biaya_obat").val() * $("#qty").val() * fmarkup * ppn) ;
            // }
            var total = ($("#biaya_obat").val() * $("#qty").val());

        }

        var total_akhir = total * parseFloat(margin);
        $('#vtot').val(total.toFixed(0));
        $('#vtot_hide').val(total.toFixed(0));
        $("#vtot_akhir").val(total_akhir.toFixed(0));
        $("#vtotakhir_hide").val(total_akhir.toFixed(0));
        console.log(total);
    }

    function set_total_akhir() {
        // var margin = $("#margin").val();
        var total = parseFloat($('#vtot_hide').val());
        var total_akhir = total;

        $("#vtot_akhir").val(total_akhir.toFixed(0));
        $("#vtotakhir_hide").val(total_akhir.toFixed(0));
    }

    function set_total_akhir_racik() {
        var margin = $("#margin_racik").val();

      //  var tuslah_racik = $("#tuslah_racik").val();
        var total = parseFloat($('#vtot_x_hide').val());
        var total_akhir = total;// + parseFloat(tuslah_racik);

        $("#vtot_akhir_racik").val(total_akhir.toFixed(0));
        $("#vtotakhir_hide_racik").val(total_akhir.toFixed(0));
    }

    function set_total_racikan() {
        var total = $("#biaya_racikan").val() * $("#qty_racikan").val();
        $('#vtot_racikan').val(total);
        $('#vtot_racikan_hide').val(total);
    }

    function set_hasil_calculator() {
        var total = ($("#diminta").val() * $("#dibutuhkan").val()) / $("#dosis").val();
        total = Math.round(total);
        $('#hasil_calculator').val(total);
        $('#hasil_calculator_hide').val(total);
        $("#qty_racikan").val(total);
        $("#qty_racikan_hidden").val(total);
        var total2 = $("#biaya_racikan").val() * total;
        $('#vtot_racikan').val(total2);
        $('#vtot_racikan_hide').val(total2);
    }

    function edit_obat(id_resep_pasien) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_data_edit_obat')?>",
            data: {
                id_resep_pasien: id_resep_pasien
            },
            success: function (data) {
                $('#edit_no_register').val(data[0].no_register);
                $('#edit_id_obat').val(data[0].item_obat);
                $('#edit_id_obat_hidden').val(data[0].item_obat);
                $('#edit_nama_obat').val(data[0].nama_obat);
                $('#edit_biaya_obat').val(data[0].biaya_obat);
                $('#edit_qty').val(data[0].qty);
                $('#edit_qty_hidden').val(data[0].qty);
                $('#edit_id_resep_pasien').val(data[0].id_resep_pasien);

                // $('#edit_signa option[value='+data[0].signa+']').attr('selected','selected').change();
                $('#edit_signa').val(data[0].kali_harian).change();
                $('#edit_qtx').val(data[0].qtx).change();
                $('#edit_satuan').val(data[0].Satuan_obat).change();
                $('#edit_cara_pakai').val(data[0].cara_pakai).change();
            },
            error: function () {
                alert("error");
            }
        });
    }

    function set_hasil_obat() {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_biaya_resep')?>",
            data: {
                no_register: "<?php echo $no_register ?>"
            },
            success: function (data) {
                var fmarkup = $("#fmarkup").val();
                console.log(data);
               // var tuslah_racik = $("#tuslah_racik").val();
                var ppn = $("#ppn").val();
                var margin = $("#margin").val();
                var qty = $("#qty1").val();
                var cara_bayar = "<?php echo $cara_bayar; ?>";
                //alert(data);
                if (cara_bayar == 'BPJS') {
                    var total = data;

                } else {
                    var total = (data * fmarkup * ppn);
                }

                // var total_akhir = parseInt(total) * parseFloat(margin);
                var total_akhir = data * qty;

                $('#vtot_x').val(parseInt(total));
                $('#vtot_x_hide').val(total);
                //di hide dulu karena tidak ada margin
                // $("#vtot_akhir_racik").val(total_akhir.toFixed(0));
                // $("#vtotakhir_hide_racik").val(total_akhir.toFixed(0));
                $("#vtot_akhir_racik").val(total_akhir);
                $("#vtotakhir_hide_racik").val(total_akhir);
            },
            error: function () {
                alert("error");
            }
        });
    }

    function set_hasil_obat_petugas() {
                var data = $("#vtot_racikan_petugas").val();
                console.log(data);

                var qty = $("#qty1").val();

                var total_akhir = data * qty;

                $('#vtot_x').val(parseInt(data));
                $('#vtot_x_hide').val(data);

                $("#vtot_akhir_racik").val(total_akhir);
                $("#vtotakhir_hide_racik").val(total_akhir);
    }

    function insert_total() {
        var jumlah = $('#jumlah').val();

        // bawah
        //qty di set 1 karena hasil dari perhitungan sendiri


        var val = $('select[name=idtindakan]').val();
        var temp = val.split("-");
        var cara_bayar = "$data_pasien[0]['carabayar']";

        $('#biaya_obat').val(jumlah);
        $('#biaya_obat_hide').val(jumlah);
        var qty = 1;
        $('#qtyind').val(1)
        var total = qty * jumlah;
        $('#vtot').val(total);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_biaya_resep')?>",
            data: {
                no_resep: "<?php echo $no_resep ?>",
                qty: qty
            },
            success: function (data) {
                //alert(data);
                $('#vtot_x').val(data);
                $('#vtot_x_hide').val(data);
            },
            error: function () {
                alert("error");
            }
        });
    }


    function closepage() {
		window.open(' ', '_self', ' '); window.close();
	}


    function cek_stock() {
        /*if ($('#unitasal').val() == '') {
            sweetAlert("Input Unit Asal Obat/Resep terlebih dahulu !", "", "error");
        } else {*/
            swal({
                    title: "Selesai Resep",
                    text: "Benar Akan Menyimpan Data?",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function () {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: "<?php echo base_url('farmasi/Frmcdaftar/cek_stok')?>",
                        data: {
                            no_register: "<?php echo $no_register ?>",
                            kelas_pasien: "<?php echo $kelas_pasien ?>",
                            no_medrec: "<?php echo $no_medrec ?>",
                            cara_bayar: "<?php echo $cara_bayar ?>",
                            idrg: $('#unitasal').val(),
                            bed: $('#unitasal option:selected').text(),
                            nm_dokter: "<?php echo $nmdokter ?>"
                        },
                        success: function (data) {
                            if (data.status == 'success') {
                                if (data.cara_bayar=="BPJS") {
                                    window.location.href = "<?php echo base_url('farmasi/Frmcdaftar')?>";
                                    // url = "<?php echo base_url('farmasi/Frmckwitansi/cetak_faktur_kt_kronis')?>/" + data.no_resep;
                                    // window.open(url, "_blank");
                                    // url = "<?php echo base_url('farmasi/Frmckwitansi/cetak_faktur_kt_nonkronis')?>/" + data.no_resep;
                                    // if (data.jenis_pasien=="RJ" && data.cara_bayar!="BPJS") {
                                    //     window.location.href = "<?php echo base_url('farmasi/Frmcdaftar/list_pasien_rj')?>";
                                    // }else if(data.jenis_pasien=="RJ" && data.cara_bayar=="BPJS"){
                                    //     window.location.href = "<?php echo base_url('farmasi/Frmcdaftar/list_pasien_rj_bpjs')?>";
                                    // }else if(data.jenis_pasien=="RI" && data.cara_bayar!="BPJS"){
                                    //     window.location.href = "<?php echo base_url('farmasi/Frmcdaftar/list_pasien_ri')?>";
                                    // }else{
                                    //     window.location.href = "<?php echo base_url('farmasi/Frmcdaftar/list_pasien_ri_bpjs')?>";
                                    // }
                                    // window.open(url, "_blank");
                                }else{
                                    if (data.no_resep != null) {
                                        url = "<?php echo base_url('farmasi/Frmckwitansi/cetak_faktur_kt')?>/" + data.no_resep;
                                        window.open(url, "_blank");
                                    }
                                    window.location.href = "<?php echo base_url('farmasi/Frmcdaftar')?>";
                                }
                                //swal("Good job!", "You clicked the button!", "success")
                            } else if (data.status == 'kosong') {
                                sweetAlert("Oops... Obat belum di Inputkan!", "", "error");
                            } else {
                                sweetAlert(data.status, "Stock Kurang !", "error");
                            }
                            // sweetAlert("Oops...", data.status, "error");
                        },
                        error: function (data) {
                            // alert("error");
                            //sweetAlert("Oops...", data, "error");
                        }
                    });
                });
        //}

    }

    function saveEditQtyObat() {
        var oldqty = $("#edit_qty_old").val();
        var qty = $("#edit_qty_obat").val();
        var idinventory = $("#edit_qty_idinventory").val();
        var idobat = $("#edit_qty_idobat").val();
        var noregister = $("#edit_qty_noregister").val();
        var vtot = $("#edit_qty_vtot").val();
        var biaya = $("#edit_qty_biaya").val();

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "<?=base_url('farmasi/Frmcdaftar/edit_qty_obat')?>",
                data:{
                    idinventory: idinventory,
                    idobat: idobat,
                    noregister: noregister,
                    oldqty: oldqty,
                    qty: qty,
                    vtot: vtot,
                    biaya: biaya
                },
                success: function (data) {
                    if(data.status === 'success'){
                        swal({
                                title: "Selesai",
                                text: "Data Sudah Disimpan",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function () {
                                window.location.reload();
                            });
                    }else{
                        sweetAlert("Error", "Oops! Terjadi Kesalahan, Silahkan hubungi IT!", "error");
                    }
                }
            })
    }

    function editQtyObat(idinventory, idobat, qty, noregister, vtot, biaya_obat) {
        //alert(idinventory + " " + idobat + " " + noregister);
        $("#edit_qty_obat_lama").val(qty);
        $("#edit_qty_old").val(qty);
        $("#edit_qty_idinventory").val(idinventory);
        $("#edit_qty_idobat").val(idobat);
        $("#edit_qty_noregister").val(noregister);
        $("#edit_qty_vtot").val(vtot);
        $("#edit_qty_biaya").val(biaya_obat);
        $("#editQtyModal").modal("show");
    }

    function buatajax(){
        if (window.XMLHttpRequest){
        return new XMLHttpRequest();
        }
        if (window.ActiveXObject){
        return new ActiveXObject("Microsoft.XMLHTTP");
        }
        return null;
    }

    function ajaxobat(id_poli){
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_poli'); ?>";
        url=url+"/"+id_poli;
        url=url+"/"+Math.random();
        ajaxku.onreadystatechange=stateChangedObat;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function ajaxobatsearch(text){
        var id_poli = $('#id_poli_rujuk').val();
        console.log(id_poli);
        console.log(text);
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_poli_search'); ?>";
        url=url+"/"+id_poli;
        url=url+"/"+text;
        ajaxku.onreadystatechange=stateChangedObat;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    var ajaxku;
    function stateChangedObat(){
        var data;
        //alert(ajaxku.responseText);
        if (ajaxku.readyState==4){
            data=ajaxku.responseText;
            if(data.length>=0){
                document.getElementById("id_obat_poli").innerHTML = data;
            }
        }

    }

    function ajaxdiag(){
        var id_icd = $('#id_diag').val();
        console.log(id_icd);
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_diag'); ?>";
        url=url+"/"+id_icd;
        url=url+"/"+Math.random();
        ajaxku.onreadystatechange=stateChangedDiag;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function ajaxdiagsearch(text){
        var id_icd = $('#id_diag').val();
        console.log(id_icd);
        console.log(text);
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_diag_search'); ?>";
        url=url+"/"+id_icd;
        url=url+"/"+text;
        ajaxku.onreadystatechange=stateChangedDiag;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }


    function stateChangedDiag(){
        var data;
        //alert(ajaxku.responseText);
        if (ajaxku.readyState==4){
            data=ajaxku.responseText;
            if(data.length>=0){
                document.getElementById("id_obat_diag").innerHTML = data;
            }
        }

    }


    function ajaxhistory(no_register){
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_history'); ?>";
        url=url+"/"+ no_register; // added @aldi
        ajaxku.onreadystatechange=stateChangedHistory;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function ajaxhistory_ri(no_register,noregasal){
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_history'); ?>";
        url=url+"/"+ no_register + "/" + noregasal; // added @aldi
        ajaxku.onreadystatechange=stateChangedHistory;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function ajaxhistorysearch(text){
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_history_search/').$no_register; ?>";
        url=url+"/"+text;
        ajaxku.onreadystatechange=stateChangedHistory;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function stateChangedHistory(){
        var data;
        //alert(ajaxku.responseText);
        if (ajaxku.readyState==4){
            data=ajaxku.responseText;
            if(data.length>=0){
                document.getElementById("id_obat_history").innerHTML = data;
            }
        }

    }

    function ajaxobatallsearch(text){
        var id_poli = $('#id_poli_rujuk').val();
        console.log(id_poli);
        console.log(text);
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/data_obat_all_search'); ?>";
        url=url+"/"+id_poli;
        url=url+"/"+text;
        ajaxku.onreadystatechange=stateChangedObatAll;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function stateChangedObatAll(){
        var data;
        //alert(ajaxku.responseText);
        if (ajaxku.readyState==4){
            data=ajaxku.responseText;
            if(data.length>=0){
                document.getElementById("id_obat_all").innerHTML = data;
            }
        }

    }


    function back() {
        var base = "<?php echo base_url() ?>";
		window.open(base+'/farmasi/Frmcdaftar/', '_self');
        window.focus();
	}

    function showswal() {
        var base = "<?php echo base_url() ?>";
        swal({
            title: "",
            text: "MOHON REFRESH HALAMAN",
            type: "success",
            showConfirmButton: true,
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function () {
            window.open(base+'farmasi/Frmcdaftar/', '_self');
        });
    }



    function edit_obat_racikan(no_register,id_obat_racikan,id_resep_pasien) {
        console.log(no_register);
        console.log(id_obat_racikan);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('farmasi/Frmcdaftar/get_data_edit_obat_racikan')?>",
            data: {
                id_obat_racikan: id_obat_racikan
            },
            success: function (data) {
                // console.log(data[0].hargajual);
                console.log(data[0]);
                // console.log(data);
                $('#edit_no_register_racikan').val(data[0].no_register);
                $('#edit_id_obat_racikan').val(data[0].item_obat);
                $('#edit_id_obat_racikan_hidden').val(data[0].id_obat_racikan);
                $('#edit_nama_obat_racikan').val(data[0].nm_obat);
                $('#edit_biaya_obat_racikan').val(data[0].hargajual);
                $('#edit_qty_racikan').val(data[0].qty);
                $('#edit_qty_racikan_hidden').val(data[0].qty);
                $('#edit_dosis_obat_racikan').val(data[0].dosis);
                $('#edit_satuan_obat_racikan').val(data[0].satuan);
                $('#edit_id_resep_pasien_racikan').val(id_resep_pasien);

            },
            error: function () {
                alert("error");
            }
        });
    }

    function set_total_harga_racikan() {
        var harga = $("#edit_biaya_obat_racikan").val();
        var qty = $("#qty").val();


        var total_akhir = harga * qty;
        $('#vtot_racikan').val(total_akhir);
        console.log(total_akhir);
    }

    var table_obat_racik_petugas;
    function edit_obat_racikan_petugas(no_register,id_resep_pasien) {
        console.log(id_resep_pasien);
        ajaxku = buatajax();
        var url="<?php echo site_url('farmasi/Frmcdaftar/get_data_edit_obat_racikan_petugas'); ?>";
        url=url+"/"+id_resep_pasien;
        url=url+"/"+no_register;
        ajaxku.onreadystatechange=stateChangedRacikPetugas;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);

        $.ajax({
            url : "<?php echo base_url('farmasi/Frmcdaftar/get_data_edit_obat_racikan_selesai_petugas') ?>",
            dataType : "JSON",
            type: 'POST',
            data : {
                id_resep_pasien : id_resep_pasien
            },
            success: function (data) {
                console.log(data);
                console.log(data.data.kali_harian);
                console.log(data.status == 'success');
                if(data.status == 'success'){
                    $('#selesai_racik_petugas').show();
                    $('#rck').val(data.data.nama_obat);

                    $('#signa_petugas').val(data.data.kali_harian).change();
                    $('#qtx_petugas').val(data.data.qtx).change();
                    $('#satuan_petugas').val(data.data.Satuan_obat).change();
                    $('#cara_pakai_petugas').val(data.data.cara_pakai).change();

                    // $('#qty1').val(data.data.qty);
                    $('#qty_old_petugas').text("|Qty Sebelumnya("+data.data.qty+")");

                    $('#vtot_x').val(data.data.vtot_racik_petugas);
                    $('#vtot_x_hide').val(data.data.vtot_racik_petugas);

                    $('#vtot_akhir_racik').val(data.data.vtot);
                    $('#vtotakhir_hide_racik').val(data.data.vtot);
                    $('#id_resep_pasien_petugas').val(id_resep_pasien);

                    if(data.data.resep_pulang == '1'){
                        $('#resep_pulang_racik_1').prop("checked", true);
                        $('#resep_pulang_racik_2').prop("checked", false);
                    }else{
                        $('#resep_pulang_racik_1').prop("checked", false);
                        $('#resep_pulang_racik_2').prop("checked", true);
                    }

                    set_hasil_obat_petugas();
                }else{
                    sweetAlert("Error", "Oops! Terjadi Kesalahan, Silahkan hubungi IT!", "error");
                }
            }
        });

        $('#id_resep_petugas').val(id_resep_pasien);

    }

    function stateChangedRacikPetugas(){
        var data;
        //alert(ajaxku.responseText);
        if (ajaxku.readyState==4){
            data=ajaxku.responseText;
            if(data.length>=0){
                document.getElementById("table_obat_racik_petugas").innerHTML = data;
            }
        }

    }

    function selesai_racik(no_register,id_resep_pasien,vtot) {
        var pelayan = '<?php echo $pelayan; ?>';

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: "<?=base_url('farmasi/Frmcdaftar/insert_racikan_selesai_petugas')?>",
            data:{
                no_register: no_register,
                id_resep_pasien: id_resep_pasien,
                pelayan: pelayan,
                vtot: vtot
            },
            success: function (data) {
                console.log(data == 'success');
                if(data == 'success'){
                    swal({
                            title: "Selesai",
                            text: "Data Sudah Disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
                }else{
                    sweetAlert("Error", "Oops! Terjadi Kesalahan, Silahkan hubungi IT!", "error");
                }
            }
        })
    }

    function racik_petugas(){
        $.ajax({
            url:"<?php echo base_url('farmasi/Frmcdaftar/insert_racikan_petugas')?>",
            type: "POST",
            data: $('#formRacikPetugas').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                console.log(data.status == true);
                console.log(data.no_register);
                console.log(data.id_resep_pasien);
                if(data.status == true) //if success close modal and reload ajax table
                {

                    document.getElementById('cari_obat2').value = '';
                    document.getElementById('ket2').value = '';
                    document.getElementById('idracikan').value = '';
                    document.getElementById('idtindakanracik').value = '';
                    document.getElementById('dosis_racikan').value = '';
                    document.getElementById('satuan_racikan').value = '';
                    document.getElementById('biaya_racikan').value = '';
                    document.getElementById('biaya_racikan_hide').value = '';
                    swal({
                            title: "Data Berhasil Disimpan.",
                            text: "Akan menghilang dalam 3 detik.",
                            timer: 2000,
                            type: "success",
                            showConfirmButton: false,
                            showCancelButton: false,
                            showLoaderOnConfirm: true
                        });
                        edit_obat_racikan_petugas(data.no_register,data.id_resep_pasien);

                    // window.location.reload();
                }else{
                    swal({
                        title: "Gagal",
                        text: "Pastikan Data Diisi Dengan Benar",
                        type: "error",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function () {
                        window.location.reload();
                    });
                }


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // window.location.reload();
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                // alert(errorThrown);
                    // window.location.reload();

            }
        });
    }

    function hapus_obat_racikan(no_register,id_obat_racikan,id_resep_pasien) {
        $.ajax({
            url  : "<?php echo base_url('farmasi/Frmcdaftar/hapus_data_racikan/') ?>"+no_register+"/"+id_obat_racikan,
            type : "POST",
            data : {
                id_resep_pasien: id_resep_pasien
            },
            dataType : "JSON",
            success: function(data)
            {
                console.log(data);
                if(data.status == true) //if success close modal and reload ajax table
                {

                    swal({
                            title: "Data Berhasil Dihapus.",
                            text: "Akan menghilang dalam 3 detik.",
                            timer: 2000,
                            type: "success",
                            showConfirmButton: false,
                            showCancelButton: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });


                    // window.location.reload();
                }else{
                    swal({
                        title: "Gagal",
                        text: "Gagal Hapus Data",
                        type: "error",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function () {
                        window.location.reload();
                    });
                }


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // window.location.reload();
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                // alert(errorThrown);
                    window.location.reload();

            }
        });
    }

    function editracikanpetugas(){
        $.ajax({
            url:"<?php echo base_url('farmasi/Frmcdaftar/edit_obat_racikan')?>",
            type: "POST",
            data: $('#formEditRacikPetugas').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                console.log(data);
                if(data.status == true) //if success close modal and reload ajax table
                {

                    swal({
                            title: "Data Berhasil Disimpan.",
                            text: "Akan menghilang dalam 3 detik.",
                            timer: 2000,
                            type: "success",
                            showConfirmButton: false,
                            showCancelButton: false,
                            showLoaderOnConfirm: true
                        });
                        edit_obat_racikan_petugas(data.no_register,data.id_resep_pasien);

                        $('#editModalracikan').modal('hide');
                    // window.location.reload();
                }else{
                    swal({
                        title: "Gagal",
                        text: "Pastikan Data Diisi Dengan Benar",
                        type: "error",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function () {
                        window.location.reload();
                    });
                }
                set_hasil_obat_petugas();

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // window.location.reload();
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                // alert(errorThrown);
                    window.location.reload();

            }
        });
    }

    function switchObatIgd() {
        $('.obat-igd').show();
        $('.obat-biasa').hide();
        $('#cek_obat_igd').prop('disabled',false);
        $('#cek_obat_biasa').prop('disabled',true);
    }

    function switchObatBiasa() {
        $('.obat-igd').hide();
        $('.obat-biasa').show();
        $('#cek_obat_igd').prop('disabled',true);
        $('#cek_obat_biasa').prop('disabled',false);
    }

    function obat_igd(id_inventory) {
        $.ajax({
            url: '<?php echo site_url('farmasi/Frmcdaftar/detail_obat_igd')?>',
            dataType: "JSON",
            type: "POST",
            data: {
                id_inventory: id_inventory
            },
            success: function (data) {
                // $('#cari_obat').val('' + ui.item.nama);
                console.log(data);
                console.log(data.data);
                console.log(data.data.nm_obat);
                console.log(data.data.hargajual);
                $('#idtindakan_igd').val(data.data.nm_obat);
                $('#biaya_obat').val(data.data.hargajual);
                $('#biaya_obat_hide').val(data.data.hargajual);
                $('#qty').val('1');
                set_total();
            }
        });
    }

    function switchsigna(val) {
        console.log(val);
        if (val == 'OTOMATIS') {
            $('.otomatis').show();
            $('.manual').hide();
            $('.jenis_signa').val(val);
        }else{
            $('.otomatis').hide();
            $('.manual').show();
            $('.jenis_signa').val(val);
        }
    }

    function kondisi_obat_igd_biasa(val) {
        if (val == '0') {
            $('.obat-biasa').show();
            $('.obat-igd').hide();
            $('.btn_obat_biasa').hide();
            $('.btn_obat_igd').hide();
        }else{
            $('.obat-biasa').show();
            $('.obat-igd').hide();
            $('.btn_obat_biasa').show();
            $('.btn_obat_igd').show();
        }
    }

    function biaya_racikan_luar() {
        if($("input[name=jenis_obat_racik]:checked").val() == '0'){
            $('#biaya_racikan').val('0');
            $('#biaya_racikan_hide').val('0');
            $('#qty_racikan').val('1');
        } else{}

    }

    function sabar(){
        alert('Berhasil,Silakan klik ok');
    }

</script>
<?=$this->session->flashdata('warning')?>
<?=$this->session->flashdata('info')?>
<?php include('frmvdatapasien.php'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
        <div class="card-block p-b-0">

        <?php if($pengkondisian_poli == 'BJ00') { ?>
            <button type="button" class="btn btn-warning box-title" data-toggle="modal" data-target="#obatHistory" onclick="ajaxhistory('<?php echo $no_register ?>')">Obat History</button>
            <button type="button" class="btn btn-primary box-title" data-toggle="collapse" data-target="#obatall">Semua Obat</button>
            <button type="button" class="btn btn-primary box-title" data-toggle="collapse" data-target="#obatpoli">Obat Poliklinik</button>
            <button type="button" class="btn btn-primary box-title" data-toggle="collapse" data-target="#obatdiag">Obat Diagnosa</button>
            <button type="button" class="btn btn-primary box-title" data-toggle="collapse" data-target="#obatluar">Obat Luar</button>

            <a class="btn btn-info box-title" href="<?= base_url('master/mcobat_diagnosa'); ?>" style="float:right;margin-left: 10px;">Insert Obat Diagnosa</a>
            <a class="btn btn-info box-title" href="<?= base_url('master/mcobat_poli'); ?>" style="float:right;margin-left: 10px;">Insert Obat Poliklinik</a>
            <a class="btn btn-info box-title" href="<?= base_url('master/mcsigna'); ?>" style="float:right;margin-left: 10px;">Insert Signa</a>

            <br>
            <div class="collapse" id="obatall" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-content">
                    <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_all'); ?>
                        <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
                            <div class="modal-header">
                                <h3 class="modal-title">Input Obat</h3>
                            </div>
                            <div class="modal-body">

                                <div class="form-group row">
                                        <p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Obat *</b></p>
                                        <div class="col-sm-10">
                                            <div class="form-group row">
                                                <input type="text" name="keyword" id="keyword" class="form-control col-sm-3" onkeyup="ajaxobatallsearch(this.value.toUpperCase())" placeholder="Cari Nama Obat..."/>
                                            </div>
                                        </div>
                                </div>

                                <div class="form-group row">

                                        <div class="col-sm-12">
                                            <div class="form-inline" id="id_obat_all">

                                            </div>
                                        </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="no_register_all" id="no_register_all" value="<?php echo $no_register; ?>">
                                <input type="hidden" name="no_medrec_all" id="no_medrec_all" value="<?php echo $no_medrec; ?>">
                                <input type="hidden" name="cara_bayar_all" id="cara_bayar_all" value="<?php echo $cara_bayar; ?>">
                                <input type="hidden" name="idrg_all" id="idrg_all" value="<?php echo $idrg; ?>">
                                <input type="hidden" name="bed_all" id="bed_all" value="<?php echo $bed; ?>">
                                <input type="hidden" name="no_resep_all" id="no_resep_all" value="<?php echo $no_resep; ?>" >
                                <input type="hidden" name="pelayan_all" id="pelayan_all" value="<?php echo $pelayan; ?>" >
                                <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
                                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                            </div>
                        <!-- </form> -->
                        <?php echo form_close(); ?>
                </div>
            </div>
            <div class="collapse" id="obatpoli" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-content">
                    <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_poli'); ?>
                        <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
                            <div class="modal-header">
                                <h3 class="modal-title">Input Obat Poliklinik</h3>
                            </div>
                            <div class="modal-body">

                                <div class="form-group row">
                                        <p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Poliklinik *</b></p>
                                        <div class="col-sm-10">
                                            <div class="form-group row">
                                                <select id="id_poli_rujuk" class="form-control custom-select col-sm-7" name="id_poli_rujuk" onchange="ajaxobat(this.value)">
                                                    <option value="">-Pilih Poli-</option>
                                                    <?php
                                                    foreach($poliklinik as $row){
                                                        echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <input type="text" name="keyword" id="keyword" class="form-control col-sm-3" onkeyup="ajaxobatsearch(this.value.toUpperCase())" placeholder="Cari Nama Obat..."/>
                                            </div>
                                        </div>
                                </div>

                                <div class="form-group row">

                                        <div class="col-sm-12">
                                            <div class="form-inline" id="id_obat_poli">

                                            </div>
                                        </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="no_register_poli" id="no_register_poli" value="<?php echo $no_register; ?>">
                                <input type="hidden" name="no_medrec_poli" id="no_medrec_poli" value="<?php echo $no_medrec; ?>">
                                <input type="hidden" name="cara_bayar_poli" id="cara_bayar_poli" value="<?php echo $cara_bayar; ?>">
                                <input type="hidden" name="idrg_poli" id="idrg_poli" value="<?php echo $idrg; ?>">
                                <input type="hidden" name="bed_poli" id="bed_poli" value="<?php echo $bed; ?>">
                                <input type="hidden" name="no_resep_poli" id="no_resep_poli" value="<?php echo $no_resep; ?>" >
                                <input type="hidden" name="pelayan_poli" id="pelayan_poli" value="<?php echo $pelayan; ?>" >
                                <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
                                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                            </div>
                        <!-- </form> -->
                        <?php echo form_close(); ?>
                </div>
            </div>
            <div class="collapse" id="obatdiag" role="dialog" data-backdrop="static" data-keyboard="false" >
                <div class="modal-content">
                    <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_diag'); ?>
                    <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
                        <div class="modal-header">
                            <h3 class="modal-title">Input Obat Diagnosa</h3>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row" >
                                    <p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Diagnosa *</b></p>
                                    <div class="col-sm-10">
                                        <div class="form-inline">
                                            <input type="text" class="form-control custom-select" id="cari_diag" name="cari_diag" placeholder="Pencarian Diagnosa" onkeyup="ajaxdiag()" onchange="ajaxdiag()">
                                            <input type="hidden" name="id_diag" id="id_diag">

                                            <input type="text" name="keyword_diag" id="keyword_diag" class="form-control" onkeyup="ajaxdiagsearch(this.value.toUpperCase())" placeholder="Cari Nama Obat..."/>

                                        </div>
                                    </div>
                            </div>

                            <div class="form-group row">

                                    <div class="col-sm-12">
                                        <div class="form-inline" id="id_obat_diag">

                                        </div>
                                    </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="no_register_diag" id="no_register_diag" value="<?php echo $no_register; ?>">
                            <input type="hidden" name="no_medrec_diag" id="no_medrec_diag" value="<?php echo $no_medrec; ?>">
                            <input type="hidden" name="cara_bayar_diag" id="cara_bayar_diag" value="<?php echo $cara_bayar; ?>">
                            <input type="hidden" name="idrg_diag" id="idrg_diag" value="<?php echo $idrg; ?>">
                            <input type="hidden" name="bed_diag" id="bed_diag" value="<?php echo $bed; ?>">
                            <input type="hidden" name="no_resep_diag" id="no_resep_diag" value="<?php echo $no_resep; ?>" >
                            <input type="hidden" name="pelayan_diag" id="pelayan_diag" value="<?php echo $pelayan; ?>" >
                            <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
                            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                        </div>
                    <!-- </form> -->
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="collapse" id="obatluar" role="dialog" data-backdrop="static" data-keyboard="false" >
                <div class="modal-content">
                    <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_luar'); ?>
                    <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
                        <div class="modal-header">
                            <h3 class="modal-title">Input Obat Luar</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row" >
                                    <p class="col-sm-1 form-control-label text-right" id="nmdokter"><b>Obat *</b></p>
                                    <div class="col-sm-2">
                                        <div class="form-inline">
                                            <input type="text" class="form-control" name="nama_obat_luar" placeholder="Nama Obat" style="width:100%;">
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="margin-left:-20px;">
                                        <div class="form-inline">
                                            <select name="signa_luar" id="signa_luar" class="form-control custom-select" style="width:100%;">
                                                <option value="">--Signa--</option>
                                                <?php foreach ($satuan_signa as $row) { ?>
                                                    <option value="<?php echo $row->signa; ?>"><?php echo $row->signa; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="margin-left:-20px;">
                                        <div class="form-inline">
                                        <select name="qtx_luar" id="qtx_luar" class="form-control custom-select" style="width:100%;">
                                                <option value="">--Qtx--</option>
                                                <?php foreach ($qtx as $row) { ?>
                                                    <option value="<?php echo $row->qtx; ?>"><?php echo $row->qtx; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="margin-left:-20px;">
                                        <div class="form-inline">
                                        <select name="satuan_luar" id="satuan_luar" class="form-control custom-select" style="width:100%;">
                                                <option value="">--Satuan--</option>
                                                <?php foreach ($satuan as $row) { ?>
                                                    <option value="<?php echo $row->nm_satuan; ?>"><?php echo $row->nm_satuan; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="margin-left:-20px;">
                                        <div class="form-inline">
                                        <select name="cara_pakai_luar" id="cara_pakai_luar" class="form-control custom-select" style="width:100%;">
                                                <option value="">--Cara Pakai--</option>
                                                <?php foreach ($cara_pakai as $row) { ?>
                                                    <option value="<?php echo $row->cara_pakai; ?>"><?php echo $row->cara_pakai; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="margin-left:-20px;">
                                        <div class="form-inline">
                                            <input type="number" name="qty_luar" id="qty_luar" class="form-control" min="1" placeholder="QTY" style="width: 100px;">
                                        </div>
                                    </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="no_register_luar" id="no_register_luar" value="<?php echo $no_register; ?>">
                            <input type="hidden" name="no_medrec_luar" id="no_medrec_luar" value="<?php echo $no_medrec; ?>">
                            <input type="hidden" name="cara_bayar_luar" id="cara_bayar_luar" value="<?php echo $cara_bayar; ?>">
                            <input type="hidden" name="idrg_luar" id="idrg_luar" value="<?php echo $idrg; ?>">
                            <input type="hidden" name="bed_luar" id="bed_luar" value="<?php echo $bed; ?>">
                            <input type="hidden" name="no_resep_luar" id="no_resep_luar" value="<?php echo $no_resep; ?>" >
                            <input type="hidden" name="pelayan_luar" id="pelayan_luar" value="<?php echo $pelayan; ?>" >
                            <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"name="tgl_kun">
                            <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
                            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                        </div>
                    <!-- </form> -->
                    <?php echo form_close(); ?>
                </div>
            </div>

            <br>
                <div >
                        <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_old'); ?>
                            <table id="obat_neuro" class=" table display table-hover table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 25%;">Nama Obat</th>
                                        <th style="width: 60%;">Signa</th>
                                        <th style="width: 10%;">Quantity</th>
                                    </tr>
                                </thead>
                                <?php foreach ($data_obat_poli as $key) { ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="jumlah_obat[]" id="<?php echo $key->id_inventory; ?>" value="<?php echo $key->id_inventory; ?>">
                                            <label for="<?php echo $key->id_inventory; ?>"></label>
                                        </td>
                                        <td><label><?= $key->nm_obat .'- batch ('.$key->batch_no.')'?></label></td>
                                        <td>
                                            <select class="form-control " name="signa-<?php echo $key->id_inventory; ?>" id="signa-<?php echo $key->id_inventory; ?>" style="width: 20%;">
                                                <option value="">-Signa-</option>
                                                <?php foreach ($satuan_signa as $row) { ?>
                                                    <option value="<?=$row->signa?>"><?=$row->signa?></option>
                                                <?php } ?>
                                            </select>
                                            <select class="form-control " name="qtx-<?php echo $key->id_inventory; ?>" id="qtx-<?php echo $key->id_inventory; ?>" style="width: 11%;">
                                                <option value="">-Qtx-</option>
                                                <?php foreach ($qtx as $row) { ?>
                                                    <option value="<?=$row->qtx?>"><?=$row->qtx?></option>
                                                <?php } ?>
                                            </select>
                                            <select class="form-control " name="satuan-<?php echo $key->id_inventory; ?>" id="satuan-<?php echo $key->id_inventory; ?>" style="width: 24%;">
                                                <option value="">-Satuan-</option>
                                                <?php foreach ($satuan as $row) { ?>
                                                    <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                <?php } ?>
                                            </select>
                                            <select class="form-control " name="cara_pakai-<?php echo $key->id_inventory; ?>" id="cara_pakai-<?php echo $key->id_inventory; ?>" style="width: 23%;">
                                                <option value="">-Cara Pakai-</option>
                                                <?php foreach ($cara_pakai as $row) { ?>
                                                    <option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id_obat[]" id="id_obat" value="<?php echo $key->id_inventory; ?>">
                                            <input type="number" min="1" name="qty-<?php echo $key->id_inventory; ?>" id="qty" placeholder="Qty" class="form-control" style="width: 80%;">
                                        </td>
                                    </tr>
                                <?php } ?>

                            </table>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <input type="hidden" name="no_register" id="no_register" value="<?php echo $no_register; ?>">
                                    <input type="hidden" name="no_medrec" id="no_medrec" value="<?php echo $no_medrec; ?>">
                                    <input type="hidden" name="cara_bayar" id="cara_bayar" value="<?php echo $cara_bayar; ?>">
                                    <input type="hidden" name="idrg" id="idrg" value="<?php echo $idrg; ?>">
                                    <input type="hidden" name="bed" id="bed" value="<?php echo $bed; ?>">
                                    <input type="hidden" name="pelayan" id="pelayan" value="<?php echo $pelayan; ?>">
                                    <input type="hidden" name="no_resep" id="no_resep" value="<?php echo $no_resep; ?>" >
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                </div>

        <?php }elseif($pengkondisian_poli == 'BA00') { ?>
            <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item"><a class="nav-link <?php echo $tab_obat; ?>" data-toggle="tab" href="#obat"
                                            role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                    class="hidden-xs-down">OBAT</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $tab_racik; ?>" data-toggle="tab" href="#racikan"
                                            role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                    class="hidden-xs-down">RACIKAN</span></a></li>
                </ul>
                <div class="tab-content">
                    <br>

                    <div id="obat" class="tab-pane <?php echo $tab_obat; ?>" role="tabpanel">
                        <button type="button" class="btn btn-warning box-title" data-toggle="modal" data-target="#obatHistory" onclick="ajaxhistory('<?php echo $no_register ?>')">Obat History</button>
                        <button type="button" class="btn btn-primary box-title" data-toggle="collapse" data-target="#obatall">Semua Obat</button>
                        <button type="button" class="btn btn-primary box-title" data-toggle="collapse" data-target="#obatpoli">Obat IGD</button>
                        <button type="button" class="btn btn-primary box-title" data-toggle="collapse" data-target="#obatdiag">Obat Diagnosa</button>
                        <button type="button" class="btn btn-primary box-title" data-toggle="collapse" data-target="#obatluar">Obat Luar</button>

                        <a class="btn btn-info box-title" href="<?= base_url('master/mcobat_diagnosa'); ?>" style="float:right;margin-left: 10px;">Insert Obat Diagnosa</a>
                        <a class="btn btn-info box-title" href="<?= base_url('master/mcobat_poli'); ?>" style="float:right;margin-left: 10px;">Insert Obat IGD</a>
                        <a class="btn btn-info box-title" href="<?= base_url('master/mcsigna'); ?>" style="float:right;margin-left: 10px;">Insert Signa</a>

                        <br>
                        <div class="collapse" id="obatall" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-content">
                                <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_all'); ?>
                                    <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
                                        <div class="modal-header">
                                            <h3 class="modal-title">Input Obat</h3>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group row">
                                                    <p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Obat *</b></p>
                                                    <div class="col-sm-10">
                                                        <div class="form-group row">
                                                            <input type="text" name="keyword" id="keyword" class="form-control col-sm-3" onkeyup="ajaxobatallsearch(this.value.toUpperCase())" placeholder="Cari Nama Obat..."/>
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="form-group row">

                                                    <div class="col-sm-12">
                                                        <div class="form-inline" id="id_obat_all">

                                                        </div>
                                                    </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" name="no_register_all" id="no_register_all" value="<?php echo $no_register; ?>">
                                            <input type="hidden" name="no_medrec_all" id="no_medrec_all" value="<?php echo $no_medrec; ?>">
                                            <input type="hidden" name="cara_bayar_all" id="cara_bayar_all" value="<?php echo $cara_bayar; ?>">
                                            <input type="hidden" name="idrg_all" id="idrg_all" value="<?php echo $idrg; ?>">
                                            <input type="hidden" name="bed_all" id="bed_all" value="<?php echo $bed; ?>">
                                            <input type="hidden" name="no_resep_all" id="no_resep_all" value="<?php echo $no_resep; ?>" >
                                            <input type="hidden" name="pelayan_all" id="pelayan_all" value="<?php echo $pelayan; ?>" >
                                            <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
                                            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                                        </div>
                                    <!-- </form> -->
                                    <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div class="collapse" id="obatpoli" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-content">
                                <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_poli'); ?>
                                    <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
                                        <div class="modal-header">
                                            <h3 class="modal-title">Input Obat IGD</h3>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group row">
                                                    <p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Poliklinik *</b></p>
                                                    <div class="col-sm-10">
                                                        <div class="form-group row">
                                                            <select id="id_poli_rujuk" class="form-control custom-select col-sm-7" name="id_poli_rujuk" onchange="ajaxobat(this.value)">
                                                                <option value="">-Pilih Poli-</option>
                                                                <?php
                                                                foreach($poliklinik as $row){
                                                                    echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                            <input type="text" name="keyword" id="keyword" class="form-control col-sm-3" onkeyup="ajaxobatsearch(this.value.toUpperCase())" placeholder="Cari Nama Obat..."/>
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="form-group row">

                                                    <div class="col-sm-12">
                                                        <div class="form-inline" id="id_obat_poli">

                                                        </div>
                                                    </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" name="no_register_poli" id="no_register_poli" value="<?php echo $no_register; ?>">
                                            <input type="hidden" name="no_medrec_poli" id="no_medrec_poli" value="<?php echo $no_medrec; ?>">
                                            <input type="hidden" name="cara_bayar_poli" id="cara_bayar_poli" value="<?php echo $cara_bayar; ?>">
                                            <input type="hidden" name="idrg_poli" id="idrg_poli" value="<?php echo $idrg; ?>">
                                            <input type="hidden" name="bed_poli" id="bed_poli" value="<?php echo $bed; ?>">
                                            <input type="hidden" name="no_resep_poli" id="no_resep_poli" value="<?php echo $no_resep; ?>" >
                                            <input type="hidden" name="pelayan_poli" id="pelayan_poli" value="<?php echo $pelayan; ?>" >
                                            <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
                                            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                                        </div>
                                    <!-- </form> -->
                                    <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div class="collapse" id="obatdiag" role="dialog" data-backdrop="static" data-keyboard="false" >
                            <div class="modal-content">
                                <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_diag'); ?>
                                <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
                                    <div class="modal-header">
                                        <h3 class="modal-title">Input Obat Diagnosa</h3>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group row" >
                                                <p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Diagnosa *</b></p>
                                                <div class="col-sm-10">
                                                    <div class="form-inline">
                                                        <input type="text" class="form-control custom-select" id="cari_diag" name="cari_diag" placeholder="Pencarian Diagnosa" onkeyup="ajaxdiag()" onchange="ajaxdiag()">
                                                        <input type="hidden" name="id_diag" id="id_diag">

                                                        <input type="text" name="keyword_diag" id="keyword_diag" class="form-control" onkeyup="ajaxdiagsearch(this.value.toUpperCase())" placeholder="Cari Nama Obat..."/>

                                                    </div>
                                                </div>
                                        </div>

                                        <div class="form-group row">

                                                <div class="col-sm-12">
                                                    <div class="form-inline" id="id_obat_diag">

                                                    </div>
                                                </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="no_register_diag" id="no_register_diag" value="<?php echo $no_register; ?>">
                                        <input type="hidden" name="no_medrec_diag" id="no_medrec_diag" value="<?php echo $no_medrec; ?>">
                                        <input type="hidden" name="cara_bayar_diag" id="cara_bayar_diag" value="<?php echo $cara_bayar; ?>">
                                        <input type="hidden" name="idrg_diag" id="idrg_diag" value="<?php echo $idrg; ?>">
                                        <input type="hidden" name="bed_diag" id="bed_diag" value="<?php echo $bed; ?>">
                                        <input type="hidden" name="no_resep_diag" id="no_resep_diag" value="<?php echo $no_resep; ?>" >
                                        <input type="hidden" name="pelayan_diag" id="pelayan_diag" value="<?php echo $pelayan; ?>" >
                                        <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
                                        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                                    </div>
                                <!-- </form> -->
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div class="collapse" id="obatluar" role="dialog" data-backdrop="static" data-keyboard="false" >
                            <div class="modal-content">
                                <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_luar'); ?>
                                <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
                                    <div class="modal-header">
                                        <h3 class="modal-title">Input Obat Luar</h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row" >
                                                <p class="col-sm-1 form-control-label text-right" id="nmdokter"><b>Obat *</b></p>
                                                <div class="col-sm-2">
                                                    <div class="form-inline">
                                                        <input type="text" class="form-control" name="nama_obat_luar" placeholder="Nama Obat" style="width:100%;">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" style="margin-left:-20px;">
                                                    <div class="form-inline">
                                                        <select name="signa_luar" id="signa_luar" class="form-control custom-select" style="width:100%;">
                                                            <option value="">--Signa--</option>
                                                            <?php foreach ($satuan_signa as $row) { ?>
                                                                <option value="<?php echo $row->signa; ?>"><?php echo $row->signa; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" style="margin-left:-20px;">
                                                    <div class="form-inline">
                                                    <select name="qtx_luar" id="qtx_luar" class="form-control custom-select" style="width:100%;">
                                                            <option value="">--Qtx--</option>
                                                            <?php foreach ($qtx as $row) { ?>
                                                                <option value="<?php echo $row->qtx; ?>"><?php echo $row->qtx; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" style="margin-left:-20px;">
                                                    <div class="form-inline">
                                                    <select name="satuan_luar" id="satuan_luar" class="form-control custom-select" style="width:100%;">
                                                            <option value="">--Satuan--</option>
                                                            <?php foreach ($satuan as $row) { ?>
                                                                <option value="<?php echo $row->nm_satuan; ?>"><?php echo $row->nm_satuan; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" style="margin-left:-20px;">
                                                    <div class="form-inline">
                                                    <select name="cara_pakai_luar" id="cara_pakai_luar" class="form-control custom-select" style="width:100%;">
                                                            <option value="">--Cara Pakai--</option>
                                                            <?php foreach ($cara_pakai as $row) { ?>
                                                                <option value="<?php echo $row->cara_pakai; ?>"><?php echo $row->cara_pakai; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" style="margin-left:-20px;">
                                                    <div class="form-inline">
                                                        <input type="number" name="qty_luar" id="qty_luar" class="form-control" min="1" placeholder="QTY" style="width: 100px;">
                                                    </div>
                                                </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="no_register_luar" id="no_register_luar" value="<?php echo $no_register; ?>">
                                        <input type="hidden" name="no_medrec_luar" id="no_medrec_luar" value="<?php echo $no_medrec; ?>">
                                        <input type="hidden" name="cara_bayar_luar" id="cara_bayar_luar" value="<?php echo $cara_bayar; ?>">
                                        <input type="hidden" name="idrg_luar" id="idrg_luar" value="<?php echo $idrg; ?>">
                                        <input type="hidden" name="bed_luar" id="bed_luar" value="<?php echo $bed; ?>">
                                        <input type="hidden" name="no_resep_luar" id="no_resep_luar" value="<?php echo $no_resep; ?>" >
                                        <input type="hidden" name="pelayan_luar" id="pelayan_luar" value="<?php echo $pelayan; ?>" >
                                        <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"name="tgl_kun">
                                        <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
                                        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                                    </div>
                                <!-- </form> -->
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <br>
                            <div >
                                    <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_old'); ?>
                                        <table id="obat_neuro" class=" table display table-hover table-bordered table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">No</th>
                                                    <th style="width: 25%;">Nama Obat</th>
                                                    <th style="width: 60%;">Signa</th>
                                                    <th style="width: 10%;">Quantity</th>
                                                </tr>
                                            </thead>
                                            <?php foreach ($data_obat_poli as $key) { ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="jumlah_obat[]" id="<?php echo $key->id_inventory; ?>" value="<?php echo $key->id_inventory; ?>">
                                                        <label for="<?php echo $key->id_inventory; ?>"></label>
                                                    </td>
                                                    <td><label><?= $key->nm_obat.'- batch ('.$key->batch_no.')' ?></label></td>
                                                    <td>
                                                        <select class="form-control " name="signa-<?php echo $key->id_inventory; ?>" id="signa-<?php echo $key->id_inventory; ?>" style="width: 20%;">
                                                            <option value="">-Signa-</option>
                                                            <?php foreach ($satuan_signa as $row) { ?>
                                                                <option value="<?=$row->signa?>"><?=$row->signa?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select class="form-control " name="qtx-<?php echo $key->id_inventory; ?>" id="qtx-<?php echo $key->id_inventory; ?>" style="width: 11%;">
                                                            <option value="">-Qtx-</option>
                                                            <?php foreach ($qtx as $row) { ?>
                                                                <option value="<?=$row->qtx?>"><?=$row->qtx?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select class="form-control " name="satuan-<?php echo $key->id_inventory; ?>" id="satuan-<?php echo $key->id_inventory; ?>" style="width: 24%;">
                                                            <option value="">-Satuan-</option>
                                                            <?php foreach ($satuan as $row) { ?>
                                                                <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select class="form-control " name="cara_pakai-<?php echo $key->id_inventory; ?>" id="cara_pakai-<?php echo $key->id_inventory; ?>" style="width: 23%;">
                                                            <option value="">-Cara Pakai-</option>
                                                            <?php foreach ($cara_pakai as $row) { ?>
                                                                <option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="id_obat[]" id="id_obat" value="<?php echo $key->id_inventory; ?>">
                                                        <input type="number" min="1" name="qty-<?php echo $key->id_inventory; ?>" id="qty" placeholder="Qty" class="form-control" style="width: 80%;">
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </table>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <input type="hidden" name="no_register" id="no_register" value="<?php echo $no_register; ?>">
                                                <input type="hidden" name="no_medrec" id="no_medrec" value="<?php echo $no_medrec; ?>">
                                                <input type="hidden" name="cara_bayar" id="cara_bayar" value="<?php echo $cara_bayar; ?>">
                                                <input type="hidden" name="idrg" id="idrg" value="<?php echo $idrg; ?>">
                                                <input type="hidden" name="bed" id="bed" value="<?php echo $bed; ?>">
                                                <input type="hidden" name="pelayan" id="pelayan" value="<?php echo $pelayan; ?>">
                                                <input type="hidden" name="no_resep" id="no_resep" value="<?php echo $no_resep; ?>" >
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                            </div>
                    </div><!-- end div id home -->

                    <div id="racikan" class="tab-pane <?php echo $tab_racik; ?>" role="tabpanel">
                        <input name="jenis_obat" type="radio" id="obatrs" class="with-gap" value="1" checked/>
                        <?php if ($pelayan == 'DOKTER') { ?>
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan'); ?>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="jenisObat">Jenis Obat</p>
                                        <div class="col-sm-10">
                                            <div class="demo-radio-button">
                                                <input name="jenis_obat_racik" type="radio" id="obatrs_racik" class="with-gap"
                                                    value="1" checked/> <label for="obatrs_racik">Obat RS</label>
                                                <input name="jenis_obat_racik" type="radio" id="obatluar_racik" class="with-gap"
                                                    value="0"/> <label for="obatluar_racik">Obat dari Luar</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                        <div class="col-sm-10">
                                            <input type="search" class="form-control" id="cari_obat2" name="cari_obat2"
                                                placeholder="Pencarian Obat" >
                                            <input type="hidden" class="form-control" value="" name="ket2"
                                                id="ket2">
                                            <input type="hidden" name="idracikan" id="idracikan">
                                            <input type="hidden" name="idtindakanracik" id="idtindakanracik">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_dosis">Dosis</p>
                                        <div class="col-sm-2">

                                            <input type="number" step="0.1" class="form-control" name="dosis_racikan" id="dosis_racikan" required>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_dosis">Satuan</p>
                                        <div class="col-sm-2">

                                            <!-- <input type="number" step="0.1" class="form-control" name="dosis_racikan" id="dosis_racikan" required> -->
                                            <select class="form-control js-example-basic-single" style="width: 100%" name="satuan_racikan" id="satuan_racikan">
                                                <option value="">-Pilih Satuan-</option>
                                                <?php foreach ($satuan as $row) { ?>
                                                <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                    <!-- <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
                                        <div class="col-sm-2">

                                            <input type="number" step="1" class="form-control" name="qty_racikan"
                                                id="qty_racikan" onchange="set_total_racikan()">
                                            <input type="hidden" step="1" class="form-control" name="qty_racikan_hidden"
                                                id="qty_racikan_hidden">
                                        </div>

                                    </div> -->
                                    <!-- <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_qtyind"></p>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#myModal">Calculator
                                            </button>
                                        </div>
                                    </div> -->


                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog modal-sm">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Calculator Racikan</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="diminta"
                                                                id="diminta" placeholder="Diminta">
                                                        </div>
                                                        <p align="center" class="col-sm-2"><b>X</b></p>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="dibutuhkan"
                                                                id="dibutuhkan" placeholder="Dibutuhkan">
                                                        </div>
                                                    </div>
                                                    <p>______________________________________________________</p>
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" align="center" class="form-control"
                                                                name="dosis" id="dosis" placeholder="Dosis">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <p class="col-sm-2 form-control-label" id="lbl_hasil"><b>Hasil</b>
                                                        </p>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    name="hasil_calculator" id="hasil_calculator"
                                                                    placeholder="Hasil" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-primary" type="button"
                                                                            onclick="set_hasil_calculator()">Cek</button>
                                                                </span>
                                                            </div>
                                                            <input type="hidden" class="form-control" value=""
                                                                name="hasil_calculator_hide" id="hasil_calculator_hide">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Selesai
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>"
                                                name="biaya_racikan" id="biaya_racikan" disabled>
                                            <input type="hidden" class="form-control" value="" name="biaya_racikan_hide"
                                                id="biaya_racikan_hide">
                                        </div>
                                    </div>


                                    <!-- <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="vtot_racikan" id="vtot_racikan"
                                                disabled>
                                            <input type="hidden" class="form-control" value="" name="vtot_racikan_hide"
                                                id="vtot_racikan_hide">
                                        </div>
                                    </div> -->




                                    <div class="form-inline" align="right">
                                        <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                            name="kelas_pasien">
                                        <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                            name="no_medrec">
                                        <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>"
                                            name="no_cm">
                                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                            name="no_register">
                                        <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                            name="cara_bayar">


                                        <!-- <?php
                                        if ($no_resep != '') {
                                            echo "<input type='hidden' class='form-control' value=" . $no_resep . " name='no_resep'>";
                                        } else {

                                        }
                                        ?> -->
                                        <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                            name="tgl_kunjungan">
                                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                        <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                        <!--<input type="hidden" class="form-control" value="<?php echo $no_resep; ?>" name="no_resep">-->

                                        <input type="hidden" class="form-control" value="<?php echo $no_resep; ?>"
                                            name="no_resep">
                                        <div class="form-group">
                                            <button type="reset" class="btn bg-orange">Reset</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>


                                    <br><br>
                                    <table class="display nowrap table table-hover table-bordered table-striped"
                                        cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><p align="center">No</p></th>
                                            <th><p align="center">Nama Obat</p></th>
                                            <th><p align="center">Harga Obat</p></th>
                                            <th><p align="center">Dosis</p></th>
                                            <th><p align="center">Satuan</p></th>
                                            <th><p align="center">Qty</p></th>
                                            <!--<th >Harga Satuan</th>-->
                                            <th><p align="center">Total</p></th>
                                            <th><p align="center">Aksi</p></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $i = 1;
                                        $vtot1 = 0;
                                        $vtot2 = 0;

                                        foreach ($data_tindakan_racikan as $row) {

                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $i++; ?></td>
                                                <td><?php echo $row->nm_obat; ?></td>
                                                <td><?php echo $row->hargajual; ?></td>
                                                <td><?php echo $row->dosis; ?></td>
                                                <td><?php echo $row->satuan; ?></td>
                                                <td align="center"><?php echo $row->qty; ?></td>
                                                <?php $v = $row->hargajual * $row->qty;
                                                $vtot1 = $vtot1 + $v;
                                                ?>
                                                <!--<td><?php echo $row->biaya_obat; ?></td>-->
                                                <td>Rp
                                                    <div class="pull-right"><?php echo number_format($v, 2, ',', '.'); ?></div>
                                                </td>
                                                <td>
                                                    <!-- <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_racikan/" . $no_register . "/" . $row->id_obat_racikan); ?>"
                                                    class="btn btn-danger btn-xs"></a> -->
                                                    <input type="button" class="btn btn-danger btn-xs" onclick="hapus_obat_racikan('<?= $no_register ?>','<?= $row->id_obat_racikan ?>','<?= $row->id_resep_pasien ?>')" value="Hapus">
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModalracikan" onclick="edit_obat_racikan('<?php echo $no_register; ?>','<?php echo $row->id_obat_racikan; ?>')">Edit</button>
                                                    </td>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="5" align="right"><b>Total</b></td>
                                            <td>Rp
                                                <div class="pull-right"><b><?php echo number_format($vtot1, 2, ',', '.'); ?>
                                                        <input type="hidden" class="form-control"
                                                            value="<?php echo $vtot1; ?>" name="vtot1"></b></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan_selesai'); ?>
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_racikan">Nama Racikan</p>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="racikan" id="rck">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                            <!-- <div class="col-sm-1">
                                                <input type="number" class="form-control" name="sgn1" id="sgn1" min=0>
                                            </div>
                                            <div class="col-xs-1">
                                                <p><b>x Sehari</b></p>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="number" class="form-control" name="sgn2" id="sgn2" min=0>
                                            </div> -->
                                            <div class="col-sm-3">
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="signa" id="signa">
                                                    <option value="">-Pilih Signa-</option>

                                                    <?php
                                                    foreach ($satuan_signa as $row) {
                                                    ?>
                                                    <option value="<?=$row->signa?>"><?=$row->signa?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="qtx" id="qtx">
                                                    <option value="">-Pilih Qtx-</option>

                                                    <?php
                                                    foreach ($qtx as $row) {
                                                    ?>
                                                    <option value="<?=$row->qtx?>"><?=$row->qtx?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="satuan" id="satuan">
                                                    <option value="">-Pilih Satuan-</option>

                                                    <?php
                                                    foreach ($satuan as $row) {
                                                    ?>
                                                    <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="cara_pakai" id="cara_pakai">
                                                    <option value="">-Pilih Cara Pakai-</option>

                                                    <?php
                                                    foreach ($cara_pakai as $row) {
                                                    ?>
                                                    <option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col-sm-2">
                                                <select name="sgn3" id="sgn3" class="form-control" style="width: 100%;">
                                                    <option value="">--Pilih--</option>
                                                    <option value="sesudah">Sesudah Makan</option>
                                                    <option value="sebelum">Sebelum Makan</option>
                                                </select>
                                            </div> -->
                                        </div>

                                        <!-- <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                            <div class="col-sm-2">
                                                <input type="number" class="form-control" name="sgn1" id="sgn1" min=1>
                                            </div>
                                            <div class="col-sm-2">
                                                <p><b>x Sehari</b></p>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="sgn2" id="sgn2" min=0>
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="form-control" style="width: 100%" name="satuan" id="satuan"
                                                        >
                                                    <option value="">-Pilih Satuan-</option>
                                                    <?php
                                                    foreach ($satuan as $satuans) {
                                                    ?>
                                                    <option value="<?=$satuans->nm_satuan?>"><?=$satuans->nm_satuan?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="qty">Quantity Total</p>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" name="qty1" id="qty1" min=1
                                                    onkeyup="set_hasil_obat()">
                                            </div>
                                        </div>

                                        <!--<div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="qty">Tuslah Racik</p>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="tuslah_racik" id="tuslah_racik"
                                                    value="0" onchange="set_hasil_obat()">
                                            </div>
                                        </div> -->

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <p class="col-sm-4 form-control-label" id="lbl_vtotx">Total</p>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" name="vtot_x" id="vtot_x" disabled="">
                                                <input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-4 form-control-label">Farmasi *</p>
                                            <div class="col-sm-9">
                                                <div class="demo-radio-button">
                                                    <input name="bpjs_racik" type="radio" id="bpjs_racik" class="with-gap"
                                                        value="1" <?= ($cara_bayar == 'BPJS' ? 'checked' : '') ?> />
                                                    <label for="bpjs_racik">BPJS</label>
                                                    <input name="bpjs_racik" type="radio" id="umum_racik" class="with-gap"
                                                        value="0" <?php if ($cara_bayar == 'UMUM') {
                                                        echo 'checked';
                                                    } ?> />
                                                    <label for="umum_racik">PC/UMUM</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <p class="col-sm-3 form-control-label" id="margin_harga">Margin Harga *</p>
                                            <div class="col-sm-6">
                                                <div class="form-inline">
                                                    <div class="form-group" id="cb_margin_racik">
                                                        <?php

                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <p class="col-sm-4 form-control-label" id="total_akhir_racik">Total Akhir</p>
                                            <div class="col-sm-4">
                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="vtot_akhir_racik"
                                                            id="vtot_akhir_racik" disabled>
                                                        <input type="hidden" class="form-control" value=""
                                                            name="vtotakhir_hide_racik" id="vtotakhir_hide_racik">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                            name="tgl_kun">
                                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                        <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                        <!--<input type="hidden" class="form-control" value="<?php echo $no_resep; ?>" name="no_resep">-->
                                        <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>"
                                            name="xuser">
                                        <input type="hidden" class="form-control" value="<?php echo $no_resep; ?>"
                                            name="no_resep">
                                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                            name="no_register">
                                        <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                            name="kelas_pasien">
                                        <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                            name="no_medrec">
                                        <input type="hidden" class="form-control" value="<?php echo $pelayan; ?>"
                                            name="pelay$pelayan">
                                        <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>" name="no_cm">
                                        <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                            name="cara_bayar">
                                        <input type="hidden" class="form-control" name="fmarkup" id="fmarkup"
                                            value="<?php echo $fmarkup ?>">

                                        <input type="hidden" class="form-control" name="ppn" id="ppn"
                                            value="<?php echo $ppn ?>">
                                    </div>
                                    <div class="col-xs-6" align="right">
                                        <div class="form-inline" align="right">
                                            <div class="input-group">
                                                <div class="form-group">
                                                    <button class="btn btn-primary">Selesai Racik</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>

                            </div>
                        <?php }else{ ?>
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <form action="#" id="formRacikPetugas" class="formRacikPetugas">
                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                            <div class="col-sm-10">
                                                <input type="search" class="form-control" id="cari_obat2" name="cari_obat2"
                                                    placeholder="Pencarian Obat" required>
                                                <input type="hidden" class="form-control" value="" name="ket2"
                                                    id="ket2">
                                                <input type="hidden" name="idracikan" id="idracikan">
                                                <input type="hidden" name="idtindakanracik" id="idtindakanracik">

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_dosis">Dosis</p>
                                            <div class="col-sm-2">

                                                <input type="number" step="0.1" class="form-control" name="dosis_racikan" id="dosis_racikan" >
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_dosis">Satuan</p>
                                            <div class="col-sm-2">

                                                <!-- <input type="number" step="0.1" class="form-control" name="dosis_racikan" id="dosis_racikan" required> -->
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="satuan_racikan" id="satuan_racikan">
                                                    <option value="">-Pilih Satuan-</option>
                                                    <?php foreach ($satuan as $row) { ?>
                                                    <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>"
                                                    name="biaya_racikan" id="biaya_racikan" disabled>
                                                <input type="hidden" class="form-control" value="" name="biaya_racikan_hide"
                                                    id="biaya_racikan_hide">
                                            </div>
                                        </div>

                                        <div class="form-inline" align="right">
                                            <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                                name="kelas_pasien">
                                            <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                                name="no_medrec">
                                            <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>"
                                                name="no_cm">
                                            <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                                name="no_register">
                                            <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                                name="cara_bayar">
                                            <input type="hidden" class="form-control" id="id_resep_pasien_petugas"
                                                name="id_resep_pasien_petugas">


                                            <!-- <?php
                                            if ($no_resep != '') {
                                                echo "<input type='hidden' class='form-control' value=" . $no_resep . " name='no_resep'>";
                                            } else {

                                            }
                                            ?> -->
                                            <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                                name="tgl_kunjungan">
                                            <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                            <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                            <!--<input type="hidden" class="form-control" value="<?php echo $no_resep; ?>" name="no_resep">-->

                                            <input type="hidden" class="form-control" value="<?php echo $no_resep; ?>"
                                                name="no_resep">
                                            <div class="form-group">
                                                <button type="reset" class="btn bg-orange">Reset</button>
                                                <button type="button" class="btn btn-primary" onclick="racik_petugas()" >Tambah</button>
                                            </div>
                                        </div>
                                    </form>


                                    <br><br>
                                    <table  class="display nowrap table table-hover table-bordered table-striped"
                                        cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><p align="center">No</p></th>
                                            <th><p align="center">Nama Obat</p></th>
                                            <th><p align="center">Harga Obat</p></th>
                                            <th><p align="center">Dosis</p></th>
                                            <th><p align="center">Satuan</p></th>
                                            <th><p align="center">Qty</p></th>
                                            <!--<th >Harga Satuan</th>-->
                                            <th><p align="center">Total</p></th>
                                            <th><p align="center">Aksi</p></th>
                                        </tr>
                                        </thead>
                                        <tbody id="table_obat_racik_petugas">
                                        </tbody>
                                     </table>
                                </div>

                                <div id="selesai_racik_petugas">
                                    <?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan_selesai_petugas'); ?>
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <p class="col-sm-2 form-control-label" id="lbl_racikan">Nama Racikan</p>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="racikan" id="rck">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                                <div class="col-sm-3">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="signa" id="signa_petugas">
                                                        <option value="">-Pilih Signa-</option>

                                                        <?php
                                                        foreach ($satuan_signa as $row) {
                                                        ?>
                                                        <option value="<?=$row->signa?>"><?=$row->signa?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="qtx" id="qtx_petugas">
                                                        <option value="">-Pilih Qtx-</option>

                                                        <?php
                                                        foreach ($qtx as $row) {
                                                        ?>
                                                        <option value="<?=$row->qtx?>"><?=$row->qtx?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="satuan" id="satuan_petugas">
                                                        <option value="">-Pilih Satuan-</option>

                                                        <?php
                                                        foreach ($satuan as $row) {
                                                        ?>
                                                        <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="cara_pakai" id="cara_pakai_petugas">
                                                        <option value="">-Pilih Cara Pakai-</option>

                                                        <?php
                                                        foreach ($cara_pakai as $row) {
                                                        ?>
                                                        <option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-2 form-control-label" id="qty">Quantity Total <label for="" id="qty_old_petugas"></label></p>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="qty1" id="qty1" min=1
                                                        onkeyup="set_hasil_obat_petugas()" required>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <p class="col-sm-4 form-control-label" id="lbl_vtotx">Total</p>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="vtot_x" id="vtot_x" disabled="">
                                                    <input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-4 form-control-label">Farmasi *</p>
                                                <div class="col-sm-9">
                                                    <div class="demo-radio-button">
                                                        <input name="bpjs_racik" type="radio" id="bpjs_racik" class="with-gap"
                                                            value="1" <?= ($cara_bayar == 'BPJS' ? 'checked' : '') ?> />
                                                        <label for="bpjs_racik">BPJS</label>
                                                        <input name="bpjs_racik" type="radio" id="umum_racik" class="with-gap"
                                                            value="0" <?php if ($cara_bayar == 'UMUM') {
                                                            echo 'checked';
                                                        } ?> />
                                                        <label for="umum_racik">PC/UMUM</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-4 form-control-label" id="total_akhir_racik">Total Akhir</p>
                                                <div class="col-sm-4">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="vtot_akhir_racik"
                                                                id="vtot_akhir_racik" disabled>
                                                            <input type="hidden" class="form-control" value=""
                                                                name="vtotakhir_hide_racik" id="vtotakhir_hide_racik">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                                name="tgl_kun">
                                            <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                            <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                            <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>"
                                                name="xuser">
                                            <input type="hidden" class="form-control" value="<?php echo $no_resep; ?>"
                                                name="no_resep">
                                            <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                                name="no_register">
                                            <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                                name="kelas_pasien">
                                            <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                                name="no_medrec">
                                            <input type="hidden" class="form-control" value="<?php echo $pelayan; ?>"
                                                name="pelay$pelayan">
                                            <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>" name="no_cm">
                                            <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                                name="cara_bayar">
                                            <input type="hidden" class="form-control" name="fmarkup" id="fmarkup"
                                                value="<?php echo $fmarkup ?>">

                                            <input type="hidden" class="form-control" name="ppn" id="ppn"
                                                value="<?php echo $ppn ?>">
                                            <input type="hidden" class="form-control" name="id_resep_petugas" id="id_resep_petugas">
                                        </div>

                                        <div class="col-xs-6" align="right">
                                            <div class="form-inline" align="right">
                                                <div class="input-group">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary">Selesai Racik</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                                </div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
        <?php }else{ ?>
            <button type="button" class="btn btn-warning box-title" data-toggle="modal" data-target="#obatHistory" onclick="<?php if(!isset($noregasal)){ ?>ajaxhistory('<?php echo $no_register; ?>')<?php }else{ ?>ajaxhistory_ri('<?php echo $no_register; ?>','<?php echo $noregasal; ?>')<?php } ?>">Obat History</button>
            <br><br>
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item"><a class="nav-link <?php echo $tab_obat; ?>" data-toggle="tab" href="#obat"
                                            role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                    class="hidden-xs-down">OBAT</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $tab_racik; ?>" data-toggle="tab" href="#racikan"
                                            role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                    class="hidden-xs-down">RACIKAN</span></a></li>
                </ul>
                <div class="tab-content">
                    <br>

                    <div id="obat" class="tab-pane <?php echo $tab_obat; ?>" role="tabpanel">

                        <div class="panel panel-info">
                            <div class="panel-body">
                                <form action="<?php echo base_url('farmasi/Frmcdaftar/insert_permintaan_rad'); ?>" method="post">
                                <?php //echo form_open('farmasi/Frmcdaftar/insert_permintaan'); ?>
                                    <input type="hidden" name="idpoli" value="<?= isset($idrg)?($idrg == "BA00")?$idrg:$id_poli:$id_poli  ?>"/>
                                    <input type="hidden" name="jenis_cara_bayar" value="<?=$cara_bayar?>"/>
                                    <input type="hidden" name="satelit" value=""/>
                                    <input type="hidden" name="pelayan" value="<?=$pelayan?>"/>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label">Kronis?</p>
                                        <div class="col-sm-2">
                                            <select name="kronis" id="kronis" class="form-control" >
                                                <option value="0"> Non Kronis</option>
                                                <option value="1"> Kronis</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="jenisObat">Jenis Obat *</p>
                                        <div class="col-sm-10">
                                            <div class="demo-radio-button">
                                                <input onclick="kondisi_obat_igd_biasa(this.value)" name="jenis_obat" type="radio" id="obatrs" class="with-gap"
                                                    value="1" checked/> <label for="obatrs">Obat RS</label>
                                                <input onclick="kondisi_obat_igd_biasa(this.value)" name="jenis_obat" type="radio" id="obatluar" class="with-gap"
                                                    value="0"/> <label for="obatluar">Obat dari Luar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="jenisObat">Pilih Dokter </p>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="dokter_rad" id="dokter_rad" required >
                                                <option value="">-Pilih Dokter-</option>
                                                <?php foreach($dokter_rad as $r){	
                                                    echo '<option value="'.$r->id_dokter.'-'.$r->userid.'-'.$r->nm_dokter.'">'.$r->nm_dokter.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($pengkondisian_poli == 'BA00') { ?>
                                        <div class="form-group row obat-biasa">
                                            <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                            <div class="col-sm-6">
                                                <input type="search" class="form-control" id="cari_obat" name="cari_obat"
                                                    placeholder="Pencarian Obat">
                                                <input type="hidden" name="idtindakan" id="idtindakan">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="hidden" name="obat_biasa_igd" id="cek_obat_biasa" value="obat_biasa">
                                                <input type="button" value="OBAT IGD" class="btn btn-primary btn_obat_igd" onclick="switchObatIgd()">
                                            </div>
                                        </div>
                                        <div class="form-group row obat-igd">
                                            <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                            <div class="col-sm-6">
                                                <!-- <input type="search" class="form-control" id="cari_obat" name="cari_obat"placeholder="Pencarian Obat"> -->
                                                <select name="cari_obat_igd" id="cari_obat_igd" class="form-control js-example-basic-single" onchange="obat_igd(this.value)">
                                                    <option value="">--Pilih Obat--</option>
                                                    <?php foreach ($obat_igd as $key) { ?>
                                                        <option value="<?php echo $key->id_inventory ?>"><?php echo $key->nm_obat ?></option>
                                                    <?php } ?>
                                                </select>
                                                <input type="hidden" name="idtindakan_igd" id="idtindakan_igd">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="hidden" name="obat_biasa_igd" id="cek_obat_igd" value="obat_igd">
                                                <input type="button" value="OBAT ALL" class="btn btn-primary btn_obat_biasa" onclick="switchObatBiasa()">
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                            <div class="col-sm-6">
                                                <input type="search" class="form-control" id="cari_obat" name="cari_obat"
                                                    placeholder="Pencarian Obat">
                                                <input type="hidden" name="idtindakan" id="idtindakan">
                                            </div>
                                        </div>
                                    <?php } ?>


                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>"
                                                name="biaya_obat" id="biaya_obat" disabled>
                                            <input type="hidden" class="form-control" value="" name="biaya_obat_hide"
                                                id="biaya_obat_hide">
                                        </div>
                                    </div>

                                    <div class="form-group row otomatis">
                                        <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                        <!-- <div class="col-sm-1">
                                            <input type="number" class="form-control" name="sgn1" id="sgn1" min=0>
                                        </div>
                                        <div class="col-xs-1">
                                            <p><b>x Sehari</b></p>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="sgn2" id="sgn2" min=0>
                                        </div> -->
                                        <div class="col-sm-2">
                                            <select class="form-control js-example-basic-single" style="width: 100%" name="signa" id="signa">
                                                <option value="">-Pilih Signa-</option>

                                                <?php
                                                foreach ($satuan_signa as $row) {
                                                ?>
                                                <option value="<?=$row->signa?>"><?=$row->signa?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                        <?php if($pengkondisian_poli == 'BR00') { ?>
                                            <input type="text" class="form-control" name="qtx" id="qtx" placeholder="Qtx">
                                        <?php }else{ ?>
                                            <select class="form-control js-example-basic-single" style="width: 100%" name="qtx" id="qtx">
                                                <option value="">-Pilih Qtx-</option>

                                                <?php
                                                foreach ($qtx as $row) {
                                                ?>
                                                <option value="<?=$row->qtx?>"><?=$row->qtx?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        <?php } ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <select class="form-control js-example-basic-single" style="width: 100%" name="satuan" id="satuan">
                                                <option value="">-Pilih Satuan-</option>

                                                <?php
                                                foreach ($satuan as $row) {
                                                ?>
                                                <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select class="form-control js-example-basic-single" style="width: 100%" name="cara_pakai" id="cara_pakai">
                                                <option value="">-Pilih Cara Pakai-</option>

                                                <?php
                                                foreach ($cara_pakai as $row) {
                                                ?>
                                                <option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="button" value="MANUAL" class="btn btn-primary" onclick="switchsigna(this.value)">
                                        </div>
                                        <!-- <div class="col-sm-2">
                                            <select name="sgn3" id="sgn3" class="form-control" style="width: 100%;">
                                                <option value="">--Pilih--</option>
                                                <option value="sesudah">Sesudah Makan</option>
                                                <option value="sebelum">Sebelum Makan</option>
                                            </select>
                                        </div> -->
                                    </div>

                                    <div class="form-group row manual">
                                        <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                        <div class="col-sm-8">
                                            <input type="text" name="signa_all" id="" class="form-control">
                                        </div>
                                        <div class="col-sm-2">

                                            <input type="button" value="OTOMATIS" class="btn btn-primary"onclick="switchsigna(this.value)">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
                                        <div class="col-sm-2">
                                            <input type="number" class="form-control" name="qty" id="qty" min=1
                                                onkeyup="set_total(this.value)">
                                            <input type="hidden" class="form-control" value="" name="ket"
                                                id="ket">
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" name="fmarkup" id="fmarkup"
                                        value="<?php echo $fmarkup ?>">

                                    <input type="hidden" class="form-control" name="ppn" id="ppn"
                                        value="<?php echo $ppn ?>">

                                    <!-- <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="farmasi">Farmasi *</p>
                                        <div class="col-sm-10">
                                            <div class="demo-radio-button">
                                                <input name="bpjs" type="radio" id="bpjs" class="with-gap"
                                                    value="1" <?= ($cara_bayar == 'BPJS' ? 'checked' : '') ?> />
                                                <label for="bpjs">BPJS</label>
                                                <input name="bpjs" type="radio" id="umum" class="with-gap"
                                                    value="0" <?php if ($cara_bayar == 'UMUM') {
                                                    echo 'checked';
                                                } ?> />
                                                <label for="umum">PC/UMUM</label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="margin_harga">Margin Harga *</p>
                                        <div class="col-sm-10">
                                            <div class="form-inline">
                                                <div id="cb_margin" disabled>
                                                    <?php
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="total_akhir">Total Akhir</p>
                                        <div class="col-sm-10">
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="vtot"
                                                        id="vtot" disabled>
                                                    <input type="hidden" class="form-control" value="" name="vtot_hide"
                                                        id="vtot_hide">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- added -> aldi -->
                                    <!-- kalo pasien rawat inap masuk kesini -->
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="jenisObat">Resep Pulang</p>
                                        <div class="col-sm-10">
                                            <div class="demo-radio-button">
                                                <input name="resep_pulang" type="radio" id="resep_pulang_1" class="with-gap"
                                                    value="1" /> <label for="resep_pulang_1">Ya</label>
                                                <input name="resep_pulang" type="radio" id="resep_pulang_2" class="with-gap"
                                                    value="0" checked/> <label for="resep_pulang_2">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->

                                    <input type="hidden" name="gantisigna" class="jenis_signa">
                                    <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                        name="kelas_pasien">
                                    <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                        name="no_medrec">
                                    <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>" name="no_cm">
                                    <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                        name="no_register">
                                    <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                        name="cara_bayar" id="cara_bayar">


                                    <?php
                                    if ($no_resep != '') {
                                        echo "<input type='hidden' class='form-control' value=" . $no_resep . " name='no_resep'>";
                                    } else {

                                    }
                                    ?>
                                    <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                        name="tgl_kun">
                                    <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                    <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                    <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>"
                                        name="xuser">
                                    <!--<input type="hidden" class="form-control" value="<?php echo $no_resep; ?>" name="no_resep">-->

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="submit" class="btn btn-primary" onClick="sabar()" id="btn-order">Simpan</button>
                                        </div>
                                    </div>
                                <?php //echo form_close(); ?>
                                </form>
                            </div><!-- end panel body -->
                        </div><!-- end panel info-->
                    </div><!-- end div id home -->

                    <div id="racikan" class="tab-pane <?php echo $tab_racik; ?>" role="tabpanel">
                        <?php if ($pelayan == 'DOKTER') { ?>
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan'); ?>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="jenisObat">Jenis Obat</p>
                                        <div class="col-sm-10">
                                            <div class="demo-radio-button">
                                                <input name="jenis_obat_racik" type="radio" id="obatrs_racik" class="with-gap"
                                                    value="1" checked/> <label for="obatrs_racik">Obat RS</label>
                                                <input name="jenis_obat_racik" type="radio" id="obatluar_racik" class="with-gap"
                                                    value="0"/> <label for="obatluar_racik">Obat dari Luar</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                        <div class="col-sm-10">
                                            <input type="search" class="form-control" id="cari_obat2" name="cari_obat2"
                                                placeholder="Pencarian Obat" onkeyup="biaya_racikan_luar()" onchange="biaya_racikan_luar()">
                                            <input type="hidden" class="form-control" value="" name="ket2"
                                                id="ket2">
                                            <input type="hidden" name="idracikan" id="idracikan">
                                            <input type="hidden" name="idtindakanracik" id="idtindakanracik">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_dosis">Dosis</p>
                                        <div class="col-sm-2">

                                            <input type="number" step="0.1" class="form-control" name="dosis_racikan" id="dosis_racikan" required>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_dosis">Satuan</p>
                                        <div class="col-sm-2">

                                            <!-- <input type="number" step="0.1" class="form-control" name="dosis_racikan" id="dosis_racikan" required> -->
                                            <select class="form-control js-example-basic-single" style="width: 100%" name="satuan_racikan" id="satuan_racikan">
                                                <option value="">-Pilih Satuan-</option>
                                                <?php foreach ($satuan as $row) { ?>
                                                <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                    <!-- <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
                                        <div class="col-sm-2">

                                            <input type="number" step="1" class="form-control" name="qty_racikan"
                                                id="qty_racikan" onchange="set_total_racikan()">
                                            <input type="hidden" step="1" class="form-control" name="qty_racikan_hidden"
                                                id="qty_racikan_hidden">
                                        </div>

                                    </div> -->
                                    <!-- <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_qtyind"></p>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#myModal">Calculator
                                            </button>
                                        </div>
                                    </div> -->


                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog modal-sm">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Calculator Racikan</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="diminta"
                                                                id="diminta" placeholder="Diminta">
                                                        </div>
                                                        <p align="center" class="col-sm-2"><b>X</b></p>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="dibutuhkan"
                                                                id="dibutuhkan" placeholder="Dibutuhkan">
                                                        </div>
                                                    </div>
                                                    <p>______________________________________________________</p>
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="text" align="center" class="form-control"
                                                                name="dosis" id="dosis" placeholder="Dosis">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <p class="col-sm-2 form-control-label" id="lbl_hasil"><b>Hasil</b>
                                                        </p>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    name="hasil_calculator" id="hasil_calculator"
                                                                    placeholder="Hasil" disabled>
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-primary" type="button"
                                                                            onclick="set_hasil_calculator()">Cek</button>
                                                                </span>
                                                            </div>
                                                            <input type="hidden" class="form-control" value=""
                                                                name="hasil_calculator_hide" id="hasil_calculator_hide">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Selesai
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>"
                                                name="biaya_racikan" id="biaya_racikan" disabled>
                                            <input type="hidden" class="form-control" value="" name="biaya_racikan_hide"
                                                id="biaya_racikan_hide">
                                        </div>
                                    </div>


                                    <!-- <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="vtot_racikan" id="vtot_racikan"
                                                disabled>
                                            <input type="hidden" class="form-control" value="" name="vtot_racikan_hide"
                                                id="vtot_racikan_hide">
                                        </div>
                                    </div> -->




                                    <div class="form-inline" align="right">
                                        <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                            name="kelas_pasien">
                                        <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                            name="no_medrec">
                                        <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>"
                                            name="no_cm">
                                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                            name="no_register">
                                        <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                            name="cara_bayar">


                                        <!-- <?php
                                        if ($no_resep != '') {
                                            echo "<input type='hidden' class='form-control' value=" . $no_resep . " name='no_resep'>";
                                        } else {

                                        }
                                        ?> -->
                                        <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                            name="tgl_kunjungan">
                                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                        <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                        <!--<input type="hidden" class="form-control" value="<?php echo $no_resep; ?>" name="no_resep">-->

                                        <input type="hidden" class="form-control" value="<?php echo $no_resep; ?>"
                                            name="no_resep">
                                        <div class="form-group">
                                            <button type="reset" class="btn bg-orange">Reset</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>


                                    <br><br>
                                    <table class="display nowrap table table-hover table-bordered table-striped"
                                        cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><p align="center">No</p></th>
                                            <th><p align="center">Nama Obat</p></th>
                                            <th><p align="center">Harga Obat</p></th>
                                            <th><p align="center">Dosis</p></th>
                                            <th><p align="center">Satuan</p></th>
                                            <th><p align="center">Qty</p></th>
                                            <!--<th >Harga Satuan</th>-->
                                            <th><p align="center">Total</p></th>
                                            <th><p align="center">Aksi</p></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $i = 1;
                                        $vtot1 = 0;
                                        $vtot2 = 0;

                                        foreach ($data_tindakan_racikan as $row) {

                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $i++; ?></td>
                                                <td><?php echo $row->nama_obat; ?></td>
                                                <td><?php echo isset($row->hargajual)?$row->hargajual:'0'; ?></td>
                                                <td><?php echo $row->dosis; ?></td>
                                                <td><?php echo $row->satuan; ?></td>
                                                <td align="center"><?php echo $row->qty; ?></td>
                                                <?php $v = $row->hargajual * $row->qty;
                                                $vtot1 = $vtot1 + $v;
                                               
                                                ?>
                                                <!--<td><?php echo $row->biaya_obat; ?></td>-->
                                                <td>Rp
                                                    <div class="pull-right"><?php echo number_format($v, 2, ',', '.'); ?></div>
                                                </td>
                                                <td>
                                                    <!-- <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_racikan/" . $no_register . "/" . $row->id_obat_racikan); ?>"
                                                    class="btn btn-danger btn-xs"></a> -->
                                                    <input type="button" class="btn btn-danger btn-xs" onclick="hapus_obat_racikan('<?= $no_register ?>','<?= $row->id_obat_racikan ?>','<?= $row->id_resep_pasien ?>')" value="Hapus">
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModalracikan" onclick="edit_obat_racikan('<?php echo $no_register; ?>','<?php echo $row->id_obat_racikan; ?>')">Edit</button>
                                                    </td>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="5" align="right"><b>Total</b></td>
                                            <td>Rp
                                                <div class="pull-right"><b><?php echo number_format($vtot1, 2, ',', '.'); ?>
                                                        <input type="hidden" class="form-control"
                                                            value="<?php echo $vtot1; ?>" name="vtot1"></b></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan_selesai'); ?>
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_racikan">Nama Racikan</p>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="racikan" id="rck">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                            <!-- <div class="col-sm-1">
                                                <input type="number" class="form-control" name="sgn1" id="sgn1" min=0>
                                            </div>
                                            <div class="col-xs-1">
                                                <p><b>x Sehari</b></p>
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="number" class="form-control" name="sgn2" id="sgn2" min=0>
                                            </div> -->
                                            <div class="col-sm-3">
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="signa" id="signa">
                                                    <option value="">-Pilih Signa-</option>

                                                    <?php
                                                    foreach ($satuan_signa as $row) {
                                                    ?>
                                                    <option value="<?=$row->signa?>"><?=$row->signa?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="qtx" id="qtx">
                                                    <option value="">-Pilih Qtx-</option>

                                                    <?php
                                                    foreach ($qtx as $row) {
                                                    ?>
                                                    <option value="<?=$row->qtx?>"><?=$row->qtx?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="satuan" id="satuan">
                                                    <option value="">-Pilih Satuan-</option>

                                                    <?php
                                                    foreach ($satuan as $row) {
                                                    ?>
                                                    <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="cara_pakai" id="cara_pakai">
                                                    <option value="">-Pilih Cara Pakai-</option>

                                                    <?php
                                                    foreach ($cara_pakai as $row) {
                                                    ?>
                                                    <option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col-sm-2">
                                                <select name="sgn3" id="sgn3" class="form-control" style="width: 100%;">
                                                    <option value="">--Pilih--</option>
                                                    <option value="sesudah">Sesudah Makan</option>
                                                    <option value="sebelum">Sebelum Makan</option>
                                                </select>
                                            </div> -->
                                        </div>

                                        <!-- <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                            <div class="col-sm-2">
                                                <input type="number" class="form-control" name="sgn1" id="sgn1" min=1>
                                            </div>
                                            <div class="col-sm-2">
                                                <p><b>x Sehari</b></p>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" name="sgn2" id="sgn2" min=0>
                                            </div>
                                            <div class="col-sm-3">
                                                <select class="form-control" style="width: 100%" name="satuan" id="satuan"
                                                        >
                                                    <option value="">-Pilih Satuan-</option>
                                                    <?php
                                                    foreach ($satuan as $satuans) {
                                                    ?>
                                                    <option value="<?=$satuans->nm_satuan?>"><?=$satuans->nm_satuan?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="qty">Quantity Total</p>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" name="qty1" id="qty1" min=1
                                                    oninput="set_hasil_obat()">
                                            </div>
                                        </div>

                                        <!--<div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="qty">Tuslah Racik</p>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="tuslah_racik" id="tuslah_racik"
                                                    value="0" onchange="set_hasil_obat()">
                                            </div>
                                        </div> -->

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <p class="col-sm-4 form-control-label" id="lbl_vtotx">Total</p>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" name="vtot_x" id="vtot_x" disabled="">
                                                <input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-4 form-control-label">Farmasi *</p>
                                            <div class="col-sm-9">
                                                <div class="demo-radio-button">
                                                    <input name="bpjs_racik" type="radio" id="bpjs_racik" class="with-gap"
                                                        value="1" <?= ($cara_bayar == 'BPJS' ? 'checked' : '') ?> />
                                                    <label for="bpjs_racik">BPJS</label>
                                                    <input name="bpjs_racik" type="radio" id="umum_racik" class="with-gap"
                                                        value="0" <?php if ($cara_bayar == 'UMUM') {
                                                        echo 'checked';
                                                    } ?> />
                                                    <label for="umum_racik">PC/UMUM</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <p class="col-sm-3 form-control-label" id="margin_harga">Margin Harga *</p>
                                            <div class="col-sm-6">
                                                <div class="form-inline">
                                                    <div class="form-group" id="cb_margin_racik">
                                                        <?php

                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="jenisObat">Resep Pulang</p>
                                            <div class="col-sm-10">
                                                <div class="demo-radio-button">
                                                    <input name="resep_pulang_racik" type="radio" id="resep_pulang_racik_1" class="with-gap"
                                                        value="1" /> <label for="resep_pulang_racik_1">Ya</label>
                                                    <input name="resep_pulang_racik" type="radio" id="resep_pulang_racik_2" class="with-gap"
                                                        value="0" checked/> <label for="resep_pulang_racik_2">Tidak</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-4 form-control-label" id="total_akhir_racik">Total Akhir</p>
                                            <div class="col-sm-4">
                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="vtot_akhir_racik"
                                                            id="vtot_akhir_racik" disabled>
                                                        <input type="hidden" class="form-control" value=""
                                                            name="vtotakhir_hide_racik" id="vtotakhir_hide_racik">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                            name="tgl_kun">
                                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                        <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                        <!--<input type="hidden" class="form-control" value="<?php echo $no_resep; ?>" name="no_resep">-->
                                        <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>"
                                            name="xuser">
                                        <input type="hidden" class="form-control" value="<?php echo $no_resep; ?>"
                                            name="no_resep">
                                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                            name="no_register">
                                        <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                            name="kelas_pasien">
                                        <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                            name="no_medrec">
                                        <input type="hidden" class="form-control" value="<?php echo $pelayan; ?>"
                                            name="pelay$pelayan">
                                        <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>" name="no_cm">
                                        <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                            name="cara_bayar">
                                        <input type="hidden" class="form-control" name="fmarkup" id="fmarkup"
                                            value="<?php echo $fmarkup ?>">

                                        <input type="hidden" class="form-control" name="ppn" id="ppn"
                                            value="<?php echo $ppn ?>">
                                    </div>
                                    <div class="col-xs-6" align="right">
                                        <div class="form-inline" align="right">
                                            <div class="input-group">
                                                <div class="form-group">
                                                    <button class="btn btn-primary">Selesai Racik</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>

                            </div>
                        <?php }else{ ?>
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <form action="#" id="formRacikPetugas" class="formRacikPetugas">
                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                            <div class="col-sm-10">
                                                <input type="search" class="form-control" id="cari_obat2" name="cari_obat2"
                                                    placeholder="Pencarian Obat" required>
                                                <input type="hidden" class="form-control" value="" name="ket2"
                                                    id="ket2">
                                                <input type="hidden" name="idracikan" id="idracikan">
                                                <input type="hidden" name="idtindakanracik" id="idtindakanracik">

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_dosis">Dosis</p>
                                            <div class="col-sm-2">

                                                <input type="number" step="0.1" class="form-control" name="dosis_racikan" id="dosis_racikan" >
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_dosis">Satuan</p>
                                            <div class="col-sm-2">

                                                <!-- <input type="number" step="0.1" class="form-control" name="dosis_racikan" id="dosis_racikan" required> -->
                                                <select class="form-control js-example-basic-single" style="width: 100%" name="satuan_racikan" id="satuan_racikan">
                                                    <option value="">-Pilih Satuan-</option>
                                                    <?php foreach ($satuan as $row) { ?>
                                                    <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>"
                                                    name="biaya_racikan" id="biaya_racikan" disabled>
                                                <input type="hidden" class="form-control" value="" name="biaya_racikan_hide"
                                                    id="biaya_racikan_hide">
                                            </div>
                                        </div>

                                        <div class="form-inline" align="right">
                                            <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                                name="kelas_pasien">
                                            <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                                name="no_medrec">
                                            <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>"
                                                name="no_cm">
                                            <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                                name="no_register">
                                            <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                                name="cara_bayar">
                                            <input type="hidden" class="form-control" id="id_resep_pasien_petugas"
                                                name="id_resep_pasien_petugas">


                                            <!-- <?php
                                            if ($no_resep != '') {
                                                echo "<input type='hidden' class='form-control' value=" . $no_resep . " name='no_resep'>";
                                            } else {

                                            }
                                            ?> -->
                                            <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                                name="tgl_kunjungan">
                                            <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                            <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                            <!--<input type="hidden" class="form-control" value="<?php echo $no_resep; ?>" name="no_resep">-->

                                            <input type="hidden" class="form-control" value="<?php echo $no_resep; ?>"
                                                name="no_resep">
                                            <div class="form-group">
                                                <button type="reset" class="btn bg-orange">Reset</button>
                                                <button type="button" class="btn btn-primary" onclick="racik_petugas()" >Tambah</button>
                                            </div>
                                        </div>
                                    </form>


                                    <br><br>
                                    <table  class="display nowrap table table-hover table-bordered table-striped"
                                        cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><p align="center">No</p></th>
                                            <th><p align="center">Nama Obat</p></th>
                                            <th><p align="center">Harga Obat</p></th>
                                            <th><p align="center">Dosis</p></th>
                                            <th><p align="center">Satuan</p></th>
                                            <th><p align="center">Qty</p></th>
                                            <!--<th >Harga Satuan</th>-->
                                            <th><p align="center">Total</p></th>
                                            <th><p align="center">Aksi</p></th>
                                        </tr>
                                        </thead>
                                        <tbody id="table_obat_racik_petugas">
                                        </tbody>
                                     </table>
                                </div>

                                <div id="selesai_racik_petugas">
                                    <?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan_selesai_petugas'); ?>
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <p class="col-sm-2 form-control-label" id="lbl_racikan">Nama Racikan</p>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="racikan" id="rck">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                                <div class="col-sm-3">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="signa" id="signa_petugas">
                                                        <option value="">-Pilih Signa-</option>

                                                        <?php
                                                        foreach ($satuan_signa as $row) {
                                                        ?>
                                                        <option value="<?=$row->signa?>"><?=$row->signa?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="qtx" id="qtx_petugas">
                                                        <option value="">-Pilih Qtx-</option>

                                                        <?php
                                                        foreach ($qtx as $row) {
                                                        ?>
                                                        <option value="<?=$row->qtx?>"><?=$row->qtx?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="satuan" id="satuan_petugas">
                                                        <option value="">-Pilih Satuan-</option>

                                                        <?php
                                                        foreach ($satuan as $row) {
                                                        ?>
                                                        <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="cara_pakai" id="cara_pakai_petugas">
                                                        <option value="">-Pilih Cara Pakai-</option>

                                                        <?php
                                                        foreach ($cara_pakai as $row) {
                                                        ?>
                                                        <option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-2 form-control-label" id="qty">Quantity Total <label for="" id="qty_old_petugas"></label></p>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="qty1" id="qty1" min=1
                                                        onkeyup="set_hasil_obat_petugas()" required>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <p class="col-sm-4 form-control-label" id="lbl_vtotx">Total</p>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="vtot_x" id="vtot_x" disabled="">
                                                    <input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-4 form-control-label">Farmasi *</p>
                                                <div class="col-sm-9">
                                                    <div class="demo-radio-button">
                                                        <input name="bpjs_racik" type="radio" id="bpjs_racik" class="with-gap"
                                                            value="1" <?= ($cara_bayar == 'BPJS' ? 'checked' : '') ?> />
                                                        <label for="bpjs_racik">BPJS</label>
                                                        <input name="bpjs_racik" type="radio" id="umum_racik" class="with-gap"
                                                            value="0" <?php if ($cara_bayar == 'UMUM') {
                                                            echo 'checked';
                                                        } ?> />
                                                        <label for="umum_racik">PC/UMUM</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-2 form-control-label" id="jenisObat">Resep Pulang</p>
                                                <div class="col-sm-10">
                                                    <div class="demo-radio-button">
                                                    <input name="resep_pulang_racik" type="radio" id="resep_pulang_racik_1" class="with-gap"
                                                        value="1" /> <label for="resep_pulang_racik_1">Ya</label>
                                                    <input name="resep_pulang_racik" type="radio" id="resep_pulang_racik_2" class="with-gap"
                                                        value="0" checked/> <label for="resep_pulang_racik_2">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <p class="col-sm-4 form-control-label" id="total_akhir_racik">Total Akhir</p>
                                                <div class="col-sm-4">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="vtot_akhir_racik"
                                                                id="vtot_akhir_racik" disabled>
                                                            <input type="hidden" class="form-control" value=""
                                                                name="vtotakhir_hide_racik" id="vtotakhir_hide_racik">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>"
                                                name="tgl_kun">
                                            <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                            <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                                            <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>"
                                                name="xuser">
                                            <input type="hidden" class="form-control" value="<?php echo $no_resep; ?>"
                                                name="no_resep">
                                            <input type="hidden" class="form-control" value="<?php echo $no_register; ?>"
                                                name="no_register">
                                            <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>"
                                                name="kelas_pasien">
                                            <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"
                                                name="no_medrec">
                                            <input type="hidden" class="form-control" value="<?php echo $pelayan; ?>"
                                                name="pelay$pelayan">
                                            <input type="hidden" class="form-control" value="<?php //echo $no_cm;?>" name="no_cm">
                                            <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>"
                                                name="cara_bayar">
                                            <input type="hidden" class="form-control" name="fmarkup" id="fmarkup"
                                                value="<?php echo $fmarkup ?>">

                                            <input type="hidden" class="form-control" name="ppn" id="ppn"
                                                value="<?php echo $ppn ?>">
                                            <input type="hidden" class="form-control" name="id_resep_petugas" id="id_resep_petugas">
                                        </div>

                                        <div class="col-xs-6" align="right">
                                            <div class="form-inline" align="right">
                                                <div class="input-group">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary">Selesai Racik</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>
                                </div>

                            </div>
                        <?php } ?>
                    </div>
                </div>

        <?php } ?>
            <!-- table -->
            <br>
            <br>
            <div class="col-lg-12 col-sm-12">
                <?php if($last_obat !=null ){  ?>
                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#obat-last-coll" aria-expanded="false" aria-controls="collapseExample">
                        Lanjut Obat Sebelumnya
                    </button>
                <br>
                    <div class="collapse" id="obat-last-coll">
                    <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_last'); foreach($last_obat as $row){ ?>
                        <input type="checkbox" name="jumlah_obat[]" id="<?php echo $row->id_resep_pasien; ?>" value="<?php echo $row->id_resep_pasien; ?>" checked="true">

                        <input type="hidden" class="form-control" value="<?php echo $row->kali_harian; ?>" name="signa-last-<?php echo $row->id_resep_pasien ?>">
                        <input type="hidden" class="form-control" value="<?php echo $row->qtx; ?>" name="qtx-last-<?php echo $row->id_resep_pasien ?>">
                        <input type="hidden" class="form-control" value="<?php echo $row->Satuan_obat; ?>" name="satuan-last-<?php echo $row->id_resep_pasien ?>">
                        <input type="hidden" class="form-control" value="<?php echo $row->cara_pakai; ?>" name="cara_pakai-last-<?php echo $row->id_resep_pasien ?>">
                        <!-- <input type="hidden" class="form-control" value="<?php //echo $row->kali_harian; ?>" name="kalli_harian-last-<?php //echo $row->id_resep_pasien ?>"> -->

                        <input type="hidden" class="form-control" value="<?php echo $row->qty; ?>" name="qty-last-<?php echo $row->id_resep_pasien ?>">
                        <!-- <input type="hidden" class="form-control" value="<?php //echo $row->resep_pulang; ?>" name="resep_pulang-last-<?php //echo $row->id_resep_pasien ?>"> -->
                        <input type="hidden" class="form-control" value="<?php echo $row->kronis; ?>" name="kronis-last-<?php echo $row->id_resep_pasien ?>">
                        <input type="hidden" class="form-control" value="<?php echo $row->nama_obat; ?>" name="nama_obat-last-<?php echo $row->id_resep_pasien ?>">
                        <input type="hidden" class="form-control" value="<?php echo $row->racikan; ?>" name="racikan-last-<?php echo $row->id_resep_pasien ?>">
                        <input type="hidden" class="form-control" value="<?php echo $row->biaya_obat; ?>" name="biaya_obat-last-<?php echo $row->id_resep_pasien ?>">
                        <input type="hidden" class="form-control" value="<?php echo $row->id_resep_pasien; ?>" name="id_resep_pasien-last[]">

                        <input type="hidden" class="form-control" value="<?php echo $row->item_obat; ?>" name="id_obat[]" >
                        <!-- <input type="hidden" class="form-control" value="<?php //echo $tgl_kun; ?>" name="id_obat-last-<?php //echo $row->item_obat ?>"> -->

                        <input type="hidden" class="form-control" value="<?php echo $tgl_kun; ?>" name="tgl_kun">
                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                        <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                        <input type="hidden" class="form-control" value="<?php echo $pelayan; ?>"name="pelayan" >
                        <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>" name="xuser">
                        <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>" name="kelas_pasien">
                        <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>"name="no_medrec">
                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
                        <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>" name="cara_bayar">
                    <?php } ?>
                        <div class="form-group row">
                            <p class="col-sm-2 form-control-label" id="jenisObat">Resep Pulang</p>
                            <div class="col-sm-10">
                                <div class="demo-radio-button">
                                    <input name="resep_pulang-last" type="radio" id="resep_pulang-last_1" class="with-gap"
                                        value="1" /> <label for="resep_pulang-last_1">Ya</label>
                                    <input name="resep_pulang-last" type="radio" id="resep_pulang-last_2" class="with-gap"
                                        value="0" checked/> <label for="resep_pulang-last_2">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    <?php echo form_close(); }else{} ?>
                    </div>
                <br>
                <div class="table-responsive">
                    <table id="tabel_tindakan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th>Obat</th>
                                <th>Tanggal Permintaan Obat</th>
                                <th>Item Obat</th>
                                <th>Harga Obat</th>
                                <th>Signa</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // print_r($pasien_daftar);
                            $i = 1;
                            $total = 0;

                            foreach ($data_tindakan_pasien as $row) {
                                //$id_pelayanan_poli=$row->id_pelayanan_poli;
                                // var_dump($row->vtot);die();
                                // $total += $row->vtot;

                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td>
                                        <?php if ($row->racikan == '1') { ?>
                                            <?php if ($pelayan == 'DOKTER') { ?>
                                                <!-- <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_obat/".$pelayan."/". $row->no_register . "/" . $row->id_resep_pasien. "/". $row->qty); ?>"
                                                class="btn btn-danger btn-xs">Hapus</a> -->
                                                <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_obat_racik/".$pelayan."/". $row->no_register . "/" . $row->id_resep_pasien. "/". $row->qty); ?>"class="btn btn-danger btn-xs">Hapus</a>
                                            <?php } else { ?>
                                                <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_obat_racik/".$pelayan."/". $row->no_register . "/" . $row->id_resep_pasien. "/". $row->qty); ?>" class="btn btn-danger btn-xs">Hapus</a>
                                                <button type="button" class="btn btn-primary btn-xs" onclick="edit_obat_racikan_petugas('<?php echo $row->no_register; ?>','<?php echo $row->id_resep_pasien; ?>')">Edit</button>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_obat/".$pelayan."/". $row->no_register . "/" . $row->id_resep_pasien. "/". $row->qty); ?>"
                                            class="btn btn-danger btn-xs">Hapus</a>
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_obat(<?php echo $row->id_resep_pasien; ?>)">Edit</button>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ($row->obat_luar == 0) {
                                                echo 'OBAT LUAR';
                                            }else{
                                                echo 'OBAT RS';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $row->tgl_kunjungan; ?></td>
                                    <td>
                                        <?php
                                        echo $row->nama_obat;
                                        if ($row->racikan == '1') {
                                            foreach ($data_tindakan_racik as $row1) {
                                                if ($row->id_resep_pasien == $row1->id_resep_pasien) {
                                                    echo '<br>- ' . $row1->nama_obat . ' Dosis '.$row1->dosis.', Satuan '.$row1->satuan.' (' . $row1->qty . ')';
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo (int)$row->biaya_obat; ?></td>
                                    <td><?php echo $row->signa; ?></td>
                                    <td><?php echo $row->qty; ?></td>
                                    <td>
                                        <div align="right">
                                            <?= number_format($row->vtot, 2, ',', '.') ?></div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                </div><!-- style overflow -->
                <br>
                <div class="form-group">
                    <?php if ($pelayan == 'DOKTER') {
                        if (substr($no_register, 0, 2) == "RJ") {
                            if($idrg == 'BA00'){ ?>
                                <!-- $link = base_url().'ird/rdcpelayananfdokter/pelayanan_tindakan/'.$idrg.'/'.$no_register; -->
                                <form action="<?php echo base_url().'ird/rdcpelayanan/update_rujukan_resep_ruangan_rad'; ?>" method="post">
                                    <div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan">
                                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
                                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                        <button type="submit" class="btn btn-primary">Selesai</button>
                                    </div>
                                </form>
                            <?php }else{ ?>
                                <!-- $link = base_url().'irj/rjcpelayananfdokter/pelayanan_tindakan/'.$idrg.'/'.$no_register; -->
                                <form action="<?php echo base_url().'irj/rjcpelayanan/update_rujukan_resep_ruangan_rad'; ?>" method="post">
                                    <div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan">
                                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
                                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                                        <button type="submit" class="btn btn-primary">Selesai</button>
                                    </div>
                                </form>
                            <?php   }
                                }elseif (substr($no_register, 0, 2) == "RI") { ?>
                                    <!-- $link = base_url().'iri/rictindakan/index/'.$no_register; -->
                                    <form action="<?php echo base_url().'iri/rictindakan/update_rujukan_penunjang_obat_rad'; ?>" method="post">
                                            <div class="form-inline" align="right">
                                                            <input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan">
                                                <input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_ipd">
                                                <button type="submit" class="btn btn-primary">Selesai</button>
                                            </div>
                                        </form>
                            <?php }else {
                                    $link = base_url().'farmasi/frmcdaftar/';
                                }
                            ?>
                        <!-- <a href="<?php echo $link; ?>" class="btn btn-primary">Selesai</a> -->

                        <!-- <form action="<?php echo base_url().'farmasi/frmcdaftar/insert_header_resep/'.$pelayan; ?>" method="post">
                            <div class="form-group row" style="display: none">
                                <p class="col-sm-2 form-control-label">Unit Asal *</p>
                                <div class="col-sm-6">
                                    <select class="form-control" style="width: 100%" name="unitasal" id="unitasal">
                                        <?php if (substr($no_register, 0, 2) != "PL") { ?>
                                            <option value="<?php echo $idrg; ?>" selected><?php echo $bed; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
                            <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>" name="kelas_pasien">
                            <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>" name="no_medrec">
                            <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>" name="cara_bayar">
                            <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                            <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                            <div class="form-group row">

                            </div>

                            <div class="form-inline" align="right">
                                <?php
                                if ($cara_bayar == 'BPJS') {
                                    $total_akhir = roundUpToNearestThousand($total);
                                } else {
                                    $total_akhir = $total;
                                }
                                ?>
                                <h3>TOTAL: Rp.
                                <?php
                                $total_akhir_data= 0;
                                foreach($data_tindakan_pasien as $data){
                                    $total_akhir_data += $data->vtot;
                                }


                                ?>
                                <?= number_format($total_akhir_data, '2', ',', '.') ?></h3>
                                <br>
                            </div>
                            <div class="form-inline" align="right">
                                <button type="submit" class="btn btn-primary">Selesai</button>
                            </div>
                        </form>   -->
                    <?php }else{ ?>
                        <form action="<?php echo base_url().'farmasi/frmcdaftar/insert_header_resep/'.$pelayan; ?>" method="post" target="_blank">
                            <div class="form-group row" style="display: none">
                                <p class="col-sm-2 form-control-label">Unit Asal *</p>
                                <div class="col-sm-6">
                                    <select class="form-control" style="width: 100%" name="unitasal" id="unitasal">
                                        <?php if (substr($no_register, 0, 2) != "PL") { ?>
                                            <option value="<?php echo $idrg; ?>" selected><?php echo $bed; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <?php foreach ($data_tindakan_pasien as $rows) { ?>
                                <input type="checkbox" name="jumlah_obat-perawat[]" id="<?php echo $rows->id_inventory; ?>" value="<?php echo $rows->id_inventory; ?>" checked="TRUE">
                                <input type="hidden" class="form-control" value="<?php echo $rows->qty; ?>" name="qty-perawat-<?php echo $rows->id_inventory ?>">
                                <input type="hidden" class="form-control" value="<?php echo $rows->nama_obat; ?>" name="nama_obat-perawat-<?php echo $rows->id_inventory ?>">
                                <input type="hidden" class="form-control" value="<?php echo $rows->kali_harian; ?>" name="kali_harian-perawat-<?php echo $rows->id_inventory ?>">
                                <input type="hidden" class="form-control" value="<?php echo $rows->racikan; ?>" name="racikan-perawat[]">
                                <input type="hidden" name="id_obat-perawat[]" id="id_obat" value="<?php echo $rows->item_obat; ?>">
                            <?php } ?>
                            <input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
                            <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>" name="kelas_pasien">
                            <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>" name="no_medrec">
                            <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>" name="cara_bayar">
                            <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                            <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                            <div class="form-group row">

                            </div>

                            <div class="form-inline" align="right">
                                <?php
                                if ($cara_bayar == 'BPJS') {
                                    $total_akhir = roundUpToNearestThousand($total);
                                } else {
                                    $total_akhir = $total;
                                }
                                ?>
                                <h3>TOTAL: Rp.
                                <?php
                                $total_akhir_data= 0;
                                foreach($data_tindakan_pasien as $data){
                                    $total_akhir_data += $data->vtot;
                                }


                                ?>
                                <?= number_format($total_akhir_data, '2', ',', '.') ?></h3>
                                <br>
                            </div>
                            <div class="form-inline" align="right">
                                    <button type="submit" class="btn btn-primary" onclick="showswal()">Selesai & Resep</button>
                            </div>
                        </form>
                    <?php } ?>

                </div>

                <br>
                <!-- <?php if($cara_bayar == 'BPJS') {?>
                    <?php echo form_open('farmasi/frmcdaftar/selesai_daftar_pemeriksaan'); ?>
                        <div class="form-group row" style="display: none">
                            <p class="col-sm-2 form-control-label">Unit Asal *</p>
                            <div class="col-sm-6">
                                <select class="form-control" style="width: 100%" name="unitasal" id="unitasal">
                                    <?php if (substr($no_register, 0, 2) != "PL") { ?>
                                        <option value="<?php echo $idrg; ?>" selected><?php echo $bed; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
                        <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>" name="kelas_pasien">
                        <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>" name="no_medrec">
                        <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>" name="cara_bayar">
                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                        <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                        <div class="form-group row">

                        </div>

                        <div class="form-inline" align="right">
                            <?php
                            if ($cara_bayar == 'BPJS') {
                                $total_akhir = roundUpToNearestThousand($total);
                            } else {
                                $total_akhir = $total;
                            }
                            ?>
                            <h3>TOTAL: Rp.
                            <?php
                            $total_akhir_data= 0;
                            foreach($data_tindakan_pasien as $data){
                                $total_akhir_data += $data->vtot;
                            }


                            ?>
                            <?= number_format($total_akhir_data, '2', ',', '.') ?></h3>
                            <br>
                        </div>
                        <div class="form-inline" align="right">
                            <?php
                            if ($roleid == 12 or $roleid == 1) {
                                echo '
                                            <input type="button" class="btn btn-primary" value="Selesai" onclick="cek_stock()">
                                        ';
                            }
                            if ($roleid <> 12 or $roleid == 1) {
                            echo '
                                            <button onclick="closepage()" class="ml-2 btn btn-primary">Close</button>
                                    ';
                        }
                            ?>

                    <?php echo form_close(); ?>
                <?php }else{ ?>
                    <?php echo form_open('farmasi/frmcdaftar/selesai_daftar_pemeriksaan'); ?>
                        <div class="form-group row" style="display: none">
                            <p class="col-sm-2 form-control-label">Unit Asal *</p>
                            <div class="col-sm-6">
                                <select class="form-control" style="width: 100%" name="unitasal" id="unitasal">
                                    <?php if (substr($no_register, 0, 2) != "PL") { ?>
                                        <option value="<?php echo $idrg; ?>" selected><?php echo $bed; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
                        <input type="hidden" class="form-control" value="<?php echo $kelas_pasien; ?>" name="kelas_pasien">
                        <input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>" name="no_medrec">
                        <input type="hidden" class="form-control" value="<?php echo $cara_bayar; ?>" name="cara_bayar">
                        <input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg">
                        <input type="hidden" class="form-control" value="<?php echo $bed; ?>" name="bed">
                        <div class="form-group row">

                        </div>

                        <div class="form-inline" align="right">
                            <?php
                            if ($cara_bayar == 'BPJS') {
                                $total_akhir = roundUpToNearestThousand($total);
                            } else {
                                $total_akhir = $total;
                            }
                            ?>
                            <h3>TOTAL: Rp.
                            <?php
                            $total_akhir_data= 0;
                            foreach($data_tindakan_pasien as $data){
                                $total_akhir_data += $data->vtot;
                            }


                            ?>
                            <?= number_format($total_akhir_data, '2', ',', '.') ?></h3>
                            <br>
                        </div>
                        <div class="form-inline" align="right">
                            <?php
                            if ($roleid == 12 or $roleid == 1) {
                                echo '
                                            <input type="button" class="btn btn-primary" value="Selesai & Cetak" onclick="cek_stock()">
                                        ';
                            }
                            if ($roleid <> 12 or $roleid == 1) {
                            echo '
                                            <button onclick="closepage()" class="ml-2 btn btn-primary">Close</button>
                                    ';
                        }
                            ?>

                    <?php echo form_close(); ?>
                <?php } ?> -->


                    <?php    function roundUpToNearestHundred($n)
                    {
                        return (int)(100 * ceil($n / 100));
                    }

                    function roundUpToNearestThousand($n)
                    {
                        return (int)(1000 * ceil($n / 1000));
                    }

                    ?>


                </div>
            </div>
            <br>

            <?php echo form_open('farmasi/Frmcdaftar/edit_obat'); ?>
            <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-success">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Obat</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Id Obat</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_id_obat" id="edit_id_obat"
                                           disabled="">
                                    <input type="hidden" class="form-control" name="edit_id_obat_hidden"
                                           id="edit_id_obat_hidden">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Nama Obat</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_nama_obat" id="edit_nama_obat" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Biaya Obat</p>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" name="edit_biaya_obat"
                                           id="edit_biaya_obat" min="0" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Signa</p>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%" name="edit_signa" id="edit_signa" >
                                        <option value="">-Pilih Signa-</option>
                                        <?php
                                            foreach ($satuan_signa as $row) {
                                            ?>
                                            <option value="<?=$row->signa?>"><?=$row->signa?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Qtx</p>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%" name="edit_qtx" id="edit_qtx" >
                                        <option value="">-Pilih Qtx-</option>
                                        <?php
                                            foreach ($qtx as $row) {
                                            ?>
                                            <option value="<?=$row->qtx?>"><?=$row->qtx?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Satuan</p>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%" name="edit_satuan" id="edit_satuan" >
                                        <option value="">-Pilih Satuan-</option>
                                        <?php
                                            foreach ($satuan as $row) {
                                            ?>
                                            <option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Cara Pakai</p>
                                <div class="col-sm-8">
                                    <select class="form-control" style="width: 100%" name="edit_cara_pakai" id="edit_cara_pakai" >
                                        <option value="">-Pilih Cara Pakai-</option>
                                        <?php
                                            foreach ($cara_pakai as $row) {
                                            ?>
                                            <option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
                                            <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Quantity</p>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" name="edit_qty" id="edit_qty"
                                           onkeyup="set_total(this.value)" min="1">
                                    <input type="hidden" name="edit_qty_hidden" id="edit_qty_hidden">
                                    <input type="hidden" name="edit_no_register" id="edit_no_register">
                                    <input type="hidden" name="edit_id_resep_pasien" id="edit_id_resep_pasien">
                                    <input type="hidden" name="pelayan" id="pelayan" value="<?php echo $pelayan; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Edit Obat</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>

            <div class="modal fade" id="editQtyModal" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-success">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Ubah QTY Obat</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">QTY Lama</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_qty_obat_lama" id="edit_qty_obat_lama" disabled>
                                    <input type="hidden" name="edit_qty_idinventory" id="edit_qty_idinventory"/>
                                    <input type="hidden" name="edit_qty_idobat" id="edit_qty_idobat"/>
                                    <input type="hidden" name="edit_qty_noregister" id="edit_qty_noregister"/>
                                    <input type="hidden" name="edit_qty_old" id="edit_qty_old"/>
                                    <input type="hidden" name="edit_qty_vtot" id="edit_qty_vtot"/>
                                    <input type="hidden" name="edit_qty_biaya" id="edit_qty_biaya"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">QTY Baru</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_qty_obat" id="edit_qty_obat">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="button" id="btnEdit" onclick="saveEditQtyObat()">Edit Obat</button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- <?php echo form_open('farmasi/Frmcdaftar/edit_obat_racikan'); ?> -->
            <form action="#" id="formEditRacikPetugas" class="formEditRacikPetugas">
            <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModalracikan" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-success">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Obat Racikan</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Id Obat</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_id_obat_racikan" id="edit_id_obat_racikan"
                                           disabled="">
                                    <input type="hidden" class="form-control" name="edit_id_obat_racikan_hidden"
                                           id="edit_id_obat_racikan_hidden">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Nama Obat</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_nama_obat_racikan" id="edit_nama_obat_racikan" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Biaya Obat</p>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" name="edit_biaya_obat_racikan"
                                           id="edit_biaya_obat_racikan" min="0" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Dosis</p>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" name="edit_dosis_obat_racikan"
                                           id="edit_dosis_obat_racikan" min="0" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Satuan</p>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="edit_satuan_obat_racikan"
                                           id="edit_satuan_obat_racikan" disabled="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Quantity</p>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control" name="edit_qty_racikan" id="edit_qty_racikan"
                                           onkeyup="set_total_harga_racikan(this.value)" min="1">
                                    <input type="hidden" name="edit_qty_racikan_hidden" id="edit_qty_racikan_hidden">
                                    <input type="hidden" name="edit_no_register_racikan" id="edit_no_register_racikan">
                                    <input type="hidden" name="edit_id_resep_pasien_racikan" id="edit_id_resep_pasien_racikan">
                                    <input type="hidden" name="pelayan_racikan" id="pelayan_racikan" value="<?php echo $pelayan; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="button" onclick="editracikanpetugas()">Edit Obat</button>
                        </div>
                    </div>

                </div>
            </div>
            </form>
            <!-- <?php echo form_close(); ?> -->

        </div>
    </div>
</div>

<div class="modal fade" id="obatHistory" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan_obat_history'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">History Obat</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="fomr-inline row">
                        <div class="col-sm-1"></div>
                        <p class="form-control-label col-sm-2" id="nmdokter"><b>Cari </b></p>
                        <div class="col-sm-1"></div>
                        <input type="text" name="keyword" id="keyword" class="form-control col-sm-7" onkeyup="ajaxhistorysearch(this.value.toUpperCase())" placeholder="Cari Nama Obat..." style="width: 300px;"/>
                    </div>
                </div>
                    <div class="form-inline" id="id_obat_history">

                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="no_register_history" id="no_register_history" value="<?php echo $no_register; ?>">
                <input type="hidden" name="no_medrec_history" id="no_medrec_history" value="<?php echo $no_medrec; ?>">
                <input type="hidden" name="cara_bayar_history" id="cara_bayar_history" value="<?php echo $cara_bayar; ?>">
                <input type="hidden" name="idrg_history" id="idrg_history" value="<?php echo $idrg; ?>">
                <input type="hidden" name="bed_history" id="bed_history" value="<?php echo $bed; ?>">
                <input type="hidden" name="no_resep_history" id="no_resep_history" value="<?php echo $no_resep; ?>" >
                <input type="hidden" name="pelayan_history" id="pelayan_history" value="<?php echo $pelayan; ?>" >
                <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>



<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>