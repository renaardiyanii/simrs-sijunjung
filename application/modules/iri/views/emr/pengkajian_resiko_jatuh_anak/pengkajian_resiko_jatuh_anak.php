<?php 
$this->load->view('layout/header_form');
// var_dump($resiko_jatuh_anak)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyresikojatuhanak"></div>

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

surveyJSONjatuhanak = <?php echo file_get_contents("pengkajian_resiko_jatuh_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerjatuhanak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/pengkajian_resiko_jatuh_anak/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_resiko_jatuh_anak_json:JSON.stringify(survey.data),
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


    var survey_resiko_anak = new Survey.Model(surveyJSONjatuhanak);

    <?php if($resiko_jatuh_anak){ ?>
		survey_resiko_anak.data = <?php echo isset($resiko_jatuh_anak->formjson)?$resiko_jatuh_anak->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyresikojatuhanak").Survey({
    model: survey_resiko_anak,
    onComplete: sendDataToServerjatuhanak
});
</script>