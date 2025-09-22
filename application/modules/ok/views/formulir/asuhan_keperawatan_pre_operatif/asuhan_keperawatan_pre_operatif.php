<?php 
 $diag = (isset($persetujuan_tind_kedokteran->row()->formjson)?json_decode($persetujuan_tind_kedokteran->row()->formjson):''); 
 $fis = (isset($assesment_pra_anestesi->formjson)?json_decode($assesment_pra_anestesi->formjson):''); 
 $this->load->view('header_form');
?>
<style>

</style>


<div id="SurveyAsuhanKeperawatan"></div>
<script>

Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("asuhan_keperawatan_perioperatif.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okcdaftar/asuhan_keperawatan_peri_operatif/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
                asuhankeperawatan_json:JSON.stringify(survey.data),
            },
            success: function(data)
            {
            
                location.reload();
                

            },
            error: function(data)
            {
                
            }
        }); 
            //  console.log(JSON.stringify(survey.data));
        
        }


    var survey_asuhan_keperawatan = new Survey.Model(surveyJSON);
    
    <?php
	if(isset($asuhan_keperawatan_peri_operatif)){ ?>
		survey_asuhan_keperawatan.data = <?= $asuhan_keperawatan_peri_operatif->formjson ?>;

	<?php } else { ?>
        survey_asuhan_keperawatan.data = {"question1":{
            "suhu":"<?= isset($fis->question1[0]->suhu)?$fis->question1[0]->suhu:'' ?>",
            "td":"<?= isset($fis->question1[0]->td)?$fis->question1[0]->td:'' ?>",
            "nadi":"<?= isset($fis->question1[0]->fn)?$fis->question1[0]->fn:'' ?>",
            },
            "question2":[{"diagnosa_sebelum":"<?= isset($diag->question2->{'Row 1'}->isi_informasi)?$diag->question2->{'Row 1'}->isi_informasi:'' ?>"}]}
   <?php } ?>



	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyAsuhanKeperawatan").Survey({
    model: survey_asuhan_keperawatan,
    onComplete: sendDataToServer
});
</script>