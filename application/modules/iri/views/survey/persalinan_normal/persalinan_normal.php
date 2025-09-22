<?php 
$test = isset($history_assesment_keperawatan[0]->formjson)?json_decode($history_assesment_keperawatan[0]->formjson):'';
 //var_dump($test); die();
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="SurveyPersalinanNormal"></div>
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

surveyJSON = <?php echo file_get_contents("persalinan_normal.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/persalinan_normal/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                persalinanormal_json:JSON.stringify(survey.data),
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


    var survey_persalinan_normal = new Survey.Model(surveyJSON);
    
    <?php if($persalinan_normal->num_rows()){ ?>
		survey_persalinan_normal.data = <?= $persalinan_normal->row()->formjson; ?>
	<?php }else{ ?>
        survey_persalinan_normal.data = {"question1":{"noreg":"<?= $data_pasien[0]['no_ipd'] ?>",
            "alamat":"<?= $data_pasien[0]['alamat'] ?>",
            "g":"<?= isset($test->gpah->g)?$test->gpah->g:'' ?>",
            "p":"<?= isset($test->gpah->p)?$test->gpah->p:'' ?>",
            "a":"<?= isset($test->gpah->a)?$test->gpah->a:'' ?>"}}
        <?php } ?>


	// survey_ews.showNavigationButtons = false;






// survey.css = myCss;
$("#SurveyPersalinanNormal").Survey({
    model: survey_persalinan_normal,
    onComplete: sendDataToServer
});
</script>