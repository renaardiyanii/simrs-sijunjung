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
                <form method="post" action="<?= base_url('logistik_farmasi/Frmclaporan/lap_mutasi_obat') ?>">

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
                        <div style="margin-left:10px;margin-right:10px;margin-top:5px">Gudang :</div>                
                        <div class="form-group col-md-3">
                            <select name="gudang" id="filter" class="form-control">
                                <option value="semua" selected="">---- Pilih Semua ----</option>
                                <?php foreach ($gudang as $spl): ?>
                                <option value=<?= $spl->id_gudang ?>><?= $spl->nama_gudang ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div style="margin-left:10px;margin-right:10px;margin-top:5px">Kelompok :</div>                
                        <div class="form-group col-md-3">
                            <select name="kel" id="filter" class="form-control">
                                <option value="semua" selected="">---- Pilih Semua ----</option>
                                <?php foreach ($kel as $spl): ?>
                                <option value=<?= $spl->kode ?>><?= $spl->nm_kelompok ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                       
                            <span class="input-group-btn">
                                <button class="btn btn-primary pull-right" type="submit">Lihat</button>
                            </span>
                        </div>              
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
                <table class=" datatable table  table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">ED</th>
                            <th rowspan="2">Batch</th>
                            <th rowspan="2">Barang</th>
                            <th colspan="2" style="text-align:center">Harga</th>
                            <th rowspan="2">Stock Awal </th>
                            <th colspan="3" style="text-align:center">Masuk</th>
                            <th colspan="4" style="text-align:center">Keluar</th>
                            <th rowspan="2">Total Stock Akhir</th>
                            <th rowspan="2">Total Sisa</th>
                        </tr>
                        <tr>
                           
                            <th>Satuan</th>
                            <th>Satuan + PPN </th>
                            <th>GD</th>
                            <th>Mutasi</th>
                            <th>Total</th>
                            <th>Mutasi</th>
                            <th>Pemakaian</th>
                            <th>Expired</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index=1; foreach ($lap_mutasi_obat as $val):?>
                        <tr>
                            <td><?= $index ?></td>
                            <td><?= $val->expire_date ?></td>
                            <td><?= $val->batch_no ?></td>
                            <td><?= $val->nm_obat ?></td>
                            <td><?= $val->satuank ?></td>
                            <td><?= $val->hargabeli?></td>
                            <?php 
                            if($val->stock_awal != null or $val->stock_awal != ''){
                                $stok_awal = $val->stock_awal;
                            }else{
                                $stok_awal = 0;
                            }
                            
                            ?>
                            <td><?= $stok_awal ?></td>
                            <td><?= $val->masuk_gd ?></td>
                            <td><?= $val->masuk_mutasi ?></td>
                            <?php 
                            $tot_masuk = $val->masuk_gd + $val->masuk_mutasi;
                            ?>
                            <td><?= $tot_masuk ?></td>
                            <td><?= $val->keluar_mutasi ?></td>
                            <td><?= $val->keluar_pemakaian ?></td>
                            <td><?= $val->expire_date ?></td>
                            <?php 
                            $tot_keluar = $val->keluar_mutasi + $val->keluar_pemakaian;
                            ?>
                            <td><?= $tot_keluar ?></td>
                            <?php 
                            $st = $tot_masuk + $val->stock_awal;
                            $tot_sisa = $st + $tot_keluar;
                            ?>
                            <td><?= $tot_sisa ?></td>
                            <?php 
                            if($val->hargabeli != null && $tot_sisa != null){
                                $total_harga = (int)$val->hargabeli*(int)$tot_sisa;
                            }else{
                                $total_harga = 0;
                            }
                            
                            ?>
                            <td><?= $total_harga ?></td>
                        <?php $index++; endforeach; ?>
                    </tbody>
                </table>   
            </div>     
                <a href="<?php echo site_url('logistik_farmasi/Frmclaporan/download_lap_mutasi_obat/'.$tgl_awal.'/'.$tgl_akhir.'/'.$idgudang.'/'.$kelompok);?>">
                <input type="button" class="btn" style="background-color: lime;color:white;margin:5px" value="EXCEL"></a>
        </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
    $('.datatable').DataTable({});
	});
</script>
<?php

    $this->load->view("layout/footer_left");

?>
