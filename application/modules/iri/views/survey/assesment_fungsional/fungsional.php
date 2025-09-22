<?php 
$this->load->view('layout/header_form');
?>

<?php 
// var_dump($form_a_evaluasi->formjson);
$resultAll_1 = isset($fungsional_iri)?$fungsional_iri->row():null;
?>

<div class="card m-5">
    <div class="body">
    <div id="surveyFungsional"></div>

    </div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonFungsional = <?php echo file_get_contents("fungsional.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyfungsional = new Survey.Model(surveyJsonFungsional);


    function sendDataToServerFungsional(survey) {
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_fungsional/')?>",
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

    <?php if($resultAll_1){ ?>
        surveyfungsional.data = <?= $resultAll_1->formjson ?>;
    <?php } ?>
  
    surveyfungsional.render("surveyFungsional");
    surveyfungsional
        .onComplete
        .add(function (result) {
            sendDataToServerFungsional(result);
        });
</script>