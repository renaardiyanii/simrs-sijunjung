<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    // $('.date_day_pickers').datepicker({
    //     format: "yyyy-mm-dd",
    //     autoclose: true,
    //     todayHighlight: true,
    //     minDate: '0'
    // });
    $('#example').DataTable();
    $('#date_picker_days').show();
    $('#date_picker_months').hide();
    $('#date_picker_years').hide();

    tablelaprange('','');

	var v00 = $("#formsearchlaprange").validate({
      rules: {
        tglawal: {
          required: true
        },
        tglakhir: {
          required: true
        }
      }, 
    highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
     errorElement: "span",
     errorClass: "help-block help-block-error",
     submitHandler: function(form) {
     		var tgl_awal = document.getElementById('tglawal').value;
     		var tgl_akhir = document.getElementById('tglakhir').value;
     		var tindak = document.getElementById('tindak').value;
     		var dokter = document.getElementById('dokter').value;
             $('#tgl_periksa').text('Laporan Pemeriksaan Radiologi Tanggal '+tgl_awal+' - '+tgl_akhir);
            tablelaprange(tgl_awal,tgl_akhir,tindak,dokter);
        }
    });

});

function tablelaprange(date0,date1,tindak,dokter){
	var url = "<?php echo site_url();?>rad/Radclaporan/showlap_pemeriksaan/";
	if(date0!='' && date1!=''){
		url = url+date0+"/"+date1+"/"+tindak+"/"+dokter;	
	}
	table = $('#laprad').DataTable({
        ajax: url,
        columns: [
            { data: "idtindakan" },
            { data: "tgl_kunjungan" },
            { data: "nmtindakan" },
            { data: "nm_dokter" },
            { data: "banyak" }
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
        /*,
        drawCallback: function ( data ) {
                //Make your callback here.
                console.log(data.aoData);
                alert(data);
                return data;
            }*/               
    	});	
}

function down_excel(){
	var date0 = document.getElementById('tglawal').value;
    var date1 = document.getElementById('tglakhir').value;
     		var tindak = document.getElementById('tindak').value;
     		var dokter = document.getElementById('dokter').value;
    if(date0=='' && date1==''){
		window.open('<?php echo site_url('rad/Radclaporan/excel_lappemeriksaan');?>/', '_blank'); 
    }else{    	
    	window.open('<?php echo site_url('rad/Radclaporan/excel_lappemeriksaan');?>/'+date0+"/"+date1+"/"+tindak+"/"+dokter, '_blank');    
    }
}

function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			//alert("tgl");
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker_days").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			//$('#date_picker_days').datepicker("setDate", "0");
			$('#date_picker_days').show();
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			//alert("bln");
			document.getElementById("date_picker_days").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker_days").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker_days').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			//alert("thn");
			var tgl1 = new Date().getFullYear();
			document.getElementById("date_picker_days").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_days").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker_days').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}
</script>
<style>
hr {
	border-color:#7DBE64 !important;
}

/* thead {
	background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
} */
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('rad/Radclaporan/lap_pemeriksaan');?>
                    <div class="row p-t-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="TGL">Tanggal</option>
                                    <option value="BLN">Bulan</option>
                                    <option value="THN">Tahun</option>
                                </select>
                            </div>
                        </div>											
                        <div class="col-md-3">
                            <div class="form-group">
                                <div id="date_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required >	
                                </div>
                                <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                </div>
                                <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>
                <!-- <form class="form-horizontal" method="POST" id="formsearchlaprange">
                    <div class="col-sm-12" >
                        <div class="form-group row">
                            <div>
                                <input type="date" id="tglawal" class="form-control date_day_pickers" placeholder="Tanggal Awal" name="date0" required>&nbsp;
                            </div>
                            <div >	
                                <input type="date" id="tglakhir" class="form-control date_day_pickers" placeholder="Tanggal Akhir" name="date1" required>
                            </div>
                            <div>	
                                <select name="tindak" id="tindak" class="form-control">
                                    <option>--Pilih Tindakan--</option>
                                    <option value="semua">SEMUA</option>
                                    <?php foreach ($tindakan as $row) { ?>
                                        <option value="<?php echo $row->idtindakan ?>"><?php echo $row->nmtindakan ?></option>                
                                    <?php } ?>
                                </select>
                            </div> -->
                            <!-- <div>	
                                <select name="dokter" id="dokter" class="form-control">
                                    <option>--Pilih Dokter--</option>
                                    <option value="semua">SEMUA</option>
                                    <?php foreach ($dokter as $row) { ?>
                                        <option value="<?php echo $row->id_dokter ?>"><?php echo $row->nm_dokter ?></option>                
                                    <?php } ?>
                                </select>
                            </div> -->
                            <!-- <div>
                                    <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </div>                                
                    </div>                              
                </form>  -->
					
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
					<h4 align="center" id="tgl_periksa">Laporan Pemeriksaan Radiologi Hari Ini</h4></div>					
                    <div class="panel-body">
                        
                                <table id="example" class="table display table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <!-- <th>Tanggal</th> -->
                                            <th>Nama Tindakan</th>
                                            <th>dr. Widya Sp.Rad</th>
                                            <th>dr. Rommy Sp.Rad</th>
                                            <th>Belum Diisi</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1;
                                            foreach($data_pemeriksaan as $r) {
                                            $total = $r->drwidya + $r->dromy + $r->kosong;
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $r->jenis_tindakan; ?></td>
                                            <td><?php echo $r->drwidya; ?></td>
                                            <td><?php echo $r->dromy; ?></td>
                                            <td><?php echo $r->kosong; ?></td>
                                            <td><?php echo $total; ?></td>
                                        </tr>
                                        <?php } ?>						
                                    </tbody>
                                </table>
                            <?php if($tampil == '') { ?>
                                <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$today.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a>
                            <?php } else if($tampil == 'TGL') { ?>
                                <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$tgl.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a>
                            <?php } else if($tampil == 'BLN') { ?>
                                <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$bln.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a>
                            <?php } else if($tampil == 'THN') { ?>
                                <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$thn.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a>
                            <?php } ?>
                    </div>							
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