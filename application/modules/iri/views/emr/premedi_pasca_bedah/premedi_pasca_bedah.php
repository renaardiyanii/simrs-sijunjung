<?php 
$this->load->view('layout/header_form');
// var_dump($tindakan_hemodialisa);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypremedi_pasca_bedah"></div>

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

surveyJSONpremeedi_pasca = <?php echo file_get_contents("premedi_pasca_bedah.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer_premedi_pasca_bedah(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_pasca_bedah/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                premedi_pasca_bedah_json:JSON.stringify(survey.data),
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


    var survey_premedi_pasca_bedah = new Survey.Model(surveyJSONpremeedi_pasca);

    <?php if($premedi_pasca_bedah){ ?>
		survey_premedi_pasca_bedah.data = <?php echo isset($premedi_pasca_bedah->formjson)?$premedi_pasca_bedah->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypremedi_pasca_bedah").Survey({
    model: survey_premedi_pasca_bedah,
    onComplete: sendDataToServer_premedi_pasca_bedah
});
</script>