<?php $this->load->view("layout/header_form"); ?>
<script>
    function inputResep() {
        window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER')?>", "_self");
    }
</script>

<div class="card m-5">
	<div class="card-header">
		<div class="d-flex justify-content-between">
            <h5>Resep Obat</h5>
			<div class="d-flex">
            <button class="btn btn-primary" onclick="inputResep()"><i class="fa fa-plus"></i> Resep</button>&nbsp;&nbsp;
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="input-group">
            <?php 
            
                if($rujukan_penunjang->status_obat>='1'){
                    echo '<label>'.$rujukan_penunjang->status_obat.'x Telah Di Tindak </label>';
                }else{}
            
            ?>&nbsp;
        </div>

        <div class="input-group">
        
            <?php
            if(!empty($cetak_resep_pasien)){
                echo form_open('farmasi/Frmckwitansi/cetak_faktur_resep_kt');
            ?>
                <select id="no_resep" class="custom-select" name="no_resep"  required>
                    <?php
                        foreach($cetak_resep_pasien as $row){
                            echo "<option value=".$row->no_resep." selected>".$row->no_resep."</option>";
                        }
                    ?>
                </select>
                <button type="submit" class="btn btn-primary"> Cetak Faktur</button>
                <?=form_close()?>
            <?php
            }else{
                echo "Faktur Belum Keluar";
            }
            ?>
        </div>

        <div class="table-responsive m-t-0">
            <table id="tabel_resep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                    <th>No Resep</th>
                    <th>Obat</th>
                    <th>Nama Obat</th>
                    <th>Tgl Tindakan</th>
                    <th>Satuan Obat</th>
                    <th>Biaya Obat</th>
                    <th>Qty</th>
                    <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_bayar = 0;
                    if(!empty($list_resep_pasien)){
                        foreach($list_resep_pasien as $r){ ?>
                        <tr>
                            <td><?php echo $r->no_resep ; ?></td>
                            <td>
                                <?php
                                    if ($r->obat_luar == 0) {
                                        echo 'OBAT LUAR';
                                    }else{
                                        echo 'OBAT RS';
                                    }
                                ?>
                            </td>
                            <td><?php echo $r->nama_obat ; ?></td>
                            <td><?= isset($r->tgl_kunjungan)?date('d-m-Y',strtotime($r->tgl_kunjungan)):'-'?></td>
                            <td><?php echo $r->signa ; ?></td>
                            <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
                            <td><?php echo $r->qty ; ?></td>
                            <td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
                            <?php $total_bayar = $total_bayar + $r->vtot;?>
                        </tr>
                        <?php
                                    }
                                 }else{ 
                                    ?>
                                    <tr>
                                            <td colspan="7">Data Kosong</td>
                                        
                                        </tr>
                                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer">
            <div class="form-inline" align="right">
                <div class="input-group">
                    <table width="100%" class="table table-hover table-striped table-bordered">
                        <tr>
                        <td colspan="6">Total Resep</td>
                        <td>Rp. <?php echo number_format($total_bayar,0);?></td>
                        </tr>
                    </table>
                </div>
            </div>
    </div>
</div>





