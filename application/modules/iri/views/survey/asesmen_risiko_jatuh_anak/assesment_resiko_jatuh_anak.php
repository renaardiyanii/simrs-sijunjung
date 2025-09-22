<?php 
$this->load->view('layout/header_form');
?>
<?php 
 $test = isset($history_assesment_keperawatan[0]->formjson)?json_decode($history_assesment_keperawatan[0]->formjson):'';
 //var_dump($test->question9->result->{'1'}); die();
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->

<div class="card m-5">
    <div class="body">
    <div id="AssesmentJatuhAnak"></div>

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

surveyJSON = <?php echo file_get_contents("assesment_resiko_jatuh_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/assesment_resiko_jatuh/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                assesmentjatuh_json:JSON.stringify(survey.data),
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


    var assesment_jatuh_anak = new Survey.Model(surveyJSON);
    
    <?php if($assesment_risiko_jatuh->num_rows()){ ?>
		assesment_jatuh_anak.data = <?= $assesment_risiko_jatuh->row()->formjson; ?>
	<?php }else{ ?>
        assesment_jatuh_anak.data = {"resiko_jatuh":[{
            "1":"<?= isset($test->question9->result->{'1'} )?$test->question9->result->{'1'} :''?>",
            "2":"<?= isset($test->question9->result->{'2'})?$test->question9->result->{'2'}:'' ?>",
            "3":"<?= isset($test->question9->result->{'3'})?$test->question9->result->{'3'}:'' ?>",
            "detail_umur":""}]}
        <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#AssesmentJatuhAnak").Survey({
    model: assesment_jatuh_anak,
    onComplete: sendDataToServer
});
</script>