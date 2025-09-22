<?php 
$this->load->view('layout/header_form');
// var_dump($keperawatan_general)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyrencanatindakan"></div>

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

surveyJSONresikojatuh = <?php echo file_get_contents("resiko_jatuh_new.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerresiko_jatuh(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_resiko_jatuh_new/') ?>',
            data: {
                no_register : '<?php echo $no_ipd;?>',
                resiko_jatuh_new_json:JSON.stringify(survey.data),
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


    var survey_resiko_jatuh = new Survey.Model(surveyJSONresikojatuh);

    <?php if($resiko_jatuh_new){ ?>
		survey_resiko_jatuh.data = <?php echo isset($resiko_jatuh_new->formjson)?$resiko_jatuh_new->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyrencanatindakan").Survey({
    model: survey_resiko_jatuh,
    onComplete: sendDataToServerresiko_jatuh
});
</script>