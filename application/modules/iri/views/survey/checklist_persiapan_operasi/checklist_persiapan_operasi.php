<?php 
 $diag = (isset($persetujuan_tind_kedokteran->row()->formjson)?json_decode($persetujuan_tind_kedokteran->row()->formjson):''); 
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="PersiapanOperasi"></div>
<script>
Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("checklist_persiapan_operasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

       
            //  console.log(JSON.stringify(survey.data));
        
        }


    var persiapan_operasi = new Survey.Model(surveyJSON);
 


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#PersiapanOperasi").Survey({
    model: persiapan_operasi,
    onComplete: sendDataToServer
});
</script>