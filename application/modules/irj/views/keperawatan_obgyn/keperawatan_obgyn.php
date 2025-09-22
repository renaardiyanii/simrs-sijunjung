<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyKeperawatanObgyn"></div>

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

surveyJSONKepObgyn = <?php echo file_get_contents("keperawatan_obgyn.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerKepObgyn(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayanan/insert_kep_obgyn/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                keperawatan_obgyn_json:JSON.stringify(survey.data),
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


    var survey_keperawatanObgyn = new Survey.Model(surveyJSONKepObgyn);

    <?php if($keperawatan_obgyn){ ?>
		survey_keperawatanObgyn.data = <?php echo isset($keperawatan_obgyn->formjson)?$keperawatan_obgyn->formjson:''; ?>
	<?php }else{ ?>
        

    <?php } ?>

// survey.css = myCss;
$("#SurveyKeperawatanObgyn").Survey({
    model: survey_keperawatanObgyn,
    onComplete: sendDataToServerKepObgyn
});
</script>