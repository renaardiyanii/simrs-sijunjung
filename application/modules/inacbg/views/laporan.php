<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
<script type='text/javascript'>
	$(document).ready(function () {
		$('#tgl').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment('<?= $tgl_awal ?>'),
          	endDate: moment('<?= $tgl_akhir ?>'),
		});
    $('.datatables').DataTable(); 
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
			window.open("<?php echo base_url('inacbg/klaim/lap_inacbg_excel/'.$tgl_awal.'/'.$tgl_akhir)?>");
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
                <form method="post" action="<?= base_url('inacbg/klaim/lap_inacbg') ?>">
                    <div class="row">
                    <div class="form-group col-md-3">
                        Periode
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="tgl" name="tgl">
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
            <div class="modal-body table-responsive">
                <table id="table" class="datatables display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                  <tr>
                    <th>No Regiter</th>
                    <th>Nama</th>
                    <th>No SEP</th>
                    <th>No Kartu</th>
                    <th>Jenis Rawat</th>
                    <th>Kelas</th>
                    <th>Diagnosa</th>
                    <th>Prosedur</th>
                    <th>Dokter</th>
                    <th>Tarif Grouper 1</th>
                    <th>Tarif Grouper 2</th>
                    <th>Jumlah</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($inacbgs as $inacbg){ ?>
                      <tr>
                          <td><?= $inacbg->no_register ?></td>
                          <td><?= $inacbg->nama_pasien ?></td>
                          <td><?= $inacbg->no_sep ?></td>
                          <td><?= $inacbg->nomor_kartu ?></td>
                          <td><?= $inacbg->jenis_rawat==2 ? 'IRJ' : 'IRI' ?></td>
                          <td><?= $inacbg->kelas_rawat ?></td>
                          <td><?= $inacbg->diagnosa ?> </td>
                          <td><?= $inacbg->procedure ?></td>
                          <td><?= $inacbg->nama_dokter ?></td>
                          <td><?= $inacbg->tarif_grouper1 ?></td>
                          <td><?= $inacbg->tarif_grouper2 ?></td>>
                          <td><?= $inacbg->tarif_grouper1 + $inacbg->tarif_grouper2?></td>>
                          <td><?= $inacbg->total_bayar ?></td>>
                          <th><a href="<?= base_url('inacbg/klaim/claim_print/'.$inacbg->no_sep) ?>" class="btn btn-primary">Detail</a></th>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>        
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
