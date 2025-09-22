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
			window.open("<?php echo base_url('logistik_farmasi/frmclaporan/download_peneriamaan_obat/'.$supplier.'/'.$jenis.'/'.$jenis_obat.'/'.$tgl_awal.'/'.$tgl_akhir)?>");
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
                            Supplier
                            <select name="supplier" id="filter" class="form-control">
                                <option value="" selected="">---- Pilih Semua ----</option>
                                <?php foreach ($suppliers as $spl): ?>
                                <option value="<?= $spl->id ?>" <?= $spl->id == $supplier ? 'selected' : ''?>><?= $spl->pbf ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
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
                            
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Faktur</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>PBF/Distributor</th>
                            <th>No PO</th>
                            <th>No DO</th>
                            <th>No Faktur</th>
                            <th>Produsen/Prinsipal</th>
                            <th>Nilai Faktur</th>
                            <th>Pembulatan Nilai Faktur</th>
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
                            <th>HNA+PPN (Besar)</th>
                            <th>HNA+PPN (Kecil)</th>
                            <th>Jumlah</th>
                        
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($penerimaan_obats as $penerimaan_obat){ ?>
                            <tr>
                                <th rowspan="<?= $penerimaan_obat->row ?>"><?= $penerimaan_obat->tanggal_masuk ?></th>
                                <th rowspan="<?= $penerimaan_obat->row ?>"><?= $penerimaan_obat->tanggal_faktur ?></th>
                                <th rowspan="<?= $penerimaan_obat->row ?>"><?= $penerimaan_obat->jatuh_tempo ?></th>
                                <th rowspan="<?= $penerimaan_obat->row  ?>"><?= $penerimaan_obat->distributor ?></th>
                                <th rowspan="<?= $penerimaan_obat->row  ?>"></th>
                                <th rowspan="<?= $penerimaan_obat->row  ?>"><?= $penerimaan_obat->no_do ?></th>
                                <th rowspan="<?= $penerimaan_obat->row  ?>"><?= $penerimaan_obat->no_faktur ?></th>
                                <th rowspan="<?= $penerimaan_obat->row  ?>"><?= $penerimaan_obat->produsen ?></th>
                                <th rowspan="<?= $penerimaan_obat->row  ?>"><?= $penerimaan_obat->nilaifaktur ?></th>
                                <th rowspan="<?= $penerimaan_obat->row  ?>"><?= $penerimaan_obat->nilaifakturpembulatan ?></th>
                            <?php foreach ($obats as $obat){ ?>
                                <?php if ($penerimaan_obat->no_faktur == $obat->no_faktur){ ?>
                                    <th><?= $obat->description ?></th> 
                                    <th><?= $obat->batch_no ?></th> 
                                    <th><?= $obat->expire_date ?></th> 
                                    <th><?= $obat->satuanb ?></th> 
                                    <th><?= $obat->satuank ?></th> 
                                    <th><?= $obat->faktor_satuan ?></th> 
                                    <th><?= $obat->qtybesar ?></th>
                                    <th><?= $obat->qtykecil ?></th>
                                    <th><?= $obat->hargabruto ?></th>
                                    <th><?= $obat->discount_percent ?> %</th>
                                    <th><?= $obat->hnappnbesar ?></th>
                                    <th><?= $obat->hnappnkecil ?></th>
                                    <th><?= $obat->jumlah ?></th>
                                </tr>
                                <?php } ?>
                            <?php } ?>
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
