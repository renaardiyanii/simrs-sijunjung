<?php 
 
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="PersiapanOperasi"></div>
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

surveyJSON = <?php echo file_get_contents("checklist_persiapan_operasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/checklist_persiapan_operasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                persiapan_operasi_json:JSON.stringify(survey.data),
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


    var persiapan_operasi = new Survey.Model(surveyJSON);
    



	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#PersiapanOperasi").Survey({
    model: persiapan_operasi,
    onComplete: sendDataToServer
});
</script>