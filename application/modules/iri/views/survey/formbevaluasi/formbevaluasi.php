<?php 
$this->load->view('layout/header_form');
?>

<div class="card m-5">
    <div class="body">
    <div id="surveyformbevaluasi"></div>

    </div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonFormB = <?php echo file_get_contents("formbevaluasi.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyFormB = new Survey.Model(surveyJsonFormB);


    function sendDataToServerFormB(survey) {
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/form_b_evaluasi/')?>",
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
    
    <?php if($form_b_evaluasi){ ?>
    surveyFormB.data = <?= $form_b_evaluasi->formjson ?>;
    <?php } ?>

    surveyFormB.render("surveyformbevaluasi");
    surveyFormB
        .onComplete
        .add(function (result) {
            sendDataToServerFormB(result);
        });
</script>