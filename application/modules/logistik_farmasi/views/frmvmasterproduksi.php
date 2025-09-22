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
                Detail Master Produksi
            </div>
           
            <div class="ribbon-content">
            <?php echo form_open('logistik_farmasi/Frmcproduksi/insert_master_produksi'); ?>
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

                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>






<?php
  $this->load->view('layout/footer_left.php');
?>