<?php 
 $test = isset($persiapan_operasi[0]->formjson)?json_decode($persiapan_operasi[0]->formjson):'';
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="LaporanMedikLokalAnastesi"></div>
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

surveyJSON = <?php echo file_get_contents("laporan_medik_lokal_anastesi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/laporan_medik_lokal_anastesi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                medik_lokal_anastesi_json:JSON.stringify(survey.data),
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


    var medik_lokal_anastesi = new Survey.Model(surveyJSON);
    
    <?php
	if(isset($lap_medik_lokal_anestesi)){ ?>
		medik_lokal_anastesi.data = <?= $lap_medik_lokal_anestesi->formjson ?>;

	<?php } else { ?>
        medik_lokal_anastesi.data =
         {"table2":[{"column3":"<?= isset($list_ok_pasien[0]->jenis_tindakan)?$list_ok_pasien[0]->jenis_tindakan:'' ?>",
            "column4":"<?= isset($test->operasi->jenis_operasi )?$test->operasi->jenis_operasi :''?>"}]}
        // medik_lokal_anastesi.data =  {"operasi":{"ruangan":"<?= $data_pasien[0]['nmruang'] ?>","diagnosis":"<?= isset($diagnosa_iri_utama->diagnosa)?$diagnosa_iri_utama->diagnosa:'' ?>"}}
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#LaporanMedikLokalAnastesi").Survey({
    model: medik_lokal_anastesi,
    onComplete: sendDataToServer
});
</script>