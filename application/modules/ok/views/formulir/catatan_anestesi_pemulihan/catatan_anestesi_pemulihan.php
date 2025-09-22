<?php 
 $this->load->view('header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="CatatanPemulihan"></div>
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

surveyJSONCatatanPemulihan = <?php echo file_get_contents("catatan_anestesi_pemulihan.JSON",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServercatatan_pemulihan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okchasil/catatan_pemulihan/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
                catatan_pemulihan_json:JSON.stringify(survey.data),
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


    var catatan_anestesi_pemulihan = new Survey.Model(surveyJSONCatatanPemulihan);
    
    <?php
	if(isset($catatan_pemulihan)){ ?>
		catatan_anestesi_pemulihan.data = <?= $catatan_pemulihan->formjson ?>;

	<?php } else { ?>
       
   <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#CatatanPemulihan").Survey({
    model: catatan_anestesi_pemulihan,
    onComplete: sendDataToServercatatan_pemulihan
});
</script>