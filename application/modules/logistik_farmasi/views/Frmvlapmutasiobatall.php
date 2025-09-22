<?php
    $this->load->view("layout/header_left");

?>
<style>
hr {
	border-color:#7DBE64 !important;
}

/* thead {
	/* background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important; */
/* }  */
</style>	

<script type='text/javascript'>
	$(document).ready(function () {
        var dataTable = $('#dataTables-example').DataTable( {
			
		});
        $('.datatable').DataTable({});
        //$('.datatables').DataTable();	
		$('#tgl').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment('<?= $tgl_awal ?>'),
          	endDate: moment('<?= $tgl_akhir ?>'),
		});
    $('#tabel_receiving').DataTable();
    });
	function download(){
		swal({
		  title: "Download?",
		  text: "Download !",
		  type: "warning",
		  showCancelButton: true,
	  	  showLoaderOnConfirm: false,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Ya!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('logistik_farmasi/frmclaporan/download_peneriamaan_obat/'.$supplier.'/'.$jenis.'/'.$jenis_obat.'/'.$tgl_awal.'/'.$tgl_akhir)?>");
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
	}	

    function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="post" action="<?= base_url('logistik_farmasi/Frmclaporan/lap_mutasi_obat_all') ?>">

                    <div class="row">

                            <div style="margin-left:10px;margin-right:10px;margin-top:5px">Tanggal :</div>

                            <div class="form-group col-md-3">
                                <input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
                            </div>

                            <div class="form-group col-md-3">
                                <input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
                            </div>        
                    </div>

                    <div class="row">

                    <div style="margin-left:10px;margin-right:10px;margin-top:5px">Kelompok :</div>                
                        <div class="form-group col-md-3">
                            <select name="kel" id="filter" class="form-control">
                                <option value="semua" selected="">---- Pilih Semua ----</option>
                                <?php foreach ($kel as $spl): ?>
                                <option value=<?= $spl->kode ?>><?= $spl->nm_kelompok ?></option>
                                <?php endforeach ?>
                            </select>
                    </div>
                    </div>

                    <div class="form-group col-md-2">
                       
                       <span class="input-group-btn">
                           <button class="btn btn-primary pull-right" type="submit">Lihat</button>
                       </span>
                   </div>   
                    
               
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
        <div class="card-header">
            <div class="row">
              <div class="col-xs-9" id="alertMsg">  
                    <?php echo $this->session->flashdata('alert_msg'); ?>
              </div>
            </div>
        </div>
        <div class="card-block">
        <div class="table-responsive col-sm-12">
            <table id="tabel_receiving" class="display nowrap table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>ED</th>
                      <th>Batch</th>
                      <th>Barang</th>
                      <th>Satuan</th>
                      <th>Satuan+ppn</th>
                      <th>SA GD</th>
                      <th>SA Neuro</th>
                      <th>SA B</th>
                      <th>SA C</th>
                      <th>SA RJ</th>
                      <th>SA Produksi</th>
                      <th>Total SA</th>
                      <th>Masuk GD</th>
                      <th>Masuk Neuro</th>
                      <th>Masuk B</th>
                      <th>Masuk C</th>
                      <th>Masuk RJ</th>
                      <th>Masuk Produksi</th>
                      <th>Total Masuk</th>
                      <th>keluar GD</th>
                      <th>keluar Neuro</th>
                      <th>keluar B</th>
                      <th>keluar C</th>
                      <th>keluar RJ</th>
                      <th>keluar Produksi</th>
                      <th>Total keluar</th>
                      <th>sisa GD</th>
                      <th>sisa Neuro</th>
                      <th>sisa B</th>
                      <th>sisa C</th>
                      <th>sisa RJ</th>
                      <th>sisa Produksi</th>
                      <th>Total sisa</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php $index=1; foreach ($lap_mutasi_obat_all as $val):?>
                        <tr>
                            <td><?= $index ?></td>
                            <td><?= $val->expire_date ?></td>
                            <td><?= $val->batch_no ?></td>
                            <td><?= $val->nm_obat ?></td>
                            <td><?= $val->satuan ?></td>
                            <td><?=$val->hargabeli?></td>
                            <td><?= $val->sa_farm ?></td>
                            <td><?= $val->sa_neuro ?></td>
                            <td><?= $val->sa_b ?></td>
                            <td><?= $val->sa_c ?></td>
                            <td><?= $val->sa_rj ?></td>
                            <td><?= $val->sa_pro ?></td>
                            <td><?= $val->sa_tot ?></td>
                            <td><?= $val->mafarm ?></td>
                            <td><?= $val->maneuro ?></td>
                            <td><?= $val->ma_b ?></td>
                            <td><?= $val->ma_c ?></td>
                            <td><?= $val->ma_rj ?></td>
                            <td><?= $val->ma_pro ?></td>
                            <td><?= '' ?></td>
                            <td><?= $val->ke_farm ?></td>
                            <td><?= $val->ke_neuro ?></td>
                            <td><?= $val->ke_b ?></td>
                            <td><?= $val->ke_c ?></td>
                            <td><?= $val->ke_rj ?></td>
                            <td><?= $val->ke_pro ?></td>
                            <td><?= '' ?></td>
                            <td><?= $val->sifarm ?></td>
                            <td><?= $val->si_neuro ?></td>
                            <td><?= $val->si_b ?></td>
                            <td><?= $val->si_c ?></td>
                            <td><?= $val->si_rj ?></td>
                            <td><?= $val->si_pro ?></td>
                            <td><?= '' ?></td>
                            

                          
                      <?php $index++; endforeach; ?>
                    </tbody>
            </table>    
            <a href="<?php echo site_url('logistik_farmasi/Frmclaporan/download_lap_mutasi_obat_all/'.$bulan_old.'/'.$tgl_awal.'/'.$tgl_akhir.'/'.$kelompok);?>">
                <input type="button" class="btn" style="background-color: lime;color:white;margin:5px" value="EXCEL"></a>   
        </div> 
        </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
    $('.datatable').DataTable({});
    $('#tabel_receiving').DataTable();
	});
</script>
<?php

    $this->load->view("layout/footer_left");

?>
