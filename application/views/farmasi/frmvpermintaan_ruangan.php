<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
<style type="text/css">
    .demo-radio-button label {
        min-width: 90px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
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

    <style type="text/css">
        .demo-radio-button label {
            min-width: 90px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".js-example-basic-single").select2();
        });
    </script>

    <script type='text/javascript'>

        //-----------------------------------------------Data Table
        $(document).ready(function () {
            document.getElementById("cari_obat").focus();

            loadCbMargin("<?php echo $cara_bayar; ?>");
            loadCbMarginRacik("<?php echo $cara_bayar; ?>");

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
                $('#biaya_obat').val(ui.item.harga);
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
                $('#cari_obat2').val('' + ui.item.nama);
                $('#idracikan').val(ui.item.idobat);
                $('#idtindakanracik').val(ui.item.idinventory);
                $('#biaya_racikan').val(ui.item.harga);
                $('#biaya_racikan_hide').val(ui.item.harga);
                $('#ket').val(ui.item.ket);
                $('#qty_racikan').val('1');
                set_total_racikan();             
            }
        });
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
                //  //alert ("tes"+ checked);
                //  var total = ($("#biaya_obat").val() * $("#qty").val() * fmarkup * ppn + parseInt(tuslah_non)) ;
                // } else {
                //  var total = ($("#biaya_obat").val() * $("#qty").val() * fmarkup * ppn) ;
                // }
                var total = ($("#biaya_obat").val() * $("#qty").val() * fmarkup * ppn);

            }

            var total_akhir = total * parseFloat(margin);
            $('#vtot').val(total.toFixed(0));
            $('#vtot_hide').val(total.toFixed(0));
            $("#vtot_akhir").val(total_akhir.toFixed(0));
            $("#vtotakhir_hide").val(total_akhir.toFixed(0));

        }

        function set_total_akhir() {
            var margin = $("#margin").val();
            var total = parseFloat($('#vtot_hide').val());
            var total_akhir = total * parseFloat(margin);

            $("#vtot_akhir").val(total_akhir.toFixed(0));
            $("#vtotakhir_hide").val(total_akhir.toFixed(0));
        }

        function set_total_akhir_racik() {
            var margin = $("#margin_racik").val();

            var tuslah_racik = $("#tuslah_racik").val();
            var total = parseFloat($('#vtot_x_hide').val());
            var total_akhir = total * parseFloat(margin) + parseFloat(tuslah_racik);

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
                    $('#edit_signa').val(data[0].Signa);
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
                    var tuslah_racik = $("#tuslah_racik").val();
                    var ppn = $("#ppn").val();
                    var margin = $("#margin").val();
                    var cara_bayar = "<?php echo $cara_bayar; ?>";
                    //alert(data);
                    if (cara_bayar == 'BPJS') {
                        var total = data;

                    } else {
                        var total = (data * fmarkup * ppn + parseInt(tuslah_racik));
                    }

                    var total_akhir = total * parseFloat(margin) + parseInt(tuslah_racik);

                    $('#vtot_x').val(parseInt(total));
                    $('#vtot_x_hide').val(total);
                    $("#vtot_akhir_racik").val(total_akhir.toFixed(0));
                    $("#vtotakhir_hide_racik").val(total_akhir.toFixed(0));
                },
                error: function () {
                    alert("error");
                }
            });
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
            window.open(' ', '_self', ' ');
            window.close();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('farmasi/Frmcdaftar/')?>",

            });
        }


        function cek_stock() {
            if ($('#unitasal').val() == '') {
                sweetAlert("Input Unit Asal Obat/Resep terlebih dahulu !", "", "error");
            } else {
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
                                    //swal("Good job!", "You clicked the button!", "success")
                                    url = "<?php echo base_url('farmasi/Frmckwitansi/cetak_faktur_kt')?>/" + data.no_resep;
                                    window.location.href = "<?php echo base_url('farmasi/Frmcdaftar')?>";
                                    window.open(url, "_blank");
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
            }

        }


    </script>
