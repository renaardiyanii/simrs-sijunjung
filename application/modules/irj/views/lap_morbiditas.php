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
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('irj/rjclaporan/morbiditas_diagnosa');?>
                    <div class="row p-t-0">	
                        <div class="col-md-2">
                            <div class="form-group">
                                
                                <select name="layanan" id="layanan" class="form-control">
                                    <option value="rj">Rawat Jalan</option>
                                    <option value="rd">Rawat Darurat</option>
                                    <option value="ri">Rawat Inap</option>
                                </select>
                            </div>
                        </div>		
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
                                <div id="month_input">
                                    <input type="date" id="date_days" class="form-control" name="date_days">
                                    <input type="month" id="date_months" class="form-control" name="date_months">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" id="btncari" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
			</div>			
		</div>						
	</div>
</div>

</section>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
                        <?php 
								if($layanan != ''){ 
									if($layanan == 'rj'){
										$layananya = 'Rawat Jalan';
									}else if($layanan == 'rd'){
										$layananya = 'Rawat Darurat';
									}else{
										$layananya = 'Rawat Inap';
									}
								}else{
                                    $layananya = '';
                                }
						?>
					<h4 align="center">Laporan Morbiditas <?= $layananya ?> <?= $judul ?>
                                        Di Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi”
                                        </h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">ICD 10</th>
                                            <th rowspan="2">Diagnosa</th>
                                            <th colspan="2">0hr-27hr</th>
                                            <th colspan="2">28hr-< 1th</th>
                                            <th colspan="2">1th-4th</th>
                                            <th colspan="2">5th-14th</th>
                                            <th colspan="2">15th-24th</th>
                                            <th colspan="2">25th-44th</th>
                                            <th colspan="2">45th-64th</th>
                                            <th colspan="2">65+</th>
                                            <th colspan="3">Jumlah Kasus Baru Menurut Sex</th>
                                            <?php 
                                            if($layanan == 'ri'){ ?>
                                                <th rowspan="2">Jumlah Kunjungan H+M</th>
                                            <?php }else{ ?>
                                                <th rowspan="2">Jumlah Kunjungan B+L</th>
                                            <?php }
                                            ?>
                                           
                                        </tr>  
                                        <tr>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>Total</th>
                                        </tr>                                     
                                    </thead>
                                    <tbody id="tbodyexample">
                                        <?php 
                                        $i = 1;
                                        foreach($morbiditas as $row) { 
                                            $total_l = $row->hari_0_27_baru_l + $row->hari_28_1_baru_l + $row->tahun_1_4_baru_l + $row->tahun_5_14_baru_l + $row->tahun_15_24_baru_l + $row->tahun_25_44_baru_l + $row->tahun_45_64_baru_l + $row->tahun_65_baru_l; 
                                            $total_p = $row->hari_0_27_baru_p + $row->hari_28_1_baru_p + $row->tahun_1_4_baru_p + $row->tahun_5_14_baru_p + $row->tahun_15_24_baru_p + $row->tahun_25_44_baru_p + $row->tahun_45_64_baru_p + $row->tahun_65_baru_p; 
                                            $total_lama = $row->hari_0_27_lama + $row->hari_28_1_lama + $row->tahun_1_4_lama + $row->tahun_5_14_lama + $row->tahun_15_24_lama + $row->tahun_25_44_lama + $row->tahun_45_64_lama + $row->tahun_65_lama;?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row->id_diagnosa;?></td>
                                                <td><?php echo $row->diagnosa;?></td>
                                                <td><?php echo $row->hari_0_27_baru_l;?></td>
                                                <td><?php echo $row->hari_0_27_baru_p;?></td>
                                                <td><?php echo $row->hari_28_1_baru_l;?></td>
                                                <td><?php echo $row->hari_28_1_baru_p;?></td>
                                                <td><?php echo $row->tahun_1_4_baru_l;?></td>
                                                <td><?php echo $row->tahun_1_4_baru_p;?></td>
                                                <td><?php echo $row->tahun_5_14_baru_l;?></td>
                                                <td><?php echo $row->tahun_5_14_baru_p;?></td>
                                                <td><?php echo $row->tahun_15_24_baru_l;?></td>
                                                <td><?php echo $row->tahun_15_24_baru_p;?></td>
                                                <td><?php echo $row->tahun_25_44_baru_l;?></td>
                                                <td><?php echo $row->tahun_25_44_baru_p;?></td>
                                                <td><?php echo $row->tahun_45_64_baru_l;?></td>
                                                <td><?php echo $row->tahun_45_64_baru_p;?></td>
                                                <td><?php echo $row->tahun_65_baru_l;?></td>
                                                <td><?php echo $row->tahun_65_baru_p;?></td>
                                                <td><?php echo $total_l;?></td>
                                                <td><?php echo $total_p;?></td>
                                                <td><?php echo $total_l + $total_p;?></td>
                                                <td><?php echo $total_l + $total_p + $total_lama;?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('irj/rjclaporan/excel_morbiditas_diagnosa/'.$date.'/'.$tampil.'/'.$layanan); ?>" class="btn btn-danger" target="_blank">Excel</a>				
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