<?php
if ($role_id == 1) {
  $this->load->view("layout/header_left");
} else {
  $this->load->view("layout/header_left");
}
?>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#kode_inacbg').select2();
	} );

</script>
<?php echo $this->session->flashdata('pesan');?>
<div class="row">
    <div class="col-sm-6">
        <div class="card card-outline-info">
            <div class="card-header text-white" align="center" >Data Pasien</div>
            <div class="card-block">
                <br/>
                <div class="row">
                    <div class="col-sm-3">
                        <div align="center"><img height="100px" class="img-rounded" src="<?php 
                            if($data_pasien->foto == ''){
                                echo site_url("upload/photo/unknown.png");
                            }else{
                                echo site_url("upload/photo/".$data_pasien->foto); 
                            }
                            ?>">
                        </div>
                        <div align="center"><br><a href="<?php echo base_url();?>irj/rjclaporan/cetak_rekap_pasien/<?php echo $data_pasien->no_register;?>" target="_blank" class="btn btn-primary btn-sm" style="white-space: normal;">Rekap Bill</a><br></div>
                    </div>

                    <div class="col-sm-9 table-responsive">
                        <table class="table-sm table-striped" style="font-size:15">
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien->nama;?></td>
                                </tr>
                                <tr>
                                    <th>No. MedRec</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien->no_cm;?></td>
                                </tr>
                                <tr>
                                    <th>No. Register</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien->no_register;?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Lahir</th>
                                    <td>:&nbsp;</td>
                                    <td><?php
                                        $interval = date_diff(date_create(), date_create($data_pasien->tgl_lahir));
                                        echo date('d-m-Y', strtotime($data_pasien->tgl_lahir));
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien->alamat;?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kunjungan</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo date('d-m-Y', strtotime($data_pasien->tgl_kunjungan)); ?></td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien->kelas_pasien;?></td>
                                </tr>
                                <tr>
                                    <th>DPJP</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien->nm_dokter;?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Asal</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien->nm_poli;?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Cara Bayar</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien->cara_bayar;?> 
                                        <!-- <a href="<?php echo base_url() ;?>iri/ricpasien/ubah_cara_bayar/<?php ?>"><input type="button" class="btn btn-primary btn-sm" value="Ubah"></a> -->
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td> &nbsp;</td>
                                    <td><?php echo $data_pasien->kontraktor;?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br/>
                <div class="row" style="align: center;">
                    <div class="col-md-12">
                        <a href="<?php echo base_url().'emedrec/C_emedrec/rekam_medik_detail/'.$data_pasien->no_cm.'/'.$data_pasien->no_medrec ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="margin-left: 45%;width: 20%;">E-KAMEK</a>									
                    </div>								
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card card-outline-danger">
            <div class="card-header text-white" align="center">Kode INA - CBG</div>
                <div class="card-block">
                    <br/>
                    <h5>Diagnosa :</h5>
                    <?php foreach($diagnosa as $diag) {
                        echo '- '.$diag->id_diagnosa.' - '.$diag->diagnosa.'('.$diag->klasifikasi_diagnos.')'.'<br>';
                    } ?><br>
                    <form action="<?php echo site_url('irj/rjcmedrec/insert_inacbg'); ?>" method="post">
                        <div class="form-group row">
                            <p class="col-sm-2 form-control-label">INA - CBG :</p>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <select name="kode_inacbg" id="kode_inacbg" class="form-control select2">
                                        <option value="">Pilih Kode INA - CBG</option>
                                        <?php 
                                        foreach($inacbg as $row){
                                            echo '<option value="'.$row->kd_inacbg.'" ';
                                            if($row->kd_inacbg == $data_pasien->kode_inacbg) echo 'selected';
                                            echo '>'.$row->kd_inacbg.' | '.$row->uraian.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-inline" align="right">
                            <input type="hidden" class="form-control" value="<?php echo $data_pasien->no_register;?>" name="no_register">
                            <input type="hidden" class="form-control" value="" name="id_row_diagnosa" id="id_row_diagnosa">
                            <div class="form-group" align="right">
                                <!-- <button type="reset" class="btn btn-warning btn-sm">Reset</button>&nbsp; -->
                                <input type="submit" class="btn btn-primary" id="btn_simpan" value="Simpan">
                            </div>
                        </div>
                    </form>
                </div>
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