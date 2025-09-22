<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyPenolakanPertujuanHIV"></div>

    </div>
</div>


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

surveyJSONpersetujuanhiv = <?php echo file_get_contents("persetujuan_test_hiv.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPersetujuanHIV(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/persetujuan_tes_hiv/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                persetujuan_hiv_json:JSON.stringify(survey.data),
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


    var survey_persetujuan_hiv = new Survey.Model(surveyJSONpersetujuanhiv);

    
    <?php if($persetujuan_hiv){ ?>
		survey_persetujuan_hiv.data = <?php echo isset($persetujuan_hiv->formjson)?$persetujuan_hiv->formjson:''; ?>
	<?php }else{ ?>
        
        <?php } ?>

// survey.css = myCss;
$("#SurveyPenolakanPertujuanHIV").Survey({
    model: survey_persetujuan_hiv,
    onComplete: sendDataToServerPersetujuanHIV
});
</script>