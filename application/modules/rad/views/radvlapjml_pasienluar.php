<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#date_picker_days').show();
	$('#date_picker_months').hide();
    $('#example').DataTable();
});

function cek_tampil_per(val) {
    if(val == 'Tanggal') {
        document.getElementById("date_picker_months").value = '';
		document.getElementById("date_picker_days").required = true;
		document.getElementById("date_picker_months").required = false;
		$('#date_picker_days').show();			
		$('#date_picker_months').hide();
    } else if(val == 'Bulan') {
        document.getElementById("date_picker_days").value = '';
		document.getElementById("date_picker_months").required = true;
		document.getElementById("date_picker_days").required = false;
		$('#date_picker_days').hide();			
		$('#date_picker_months').show();
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
                <?php echo form_open('rad/radclaporan/lapjml_pasien_luar');?>
                    <div class="row p-t-0">		
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="tipe" id="tipe" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="Tanggal">Harian</option>
                                    <option value="Bulan">Bulanan</option>
                                </select>
                            </div>
                        </div>						
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date">	
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="month">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" id="btncari" type="submit">Search</button>
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
					<h4 align="center">Laporan Jumlah Pasien Luar <?php echo $tipe;?><b> <?php echo $judul;?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th rowspan = "2">No.</th>
                                        <th rowspan = "2">Pemeriksaan</th>
                                        <th colspan = "6">dr. Rommy Sp.Rad</th>
                                        <th rowspan = "2">dr. Rommy Sp.Rad Total</th>
                                        <th colspan = "6">dr. Widya Sp.Rad</th>
                                        <th rowspan = "2">dr. Widya Sp.Rad Total</th>
                                        <th colspan = "6">(Blank)</th>
                                        <th rowspan = "2">(Blank) Total</th>
                                        <th rowspan = "2">Grand Total</th>
                                    </tr>                              
                                    <tr>
                                        <th>BPJS - Mandiri</th>
                                        <th>RS Ahmad Mochtar</th>
                                        <th>RS Adnan WD Payakumbuh</th>
                                        <th>RS Madina</th>
                                        <th>RST Bukittinggi</th>
                                        <th>(Blank)</th>
                                        <th>BPJS - Mandiri</th>
                                        <th>RS Ahmad Mochtar</th>
                                        <th>RS Adnan WD Payakumbuh</th>
                                        <th>RS Madina</th>
                                        <th>RST Bukittinggi</th>
                                        <th>(Blank)</th>
                                        <th>BPJS - Mandiri</th>
                                        <th>RS Ahmad Mochtar</th>
                                        <th>RS Adnan WD Payakumbuh</th>
                                        <th>RS Madina</th>
                                        <th>RST Bukittinggi</th>
                                        <th>(Blank)</th>
                                    </tr>         
                                </thead>
                                <tbody id="tbodyexample">
                                    <?php
                                    $i = 1;
                                    $total_drommy_bpjs_mandiri = 0;
                                    $total_drommy_rsam = 0;
                                    $total_drommy_rs_payakumbuh = 0;
                                    $total_drommy_madina = 0;
                                    $total_drommy_rst = 0;
                                    $total_drommy_blank = 0;
                                    $total_drwid_bpjs_mandiri = 0;
                                    $total_drwid_rsam = 0;
                                    $total_drwid_rs_payakumbuh = 0;
                                    $total_drwid_madina = 0;
                                    $total_drwid_rst = 0;
                                    $total_drwid_blank = 0;
                                    $total_blank_bpjs_mandiri = 0;
                                    $total_blank_rsam = 0;
                                    $total_blank_rs_payakumbuh = 0;
                                    $total_blank_madina = 0;
                                    $total_blank_rst = 0;
                                    $total_blank_blank = 0;
                                    $grtotal_drommy = 0;
                                    $grtotal_drwid = 0;
                                    $grtotal_blank = 0;
                                    $total = 0;
                                    
                                    foreach($pasien_luar as $row) { 
                                        $total_drommy = $row->drommy_bpjs_mandiri + $row->drommy_rsam + $row->drommy_rs_payakumbuh + $row->drommy_madina + $row->drommy_rst + $row->drommy_blank;
                                        $total_drwid = $row->drwid_bpjs_mandiri + $row->drwid_rsam + $row->drwid_rs_payakumbuh + $row->drwid_madina + $row->drwid_rst + $row->drwid_blank;
                                        $total_blank = $row->blank_bpjs_mandiri + $row->blank_rsam + $row->blank_rs_payakumbuh + $row->blank_madina + $row->blank_rst + $row->blank_blank; ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row->jenis_tindakan;?></td>
                                            <td><?php echo $row->drommy_bpjs_mandiri;
                                                $total_drommy_bpjs_mandiri += $row->drommy_bpjs_mandiri;?></td>
                                            <td><?php echo $row->drommy_rsam;
                                                $total_drommy_rsam += $row->drommy_rsam;?></td>
                                            <td><?php echo $row->drommy_rs_payakumbuh;
                                                $total_drommy_rs_payakumbuh += $row->drommy_rs_payakumbuh;?></td>
                                            <td><?php echo $row->drommy_madina;
                                                $total_drommy_madina += $row->drommy_madina;?></td>
                                            <td><?php echo $row->drommy_rst;
                                                $total_drommy_rst += $row->drommy_rst;?></td>
                                            <td><?php echo $row->drommy_blank;
                                                $total_drommy_blank += $row->drommy_blank;?></td>
                                            <td><?php echo $total_drommy;
                                                $grtotal_drommy += $total_drommy;?></td>
                                            <td><?php echo $row->drwid_bpjs_mandiri;
                                                $total_drwid_bpjs_mandiri += $row->drwid_bpjs_mandiri;?></td>
                                            <td><?php echo $row->drwid_rsam;
                                                $total_drwid_rsam += $row->drwid_rsam;?></td>
                                            <td><?php echo $row->drwid_rs_payakumbuh;
                                                $total_drwid_rs_payakumbuh += $row->drwid_rs_payakumbuh;?></td>
                                            <td><?php echo $row->drwid_madina;
                                                $total_drwid_madina += $row->drwid_madina;?></td>
                                            <td><?php echo $row->drwid_rst;
                                                $total_drwid_rst += $row->drwid_rst;?></td>
                                            <td><?php echo $row->drwid_blank;
                                                $total_drwid_blank += $row->drwid_blank;?></td>
                                            <td><?php echo $total_drwid;
                                                $grtotal_drwid += $total_drwid;?></td>
                                            <td><?php echo $row->blank_bpjs_mandiri;
                                                $total_blank_bpjs_mandiri += $row->blank_bpjs_mandiri;?></td>
                                            <td><?php echo $row->blank_rsam;
                                                $total_blank_rsam += $row->blank_rsam;?></td>
                                            <td><?php echo $row->blank_rs_payakumbuh;
                                                $total_blank_rs_payakumbuh += $row->blank_rs_payakumbuh;?></td>
                                            <td><?php echo $row->blank_madina;
                                                $total_blank_madina += $row->blank_madina;?></td>
                                            <td><?php echo $row->blank_rst;
                                                $total_blank_rst += $row->blank_rst;?></td>
                                            <td><?php echo $row->blank_blank;
                                                $total_blank_blank += $row->blank_blank;?></td>
                                            <td><?php echo $total_blank;
                                                $grtotal_blank += $total_blank;?></td>
                                            <td><?php echo $total_drommy + $total_drwid + $total_blank;
                                            $total += $total_drommy + $total_drwid + $total_blank;?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan = "2"><b>Grand Total</b></td>
                                        <td><?php echo $total_drommy_bpjs_mandiri;?></td>
                                        <td><?php echo $total_drommy_rsam;?></td>
                                        <td><?php echo $total_drommy_rs_payakumbuh;?></td>
                                        <td><?php echo $total_drommy_madina;?></td>
                                        <td><?php echo $total_drommy_rst;?></td>
                                        <td><?php echo $total_drommy_blank;?></td>
                                        <td><?php echo $grtotal_drommy;?></td>
                                        <td><?php echo $total_drwid_bpjs_mandiri;?></td>
                                        <td><?php echo $total_drwid_rsam;?></td>
                                        <td><?php echo $total_drwid_rs_payakumbuh;?></td>
                                        <td><?php echo $total_drwid_madina;?></td>
                                        <td><?php echo $total_drwid_rst;?></td>
                                        <td><?php echo $total_drwid_blank;?></td>
                                        <td><?php echo $grtotal_drwid;?></td>
                                        <td><?php echo $total_blank_bpjs_mandiri;?></td>
                                        <td><?php echo $total_blank_rsam;?></td>
                                        <td><?php echo $total_blank_rs_payakumbuh;?></td>
                                        <td><?php echo $total_blank_madina;?></td>
                                        <td><?php echo $total_blank_rst;?></td>
                                        <td><?php echo $total_blank_blank;?></td>
                                        <td><?php echo $grtotal_blank;?></td>
                                        <td><?php echo $total;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('rad/radclaporan/excel_lapjml_pasien_luar/'.$tipe.'/'.$date); ?>" class="btn btn-danger" target="_blank">Excel</a>				
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