<?php 
$this->load->view('layout/header_form');
?>

<div class="card m-5">
    <div class="body">
    <div id="surveyDekubitus"></div>

    </div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonDekubitus = <?php echo file_get_contents("dekubitus.json",FILE_USE_INCLUDE_PATH);?>;
    var surveydekubitus = new Survey.Model(surveyJsonDekubitus);


    function sendDataToServerDekubitus(survey) {
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_dekubitus/')?>",
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
  
    surveydekubitus.render("surveyDekubitus");
    surveydekubitus
        .onComplete
        .add(function (result) {
            sendDataToServerDekubitus(result);
        });
</script>