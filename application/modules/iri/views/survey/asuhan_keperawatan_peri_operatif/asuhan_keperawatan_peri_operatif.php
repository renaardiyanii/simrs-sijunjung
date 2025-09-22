
<?php 
$this->load->view('layout/header_form');
?>
<?php 
 $diag = (isset($persetujuan_tind_kedokteran->row()->formjson)?json_decode($persetujuan_tind_kedokteran->row()->formjson):''); 
 $fis = (isset($assesment_pra_anestesi->formjson)?json_decode($assesment_pra_anestesi->formjson):''); 

?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->

<div class="card m-5">
    <div class="body">
    <div id="SurveyAsuhanKeperawatan"></div>

    </div>
</div>

<script>
//     var widget = {
//     name: "emptyRadio",
//     isFit : function(question) {  
//         return question.getType() === 'radiogroup'; 
//     },
//     isDefaultRender: true,
//     afterRender: function(question, el) {
//       var $el = $(el);
//       $el.find("input:radio").click(function(event){
//            var UnCheck = "UnCheck",
//                   $clickedbox = $(this),
//                   radioname = $clickedbox.prop("name"),
//                   $group = $('input[name|="'+ radioname + '"]'),
//                   doUncheck = $clickedbox.hasClass(UnCheck),
//                   isChecked = $clickedbox.is(':checked');
//               if(doUncheck){
//                   $group.removeClass(UnCheck);
//                   $clickedbox.prop('checked', false);
//                   question.value = null;
//               }
//               else if(isChecked){
//                   $group.removeClass(UnCheck);
//                   $clickedbox.addClass(UnCheck);
//               }
//       });    
//     },
//     willUnmount: function(question, el) {
//     }
// };

// Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("asuhan_keperawatan_perioperatif.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/asuhan_keperawatan_peri_operatif/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                id_ok : '<?php echo isset($id_ok)?$id_ok:'';?>',
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