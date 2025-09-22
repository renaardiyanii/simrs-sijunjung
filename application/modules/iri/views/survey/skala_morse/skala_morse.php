<?php 
$this->load->view('layout/header_form');
?>

<div class="card m-5">
    <div class="body">
    <div id="surveySkalaMorse"></div>

    </div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonSkalaMorse = <?php echo file_get_contents("skala_morse.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyskalamorse = new Survey.Model(surveyJsonSkalaMorse);


    function sendDataToServerskalamorse(survey) {
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_skala_morse/')?>",
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
  
    surveyskalamorse.render("surveySkalaMorse");
    surveyskalamorse
        .onComplete
        .add(function (result) {
            sendDataToServerskalamorse(result);
        });
</script>