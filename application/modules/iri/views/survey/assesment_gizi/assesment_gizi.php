<?php 
$this->load->view('layout/header_form');
?>

<div class="card m-5">
    <div class="body">
    <a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/assesment_gizi/'.$no_ipd) ?>" class="btn btn-primary">Lihat Assesment Gizi</a>
<div id="surveyassesmentgizi"></div>

    </div>
</div>

<script>
    Survey.StylesManager.applyTheme("modern");
    surveyassesmentgizijson = <?php echo file_get_contents("assesment_gizi.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyassesmentgizi = new Survey.Model(surveyassesmentgizijson);


    function sendDataToserverAssesmentGizi(survey) {
        
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_assesment_gizi/')?>",
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
                // new swal('Berhasil!','Data Berhasil Disimpan','success');
                location.reload();
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }
    surveyassesmentgizi.setValue('dignosis_medis',"<?= '('.$data_pasien[0]['diagmasuk'].') '.$data_pasien[0]['nm_diagmasuk'] ?>");
    <?php if(isset($assesment_gizi)){
        if($assesment_gizi){ ?>
        surveyassesmentgizi.data = <?= $assesment_gizi->formjson ?>;
    <?php }} ?>
    surveyassesmentgizi.render("surveyassesmentgizi");
    surveyassesmentgizi
        .onComplete
        .add(function (result) {
            sendDataToserverAssesmentGizi(result);
        });
</script>