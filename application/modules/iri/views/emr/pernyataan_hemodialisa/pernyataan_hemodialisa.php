<?php 
$this->load->view('layout/header_form');
// var_dump($tindakan_hemodialisa);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyserah_tindakan_hemodialisa"></div>

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

surveyJSONserah_tindakan_hemodialisa = <?php echo file_get_contents("pernyataan_hemodialisa.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServertindakan_hemodialisa(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_tindakan_hemodialisa/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pernyataan_hemodialisa_json:JSON.stringify(survey.data),
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


    var survey_hemodialisa = new Survey.Model(surveyJSONserah_tindakan_hemodialisa);

    <?php if($tindakan_hemodialisa){ ?>
		survey_hemodialisa.data = <?php echo isset($tindakan_hemodialisa->formjson)?$tindakan_hemodialisa->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyserah_tindakan_hemodialisa").Survey({
    model: survey_hemodialisa,
    onComplete: sendDataToServertindakan_hemodialisa
});
</script>