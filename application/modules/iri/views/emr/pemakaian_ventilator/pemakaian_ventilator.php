<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypemakaian_ventilator"></div>

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

Survey.CustomWidgetCollection.Instance.setActivatedBy("select2", "type");

surveyJSONpemakaian_ventilator = <?php echo file_get_contents("pemakaian_ventilator.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpemakaian_ventilator(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_pemakaian_ventilator/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pemakaian_ventilator_json:JSON.stringify(survey.data),
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


    var survey_pemakaian_ventilator = new Survey.Model(surveyJSONpemakaian_ventilator);

    <?php if($pemakaian_ventilator){ ?>
		survey_pemakaian_ventilator.data = <?php echo isset($pemakaian_ventilator->formjson)?$pemakaian_ventilator->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypemakaian_ventilator").Survey({
    model: survey_pemakaian_ventilator,
    onComplete: sendDataToServerpemakaian_ventilator
});
</script>