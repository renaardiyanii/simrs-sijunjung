<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveylembar_ppi"></div>

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

surveyJSONlembar_ppi = <?php echo file_get_contents("rencana_penerapan_bundles.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerlembar_ppi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_rencana_penerapan_bundles/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                rencana_penerapan_bundles_json:JSON.stringify(survey.data),
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


    var survey_lembar_ppi = new Survey.Model(surveyJSONlembar_ppi);

    <?php if($penerapan_pencegahan_infeksi){ ?>
		survey_lembar_ppi.data = <?php echo isset($penerapan_pencegahan_infeksi->formjson)?$penerapan_pencegahan_infeksi->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveylembar_ppi").Survey({
    model: survey_lembar_ppi,
    onComplete: sendDataToServerlembar_ppi
});
</script>