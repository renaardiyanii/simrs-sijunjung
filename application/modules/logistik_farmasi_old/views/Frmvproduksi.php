<?php
  $this->load->view('layout/header_left.php');
?>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script> 
<script type='text/javascript'>

$(document).ready(function () {
    $(".js-example-basic-single").select2({
            placeholder: "Select an option"
        });
});
</script>


<div class="panel-body" style="width:100%">
    <div class="col-md-16">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-info">
                Detail Obat
            </div>
            <div class="col-sm-12">
              <!-- <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus"></i> Obat Baru</button> -->
                <a href="<?php echo site_url("logistik_farmasi/Frmcproduksi/produksi_formula"); ?>"
                class="btn btn-primary pull-right">Obat Produksi ( Formula )</a>
			</div>
            <div class="ribbon-content">
            <?php echo form_open('logistik_farmasi/Frmcproduksi/insert_header_produksi'); ?>
                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Nama Obat</p>
                    <div class="col-sm-6">
                    <select id="idobat" class="form-control js-example-basic-single" name="id_obat" width="100%" required>
                        <option value="">-Pilih Obat-</option>
                        <?php
                            foreach($data_obat as $row){
                                echo '<option value="'.$row->id_obat.'-'.$row->nm_obat.'">'.$row->nm_obat.'</option>';
                            }
                        ?>
                    </select>
                            
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Batch No</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="batch_no" id="batch_no">      
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Qty</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="qty" id="qty">      
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Exp Date</p>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" name="exp_date" id="exp_date">       
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>






<?php
  $this->load->view('layout/footer_left.php');
?>