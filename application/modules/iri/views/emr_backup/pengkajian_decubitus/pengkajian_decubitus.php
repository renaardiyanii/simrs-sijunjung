<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_decubitus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypengkajiandecubitus"></div>

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

surveyJSONPengkajiandecubitus = <?php echo file_get_contents("pengkajian_decubitus.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPengkajiandecubitus(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_decubitus/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_decubitus_json:JSON.stringify(survey.data),
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


    var survey_pengkajian_decubitus = new Survey.Model(surveyJSONPengkajiandecubitus);

    <?php if($pengkajian_decubitus){ ?>
		survey_pengkajian_decubitus.data = <?php echo isset($pengkajian_decubitus->formjson)?$pengkajian_decubitus->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypengkajiandecubitus").Survey({
    model: survey_pengkajian_decubitus,
    onComplete: sendDataToServerPengkajiandecubitus
});
</script>