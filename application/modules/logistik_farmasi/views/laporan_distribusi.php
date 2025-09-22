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

        $('#tanggal_laporan').daterangepicker({
			autoUpdateInput: false,
			dateFormat:'YYYY-MM-DD',
			Format:'YYYY-MM-DD',
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('#tanggal_laporan').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
		});

		$('#tanggal_laporan').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});

    });
		

  
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="post" action="<?= base_url('logistik_farmasi/Frmclaporan/laporan_distribusi_obat') ?>">

                    <div class="form-group row">
                            <div class="col-md-4">
								<label>Tanggal</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control" id="tanggal_laporan" name="tanggal_laporan" autocomplete="off" placeholder="Pilih Tanggal">
								</div>    
							</div> 

                             <div class="col-md-4">
								<label>Tanggal</label>
								    <div class="input-group">
									        <select name="ruang" id="ruang" class="form-control">
                                                    <option value= "SEMUA">-- Pilih Ruang --</option>
                                                    <?php 
                                                
                                                    foreach($data_gudang as $gudang){
                                                        
                                                        ?>
                                                        <option value="<?php echo $gudang->id_gudang ?>"><?php echo $gudang->nama_gudang ?></option>
                                                    <?php }
                                                    ?>
                                            </select>
								    </div>    
							</div>    
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </span>
                        </div> 

                        <div class="col-md-2">
                            <a href="<?php echo site_url('logistik_farmasi/frmclaporan/excel_lap_distribusi/'.$tgl.'/'.$tgl1.'/'.$ruang);?>"><input type="button" class="btn 
                                " style="background-color: lime;color:white;" value="Excel"></a>
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
              
            </div>
        </div>
        <div class="card-block">
            <table class=" datatable table  table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Obat</th>
                    <th>Qty</th>
                    <th>Gudang</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $index=1; foreach ($data_stock as $val):?>
                      <tr>
                          <td><?= $index ?></td>
                          <td><?= date('d-m-Y',strtotime($val->tgl_amprah)) ?></td>
                          <td><?= $val->nm_obat ?></td>
                          <td><?= $val->qty_acc ?></td>
                          <td><?= $val->gudang ?></td>
                    </tr>
                         
                    <?php $index++; endforeach; ?>
                  </tbody>
                </table>        
        </div>
        </div>
    </div>
</div>

<?php

    $this->load->view("layout/footer_left");

?>
