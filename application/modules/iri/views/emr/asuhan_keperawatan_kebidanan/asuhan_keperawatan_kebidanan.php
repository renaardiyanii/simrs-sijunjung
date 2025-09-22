<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyaskep_obgyn"></div>

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

surveyJSONaskep_obgyn = <?php echo file_get_contents("asuhan_keperawatan_kebidanan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServeraskepobgyn(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_askep_kebidanan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                asuhan_keperawatan_kebidanan_json:JSON.stringify(survey.data),
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


    var survey_askep_obgyn = new Survey.Model(surveyJSONaskep_obgyn);

    <?php if($askep_kebidanan){ ?>
		survey_askep_obgyn.data = <?php echo isset($askep_kebidanan->formjson)?$askep_kebidanan->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyaskep_obgyn").Survey({
    model: survey_askep_obgyn,
    onComplete: sendDataToServeraskepobgyn
});
</script>