<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveysurat_rujukan"></div>

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
surveyJSONsurat_rujukan = <?php echo file_get_contents("surat_rujukan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServersurat_rujukan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_surat_rujukan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                surat_rujukan_json:JSON.stringify(survey.data),
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


    var survey_surat_rujukan = new Survey.Model(surveyJSONsurat_rujukan);

    <?php if($sur_rujukan){ ?>
		survey_surat_rujukan.data = <?php echo isset($sur_rujukan->formjson)?$sur_rujukan->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveysurat_rujukan").Survey({
    model: survey_surat_rujukan,
    onComplete: sendDataToServersurat_rujukan
});
</script>