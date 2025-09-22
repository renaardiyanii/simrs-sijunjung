<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
    <style>
        .ui-autocomplete {
            z-index: 9999;
        }
    </style>
        <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green'
            });

            $(".select2").select2();
        });
        function set_hasil_obat() {
            $.ajax({
                type:'POST',
                dataType: 'json',
                url:"<?php echo base_url('master/mcobat/get_biaya_resep')?>",
                data: {
                    id_paket: "<?php echo $id_paket ?>"
                },
                success: function(data){
                    var tuslah_racik = $("#tuslah_racik").val();
                    //alert(data);
                    var total = (data + parseInt(tuslah_racik)) ;

                    var total_akhir = total + parseInt(tuslah_racik);

                    $('#vtot_x').val(total);
                    $('#vtot_x_hide').val(total);
                    // $("#vtotakhir_hide_racik").val(total_akhir.toFixed(0));
                },
                error: function(){
                    alert("error");
                }
            });
        }
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 46 || charCode > 57))
                return false;

            return true;
        }
    </script>
    <script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
    <script type="text/javascript">
    var tbl_racik;
    var tbl_tindakan;
        function hapus_data_obat(id) {
            swal({
                    title: "Hapus Obat",
                    text: "Benar Akan Menghapus Obat?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function(){
                    $.ajax({
                        type:'post',
                        dataType: 'json',
                        url:"<?php echo base_url('master/mcobat/hapus_data_obat_new')?>",
                        data: {
                            id: id
                        },
                        success: function(data){
                            if(data['hasil'] === 'sukses'){

                                swal({
                                    title: "Obat Berhasil Dihapus!",
                                    text: "Akan Menghilang dalam 3 Detik",
                                    type: "success",
                                    timer: 3000
                                });

                                populateDataObat();

                            }else{
                                sweetAlert(data['hasil'], "Oops. Terjadi Kesalahan", "error");
                            }
                        },
                        error: function(data){
                            // alert("error");
                            //sweetAlert("Oops...", data, "error");
                        }
                    });
                    document.getElementById("cari_obat").focus();
                });
        }
        
    </script>
    <script type='text/javascript'>
        //-----------------------------------------------Data Table
        $(document).ready(function() {
            $('#nama_obat').autocomplete({

            source : function( request, response ) {
                $.ajax({
                    url: '<?php echo site_url('farmasi/frmcdaftar/cari_data_obat')?>',
                    dataType: "json",
                    type: 'GET',
                    data: {
                        term: request.term,
                        jenis_obat: 1
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

                $('#nama_obat').val(''+ui.item.nama);
                $('#id_obat').val(ui.item.idobat);
                $('#satuan').val(ui.item.satuan);

                $('#qty').focus();
            }
            });
            
            $('#cari_obat2').autocomplete({

                source : function( request, response ) {
                    $.ajax({
                        url: '<?php echo site_url('farmasi/frmcdaftar/cari_data_obat')?>',
                        dataType: "json",
                        type: 'GET',
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
                    $('#qty_racikan').val('1');
                    set_total_racikan() ;
                }
                });

                $("#insert_racikan").submit(function (event) {
                event.preventDefault();

                $.ajax({
                    url: "<?php echo base_url('master/mcobat/insert_racikan')?>",
                    type:'POST',
                    data:$(this).serialize(),
                    success:function(data, result){
                        if(data === 'sukses') {
                            swal({
                                title: "Berhasil Ditambahkan!",
                                text: "Akan Menghilang dalam 2 Detik",
                                type: "success",
                                timer: 1000
                            });
                            populateDataObatRacik();
                            clearTextInputRacik();
                        }else{
                            alert('Oops. Something Happen');
                        }
                    }

                });
            });

                $("#insert_racikan_selesai").submit(function (event) {
                event.preventDefault();

                $.ajax({
                    url: "<?php echo base_url('master/mcobat/insert_racikan_selesai')?>",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (data) {
                        if(data === 'sukses') {
                            swal({
                                title: "Berhasil Ditambahkan!",
                                text: "Akan Menghilang dalam 2 Detik",
                                type: "success",
                                timer: 1000
                            },function() {
                            //   window.location.reload();

                            populateDataObat();
                            populateDataObatRacik();
                            clearTextInputRacikSelesai();
                            });
                        }else{
                            alert('Oops. Something Happen');
                        }
                    }
                });
            });
        });

            function hapus_data_racikan_list(id_paket, id) {
            swal({
                    title: "Hapus Obat",
                    text: "Benar Akan Menghapus Obat?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: "<?php echo base_url('master/mcobat/hapus_data_obat_racik_new')?>",
                        data: { id: id },
                        success: function(data){
                            if(data['hasil'] === 'sukses'){

                                swal({
                                    title: "Obat Berhasil Dihapus!",
                                    text: "Akan Menghilang dalam 2 Detik",
                                    type: "success",
                                    timer: 1000
                                });

                                populateDataObat();

                            }else{
                                sweetAlert(data['hasil'], "Oops. Terjadi Kesalahan", "error");
                            }
                        },
                        error: function(data){
                            // alert("error");
                            //sweetAlert("Oops...", data, "error");
                        }
                    });
                });
        }

        function set_total_racikan() {
            var total = $("#biaya_racikan").val() * $("#qty_racikan").val() ;
            $('#vtot_racikan').val(total);
            $('#vtot_racikan_hide').val(total);
        }

        function clearTextInput() {
            $("#cari_obat").val('');
            $("#bpjs").val();
            $("#qty").val('');
            $("#sgn1").val('');
            $("#sgn2").val('');
            $("#satuan").val('');
            $("#biaya_obat").val('');
            $("#biaya_obat_hide").val('');
            $("#vtotakhir_hide").val('');
            $("#vtot_akhir").val('');
            $("#carapakai").val('');

            $("#cari_obat").focus();
        }

        function clearTextInputRacik() {
            $("#cari_obat2").focus();
            $("#cari_obat2").val('');
            $("#idracikan").val('');
            $("#qty_racikan").val('');
            $("#qty_racikan_hidden").val('');
            $("#biaya_racikan").val('');
            $("#biaya_racikan_hide").val('');
            $("#vtot_racikan").val('');
            $("#vtot_racikan_hide").val('');

        }

        function clearTextInputRacikSelesai() {
            $("#racikan").val('');
            $("#sgn1_racik").val('');
            $("#sgn2_racik").val('');
            $("#satuan").val('');
            $("#carapakai_racik").val('');
            $("#qty1").val('');
            $("#tuslah_racik").val('');
            $("#vtot_x").val('');
            $("#vtot_x_hide").val('');
            $("#vtot_akhir_racik").val('');
            $("#vtotakhir_hide_racik").val('');
        }
        $(document).ready(function() {
        
            tbl_racik = $("#tabel_racik").DataTable({
                ajax: "<?php echo site_url(); ?>master/mcobat/get_tabel_racik/<?php echo $id_paket; ?>",
                columns: [
                    { data: "no" },
                    { data: "nama_obat" },
                    // { data: "harga" },
                    { data: "qty" },
                    // { data: "total" },
                    { data: "aksi" }
                ],
                lengthMenu: [[25, 50, 50, -1], [20, 50, "All"]],
                bfilter: false,
                bPaginate: false,
                destroy: true,
                order: [[0, "asc"]]
            });
        });

        function populateDataObat() {
            // var cara_bayar = $("#cara_bayar").val();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: "<?php echo site_url(); ?>master/mcobat/get_tabel_resep/<?php echo $id_paket; ?>",
                success: function (response) {
                    //alert(JSON.stringify(response.data));
                    tbl_tindakan.clear().draw();
                    tbl_tindakan.rows.add(response.data);
                    tbl_tindakan.columns.adjust().draw();

                    total = response.total;
                    // $("#total_akhir").html('<h3>Rp. ' + penomoran(total).replace(/,/g,'.') + '</h3>');

                    //alert(response.total);
                }
            });
        }
        function populateDataObatRacik() {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: "<?php echo site_url(); ?>master/mcobat/get_tabel_racik/<?php echo $id_paket; ?>",
                success: function (response) {
                  
                    // tbl_racik.clear().draw();
                    tbl_racik.rows.add(response.data);
                    tbl_racik.columns.adjust().draw();
                }
            });
        }

        function hapus_obat(idpaketobat) {
            swal({
                    title: "Hapus Obat",
                    text: "Benar Akan Menghapus Data ini?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    $.ajax({
                        type:'post',
                        dataType: 'json',
                        url:"<?php echo base_url('master/Mcobat/hapus_paket_obat')?>",
                        data: {
                            id: idpaketobat
                        },
                        success: function(data){
                            if(data.status=='success'){
                                swal({
                                        title: "Selesai",
                                        text: "Data Sudah Dihapus",
                                        type: "success",
                                        showCancelButton: false,
                                        closeOnConfirm: false,
                                        showLoaderOnConfirm: true
                                    },
                                    function () {
                                        window.location.reload();
                                    });
                            }else {
                                sweetAlert(data.status, "Stock Kurang !", "error");
                            }
                        },
                        error: function(data){

                        }
                    });
                });
        }

        function hapus_data_racikan(id_paket, id_obat_racikan) {
            swal({
                    title: "Hapus Obat",
                    text: "Benar Akan Menghapus Obat?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: "<?php echo base_url('farmasi/frmcdaftar/hapus_data_racikan_new')?>",
                        data: { id_obat_racikan: id_obat_racikan },
                        success: function(data){
                            if(data['hasil'] === 'sukses'){

                                swal({
                                    title: "Obat Berhasil Dihapus!",
                                    text: "Akan Menghilang dalam 2 Detik",
                                    type: "success",
                                    timer: 1000
                                });

                                populateDataObatRacik();

                            }else{
                                sweetAlert(data['hasil'], "Oops. Terjadi Kesalahan", "error");
                            }
                        },
                        error: function(data){
                            // alert("error");
                            //sweetAlert("Oops...", data, "error");
                        }
                    });
                });
        }

        function set_hasil_calculator() {
            var total = ($("#diminta").val() * $("#dibutuhkan").val()) / $("#dosis").val() ;
            total = Math.round(total);
            $('#hasil_calculator').val(total);
            $('#hasil_calculator_hide').val(total);
            $("#qty_racikan").val(total) ;
            $("#qty_racikan_hidden").val(total) ;
            var total2 = $("#biaya_racikan").val() * total;
            $('#vtot_racikan').val(total2);
            $('#vtot_racikan_hide').val(total2);
        }
        $(document).ready(function(){
            tbl_tindakan = $('#tabel_tindakan').DataTable({
                ajax: "<?php echo site_url(); ?>master/mcobat/get_tabel_resep/<?php echo $id_paket; ?>",
                columns: [
                    { data: "no" },
                    { data: "id_obat" },
                    { data: "nama_obat" },
                   
                    { data: "qty" },
                   
                    { data: "aksi" }
                ],
                lengthMenu: [[25, 50, 50, -1], [20, 50, "All"]],
                //bFilter: true,
                bPaginate: true,
                destroy: true,
                order: [[2, "asc"]]
            });
        });
    </script>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block p-b-0">
                    <?php
                    echo $this->session->flashdata('success_msg');
                    ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> Tambah Obat</button>
                        <!-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#addModal2">Racik Obat</button> -->
                        <br/>
                        <br/>

                        <table id="tabel_tindakan" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="5%"><div align="center">No</div></th>
                                <th width="5%"><div align="center">ID</div></th>
                                <th><div align="center">Nama Obat</div></th>
                               
                                <th width="10%"><div align="center">QTY</div></th>
                              
                                <th width="5%"><div align="center">Aksi</div></th>
                            </tr>
                            </thead>
                            <tbody id="bodyt">
                            <!-- <?php
                            $i=1;
                            foreach($obat as $row){
                                ?>
                                <tr>
                                    <td><?=$i++?></td>
                                    <td><?=$row->id_obat?></td>
                                    <td><?=$row->nm_obat?></td>
                                    <td align="center"><?=$row->satuank?></td>
                                    <td align="center"><?=$row->signa?></td>
                                    <td align="center"><?=$row->qty?></td>
                                    <td align="right"><?=number_format($row->hargajual, '0', ',', '.')?></td>
                                    <td align="center"><button type="button" class="btn btn-danger btn-xs btn-block" onclick="hapus_obat(<?=$row->id?>)">Hapus</button></td>
                                </tr>
                            <?php } ?> -->
                            </tbody>
                        </table>

                        <br/><br/>
                        <button type="button" class="btn btn-success" onclick="window.location='<?=base_url("master/Mcobat/paket_obat")?>'"><i class="fa fa-arrow-left"></i> Kembali</button>
                        <?php echo form_open('master/mcobat/save_paket_obat');?>
                        <!-- Modal Edit Obat -->
                        <div class="modal fade" id="addModal" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-success">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Tambah Paket Obat</h4>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Nama Obat</p>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="nama_obat" id="nama_obat">
                                                <input type="hidden" class="form-control" name="id_obat" id="id_obat">
                                                <input type="hidden" class="form-control" name="id_paket" id="id_paket" value="<?=$id_paket?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-body" style="display: none">
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Satuan Obat</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="satuan" id="satuan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Qty</p>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="qty" id="qty" min="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
                        
                        <div class="modal fade" id="addModal2" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-lg modal-success">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Racik Obat</h4>
                                    </div>

                                    <div class="modal-body">
                                    <form id="insert_racikan">
                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="jenisObat">Jenis Obat *</p>
                                            <div class="col-sm-10">
                                                <div class="demo-radio-button">
                                                    <input name="jenis_obat" type="radio" id="obatrs" class="with-gap"
                                                           value="1" checked/> <label for="obatrs">Obat RS</label>
                                                    <input name="jenis_obat" type="radio" id="obatluar" class="with-gap"
                                                           value="2"/> <label for="obatluar">Obat Konsinyasi</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <p class="col-lg-2 form-control-label " id="tindakan">Obat</p>
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control" id="cari_obat2" name="cari_obat2" placeholder="Pencarian Obat" style="width:350px;">
                                                <input type="hidden" name="idracikan" id="idracikan">
                                                <input type="hidden" name="idtindakanracik" id="idtindakanracik">
                                                <input type="hidden" class="form-control" name="id_paket2" id="id_paket2" value="<?=$id_paket?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
                                            <div class="col-sm-3">

                                                <input type="number" step="0.01" class="form-control" name="qty_racikan" id="qty_racikan" onchange="set_total_racikan()">
                                                <input type="hidden" step="0.01" class="form-control" name="qty_racikan_hidden" id="qty_racikan_hidden" >
                                            </div>
                                            <!-- <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Calculator</button>
                                            </div> -->
                                        </div>


                                        <!-- Modal -->
                                        

                                        <div class="form-inline" align="right">
                                            <div class="form-group">
                                                <button type="reset" class="btn btn-warning">Reset</button>
                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                            </div>
                                        </div>
                                    </form>
                                        <br><br>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <table class="display nowrap table table-hover table-bordered table-striped" id="tabel_racik"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><p align="center">Id Racik</p></th>
                                                        <th><p align="center">Nama Obat</p></th>
                                                        <th><p align="center">Qty</p></th>
                                                        <th><p align="center">Aksi</p></th>
                                                    </tr>
                                                    </thead>
                                                    <!-- <tbody>
                                                    <tr>
                                                        <td colspan="5" align="right"><b>Total</b></td>
                                                        <td>Rp. <div class="pull-right" id="total_racik"></div></td>
                                                    </tr>
                                                    </tbody> -->
                                                </table>
                                                <br/><br/>
                                                <div class="row p-t-0">
                                                    <div class="col-md-6">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div align="right" id="total_racik"></div>
                                                    <input type="hidden" class="form-control" name="vtot1" id="vtot1">
                                                    </div><br>
                                                </div>
                                                <input type="hidden" name="dataobat" id="dataobat">
                                            </div>
                                        </div>
                                        <form id="insert_racikan_selesai">
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-2 form-control-label">Nama Racikan</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="nama_racik" id="nama_racik">
                                                <input type="hidden" class="form-control" name="id_paket2" id="id_paket2" value="<?=$id_paket?>">
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
                                                <div class="col-sm-2">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" name="sgn1" id="sgn1_racik" min=1 required>
                                                </div>
                                                <div class="col-sm-2">
                                                    <p><b>x  Sehari</b></p>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control" name="sgn2" id="sgn2_racik" min=1 required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <select  class="form-control" style="width: 100%" name="satuan" id="satuan" required>
                                                        <option value="">-Pilih Satuan-</option>
                                                        <?php foreach ($satuan as $row) { ?>
                                                            <option value="<?php echo $row->nm_satuan; ?>"><?php echo $row->nm_satuan; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-2 form-control-label">Quantity Total</p>
                                            <div class="col-sm-4">
                                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control" name="qty1" id="qty1" min=1  required>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                            <p class="col-sm-2 form-control-label">Tuslah Racik</p>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="tuslah_racik" id="tuslah_racik" value="0" onchange="set_hasil_obat()">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="display: none;">
                                                <p class="col-sm-3 form-control-label" id="lbl_vtotx">Total</p>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="vtot_x" id="vtot_x" disabled="">
                                                    <input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
                                                </div>
                                            </div> -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" type="submit">Selesai Racik</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>

                </div>
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