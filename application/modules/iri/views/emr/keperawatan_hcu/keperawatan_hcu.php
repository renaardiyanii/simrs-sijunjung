<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveykeperawatan_hcu"></div>

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

surveyJSONkeperawatan_hcu = <?php echo file_get_contents("keperawatan_hcu.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerkeperawatan_hcu(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_keperawatan_hcu/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                keperawatan_hcu_json:JSON.stringify(survey.data),
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


    var survey_keperawatan_hcu = new Survey.Model(surveyJSONkeperawatan_hcu);

    <?php if($keperawatan_hcu){ ?>
		survey_keperawatan_hcu.data = <?php echo isset($keperawatan_hcu->formjson)?$keperawatan_hcu->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveykeperawatan_hcu").Survey({
    model: survey_keperawatan_hcu,
    onComplete: sendDataToServerkeperawatan_hcu
});
</script>