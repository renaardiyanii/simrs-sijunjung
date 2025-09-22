<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyperioperaktif"></div>

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

surveyJSONperioperaktif = <?php echo file_get_contents("keperawatan_perioperatif.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerperioperaktif(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_keperawatan_perioperatif/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                keperawatan_perioperatif_json:JSON.stringify(survey.data),
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


    var survey_edukasi_peri_operaktif = new Survey.Model(surveyJSONperioperaktif);

    <?php if($keperawatan_perioperatif){ ?>
		survey_edukasi_peri_operaktif.data = <?php echo isset($keperawatan_perioperatif->formjson)?$keperawatan_perioperatif->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyperioperaktif").Survey({
    model: survey_edukasi_peri_operaktif,
    onComplete: sendDataToServerperioperaktif
});
</script>