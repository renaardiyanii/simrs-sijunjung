<?php 
$this->load->view('layout/header_form');
// var_dump($identifikasi_bayi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveykontrol_intensive"></div>

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

surveyJSONkontrol_intensive = <?php echo file_get_contents("kontrol_intensive.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerkontrol_intensive(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_kontrol_intensive/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                kontrol_intensive_json:JSON.stringify(survey.data),
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


    var survey_kontrol_intensive = new Survey.Model(surveyJSONkontrol_intensive);

    <?php if($kontrol_intensive){ ?>
		survey_kontrol_intensive.data = <?php echo isset($kontrol_intensive->formjson)?$kontrol_intensive->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveykontrol_intensive").Survey({
    model: survey_kontrol_intensive,
    onComplete: sendDataToServerkontrol_intensive
});
</script>