<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
<style>
hr {
	border-color:#7DBE64 !important;
}

thead {
	background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}
</style>	

<script type='text/javascript'>
	$(document).ready(function () {
        $('#example').DataTable();
        $('.datatables').DataTable();	
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
			window.open("<?php echo base_url('logistik_farmasi/frmclaporan/download_penerimaan_obat_by_faktur/'.$status.'/'.$jenis_obat.'/'.$verif.'/'.$tgl_awal.'/'.$tgl_akhir)?>");
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
	}	
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
                <div class="card-header">
                    <form method="post" action="<?= base_url('logistik_farmasi/Frmclaporan/penerimaan_obat') ?>">
                    <div class="row">
                        <div class="form-group col-md-3">
                            Jenis Pembelian
                            <select name="id_jenis" id="filter" class="form-control">
                                <option value="" selected="">---- Pilih Semua ----</option>
                                <?php foreach ($jenis_obats as $jns): ?>
                                <option value="<?= $jns->nm_jenis ?>" <?= $jns->nm_jenis == $jenis_obat ? 'selected' : ''?>><?= $jns->nm_jenis ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            Status Penerimaan
                            <select name="status" id="filter" class="form-control">
                                <option value="" selected="">---- Pilih Semua ----</option>
                                <option value="Beli sendiri">Beli Sendiri</option>
                                <option value="Konsinyasi">Konsinyasi</option>
                                <option value="Pinjam Barang">Pinjam Barang</option>
                                <option value="mengembalikan_barang">Mengembalikan Barang</option>
                                <option value="Hibah">Hibah</option>
                               
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            Verifikasi
                            <select name="verif" id="filter" class="form-control">
                                <option value="" selected="">---- Pilih Semua ----</option>
                                <option value="penerima">Penerima</option>
                                <option value="gudang">Gudang</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            Tanggal awal
                                <input type="date" id="date_picker" class="form-control" placeholder="Masukin Periode Awal" name="tanggal_awal" required>
                        </div>

                        <div class="form-group col-md-3">
                            Tanggal Akhir
                                <input type="date" id="date_picker" class="form-control" placeholder="Masukin Periode akhir" name="tanggal_akhir" required>
                        </div>
                    </div>


                    <div class="form-group col-md-2">
                        <br>
                        <span class="input-group-btn">
                            <button class="btn btn-primary pull-right" type="submit">Lihat</button>
                        </span>
                    </div>
                    <div class="form-group col-md-2">
                        <br>
                        <span class="input-group-btn">
                            <button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>
                        </span>
                    </div>
                    </form>
                </div>
                    
                <div class="">
                    <div class="row">
                        <div class="col-xs-9" id="alertMsg">  
                            <?php echo $this->session->flashdata('alert_msg'); ?>
                        </div>
                    </div>
                    <div class="table-responsive col-sm-12">
                        <table id="example" class="display" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID Penerima</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Faktur</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>PBF/Distributor</th>
                            <th>No PO</th>
                            <th>No DO</th>
                            <th>No Faktur</th>
                            <th>Nilai Faktur</th>
                            <th>Pembulatan Nilai Faktur</th>
                            <th>Produsen/Prinsipal</th>
                            <th>Nama Barang</th>
                            <th>Batch</th>
                            <th>ED</th>
                            <th>Satuan Besar</th>
                            <th>Satuan Kecil</th>
                            <th>Faktor Satuan</th>
                            <th>Qty Besar</th>
                            <th>Qty Kecil</th>
                            <th>Harga Bruto</th>
                            <th>Disc</th>
                            <th>HNA</th>
                            <th>HNA+PPN (Besar)</th>
                            <th>HNA+PPN (Kecil)</th>
                            <th>Jumlah HNA</th>
                            <th>Jumlah PPN 11%</th>
                            <th>Jumlah</th>
                           
                        
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($penerimaan_obats as $penerimaan_obat){ ?>
                            <tr>
                                <th rowspan="<?= $penerimaan_obat->jml ?>"><?= $penerimaan_obat->receiving_id ?></th>
                                <th rowspan="<?= $penerimaan_obat->jml ?>"><?= $penerimaan_obat->tgl_masuk ?></th>
                                <th rowspan="<?= $penerimaan_obat->jml ?>"><?php if($penerimaan_obat->tgl_faktur == null){echo $penerimaan_obat->tgl_do;}else{echo $penerimaan_obat->tgl_faktur;} ?></th>
                                <th rowspan="<?= $penerimaan_obat->jml ?>"><?= $penerimaan_obat->jatuh_tempo ?></th>
                                <th rowspan="<?= $penerimaan_obat->jml ?>"><?= $penerimaan_obat->distributor ?></th>
                                <th rowspan="<?= $penerimaan_obat->jml ?>"></th>
                                <th rowspan="<?= $penerimaan_obat->jml ?>"><?= $penerimaan_obat->no_do ?></th>
                                <th rowspan="<?= $penerimaan_obat->jml ?>"><?= $penerimaan_obat->no_faktur ?></th>
                                <th rowspan="<?= $penerimaan_obat->jml  ?>"><?= $penerimaan_obat->total_price_awal ?></th>
                                <th rowspan="<?= $penerimaan_obat->jml  ?>"><?= $penerimaan_obat->total_price ?></th>
                                    <?php 
                                    foreach ($obats as $val){
                                        if($val->id == $penerimaan_obat->receiving_id){ ?>
                                            <th><?= $val->produsen ?></th>
                                            <th><?= $val->nama_obat ?></th>
                                            <th><?= $val->batch_no ?></th>
                                            <th><?= $val->expire_date ?></th>
                                            <th><?= $val->satuank ?></th>
                                            <th><?= $val->satuanb ?></th>
                                            <th><?= $val->faktor_satuan ?></th>
                                            <th><?= $val->qtyb ?></th>
                                            <th><?= $val->qtyk ?></th>
                                            <th><?= $val->harga_bruto ?></th>
                                            <th><?= $val->discount_percent.'%' ?></th>
                                            <?php 
                                            $hna = $val->harga_bruto - $val->harga_diskon;
                                            ?>
                                            <th><?= $hna ?></th>
                                            <th><?= $val->hnappnbesar ?></th>
                                            <th><?= $val->hnappnkecil ?></th>
                                            <?php 
                                            $jml_hna = $val->harga_bruto - $val->harga_diskon;
                                            ?>
                                            <th><?= $jml_hna ?></th>
                                            <?php 
                                            $jml_ppn = 0.11 * $jml_hna;
                                            ?>
                                            <th><?= $jml_ppn ?></th>
                                            <th><?= $jml_hna + $jml_ppn  ?></th>
                                      </tr>
                                      <?php  }
                                    }
                                ?>

                               
                            
                            <?php } ?>
                        </tbody>
                        </table>        
                    </div>
                </div>

            
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
        $('#example').DataTable();
    });
</script>
<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>
