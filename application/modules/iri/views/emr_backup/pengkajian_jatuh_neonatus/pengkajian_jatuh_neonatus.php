<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypengkajianjatuhneonatus"></div>

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

surveyJSONPengkajianjatuhneonatus = <?php echo file_get_contents("pengkajian_jatuh_neonatus.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPengkajiaJatuhneonatus(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_pengkajian_neonatus/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_jatuh_neonatus_json:JSON.stringify(survey.data),
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


    var survey_pengkajian_jatuh_neonatus = new Survey.Model(surveyJSONPengkajianjatuhneonatus);

    <?php if($jatuh_neonatus){ ?>
		survey_pengkajian_jatuh_neonatus.data = <?php echo isset($jatuh_neonatus->formjson)?$jatuh_neonatus->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypengkajianjatuhneonatus").Survey({
    model: survey_pengkajian_jatuh_neonatus,
    onComplete: sendDataToServerPengkajiaJatuhneonatus
});
</script>