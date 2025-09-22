<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypengantar_ranap"></div>

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

surveyJSONasuhan_gizi = <?php echo file_get_contents("asuhan_gizi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerasuhan_gizi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/asuhan_gizi_ri/') ?>',
            data: {
                no_register : '<?php echo $no_ipd;?>',
                asuhan_gizi_ri_json:JSON.stringify(survey.data),
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


    var survey_asuhan_gizi = new Survey.Model(surveyJSONasuhan_gizi);

    <?php if($asuhan_gizi_ri){ ?>
		survey_asuhan_gizi.data = <?php echo isset($asuhan_gizi_ri->formjson)?$asuhan_gizi_ri->formjson:''; ?>
	<?php }else{ ?>
       
        
    <?php } ?>
    

// survey.css = myCss;
$("#surveypengantar_ranap").Survey({
    model: survey_asuhan_gizi,
    onComplete: sendDataToServerasuhan_gizi
});
</script>