<?php include('frmvdatapasien.php'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block p-b-0">
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
                                    <?=$this->session->flashdata('warning')?>
                                    <?=$this->session->flashdata('info')?>

                                    <!--Form Insert Permintaan-->
                                    <?php echo form_open('farmasi/Frmcdaftar/insert_permintaan'); ?>
                                    <input type="hidden" name="idpoli" value="<?=$id_poli?>"/>
                                    <input type="hidden" name="jenis_cara_bayar" value="<?=$cara_bayar?>"/>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label">Kronis?</p>
                                        <div class="col-sm-2">
                                            <select name="kronis" id="kronis" class="form-control" required>
                                                <option value="0"> Non Kronis</option>
                                                <option value="1"> Kronis</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label">Satelit Tujuan</p>
                                        <div class="col-sm-2">
                                            <select name="satelit" id="satelit" class="form-control" required>
                                                <option value="3"> Satelit 3</option>
                                                <option value="2"> Satelit 2</option>
                                                <option value="1"> Satelit 1</option>
                                            </select>
                                        </div>
                                    </div>

                                <div class="form-group row">
                                    <p class="col-sm-2 form-control-label" id="jenisObat">Jenis Obat *</p>
                                    <div class="col-sm-10">
                                        <div class="demo-radio-button">
                                            <input name="jenis_obat" type="radio" id="obatrs" class="with-gap"
                                                   value="1" checked/> <label for="obatrs">Obat RS</label>
                                            <input name="jenis_obat" type="radio" id="obatluar" class="with-gap"
                                                   value="0"/> <label for="obatluar">Obat dari Luar</label>
                                        </div>
                                    </div>
                                </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                        <div class="col-sm-6">
                                            <input type="search" class="form-control" id="cari_obat" name="cari_obat"
                                                   placeholder="Pencarian Obat">
                                            <input type="hidden" name="idtindakan" id="idtindakan">
                                            <!-- <select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" style="width:350px;" required>
                                                        <option value="">-Pilih Obat-</option>
                                                        <?php
                                            /*foreach($data_obat as $row){
                                                echo '<option value="'.$row->id_inventory.'">'.$row->nm_obat.' ('.$row->batch_no.', '.$row->expire_date.', Stok: '.$row->qty.')</option>';
                                            }*/
                                            ?>
                                                    </select> -->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>"
                                                   name="biaya_obat" id="biaya_obat" disabled>
                                            <input type="hidden" class="form-control" value="" name="biaya_obat_hide"
                                                   id="biaya_obat_hide">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                        <div class="col-sm-1">
                                            <input type="number" class="form-control" name="sgn1" id="sgn1" min=1>
                                        </div>
                                        <div class="col-xs-1">
                                            <p><b>x Sehari</b></p>
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" name="sgn2" id="sgn2" min=0>
                                        </div>
                                         <div class="col-sm-2">
                                        <select class="form-control" style="width: 100%" name="satuan" id="satuan"
                                                required>
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
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
                                        <div class="col-sm-2">
                                            <input type="number" class="form-control" name="qty" id="qty" min=1
                                                   onchange="set_total(this.value)">
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" name="fmarkup" id="fmarkup"
                                           value="<?php echo $fmarkup ?>">
                                    <input type="hidden" class="form-control" name="tuslah_non" id="tuslah_non"
                                           value="<?php echo $tuslah_non ?>">

                                    <input type="hidden" class="form-control" name="ppn" id="ppn"
                                           value="<?php echo $ppn ?>">
                                    <input type="hidden" class="form-control" value="" name="ket"
                                               id="ket">

                                    <!--<div class="form-group row">
                                        <p class="col-sm-2 form-control-label " id="markup">Kebijakan Obat</p>
                                            <div class="col-sm-10">
                                                <div class="form-inline">
                                                    <!--
                                                    <input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
                                                    <input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
                                                    -->
                                    <!--<div class="form-group">
                                                    <select id="idmarkup" class="form-control" name="idmarkup" onchange="pilih_kebijakan(this.value)" required>
                                                        <option value="">-Pilih Kebijakan-</option>
                                                        <?php
                                    foreach ($get_data_markup as $row) {
                                        echo '<option value="' . $row->kodemarkup . '">' . $row->ket_markup . '</option>';
                                    }
                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>-->

                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" name="vtot" id="vtot" disabled>
                                            <input type="hidden" class="form-control" value="" name="vtot_hide"
                                                   id="vtot_hide">
                                        </div>
                                        <!-- <input type="checkbox" value="" width=30px height=30px name="tuslah_cek" id="tuslah_cek" onchange="set_total()" > -->
                                        <!-- <div><p><b>Tuslah</b></p></div> -->
                                    </div>

                                    <div class="form-group row">
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
                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="margin_harga">Margin Harga *</p>
                                        <div class="col-sm-10">
                                            <div class="form-inline">
                                                <div id="cb_margin">
                                                    <?php
                                                    /*foreach ($margin as $margins){
                                                    ?>
                                                    <input type="radio" name="margin" id="margin" value="<?=$margins->pengali?>" onclick="set_total_akhir(this.value)"
                                                        <?php
                                                        if($cara_bayar=='UMUM' && $margins->keterangan=='Umum'){
                                                            echo "checked";
                                                        }else if($cara_bayar=='BPJS' && $margins->keterangan=='BPJS'){
                                                            echo "checked";
                                                        }
                                                        ?>
                                                    >
                                                        &nbsp;<?=$margins->persentase?> % &nbsp;&nbsp;<?=$margins->keterangan?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    }*/
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="total_akhir">Total Akhir</p>
                                        <div class="col-sm-10">
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="vtot_akhir"
                                                           id="vtot_akhir" disabled>
                                                    <input type="hidden" class="form-control" value="" name="vtotakhir_hide"
                                                           id="vtotakhir_hide">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div><!-- end panel body -->
                            </div><!-- end panel info-->
                        </div><!-- end div id home -->

                        <div id="racikan" class="tab-pane <?php echo $tab_racik; ?>" role="tabpanel">

                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan'); ?>
                                    <input type="hidden" class="form-control" value="" name="ket"
                                               id="ket">
                                    <input type="hidden" name="idpoli_racik" value="<?=$id_poli?>"/>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
                                        <div class="col-sm-10">
                                            <input type="search" class="form-control" id="cari_obat2" name="cari_obat2"
                                                   placeholder="Pencarian Obat">
                                            <input type="hidden" name="idracikan" id="idracikan">
                                            <input type="hidden" name="idtindakanracik" id="idtindakanracik">
                                            <!-- <select id="idracikan" class="form-control js-example-basic-single" name="idracikan" onchange="pilih_racikan(this.value)" style="width:350px;" required>
                                                    <option value="">-Pilih Obat-</option>
                                                    <?php
                                            /*foreach($data_obat as $row){
                                                echo '<option value="'.$row->id_inventory.'">'.$row->nm_obat.' ('.$row->batch_no.', '.$row->expire_date.', Stok: '.$row->qty.')</option>';
                                            }*/
                                            ?>
                                                </select> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
                                        <div class="col-sm-2">

                                            <input type="number" step="0.01" class="form-control" name="qty_racikan"
                                                   id="qty_racikan" onchange="set_total_racikan()">
                                            <input type="hidden" step="0.01" class="form-control" name="qty_racikan_hidden"
                                                   id="qty_racikan_hidden">
                                        </div>
                                        <!--<div class="input-group">
                                        <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Calculator</button>
                                        </span>
                                        </div>--><!-- /input-group -->
                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-2 form-control-label" id="lbl_qtyind"></p>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#myModal">Calculator
                                            </button>
                                        </div>
                                    </div>


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
                                                    <p>_____________________________</p>
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
                                        <p class="col-sm-3 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>"
                                                   name="biaya_racikan" id="biaya_racikan" disabled>
                                            <input type="hidden" class="form-control" value="" name="biaya_racikan_hide"
                                                   id="biaya_racikan_hide">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <p class="col-sm-3 form-control-label" id="lbl_vtot">Total</p>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="vtot_racikan" id="vtot_racikan"
                                                   disabled>
                                            <input type="hidden" class="form-control" value="" name="vtot_racikan_hide"
                                                   id="vtot_racikan_hide">
                                        </div>
                                    </div>


                                    <!--<div class="form-group row">
                                        <p class="col-sm-2 form-control-label " id="markup">Kebijakan Obat</p>
                                            <div class="col-sm-10">
                                                <div class="form-inline">
                                                    <!--
                                                    <input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
                                                    <input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
                                                    -->
                                    <!--<div class="form-group">
                                                    <select id="idmarkup" class="form-control" name="idmarkup" onchange="pilih_kebijakan(this.value)" required>
                                                        <option value="">-Pilih Kebijakan-</option>
                                                        <?php
                                    foreach ($get_data_markup as $row) {
                                        echo '<option value="' . $row->kodemarkup . '">' . $row->ket_markup . '</option>';
                                    }
                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>-->


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
                                                <td align="center"><?php echo $row->qty; ?></td>
                                                <?php $v = $row->hargajual * $row->qty;
                                                $vtot1 = $vtot1 + $v;
                                                ?>
                                                <!--<td><?php echo $row->biaya_obat; ?></td>-->
                                                <td>Rp
                                                    <div class="pull-right"><?php echo number_format($v, 2, ',', '.'); ?></div>
                                                </td>
                                                <td>
                                                    <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_racikan_ruangan/" . $no_register . "/" . $row->id_obat_racikan ."/". $id_poli); ?>"
                                                       class="btn btn-danger btn-xs">Hapus</a></td>
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
                                <input type="hidden" name="idpoli_racik" value="<?=$id_poli?>"/>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <p class="col-sm-3 form-control-label" id="lbl_racikan">Nama Racikan</p>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="racikan" id="rck">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-3 form-control-label" id="lbl_signa">Signa</p>
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
                                                    required>
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
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-3 form-control-label" id="qty">Quantity Total</p>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" name="qty1" id="qty1" min=1
                                                   onchange="set_hasil_obat()">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-3 form-control-label" id="qty">Tuslah Racik</p>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="tuslah_racik" id="tuslah_racik"
                                                   value="0" onchange="set_hasil_obat()">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <p class="col-sm-3 form-control-label" id="lbl_vtotx">Total</p>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" name="vtot_x" id="vtot_x" disabled="">
                                            <input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <p class="col-sm-3 form-control-label">Farmasi *</p>
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
                                        <p class="col-sm-3 form-control-label" id="margin_harga">Margin Harga *</p>
                                        <div class="col-sm-6">
                                            <div class="form-inline">
                                                <div class="form-group" id="cb_margin_racik">
                                                    <?php
                                                    /*foreach ($margin as $margins){
                                                    ?>
                                                    <input type="radio" name="margin_racik" id="margin_racik" value="<?=$margins->pengali?>" onclick="set_total_akhir_racik(this.value)"
                                                        <?php
                                                        if($cara_bayar=='UMUM' && $margins->keterangan=='Umum'){
                                                            echo "checked";
                                                        }else if($cara_bayar=='BPJS' && $margins->keterangan=='BPJS'){
                                                            echo "checked";
                                                        }
                                                        ?>
                                                    >
                                                        &nbsp;<?=$margins->persentase?> % &nbsp;&nbsp;<?=$margins->keterangan?>&nbsp;&nbsp;&nbsp;&nbsp;<br/>
                                                    <?php
                                                    }*/
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <p class="col-sm-3 form-control-label" id="total_akhir_racik">Total Akhir</p>
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
                                </div><!-- /col-lg-6 -->
                                <?php echo form_close(); ?>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- table -->
                <br>
                <br>
                <div class="col-lg-12 col-sm-12">
                    <div class="table-responsive">
                        <table id="tabel_tindakan" class="display nowrap table table-hover table-bordered table-striped"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Permintaan Obat</th>
                                <th>Item Obat</th>
                                <th>Harga Obat</th>
                                <th>Signa</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print_r($pasien_daftar);
                            $i = 1;
                            $total = 0;
                            foreach ($data_tindakan_pasien as $row) {
                                //$id_pelayanan_poli=$row->id_pelayanan_poli;
                                $total += $row->vtot;
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row->tgl_kunjungan; ?></td>
                                    <td>
                                        <?php
                                        echo $row->nama_obat;
                                        if ($row->racikan == '1') {
                                            foreach ($data_tindakan_racik as $row1) {
                                                if ($row->id_resep_pasien == $row1->id_resep_pasien) {
                                                    echo '<br>- ' . $row1->nm_obat . ' (' . $row1->qty . ')';
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row->biaya_obat; ?></td>
                                    <td><?php echo $row->Signa; ?></td>
                                    <td><?php echo $row->qty; ?></td>
                                    <td>
                                        <div align="right">
                                            <?= number_format($row->vtot, 2, ',', '.') ?></div>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row->racikan == '1') {
                                            ?>
                                            <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_obat_racik/" . $row->no_register . "/" . $row->id_resep_pasien ."/". $id_poli); ?>"
                                               class="btn btn-danger btn-xs">Hapus</a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_obat/" . $row->no_register . "/" . $row->id_resep_pasien ."/". $id_poli); ?>"
                                               class="btn btn-danger btn-xs">Hapus</a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>

                    </div><!-- style overflow -->


                    <br>

                    <div class="form-inline" align="right">
                        <?php
                        if ($cara_bayar == 'BPJS') {
                            $total_akhir = roundUpToNearestThousand($total);
                        } else {
                            $total_akhir = $total;
                        }
                        ?>
                        <h3>TOTAL: Rp. <?= number_format($total_akhir, '2', ',', '.') ?></h3>
                        <br>
                    </div>
                        <script>
                                function batal() {
                                    swal({
                                        title: "batal",
                                        text: "Batal Input Resep Pasien?",
                                        type: "warning",
                                        showCancelButton: true,
                                        showLoaderOnConfirm: true,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "Ya!",
                                        cancelButtonText: "Tidak!",
                                        closeOnConfirm: false,
                                        closeOnCancel: false
                                    },
                                    function(isConfirm){
                                        if (isConfirm) {
                                            $.ajax({
                                                 type: "POST",
                                                url: "<?=base_url('irj/rjcpelayanan/update_rujukan_resep_ruangan')?>",
                                                data: {
                                                    id_poli: "<?=$id_poli?>",
                                                    no_register: "<?=$no_register?>",
                                                    obat: "0"
                                                },
                                                dataType: 'text',
                                                success: function (data) {
                                                    //if(data === 'success'){
                                                        window.open("<?=base_url('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'')?>","_self");
                                                    /*}else{
                                                        swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                                                    }*/
                                                }
                                            });
                                        } else {
                                            swal("Close", "Cek Data Kembali!", "error");
                                        }
                                    });
                                }
                        </script>
                    <div class="form-inline" align="right">
                    <?php
                        if(substr($no_register, 0,2) == 'RJ'){
                            ?>
                            <a href="<?=base_url('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register.'')?>" class="btn btn-primary">
                                <i class="fa fa-save"></i>&nbsp;&nbsp; SELESAI</a>&nbsp;&nbsp;
                                    <button class="btn btn-danger" onclick="batal()"><i class="fa fa-x"></i> Batal</button>
                            <?php
                        }else{
                            ?>
                            <a href="<?=base_url('iri/ricstatus/index/'.$no_register)?>" class="btn btn-primary">
                                <i class="fa fa-save"></i>&nbsp;&nbsp; SELESAI</a>
                            <?php
                        }
                        function roundUpToNearestHundred($n)
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
                                        <input type="text" class="form-control" name="edit_nama_obat" id="edit_nama_obat"
                                               disabled="">
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
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" name="edit_sgn1" id="edit_sgn1" min=1>
                                    </div>
                                    <div class="col-sm-1">
                                        <p><b>x Sehari</b></p>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" name="edit_sgn2" id="edit_sgn2" min=0>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" style="width: 100%" name="edit_satuan" id="edit_satuan"
                                                required>
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
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-1"></div>
                                    <p class="col-sm-3 form-control-label">Quantity</p>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control" name="edit_qty" id="edit_qty"
                                               onchange="set_total(this.value)">
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

            </div>
        </div>
    </div>
<?php echo form_close(); ?>
<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>