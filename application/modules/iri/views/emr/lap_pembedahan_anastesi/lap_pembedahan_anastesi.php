<?php 
$this->load->view('layout/header_form');
// var_dump($tindakan_hemodialisa);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypremedi_pembedahan_anastesi"></div>

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

surveyJSONpembedahan_anastesi = <?php echo file_get_contents("lap_pembedahan_anastesi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer_pembedahan_anastesi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_lap_pembedahan_anastesi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                lap_pembedahan_anastesi_json:JSON.stringify(survey.data),
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


    var survey_premedi_pembedahan_anastesi = new Survey.Model(surveyJSONpembedahan_anastesi);

    <?php if($pembedahan_anastesi){ ?>
		survey_premedi_pembedahan_anastesi.data = <?php echo isset($pembedahan_anastesi->formjson)?$pembedahan_anastesi->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypremedi_pembedahan_anastesi").Survey({
    model: survey_premedi_pembedahan_anastesi,
    onComplete: sendDataToServer_pembedahan_anastesi
});
</script>