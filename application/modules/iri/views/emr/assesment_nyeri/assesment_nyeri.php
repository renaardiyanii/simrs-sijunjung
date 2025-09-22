<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveynyeri"></div>

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

surveyJSONnyeri = <?php echo file_get_contents("assesment_nyeri.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServernyeri(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_assesment_nyeri/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                assesment_nyeri_json:JSON.stringify(survey.data),
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


    var survey_nyeri = new Survey.Model(surveyJSONnyeri);

    <?php if($assesement_nyeri){ ?>
		survey_nyeri.data = <?php echo isset($assesement_nyeri->formjson)?$assesement_nyeri->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveynyeri").Survey({
    model: survey_nyeri,
    onComplete: sendDataToServernyeri
});
</script>