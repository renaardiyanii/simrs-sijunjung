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

surveyJSONrencanatindakan = <?php echo file_get_contents("rencana_tindakan_keperawatan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerrencanatindakan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_rencana_tindakan_keperawatan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                rencana_tindakan_keperawatan_json:JSON.stringify(survey.data),
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


    var survey_rencana_tindakan = new Survey.Model(surveyJSONrencanatindakan);

    <?php if($rencana_tindakan_keperawatan){ ?>
		survey_rencana_tindakan.data = <?php echo isset($rencana_tindakan_keperawatan->formjson)?$rencana_tindakan_keperawatan->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyrencanatindakan").Survey({
    model: survey_rencana_tindakan,
    onComplete: sendDataToServerrencanatindakan
});
</script>