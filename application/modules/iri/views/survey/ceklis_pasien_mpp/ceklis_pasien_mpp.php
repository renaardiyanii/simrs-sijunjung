<?php 
$this->load->view('layout/header_form');
?>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

<div class="card m-5">
    <div class="body">
    <a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/ceklis_pasien_mpp/'.$no_ipd) ?>" class="btn btn-primary">Lihat Ceklis Pasien</a>
    <div id="surveyCeklisPasienMpp"></div>

    </div>
</div>

<script>
    Survey.StylesManager.applyTheme("modern");
    surveyCeklisPasienMppjson = <?php echo file_get_contents("ceklis_pasien_mpp.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyCeklisPasienMpp = new Survey.Model(surveyCeklisPasienMppjson);


    function sendDataToCeklisPasienMpp(survey) {
        
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_ceklis_pasien_mpp/')?>",
            type : 'POST',
            data : {
                no_ipd:'<?php echo $no_ipd ;?>',
                formjson: JSON.stringify(survey.data)
            },
            datatype:'json',
        
            beforeSend:function()
            {
            },      
            complete:function()
            {
            //stopPreloader();
            },
            success:function(data)
            {
                new swal('Berhasil!','Data Berhasil Disimpan','success');
                location.reload();
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }

    <?php
    if(isset($ceklis_pasien_mpp)){
        if($ceklis_pasien_mpp){
    ?>
    surveyCeklisPasienMpp.data = <?= $ceklis_pasien_mpp->formjson ?>;
    <?php }} ?>
    surveyCeklisPasienMpp.render("surveyCeklisPasienMpp");
    surveyCeklisPasienMpp
        .onComplete
        .add(function (result) {
            sendDataToCeklisPasienMpp(result);
        });
</script>