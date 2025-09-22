<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveykeperawatanperina"></div>

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

surveyJSONKeperawatanperina = <?php echo file_get_contents("keperawatan_neonatus_perina.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerKeperawatanperina(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_keperawatan_perina/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                keperawatan_neonatus_perina_json:JSON.stringify(survey.data),
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


    var survey_keperawatan_perina = new Survey.Model(surveyJSONKeperawatanperina);

    <?php if($keperawatan_perina){ ?>
		survey_keperawatan_perina.data = <?php echo isset($keperawatan_perina->formjson)?$keperawatan_perina->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveykeperawatanperina").Survey({
    model: survey_keperawatan_perina,
    onComplete: sendDataToServerKeperawatanperina
});
</script>