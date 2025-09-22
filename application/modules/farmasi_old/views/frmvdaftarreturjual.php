<?php
	$this->load->view('layout/header_left.php');
?>
    <html>
<script type='text/javascript'>
    //-----------------------------------------------Data Table
    $(document).ready(function() {
        $('#example').DataTable();
    } );
    //---------------------------------------------------------
    function retur_barang(){
        var total = parseInt($("#edit_stok_hide").val()) + parseInt($("#edit_quantity").val())  ;
        $('#edit_stok').val(total);
        $('#edit_stok').maskMoney('mask');

        var total = ($("#harga_obat").val() * $("#edit_quantity").val());

    

        // var total_akhir = total * parseFloat(margin);
        $('#biaya_retur').val(total.toFixed(0));
        $('#biaya_retur_hide').val(total.toFixed(0));
        // $("#biaya_retur").val(total_akhir.toFixed(0));
        // $("#vtotakhir_hide").val(total_akhir.toFixed(0));
        console.log(total);
    }
    function lihat_detail(idresep) {
        $.ajax({
            type:'POST',
            dataType: 'json',
            url:"<?php echo base_url('farmasi/Frmcreturjual/edit_data_retur')?>",
            data: {
                idresep : idresep
            },
            success: function(data){
                $('#id_resep').val(data[0].id_resep_pasien);
                $('#no_resep').val(data[0].no_resep);
                $('#edit_nama').val(data[0].nama_obat);
                $('#edit_qty_jual').val(data[0].qty);
                $('#edit_stok_hide').val(data[0].stok);
                $('#edit_stok').val(data[0].stok);
                $('#harga_obat').val(data[0].biaya_obat);
                // $('#biaya_retur').val(data[0].stok);
                $('#no_register').val(data[0].no_register);
                $('#item_obat').val(data[0].item_obat);
                $('#edit_quantity').prop('min', 0);
                $('#edit_quantity').prop('max', data[0].qty);

            },
            error: function(){
                alert("error");
            }
        });
    }

    function retur_stok(batch_no) {
        $.ajax({
            type:'POST',
            dataType: 'json',
            url:"<?php echo base_url('logistik_farmasi/Frmcretur/edit_stok')?>",
            data: {
                batch_no : batch_no
            },
            success: function(data){
                $('#edit_qty').val(data[0].qty);
            },
            error: function(){
                alert("error");
            }
        });
    }
   

    $(function() {
        $('#date_picker').datepicker({
            format: "yyyy-mm-dd",
            endDate: '0',
            autoclose: true,
            todayHighlight: true
        });

    });

    var site = "<?php echo site_url();?>";

</script>
<section class="content-header">
    <?php
    echo $this->session->flashdata('success_msg');
    ?>
</section>
<?php include('frmvdatapasien.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="box"  style="background: #ffffff">
           
               
                <div class="box-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><p align="center">ID Obat</p></th>
                            <th><p align="center">Nama Obat</p></th>
                            <th><p align="center">Satuan</p></th>
                            <th><p align="center">Signa</p></th>
                            <th><p align="center">Qty Beli</p></th>
                            <th><p align="center">Qty Retur</p></th>
                            <th><p align="center">Subtotal Beli</p></th>
                            <th><p align="center">Subtotal Retur</p></th>
                            <th><p align="center">Aksi</p></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        foreach($items as $row){
                            ?>
                        <tr>
                            <td><?=$row->item_obat?></td>
                            <td><?=$row->nama_obat?></td>
                            <td><?=$row->Satuan_obat?></td>
                            <td><?=$row->signa?></td>
                            <td align="right"><?=number_format($row->qty, '0', ',', '.')?></td>
                            <td align="right"><?= isset($row->qty_retur)?number_format($row->qty_retur, '0', ',', '.'):'0'?></td>
                            <td align="right"><?=number_format($row->vtot, '2', ',', '.')?></td>
                            <td align="right"><?= isset($row->biaya_retur)?number_format($row->biaya_retur, '2', ',', '.'):'0'?></td>
                            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lihatdetail" onclick="lihat_detail('<?=$row->id_resep_pasien?>')">Retur Barang</button></td>
                        </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <br/>
                    <a href="<?php echo site_url('farmasi/Frmcreturjual/'); ?>" class="btn btn-danger btn-sm">Kembali</a>

                    <?php echo form_open('farmasi/Frmcreturjual/save_retur');?>
                    <!-- Modal Edit Obat -->
                    <div class="modal fade" id="lihatdetail" role="dialog" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-success">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Detail Retur</h4>
                                    <input type="hidden" id="id_resep" name="id_resep">
                                    <input type="hidden" id="no_register" name="no_register">
                                    <input type="hidden" id="item_obat" name="item_obat">
                                    <input type="hidden" id="no_resep" name="no_resep">
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Nama Obat</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_nama" id="edit_nama" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Harga Obat</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="biaya_obat" id="harga_obat" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">QTY Jual</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_qty_jual" id="edit_qty_jual" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label" >Quantity Retur</p>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" name="edit_quantity" id="edit_quantity" oninput ="retur_barang(this.value)" 
                                             required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Total Retur</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="biaya_retur" id="biaya_retur" disabled="">
                                            <input type="hidden" class="form-control" name="biaya_retur_hide" id="biaya_retur_hide">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label" >Stok</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_stok" id="edit_stok" disabled="">
                                            <input type="hidden" class="form-control" name="edit_stok_hide" id="edit_stok_hide">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Retur Barang</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Kembali</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>

                </div>
            </div>
        </div>
</section>
<?php
	$this->load->view('layout/footer_left.php');
?>