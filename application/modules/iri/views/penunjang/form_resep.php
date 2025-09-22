<?php $this->load->view("layout/header_form"); ?>

<div class="card m-5">
	<div class="card-header ">
        <div class="d-flex justify-content-between">
			<h5>Resep</h5>
			<div class="d-flex">
                <button class="btn btn-primary" onclick="inputResep()"><i class="fa fa-plus"></i> Resep</button>&nbsp;&nbsp;
                <?php 
                if( date('Y-m-d', strtotime($data_pasien[0]['tgl_resep_terakhir'])) != date('Y-m-d')){ ?>
<a href="<?php echo base_url();?>iri/rictindakan/flag_order_obat/<?php echo $no_ipd;?>"> <input type="button" class="btn btn-danger" value="Order"></a>
                <?php }
                ?>
                
			</div>
		</div>
    </div>

    <div class="card-body">
        <div class="input-group">
            <?php 
            foreach($rujukan_penunjang as $row){
                if($row->status_obat>='1'){
                    echo '<label>'.$row->status_obat.'x Telah Di Order </label>';
                }else{}
            }
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
                    <th>Nama Obat</th>
                    <th>Tanggal</th>
                    <!-- <th>Tgl Tindakan</th> -->
                    <th>Signa</th>
                    <th>Biaya Obat</th>
                    <th>Qty</th>
                    <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_bayar = 0;
                    if(!empty($list_resep_pasien)){
                        if($data_pasien[0]['obat'] == '1'){
                        foreach($list_resep_pasien as $r){ ?>
                        <tr>
                            <td><?php echo $r->no_resep ; ?></td>
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
                                    foreach($list_resep_pasien as $r){ 
                                        if(isset($r->no_resep) != null){  ?>
                                            <tr>
                                                <td><?php echo $r->no_resep ; ?></td>
                                                <td><?php echo $r->nama_obat ; ?></td>
                                                <td><?= isset($r->tgl_kunjungan)?date('d-m-Y',strtotime($r->tgl_kunjungan)):'-'?></td>
                                                <td><?php echo $r->signa ; ?></td>
                                                <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
                                                <td><?php echo $r->qty ; ?></td>
                                                <td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
                                                <?php $total_bayar = $total_bayar + $r->vtot;?>
                                            </tr>
                                            <?php }else{ ?>	<tr>
                                        <td colspan="7">Data Kosong</td>
                                        <!-- <td>Data Kosong</td>
                                        <td>Data Kosong</td>
                                        <td>Data Kosong</td>
                                        <td>Data Kosong</td>
                                        <td>Data Kosong</td>
                                        <td>Data Kosong</td> -->
                                    </tr>
                                    <?php } }
                                    } }else{ 
                                    ?>
                                    <tr>
                                            <td colspan="7">Data Kosong</td>
                                            <!-- <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td> -->
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

<script>
    function inputResep() {
        // new swal({
        //     title: "Resep",
        //     text: "Input Data Resep Pasien?",
        //     type: "warning",
        //     showCancelButton: true,
        //     showLoaderOnConfirm: true,
        //     confirmButtonColor: "#DD6B55",
        //     confirmButtonText: "Ya!",
        //     cancelButtonText: "Tidak!",
        //     closeOnConfirm: false,
        //     closeOnCancel: false
        // },
        // function(isConfirm){
        //     if (isConfirm) {
                window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$data_pasien[0]['no_ipd'].'/DOKTER')?>", "_self");
               
        //     } else {
        //         swal("Close", "Batal Input Resep", "error");
        //     }
        // }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
        //         window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$data_pasien[0]['no_ipd'].'/DOKTER')?>", "_self");
              
        //     } else if (result.isDenied) {
        //         swal("Close", "Batal Input Resep", "error");
        //     }
        //     });
    }
</script>







	

