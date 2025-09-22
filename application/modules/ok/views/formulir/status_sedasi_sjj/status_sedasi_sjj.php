<?php 
 $this->load->view('header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="status_sedasi_sjj"></div>
<script>
    var widget = {
    name: "emptyRadio",
    isFit : function(question) {  
        return question.getType() === 'radiogroup'; 
    },
    isDefaultRender: true,
    afterRender: function(question, el) {
      var $el = $(el);
      $el.find("input:radio").click(function(event){
           var UnCheck = "UnCheck",
                  $clickedbox = $(this),
                  radioname = $clickedbox.prop("name"),
                  $group = $('input[name|="'+ radioname + '"]'),
                  doUncheck = $clickedbox.hasClass(UnCheck),
                  isChecked = $clickedbox.is(':checked');
              if(doUncheck){
                  $group.removeClass(UnCheck);
                  $clickedbox.prop('checked', false);
                  question.value = null;
              }
              else if(isChecked){
                  $group.removeClass(UnCheck);
                  $clickedbox.addClass(UnCheck);
              }
      });    
    },
    willUnmount: function(question, el) {
    }
};

Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

surveyJSONstatus_sedasi_sjj = <?php echo file_get_contents("status_sedasi_sjj.JSON",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerstatus_sedasi_sjj(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okchasil/status_sedasi_sjj/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
                status_sedasi_sjj_json:JSON.stringify(survey.data),
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


    var status_sedasi_sjj = new Survey.Model(surveyJSONstatus_sedasi_sjj);
    
    <?php
	if(isset($status_sedasi_sjj_ok)){ ?>
		status_sedasi_sjj.data = <?= $status_sedasi_sjj_ok->formjson ?>;

	<?php } else { ?>
       
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#status_sedasi_sjj").Survey({
    model: status_sedasi_sjj,
    onComplete: sendDataToServerstatus_sedasi_sjj
});
</script>