<?php 
$this->load->view('layout/header_form');
?>

<div class="card m-5">
    <div class="body">
    <div id="surveyformRekonsiliasi"></div>

    </div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonFormRekonsiliasi = <?php echo file_get_contents("rekonsiliasi_obat.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyFormRekonsiliasi = new Survey.Model(surveyJsonFormRekonsiliasi);


    function sendDataToServerRekonsiliasi(survey) {
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/rekonsiliasi_obat/')?>",
            type : 'POST',
            data : {
                no_ipd:'<?php echo $no_ipd ;?>',
                formjson: JSON.stringify(survey.data),
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
                // new swal('Berhasil!','Data Berhasil Disimpan','success');
                location.reload();
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }

    <?php if(isset($rekonsiliasi_obat)){
        if($rekonsiliasi_obat){ ?>
        surveyFormRekonsiliasi.data = <?= isset($rekonsiliasi_obat->formjson)?$rekonsiliasi_obat->formjson:''; ?>
    <?php }} ?>

    
   
    surveyFormRekonsiliasi.render("surveyformRekonsiliasi");
    surveyFormRekonsiliasi
        .onComplete
        .add(function (result) {
            sendDataToServerRekonsiliasi(result);
        });
</script>