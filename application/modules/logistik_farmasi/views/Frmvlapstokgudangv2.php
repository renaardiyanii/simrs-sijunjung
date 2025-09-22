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
        $('#tanggal_laporan').daterangepicker({
            opens: 'left',
            format: 'DD/MM/YYYY',
            startDate: moment(),
            endDate: moment(),
        });
        $('#date_picker').hide();
        $('#date_picker_months').show();
        $('#date_picker_years').hide();
    });
    function download(){
        var filter = $("#filter").val();
        var gudang = $("#filter").text();
        var periode = $("#tampil_per").val();
        var valperiod = $("#tampil_per").val();

        swal({
                title: "Download?",
                text: "Download Laporan Stok Obat!",
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
                    window.open("<?php echo base_url('logistik_farmasi/Frmclaporan/download_stok_satelit')?>/"+filter+"/"+periode);
                } else {
                    swal("Close", "Tidak Jadi", "error");
                    document.getElementById("ok1").checked = false;
                }
            });


    }

    function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#cara_bayar').show();
			$('#date_picker').show();			
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
			$('#id_dokter').show();	
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
			$('#id_dokter').hide();	
		}else{
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
			$('#id_dokter').hide();	
		}
}
</script>

<section class="content-header">
    <?php //include('pend_cari.php');	?>


</section>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <?php echo $message_nodata; ?>
                <?php echo form_open('logistik_farmasi/Frmclaporan/download_laporan_stock');?>
                <form class="form-material m-t-40 row">
                    <div class="form-group col-md-4 m-t-10">
                        <label>Gudang</label>
                    </div>
                    <div class="form-group col-md-5 m-t-10">
                        <select name="filter" id="filter" class="form-control" style="width:50%" required="">
                            <option value="" selected="">---- Pilih Gudang ----</option>
                            <?php
                            foreach ($gudang as $row) {
                                echo "<option value=".$row->id_gudang.">".$row->nama_gudang."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>BULAN</label>
                    </div>

                    <div class="form-group row col-md-8">
                        
                        <!-- <div class="form-group col-md-5">
                            <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
                                <option value="" selected="">---- Pilih Periode ----</option>
                                <option value="TGL">Harian</option>
                                <option value="BLN">Bulanan</option>
                                <option value="THN">Tahunan</option>
                            </select>
                        </div> -->

                        <div class="form-group col-md-4">
                            <!-- <input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tgl" required> -->
                            <input type="month" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
                            <!-- <input type="number" min="<?php //echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun"> -->
					    </div>
                    </div>

                    <div class="form-group col-md-4 m-t-10">
                        <button class="btn btn-primary" type="submit">Download</button>
                    </div>
                   
                </form>
                <?php echo form_close();?>
            </div>
            <div class="card-block">
                <div class="modal-body">

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
