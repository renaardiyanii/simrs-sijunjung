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
    });
    function download(){
        var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
        var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
        startDate = startDate.format('YYYY-MM-DD');
        endDate = endDate.format('YYYY-MM-DD');

        swal({
                title: "Download?",
                text: "Download Laporan Retur Pembelian Obat",
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
                    window.open("<?php echo base_url('logistik_farmasi/frmcretur/download_laporan_retur')?>/"+startDate+"/"+endDate);
                } else {
                    swal("Close", "Tidak Jadi", "error");
                    document.getElementById("ok1").checked = false;
                }
            });


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
                <form class="form-material m-t-40 row">
                    <div class="form-group col-md-10 m-t-10">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>&nbsp;&nbsp;
                            <input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
                        </div>
                    </div>
                        <div class="col-lg-2">
                            <span class="input-group-btn">
                                <!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
                                <button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>
                            </span>
                        </div>
                </form>
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
