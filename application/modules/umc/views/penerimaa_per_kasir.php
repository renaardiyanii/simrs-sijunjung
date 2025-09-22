<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<script type='text/javascript'>
$(function() {
	 
	// $('#date_picker').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// });
	// $('#date_picker_months').datepicker({
	// 	format: "yyyy-mm",
	// 	endDate: "current",
	// 	autoclose: true,
	// 	todayHighlight: true,
	// 	viewMode: "months", 
	// 	minViewMode: "months",
	// }); 
	// $('#date_picker_years').datepicker({
	// 	format: "yyyy",
	// 	endDate: "current",
	// 	autoclose: true,
	// 	todayHighlight: true,
	// 	format: "yyyy",
	// 	viewMode: "years", 
	// 	minViewMode: "years",
	// });
	$('#date_picker').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();

	cb = "<?php echo $cara_bayar; ?>";	
	if(cb!=''){
		$('#cara_bayar').val(cb).change();
	}

	
});	

function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#cara_bayar').show();
			$('#date_picker').show();			
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
			$('#id_dokter').show();	
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
			$('#id_dokter').hide();	
		}else{
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
			$('#id_dokter').hide();	
		}
}	


</script>
	
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
			<?php echo form_open('umc/cumcicilan/penerimaan_perkasir');?>
				<div class="row p-t-20">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <select name="carabayar" id="carabayar" class="form-control">
                                    <option>-- Pilih Cara Bayar --</option>
                                    <option value="semua">SEMUA</option>
                                    <option value="TUNAI">TUNAI</option>
                                    <option value="BANK">BANK</option>
                                    <option value="VA">Virtual Account</option>
                                    <option value="PIUTANG/IKS">Piutang / Kerjasama</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <select name="jaminan" id="jaminan" class="form-control">
                                    <option value="">-- Pilih Jaminan --</option>
                                    <option value="UMUM">UMUM</option>
                                    <option value="BPJS">BPJS</option>
                                    <option value="KERJASAMA">KERJASAMA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <select name="user_kasir" id="user_kasir" class="form-control">
                                    <option value="">-- Pilih User Kasir --</option>
                                    <option value="semua">SEMUA</option>
                                    <?php
                                    foreach($user_kasir as $r) {
                                        echo '<option value="'.$r->username.'">'.$r->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Search</button>
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
					<h4 align="center">Laporan Penerimaan Per Kasir </h4></div>
						<div class="panel-body">
							<div style="display:block;overflow:auto;">
						
								<?php 
                                $subtotal_rj = 0;
                                $subtotal_ri = 0;
                                $subtotal_obat = 0;
                                $subtotal_non_pasien = 0;
								foreach($poli as $row1){ 
			
                                    $array = json_decode(json_encode($hasil), True);
                                    $data_poli=array_column($array, 'asal');
                                
                                    //Klo data tdk kosong, tampilkan
                                    if (in_array($row1->id_poli, $data_poli)) {	
                                ?>
                                    <h4><b>Poliklinik : <?php echo $row1->nm_poli ?></b></h4>
                                    <table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kasir</th>
                                                <th>No Kwitansi</th>
                                                <th>Jam</th>
                                                <th>No Register</th>
                                                <th>No MR</th>
                                                <th>Nama</th>
                                                <th>Jaminan</th>
                                                <th>Status</th>
                                                <th>Jenis Bayar</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            $subtotal = 0;
                                            foreach($hasil as $row2){
                                                if ($row2->asal==$row1->id_poli) {						
                                            ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row2->kasir; ?></td>
                                                <td><?php echo $row2->no_kwitansi;?></td>
                                                <td><?php echo date("H:i", strtotime($row2->tgl_cetak));?></td>
                                                <td><?php echo $row2->no_register; ?></td>
                                                <td><?php echo $row2->no_cm;?></td>						
                                                <td><?php echo $row2->nama;?></td>
                                                <td><?php echo $row2->cara_bayar;?></td>
                                                <td><?php 
                                                    if($row2->status == NULL) {
                                                        echo'';
                                                    } else {
                                                        echo $row2->status;
                                                    }
                                                ?></td>
                                                <td><?php echo $row2->jenis_bayar;?></td>
                                                <td><?php echo number_format($row2->tunai);?></td>
                                            </tr>
                                            <?php 
                                            if($row2->status == NULL) {
                                                $subtotal += $row2->tunai;
                                            } else if($row2->status == 'batal') {
                                                $subtotal += 0;
                                            }           
                                                }
                                            }
                                            $subtotal_rj += $subtotal;
                                            ?>
                                            <tr>
                                                <td colspan="10"><b>Subtotal</b></td>
                                                <td><?php echo number_format($subtotal); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>	
                                    <br/>
                                <?php 
                                    }
                                } ?>

                                <?php if($farmasi) { ?>
                                    <h4><b>Farmasi</b></h4>
                                    <table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kasir</th>
                                                <th>No Kwitansi</th>
                                                <th>Jam</th>
                                                <th>No Register</th>
                                                <th>No MR</th>
                                                <th>Nama</th>
                                                <th>Jaminan</th>
                                                <th>Status</th>
                                                <th>Jenis Bayar</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i = 1;
                                            foreach($farmasi as $obat) { ?>
                                                <tr>
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $obat->kasir; ?></td>
                                                    <td><?php echo $obat->no_kwitansi;?></td>
                                                    <td><?php echo date("H:i", strtotime($obat->tgl_cetak));?></td>
                                                    <td><?php echo $obat->no_register; ?></td>
                                                    <td><?php echo $obat->no_cm;?></td>						
                                                    <td><?php echo $obat->nama;?></td>
                                                    <td><?php echo $obat->cara_bayar;?></td>
                                                    <td><?php 
                                                        if($obat->status == NULL) {
                                                            echo'';
                                                        } else {
                                                            echo $obat->status;
                                                        }
                                                    ?></td>
                                                    <td><?php echo $obat->jenis_bayar;?></td>
                                                    <td><?php echo number_format($obat->tunai);?></td>
                                                </tr>
                                            <?php 
                                                if($obat->status == NULL) {
                                                    $subtotal_obat += $obat->tunai;
                                                } else {
                                                    $subtotal_obat += 0;
                                                } 
                                            } ?>
                                            <tr>
                                                <td colspan="10"><b>Subtotal</b></td>
                                                <td><?php echo number_format($subtotal_obat); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } ?>
		
								<?php if ($hasil_ri) { ?>
                                    <h4><b>Rawat Inap</b></h4>
                                    <table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kasir</th>
                                                <th>No Kwitansi</th>
                                                <th>Jam</th>
                                                <th>No Register</th>
                                                <th>No MR</th>
                                                <th>Nama</th>
                                                <th>Ruang</th>
                                                <th>Jaminan</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                                <th>Jenis Bayar</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $i = 1;
                                        foreach($hasil_ri as $iri) { 
                                            if($iri->status == NULL && $iri->keterangan == 'Sudah Cetak') {
                                                $subtotal_ri += $iri->tunai;
                                            } else if($iri->status != NULL || $iri->keterangan == 'Belum Cetak') {
                                                $subtotal_ri += 0;
                                            } 
                                            
                                            // if($iri->keterangan == 'Sudah Cetak') {
                                            //     $tunai = $iri->tunai;
                                            // } else {
                                                // $tunai = $this->get_grandtotal_all($iri->no_ipd);
                                                // $tunai = Modules::run('cumcicilan/get_grandtotal_all', $iri->no_ipd);
                                            // }
                                            ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $iri->kasir; ?></td>
                                                <td><?php echo $iri->no_kwitansi;?></td>
                                                <td><?php if($iri->tgl_cetak != NULL) {
                                                    echo date("H:i", strtotime($iri->tgl_cetak));
                                                } else {
                                                    echo '';
                                                } ?>
                                                </td>
                                                <td><?php echo $iri->no_ipd; ?></td>
                                                <td><?php echo $iri->no_cm;?></td>						
                                                <td><?php echo $iri->nama;?></td>
                                                <td><?php echo $iri->nmruang;?></td>
                                                <td><?php echo $iri->carabayar;?></td>
                                                <td><?php 
                                                    if($iri->status == NULL) {
                                                        echo'';
                                                    } else {
                                                        echo $iri->status;
                                                    }
                                                ?></td>
                                                <td><?php echo $iri->keterangan;?></td>
                                                <td><?php echo $iri->jenis_bayar;?></td>
                                                <td><?php echo number_format($iri->tunai);?></td>
                                            </tr>
                                        <?php } ?>
                                            <tr>
                                                <td colspan="12"><b>Subtotal</b></td>
                                                <td><?php echo number_format($subtotal_ri); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } ?>

                                <?php if ($non_pasien) { ?>
                                    <h4><b>Non Pasien</b></h4>
                                    <table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kasir</th>
                                                <th>Tindakan</th>
                                                <th>No Kwitansi</th>
                                                <th>No MR</th>
                                                <th>Nama</th>
                                                <th>Jenis Bayar</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $i = 1;
                                        foreach($non_pasien as $non) { 
                                            $tindakan = $this->Mumcicilan->get_tindakan_non_pasien($non->no_kwitansi)->result();?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $non->kasir; ?></td>
                                                <td><?php foreach($tindakan as $ib) {
                                                    echo $ib->item_bayar.'<br>';
                                                }
                                                ?></td>
                                                <td><?php echo $non->no_kwitansi;?></td>
                                                <td><?php echo $non->no_cm;?></td>						
                                                <td><?php echo $non->nama;?></td>
                                                <td><?php echo $non->method_pay;?></td>
                                                <td><?php echo number_format($non->jml);?></td>
                                            </tr>
                                        <?php 
                                            // if($iri->status == NULL) {
                                            //     $subtotal_ri += $iri->tunai;
                                            // } else if($iri->status == 'batal') {
                                            //     $subtotal_ri += 0;
                                            // }
                                            $subtotal_non_pasien += $non->jml;
                                        }
                                        ?>
                                            <tr>
                                                <td colspan="7"><b>Subtotal</b></td>
                                                <td><?php echo number_format($subtotal_non_pasien); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } ?>
									
								<h4><b>Total : <?php echo number_format($subtotal_rj + $subtotal_ri + $subtotal_non_pasien + $subtotal_obat); ?></b></h4>
							<div class="form-inline" align="right">
								<div class="form-group">
									<!--<a target="_blank" href="<?php // echo site_url('irj/rjclaporan/lap_kunj_poli/'.$tgl_awal.'/'.$tgl_akhir);?>"><input type="button" class="btn btn-primary" value="Cetak Detail"></a>-->
									<!-- <a target="_blank" href="<?php echo site_url('irj/rjccetaklaporan/pdf_lapkunj/'.$param);?>"><input type="button" class="btn 
									btn-primary" value="PDF"></a> -->
									<!-- <a href="<?php echo site_url('irj/rjclaporan/excel_lapkunj_irj/'.$param);?>"><input type="button" class="btn 
									" style="background-color: lime;color:white;" value="EXCEL"></a> -->
									&nbsp;
									<a href="<?php echo site_url('umc/cumcicilan/pdf_penerimaan_perkasir/'.$tgl.'/'.$carabayar.'/'.$user.'/'.$jaminan);?>" target="_blank"><input type="button" class="btn" style="background-color: red;color:white;" value="PDF"></a>
									&nbsp;
                                    <a href="<?php echo site_url('umc/cumcicilan/penerimaan_perkasir_excel/'.$tgl.'/'.$carabayar.'/'.$user.'/'.$jaminan);?>" target="_blank"><input type="button" class="btn" style="background-color: green;color:white;" value="EXCEL"></a>
									</div>
								<?php 
								//} 
								?>
						</div>							
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


<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});

var ajaxku;
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function ajaxdokter(id_poli){
	var id = id_poli.substr(0,4);
	var pokpoli = id_poli.substr(5);
	console.log(id_poli);
	console.log(id);
	console.log(pokpoli);

	var val_cara_bayar = $('#cara_bayar').val();
	var cara_kunjungan = $('#cara_kunjungan').val();
	//var res=id.split("-");//it Works :D

    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjclaporan/data_dokter_poli'); ?>";
    url=url+"/"+id;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	//document.getElementById("id_provinsi").value = res[0];
	//document.getElementById("provinsi").value = res[1];  
	
}

function stateChangedDokter(){
    var data;
	console.log(ajaxku.readyState);
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;	
		if(data.length>=0){
			document.getElementById("id_dokter").innerHTML = data;
		}
    }
}
stateChangedDokter();
</script>