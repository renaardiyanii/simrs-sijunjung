<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypatologianatomi"></div>

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

surveyJSONpatologianatomi = <?php echo file_get_contents("patologi_anatomi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpatologianatomi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_patologi_anatomi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                patologi_anatomi_json:JSON.stringify(survey.data),
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


    var survey_patologi_anatomi = new Survey.Model(surveyJSONpatologianatomi);

    <?php if($patologi_anatomi){ ?>
		survey_patologi_anatomi.data = <?php echo isset($patologi_anatomi->formjson)?$patologi_anatomi->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypatologianatomi").Survey({
    model: survey_patologi_anatomi,
    onComplete: sendDataToServerpatologianatomi
});
</script>