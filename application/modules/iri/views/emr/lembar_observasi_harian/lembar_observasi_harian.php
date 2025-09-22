<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyDP"></div>

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

surveyJSONLOH = <?php echo file_get_contents("lembar_observasi_harian.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerLOH(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_lembar_observasi_hasian/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                lembar_observasi_harian_json:JSON.stringify(survey.data),
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


    var survey_LOH = new Survey.Model(surveyJSONLOH);

    <?php if($lembar_observasi_harian){ ?>
		survey_LOH.data = <?php echo isset($lembar_observasi_harian->formjson)?$lembar_observasi_harian->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyDP").Survey({
    model: survey_LOH,
    onComplete: sendDataToServerLOH
});
</script>