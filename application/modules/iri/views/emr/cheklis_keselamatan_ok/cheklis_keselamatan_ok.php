<?php 
$this->load->view('layout/header_form');
// var_dump($keperawatan_general)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveycheklis"></div>

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

surveyJSONcheklist = <?php echo file_get_contents("checklis_keselamatan_ok.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServercheklist(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_checklis_keselamatan_ok/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                checklis_keselamatan_ok_json:JSON.stringify(survey.data),
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


    var survey_cheklist = new Survey.Model(surveyJSONcheklist);

    <?php if($checklist_keselamatan_ok){ ?>
		survey_cheklist.data = <?php echo isset($checklist_keselamatan_ok->formjson)?$checklist_keselamatan_ok->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveycheklis").Survey({
    model: survey_cheklist,
    onComplete: sendDataToServercheklist
});
</script>