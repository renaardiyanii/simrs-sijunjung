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
		document.getElementById("date_days").required = true;
		document.getElementById("date_months").required = false;
		$('#date_days').show();
		$('#date_months').hide();
	}else if(val_tampil_per=='BLN'){
		document.getElementById("date_months").required = true;
		document.getElementById("date_days").required = false;
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
                <?php echo form_open('iri/riclaporan/ketepatan_visite_by_imn');?>
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
                                <input type="date" id="date_days" class="form-control" name="date_days">
                                <input type="month" id="date_months" class="form-control" name="date_months">
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
					<h4 align="center">Jumlah Visite DPJP Berdasarkan Ruangan dan Kelas <b><?= $judul; ?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Nama DPJP</th>
                                            <th colspan="2">Panorama Anak</th>
                                            <th colspan="2">Panorama Bedah</th>
                                            <th colspan="2">Panorama Kebidanan</th>
                                            <th colspan="2">Irna B L1,2/Singgalang</th>
                                            <th colspan="2">Irna B L3/Singgalang/Interne</th>
                                            <th colspan="2">Irna C L1/Merapi</th>
                                            <th colspan="2">Irna C L2/Merapi</th>
                                            <th colspan="2">Irna C L3/Merapi</th>
                                            <th colspan="2">Limpapeh L2&3</th>
                                            <th colspan="2">Limpapeh L4</th>
                                            <th colspan="2">ICU/ICCU</th>
                                            <th colspan="2">NICU</th>
                                            <th colspan="2">Jumlah</th>
                                            <th rowspan="2">Total</th>
                                            <th rowspan="2">Hasil</th>
                                        </tr>  
                                        <tr>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                            <th>Jam 6 - 14</th>
                                            <th>> Jam 14</th>
                                        </tr>                                     
                                    </thead>
                                    <tbody id="tbodyexample">
                                        <?php 
                                        $i = 1;
                                        $total_kurang_14_icu = 0;
                                        $total_lebih_14_icu = 0;
                                        $total_kurang_14_nicu = 0;
                                        $total_lebih_14_nicu = 0;
                                        $total_kurang_14_limpapeh23 = 0;
                                        $total_lebih_14_limpapeh23 = 0;
                                        $total_kurang_14_limpapeh4 = 0;
                                        $total_lebih_14_limpapeh4 = 0;
                                        $total_kurang_14_anak = 0;
                                        $total_lebih_14_anak = 0;
                                        $total_kurang_14_bedah = 0;
                                        $total_lebih_14_bedah = 0;
                                        $total_kurang_14_bidan = 0;
                                        $total_lebih_14_bidan = 0;
                                        $total_kurang_14_singgalang12 = 0;
                                        $total_lebih_14_singgalang12 = 0;
                                        $total_kurang_14_singgalang3 = 0;
                                        $total_lebih_14_singgalang3 = 0;
                                        $total_kurang_14_merapi1 = 0;
                                        $total_lebih_14_merapi1 = 0;
                                        $total_kurang_14_merapi2 = 0;
                                        $total_lebih_14_merapi2 = 0;
                                        $total_kurang_14_merapi3 = 0;
                                        $total_lebih_14_merapi3 = 0;
                                        $jumlah_kurang_14 = 0;
                                        $jumlah_lebih_14 = 0;
                                        $jumlah = 0;
                                        foreach($visite as $row) { ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row->nama_pemeriksa;?></td>
                                                <td><?php echo $row->kurang_14_anak;
                                                $total_kurang_14_anak += $row->kurang_14_anak;?></td>
                                                <td><?php echo $row->lebih_14_anak;
                                                $total_lebih_14_anak += $row->lebih_14_anak;?></td>
                                                <td><?php echo $row->kurang_14_bedah;
                                                $total_kurang_14_bedah += $row->kurang_14_bedah;?></td>
                                                <td><?php echo $row->lebih_14_bedah;
                                                $total_lebih_14_bedah += $row->lebih_14_bedah;?></td>
                                                <td><?php echo $row->kurang_14_bidan;
                                                $total_kurang_14_bidan += $row->kurang_14_bidan;?></td>
                                                <td><?php echo $row->lebih_14_bidan;
                                                $total_lebih_14_bidan += $row->lebih_14_bidan;?></td>
                                                <td><?php echo $row->kurang_14_singgalang12;
                                                $total_kurang_14_singgalang12 += $row->kurang_14_singgalang12;?></td>
                                                <td><?php echo $row->lebih_14_singgalang12;
                                                $total_lebih_14_singgalang12 += $row->lebih_14_singgalang12;?></td>
                                                <td><?php echo $row->kurang_14_singgalang3;
                                                $total_kurang_14_singgalang3 += $row->kurang_14_singgalang3;?></td>
                                                <td><?php echo $row->lebih_14_singgalang3;
                                                $total_lebih_14_singgalang3 += $row->lebih_14_singgalang3;?></td>
                                                <td><?php echo $row->kurang_14_merapi1;
                                                $total_kurang_14_merapi1 += $row->kurang_14_merapi1;?></td>
                                                <td><?php echo $row->lebih_14_merapi1;
                                                $total_lebih_14_merapi1 += $row->lebih_14_merapi1;?></td>
                                                <td><?php echo $row->kurang_14_merapi2;
                                                $total_kurang_14_merapi2 += $row->kurang_14_merapi2;?></td>
                                                <td><?php echo $row->lebih_14_merapi2;
                                                $total_lebih_14_merapi2 += $row->lebih_14_merapi2;?></td>
                                                <td><?php echo $row->kurang_14_merapi3;
                                                $total_kurang_14_merapi3 += $row->kurang_14_merapi3;?></td>
                                                <td><?php echo $row->lebih_14_merapi3;
                                                $total_lebih_14_merapi3 += $row->lebih_14_merapi3;?></td>
                                                <td><?php echo $row->kurang_14_limpapeh23;
                                                $total_kurang_14_limpapeh23 += $row->kurang_14_limpapeh23;?></td>
                                                <td><?php echo $row->lebih_14_limpapeh23;
                                                $total_lebih_14_limpapeh23 += $row->lebih_14_limpapeh23;?></td>
                                                <td><?php echo $row->kurang_14_limpapeh4;
                                                $total_kurang_14_limpapeh4 += $row->kurang_14_limpapeh4;?></td>
                                                <td><?php echo $row->lebih_14_limpapeh4;
                                                $total_lebih_14_limpapeh4 += $row->lebih_14_limpapeh4;?></td>
                                                <td><?php echo $row->kurang_14_icu;
                                                $total_kurang_14_icu += $row->kurang_14_icu;?></td>
                                                <td><?php echo $row->lebih_14_icu;
                                                $total_lebih_14_icu += $row->lebih_14_icu;?></td>
                                                <td><?php echo $row->kurang_14_nicu;
                                                $total_kurang_14_nicu += $row->kurang_14_nicu;?></td>
                                                <td><?php echo $row->lebih_14_nicu;
                                                $total_lebih_14_nicu += $row->lebih_14_nicu;?></td>
                                                <td><?php echo $row->kurang_14_icu + $row->kurang_14_nicu + $row->kurang_14_limpapeh23 + $row->kurang_14_limpapeh4 + $row->kurang_14_anak + $row->kurang_14_bedah + $row->kurang_14_bidan + $row->kurang_14_singgalang12 + $row->kurang_14_singgalang3 + $row->kurang_14_merapi1 + $row->kurang_14_merapi2 + $row->kurang_14_merapi3;
                                                $total_kurang_14 = $row->kurang_14_icu + $row->kurang_14_nicu + $row->kurang_14_limpapeh23 + $row->kurang_14_limpapeh4 + $row->kurang_14_anak + $row->kurang_14_bedah + $row->kurang_14_bidan + $row->kurang_14_singgalang12 + $row->kurang_14_singgalang3 + $row->kurang_14_merapi1 + $row->kurang_14_merapi2 + $row->kurang_14_merapi3;
                                                $jumlah_kurang_14 += $row->kurang_14_icu + $row->kurang_14_nicu + $row->kurang_14_limpapeh23 + $row->kurang_14_limpapeh4 + $row->kurang_14_anak + $row->kurang_14_bedah + $row->kurang_14_bidan + $row->kurang_14_singgalang12 + $row->kurang_14_singgalang3 + $row->kurang_14_merapi1 + $row->kurang_14_merapi2 + $row->kurang_14_merapi3;?></td>
                                                <td><?php echo $row->lebih_14_icu + $row->lebih_14_nicu + $row->lebih_14_limpapeh23 + $row->lebih_14_limpapeh4 + $row->lebih_14_anak + $row->lebih_14_bedah + $row->lebih_14_bidan + $row->lebih_14_singgalang12 + $row->lebih_14_singgalang3 + $row->lebih_14_merapi1 + $row->lebih_14_merapi2 + $row->lebih_14_merapi3;
                                                $total_lebih_14 = $row->lebih_14_icu + $row->lebih_14_nicu + $row->lebih_14_limpapeh23 + $row->lebih_14_limpapeh4 + $row->lebih_14_anak + $row->lebih_14_bedah + $row->lebih_14_bidan + $row->lebih_14_singgalang12 + $row->lebih_14_singgalang3 + $row->lebih_14_merapi1 + $row->lebih_14_merapi2 + $row->lebih_14_merapi3;
                                                $jumlah_lebih_14 += $row->lebih_14_icu + $row->lebih_14_nicu + $row->lebih_14_limpapeh23 + $row->lebih_14_limpapeh4 + $row->lebih_14_anak + $row->lebih_14_bedah + $row->lebih_14_bidan + $row->lebih_14_singgalang12 + $row->lebih_14_singgalang3 + $row->lebih_14_merapi1 + $row->lebih_14_merapi2 + $row->lebih_14_merapi3;?></td>
                                                <td><?php echo $total_kurang_14 + $total_lebih_14;
                                                $jumlah += $total_kurang_14 + $total_lebih_14;?></td>
                                                <?php
                                                    $total = $total_kurang_14 + $total_lebih_14;
                                                    if($total != 0) {
                                                        $hasil = ($total_kurang_14 / $total) * 100;
                                                    } else {
                                                        $hasil = 0;
                                                    }
                                                ?>
                                                <td><?php echo round($hasil, 1).'%';?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="2"><b>Jumlah</b></td>
                                            <td><?php echo $total_kurang_14_anak; ?></td>
                                            <td><?php echo $total_lebih_14_anak; ?></td>
                                            <td><?php echo $total_kurang_14_bedah; ?></td>
                                            <td><?php echo $total_lebih_14_bedah; ?></td>
                                            <td><?php echo $total_kurang_14_bidan; ?></td>
                                            <td><?php echo $total_lebih_14_bidan; ?></td>
                                            <td><?php echo $total_kurang_14_singgalang12; ?></td>
                                            <td><?php echo $total_lebih_14_singgalang12; ?></td>
                                            <td><?php echo $total_kurang_14_singgalang3; ?></td>
                                            <td><?php echo $total_lebih_14_singgalang3; ?></td>
                                            <td><?php echo $total_kurang_14_merapi1; ?></td>
                                            <td><?php echo $total_lebih_14_merapi1; ?></td>
                                            <td><?php echo $total_kurang_14_merapi2; ?></td>
                                            <td><?php echo $total_lebih_14_merapi2; ?></td>
                                            <td><?php echo $total_kurang_14_merapi3; ?></td>
                                            <td><?php echo $total_lebih_14_merapi3; ?></td>
                                            <td><?php echo $total_kurang_14_limpapeh23; ?></td>
                                            <td><?php echo $total_lebih_14_limpapeh23; ?></td>
                                            <td><?php echo $total_kurang_14_limpapeh4; ?></td>
                                            <td><?php echo $total_lebih_14_limpapeh4; ?></td>
                                            <td><?php echo $total_kurang_14_icu; ?></td>
                                            <td><?php echo $total_lebih_14_icu; ?></td>
                                            <td><?php echo $total_kurang_14_nicu; ?></td>
                                            <td><?php echo $total_lebih_14_nicu; ?></td>
                                            <td><?php echo $jumlah_kurang_14; ?></td>
                                            <td><?php echo $jumlah_lebih_14; ?></td>
                                            <td><?php echo $jumlah; ?></td>
                                            <td>
                                                <?php
                                                if($jumlah != 0) {
                                                    $presentase_jumlah = ($jumlah_kurang_14 / $jumlah) * 100;
                                                } else {
                                                    $presentase_jumlah = 0;
                                                }
                                                echo round($presentase_jumlah, 1).'%';
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Hasil Ruangan</b></td>
                                            <td><?php echo $total_kurang_14_anak + $total_lebih_14_anak; ?></td>
                                            <td><?php 
                                                $total_anak = $total_kurang_14_anak + $total_lebih_14_anak;
                                                if($total_anak != 0) {
                                                    $presentase_anak = ($total_kurang_14_anak / $total_anak) * 100;
                                                } else {
                                                    $presentase_anak = 0;
                                                }
                                                echo round($presentase_anak, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_bedah + $total_lebih_14_bedah; ?></td>
                                            <td><?php 
                                                $total_bedah = $total_kurang_14_bedah + $total_lebih_14_bedah;
                                                if($total_bedah != 0) {
                                                    $presentase_bedah = ($total_kurang_14_bedah / $total_bedah) * 100;
                                                } else {
                                                    $presentase_bedah = 0;
                                                }
                                                echo round($presentase_bedah, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_bidan + $total_lebih_14_bidan; ?></td>
                                            <td><?php 
                                                $total_bidan = $total_kurang_14_bidan + $total_lebih_14_bidan;
                                                if($total_bidan != 0) {
                                                    $presentase_bidan = ($total_kurang_14_bidan / $total_bidan) * 100;
                                                } else {
                                                    $presentase_bidan = 0;
                                                }
                                                echo round($presentase_bidan, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_singgalang12 + $total_lebih_14_singgalang12; ?></td>
                                            <td><?php
                                                $total_singgalang12 = $total_kurang_14_singgalang12 + $total_lebih_14_singgalang12;
                                                if($total_singgalang12 != 0) {
                                                    $presentase_singgalang12 = ($total_kurang_14_singgalang12 / $total_singgalang12) * 100;
                                                } else {
                                                    $presentase_singgalang12 = 0;
                                                }
                                                echo round($presentase_singgalang12, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_singgalang3 + $total_lebih_14_singgalang3; ?></td>
                                            <td><?php
                                                $total_singgalang3 = $total_kurang_14_singgalang3 + $total_lebih_14_singgalang3;
                                                if($total_singgalang3 != 0) {
                                                    $presentase_singgalang3 = ($total_kurang_14_singgalang3 / $total_singgalang3) * 100;
                                                } else {
                                                    $presentase_singgalang3 = 0;
                                                }
                                                echo round($presentase_singgalang3, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_merapi1 + $total_lebih_14_merapi1; ?></td>
                                            <td><?php
                                                $total_merapi1 = $total_kurang_14_merapi1 + $total_lebih_14_merapi1;
                                                if($total_merapi1 != 0) {
                                                    $presentase_merapi1 = ($total_kurang_14_merapi1 / $total_merapi1) * 100;
                                                } else {
                                                    $presentase_merapi1 = 0;
                                                }
                                                echo round($presentase_merapi1, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_merapi2 + $total_lebih_14_merapi2; ?></td>
                                            <td><?php
                                                $total_merapi2 = $total_kurang_14_merapi2 + $total_lebih_14_merapi2;
                                                if($total_merapi2 != 0) {
                                                    $presentase_merapi2 = ($total_kurang_14_merapi2 / $total_merapi2) * 100;
                                                } else {
                                                    $presentase_merapi2 = 0;
                                                }
                                                echo round($presentase_merapi2, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_merapi3 + $total_lebih_14_merapi3; ?></td>
                                            <td><?php 
                                                $total_merapi3 = $total_kurang_14_merapi3 + $total_lebih_14_merapi3;
                                                if($total_merapi3 != 0) {
                                                    $presentase_merapi3 = ($total_kurang_14_merapi3 / $total_merapi3) * 100;
                                                } else {
                                                    $presentase_merapi3 = 0;
                                                }
                                                echo round($presentase_merapi3, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_limpapeh23 + $total_lebih_14_limpapeh23; ?></td>
                                            <td><?php
                                                $total_limpapeh23 = $total_kurang_14_limpapeh23 + $total_lebih_14_limpapeh23;
                                                if($total_limpapeh23 != 0) {
                                                    $presentase_limpapeh23 = ($total_kurang_14_limpapeh23 / $total_limpapeh23) * 100;
                                                } else {
                                                    $presentase_limpapeh23 = 0;
                                                }
                                                echo round($presentase_limpapeh23, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_limpapeh4 + $total_lebih_14_limpapeh4; ?></td>
                                            <td><?php
                                                $total_limpapeh4 = $total_kurang_14_limpapeh4 + $total_lebih_14_limpapeh4;
                                                if($total_limpapeh4 != 0) {
                                                    $presentase_limpapeh4 = ($total_kurang_14_limpapeh4 / $total_limpapeh4) * 100;
                                                } else {
                                                    $presentase_limpapeh4 = 0;
                                                }
                                                echo round($presentase_limpapeh4, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_icu + $total_lebih_14_icu; ?></td>
                                            <td><?php 
                                                $total_icu = $total_kurang_14_icu + $total_lebih_14_icu;
                                                if($total_icu != 0) {
                                                    $presentase_icu = ($total_kurang_14_icu / $total_icu) * 100;
                                                } else {
                                                    $presentase_icu = 0;
                                                }
                                                echo round($presentase_icu, 1).'%';
                                            ?></td>
                                            <td><?php echo $total_kurang_14_nicu + $total_lebih_14_nicu; ?></td>
                                            <td><?php 
                                                $total_nicu = $total_kurang_14_nicu + $total_lebih_14_nicu;
                                                if($total_nicu != 0) {
                                                    $presentase_nicu = ($total_kurang_14_nicu / $total_nicu) * 100;
                                                } else {
                                                    $presentase_nicu = 0;
                                                }
                                                echo round($presentase_nicu, 1).'%';
                                            ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('iri/riclaporan/excel_ketepatan_visite_imn/'.$date.'/'.$tampil); ?>" class="btn btn-danger" target="_blank">Excel</a>				
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