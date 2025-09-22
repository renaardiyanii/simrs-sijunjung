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
        $('.datatables').DataTable();	
		$('#tgl').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment('<?= $tgl_awal ?>'),
      endDate: moment('<?= $tgl_akhir ?>'),
		});
    });
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">

              <form method="post" action="<?= base_url('logistik_farmasi/frmclaporan/laporan_distribusi') ?>">

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
                     <br>
                    <div class="form-group col-md-3">
                        Gudang Distribusi
                    <select name="gd_asal" id="gd_asal" class="form-control js-example-basic-single" required>
                        <?php
                          foreach($select_gudang0 as $row){
                            echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                          }
                        ?>
                        </select>
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
                            <a class="btn btn-primary pull-right" type="button" target="_blank" href="<?php echo base_url('farmasi/frmclaporan/pdf_obat_keluar/'.$tgl_awal.'/'.$tgl_akhir)?>">Cetak</a>
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
         <div class="panel-heading">     
                    <h4 align="center"><?php echo $date_title; ?></h4>
          </div>
        <div class="card-block">
            <div class="modal-body table-responsive">
                <table id="table" class="datatables display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Gudang Asal</th>
                    <th>Tujuan</th>
                    <th>Obat/Alkes</th>
                    <th>Satuan</th>
                    <th>QTY</th>
                  </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($distribusi as $row){ ?>
                      <tr>
                         <td><?= $row->tgl_amprah ?></td>
                         <td><?= $row->nama_gudang ?></td>
                         <td><?= $row->nm_jenis?></td>
                         <td><?= $row->nm_obat?></td>
                         <td><?= $row->satuank?></td>
                          <td><?= $row->qty_req?></td>
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
