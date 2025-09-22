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
                Detail  Obat
            </div>
            <div class="ribbon-content">
           
                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Nama Obat</p>
                   
                    <div class="col-sm-6">
                        <!-- <p>:</p>  -->
                        <p>: <?php echo $data_header->nm_obat ?></p>     
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Qty</p>
                    <div class="col-sm-6">
                        <p>: <?php echo$data_header->qty ?></p> 
                             
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">No Batch</p>
                    <div class="col-sm-6">
                    <p>: <?php echo $data_header->batch_no ?></p> 
                          
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Expire Date</p>
                    <div class="col-sm-6">
                    <p>: <?php echo $data_header->exp_date ?></p> 
                              
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Tanggal Produksi</p>
                    <div class="col-sm-6">
                    <p>: <?php echo $data_header->tgl_produksi ?></p> 
                           
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>


<div class="panel-body" style="width:100%">
    <div class="col-md-16">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-info">
                Detail Bahan Obat
            </div>
            <div class="ribbon-content">
            <?php echo form_open('logistik_farmasi/Frmcproduksi/insert_detail_produksi/'.$id_produksi); ?>
                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Nama Obat</p>
                    <div class="col-sm-6">
                    <select id="idobat" class="form-control js-example-basic-single" name="idobat" width="100%" required>
                        <option value="">-Pilih Obat-</option>
                        <?php
                            foreach($data_obat_bahan as $row){
                                echo '<option value="'.$row->id_obat.'-'.$row->id_inventory.'-'.$row->id_gudang.'-'.$row->batch_no.'">'.$row->nm_obat.'(batch-'.$row->batch_no.','.$row->expire_date.','.$row->qty.')</option>';
                            }
                        ?>
                    </select>
                            
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Qty</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="qty" id="qty">      
                    </div>
                </div>

                <input type="hidden" name="id_produksi" id="id_produksi" value=<?php echo $id_produksi ?>>

                <button class="btn btn-primary" type="submit">Tambah</button>
            </div>
            <?php echo form_close(); ?>
            <br><br>
            <table class="display nowrap table table-hover table-bordered table-striped"
                cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><p align="center">No</p></th>
                    <th><p align="center">Nama Obat</p></th>
                    <th><p align="center">Qty</p></th>
                    <th><p align="center">Aksi</p></th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 1;
                foreach ($data_obat_produksi as $row) {
                ?>
                    <tr>
                        <td align="center"><?php echo $i++; ?></td>
                        <td align="center"><?php echo $row->nm_obat; ?></td>
                        <td align="center" ><?php echo $row->qty; ?></td>
                        <td align="center" > 
                            <a href="<?php echo site_url("logistik_farmasi/Frmcproduksi/hapus_detail_produksi/".$row->id.'/'.$row->id_produksi); ?>"
                            class="btn btn-danger btn-xs">hapus</a>
                           
                        </td>
                    <tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
            <div class="col-xs-6" align="right">
                <div class="form-inline" align="right">
                    <div class="input-group">
                        <div class="form-group">
                        <a href="<?php echo site_url("logistik_farmasi/Frmcproduksi/insert_selesai_produksi/".$id_produksi); ?>"
                        class="btn btn-primary">Selesai Produksi</a>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
  $this->load->view('layout/footer_left.php');
?>