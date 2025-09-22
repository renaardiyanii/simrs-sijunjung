<?php 
 
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="AssesmentPraSedasi"></div>
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

surveyJSON = <?php echo file_get_contents("asesmen_prasedasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/assesment_pra_sedasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                assesment_prasedasi_json:JSON.stringify(survey.data),
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


    var assesment_prasedasi_view = new Survey.Model(surveyJSON);
    
    <?php
	if(isset($assesment_prasedasi)){ ?>
		assesment_prasedasi_view.data = <?= $assesment_prasedasi->formjson ?>;

	<?php } else { ?>
    

   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#AssesmentPraSedasi").Survey({
    model: assesment_prasedasi_view,
    onComplete: sendDataToServer
});
</script>