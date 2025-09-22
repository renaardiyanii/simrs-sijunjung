<?php 
$this->load->view('layout/header_form');
// var_dump($identifikasi_bayi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyidentifikasi_bayi"></div>

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

surveyJSONidentifikasi_bayi = <?php echo file_get_contents("identifikasi_bayi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServeridentifikasi_bayi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_identifikasi_bayi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                identifikasi_bayi_json:JSON.stringify(survey.data),
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


    var survey_identifikasi_bayi = new Survey.Model(surveyJSONidentifikasi_bayi);

    <?php if($identifikasi_bayi){ ?>
		survey_identifikasi_bayi.data = <?php echo isset($identifikasi_bayi->formjson)?$identifikasi_bayi->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyidentifikasi_bayi").Survey({
    model: survey_identifikasi_bayi,
    onComplete: sendDataToServeridentifikasi_bayi
});
</script>