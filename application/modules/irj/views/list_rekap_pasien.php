<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
    $('#date_picker_days').show();
	

    $('#detailModal').on('shown.bs.modal', function(e) {
         //get data-id attribute of the clicked element

        var no_register = $(e.relatedTarget).data('id');
        //tableDetail.clear().draw();
        $.ajax({
            dataType: "json",
            type: 'POST',
            data: {no_register:no_register},
            url: "<?php echo site_url(); ?>rad/radclaporan/get_detail_bhp_rad",
            success: function( response ) {
                tableDetail.clear().draw();
                tableDetail.rows.add(response.data);
                tableDetail.columns.adjust().draw();

                $("#total_rekap").html(response.total);
            }
        });
    });

    tableDetail = $('#tableDetail').DataTable({
            columns: [
                { data: "no_register" },
                { data: "jenis_tindakan" },
                { data: "nama_bhp" },
                { data: "satuan" },
                { data: "kategori" },
                { data: "qty" }
            ],
            columnDefs: [
                { targets: [ 0 ], orderable: false },
                { targets: [ 1 ], orderable: false },
                { targets: [ 2 ], orderable: false },
                { targets: [ 3 ], orderable: false },
                { targets: [ 4 ], orderable: false },
                { targets: [ 5 ], orderable: false }
            ],
            bFilter: false,
            bPaginate: true,
            destroy: true
        });
});

function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			$('#date_picker_days').show();
		//	$('#date_picker_months').hide();
			$('#date_picker_months').hide();
		//	$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			$('#date_picker_months').show();
			$('#date_picker_days').hide();
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
                <?php echo form_open('irj/rjclaporan/list_rekap');?>
                    
                    <div class="row p-t-0">
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="TGL">Tanggal</option>  -->
                                    <!-- <option value="BLN">Bulan</option> -->
                                    <!-- <option value="THN">Tahun</option> -->
                                <!-- </select>
                            </div>
                        </div>								 -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <!-- <div id="date_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required > -->
                                    <!-- <input type="date" id="date_picker_days2" class="form-control" placeholder="Tanggal Awal" name="date_picker_days2" required >		 -->
                                <!-- </div> -->
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date_picker_days">	
                                </div>
                                <!-- <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div> -->
                            </div>
                        </div>	
                        <!--<div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input"> -->
                                    <!-- <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required > -->
                                    <!-- <input type="date" id="date_picker_days2" class="form-control" placeholder="Tanggal Awal" name="date_picker_days2" required >		
                                </div> -->
                                <!-- <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                </div>
                                <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div> -->
                            <!-- </div>
                        </div> -->
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


</section>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">List Rekap Pasien Rawat Jalan</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Register</th>
                                            <th>Tanggal Kunjungan</th>
                                            <th>No MR</th>
                                            <th>Nama</th>
                                            <th>Penjamin</th>
                                            <th>Poli</th>
                                            <th>Aksi</th>
                                        </tr>                                       
                                    </thead>
                                    <tbody id="tbodyexample">
                                        <?php 
                                        $i = 1;
                                        foreach($list_rekap as $row) { 
                                        ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row->no_register;?></td>
                                                <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan));?></td>
                                                <td><?php echo $row->no_cm;?></td>
                                                <td><?php echo $row->nama;?></td>
                                                <td><?php echo $row->cara_bayar;?></td>
                                                <td><?php echo $row->nm_poli;?></td>
                                                <td>
                                                    <a href="<?php echo site_url(); ?>irj/rjclaporan/cetak_rekap_pasien/<?php echo $row->no_register ?>" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-plusthick"></i>Cetak Rekap</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>	
                    <?php 
                    ?>		
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