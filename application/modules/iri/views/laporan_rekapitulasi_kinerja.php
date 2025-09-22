<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#date_days').show();
	$('#date_months').hide();
    $('.select2').select2();
    $('#example').DataTable();
});

function cek_tampil_per(val_tampil_per){
	if(val_tampil_per=='TGL'){
		$('#date_days').show();
		$('#date_months').hide();
	}else if(val_tampil_per=='BLN'){
		$('#date_months').show();
		$('#date_days').hide();
	}
}
</script>
<style>
hr {
	border-color:#7DBE64 !important;
} p {
    font-size: 12px;
}
tr>th {
    text-align: center; /* Center align text horizontally */
    vertical-align: middle; /* Center align text vertically */
  }
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('iri/riclaporan/laporan_rekapitulasi_kinerja');?>
                <p>Tanggal/Bulan pasien pulang</p>
                    <div class="row p-t-0">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="TGL">Tanggal</option>
                                    <option value="BLN">Bulan</option>
                                </select>
                            </div>
                        </div>											
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">
                                    <input type="month" id="date_months" class="form-control" name="date_months">
                                    <input type="date" id="date_days" class="form-control" name="date_days">		
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" id="btncari" name="btncari" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
			</div>			
		</div>						
	</div>
</div>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">LAPORAN REKAPITULASI KINERJA DOKTER UMUM</br>RS. OTAK DR. Drs. M. HATTA BUKITTINGI <b><?php echo $date_title; ?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">No</th>
                                            <th rowspan="3">Nama Petugas</th>
                                            <th colspan="12">Kuantitas</th>
                                            <th  colspan="10">Kualitas</th>
                                            <th rowspan="3">Keterangan</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Σ Asupan Medis Dlm Bentuk SOAP Yang</th>
                                            <th colspan="4">Σ Pengkajian Awal Medis</th>
                                            <th colspan="4">Σ Pasien Pulang yang Dientrikan Diagnosis</th>
                                            <th colspan="3">Melakukan Tindakan Emergency</th>
                                            <th colspan="3">Kelengkapan Rekam Medis</th>
                                            <th colspan="3">Kepatuhan Pelaksanaan Tebak</th>
                                            <th>Respon Tim Sisrute <= 1</th>
                                        </tr>
                                        <tr>
                                            <th>RJ</th>
                                            <th>IGD</th>
                                            <th>RI</th>
                                            <th>ICU</th>
                                            <th>RJ</th>
                                            <th>IGD</th>
                                            <th>RI</th>
                                            <th>ICU</th>
                                            <th>RJ</th>
                                            <th>IGD</th>
                                            <th>RI</th>
                                            <th>ICU</th>
                                            <th>IGD</th>
                                            <th>RI</th>
                                            <th>ICU</th>
                                            <th>RJ</th>
                                            <th>IGD</th>
                                            <th>RI</th>
                                            <th>ICU</th>
                                            <th>IGD</th>
                                            <th>RI</th>
                                            <th>IGD</th>
                                        </tr>      
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = 1;
                                        foreach($list_dokter as $val):
                                           
                                        ?>
                                        <tr>
                                            <td  ><?= $no; ?></td>
                                            <td ><?= $val->nama_petugas ?></td>
                                            <td><?= $val->soap_rj; ?></td>
                                            <td><?= $val->soap_rd; ?></td>
                                            <td><?= $val->soap_ri; ?></td>
                                            <td><?= $val->soap_icu; ?></td>
                                            <td><?= $val->soap_rj; ?></td>
                                            <td><?= $val->soap_rd; ?></td>
                                            <td><?= $val->soap_ri; ?></td>
                                            <td><?= $val->soap_icu; ?></td>
                                            <td><?= $val->diagnosa_rj; ?></td>
                                            <td><?= $val->diagnosa_rd; ?></td>
                                            <td><?= $val->diagnosa_iri; ?></td>
                                            <td><?= $val->diagnosa_icu; ?></td>
                                            <td><?= $val->plan_rd; ?></td>
                                            <td><?= $val->plan_ri; ?></td>
                                            <td><?= $val->plan_icu; ?></td>
                                            <td><?= $val->plan_rd; ?></td>
                                            <td><?= $val->plan_ri; ?></td>
                                            <td><?= $val->plan_icu; ?></td>
                                            <td><?= $val->tebak_igd; ?></td>
                                            <td><?= $val->tebak_ri; ?></td>
                                            <td><?= $val->tebak_icu; ?></td>
                                            <td><?= $val->sisrute_igd; ?></td>
                                            <td></td>
                                        </tr>
                                        <?php $no++; endforeach; ?>
                                    
                                    </tbody>
                                </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('iri/riclaporan/excel_rekapitulasi_kinerja/'.$date.'/'.$tampil.'/');?>" class="btn btn-danger" target="_blank">Excel</a>				
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->
 
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>