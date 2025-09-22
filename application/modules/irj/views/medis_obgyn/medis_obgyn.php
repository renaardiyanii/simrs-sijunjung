<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="Surveymedikobgyn"></div>

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

surveyJSONMedikObgyn = <?php echo file_get_contents("medis_obgyn.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerMedikobgyn(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_medik_obgyn/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                medis_obgyn_json:JSON.stringify(survey.data),
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


    var survey_medikobgyn = new Survey.Model(surveyJSONMedikObgyn);

    
    <?php if($medik_obgyn){ ?>
		survey_medikobgyn.data = <?php echo isset($medik_obgyn->formjson)?$medik_obgyn->formjson:''; ?>
	<?php }else{ ?>
        

    <?php } ?>

// survey.css = myCss;
$("#Surveymedikobgyn").Survey({
    model: survey_medikobgyn,
    onComplete: sendDataToServerMedikobgyn
});
</script>