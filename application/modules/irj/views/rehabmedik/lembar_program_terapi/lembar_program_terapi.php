<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<a target="_blank" href="#" class="btn btn-primary">Lihat Lembar Program Terapi</a>

<div id="surveyLembarProgramTerapi"></div>
<script>
    Survey.StylesManager.applyTheme("modern");
    surveyLembarProgramTerapijson = <?php echo file_get_contents("form_lembar_program_terapi.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyLembarProgramTerapi = new Survey.Model(surveyLembarProgramTerapijson);


    function sendDataToLembarProgramTerapi(survey) {
        console.log(JSON.stringify(survey.data))
        // $.ajax({
        //     url: "<?php echo base_url('iri/rictindakan/insert_lembar_program_terapi/')?>",
        //     type : 'POST',
        //     data : {
        //         no_register:'',
        //         formjson: JSON.stringify(survey.data),
        //     },
        //     datatype:'json',
        
        //     beforeSend:function()
        //     {
        //     },      
        //     complete:function()
        //     {
        //     //stopPreloader();
        //     },
        //     success:function(data)
        //     {
        //         new swal('Berhasil!','Data Berhasil Disimpan','success');
        //         // location.reload();
        //     },
        //         error: function(e){
        //             new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
        //         }
        // });
            
    }

    <?php
    //if($assesment_medis_iri->num_rows()){
    ?>
    // surveyLembarProgramTerapi.data = <?php //echo $assesment_medis_iri->row()->formjson_dewasa ?>;
    <?php //}else{ ?>
    
    surveyLembarProgramTerapi.render("surveyLembarProgramTerapi");
    surveyLembarProgramTerapi
        .onComplete
        .add(function (result) {
            sendDataToLembarProgramTerapi(result);
        });
</script>