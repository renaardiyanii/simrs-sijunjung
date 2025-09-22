<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyresiko_geriatri"></div>

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

surveyJSONresiko_geriatri = <?php echo file_get_contents("pengkajian_resiko_jatuh_geriatri.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerresiko_geriatri(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_pengkajian_resiko_jatuh_geriatri/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_resiko_jatuh_geriatri_json:JSON.stringify(survey.data),
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


    var survey_resiko_geriatri = new Survey.Model(surveyJSONresiko_geriatri);

    <?php if($resiko_geriatri){ ?>
		survey_resiko_geriatri.data = <?php echo isset($resiko_geriatri->formjson)?$resiko_geriatri->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyresiko_geriatri").Survey({
    model: survey_resiko_geriatri,
    onComplete: sendDataToServerresiko_geriatri
});
</script>