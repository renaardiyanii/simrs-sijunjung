<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveykep_obgyn"></div>

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

surveyJSONkepobgyn = <?php echo file_get_contents("keperawatan_obgyn.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerkepobgyn(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_keperawatan_obgyn/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
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


    var survey_keperawatan_obgyn = new Survey.Model(surveyJSONkepobgyn);

    <?php if($keperawatan_obgyn){ ?>
		survey_keperawatan_obgyn.data = <?php echo isset($keperawatan_obgyn->formjson)?$keperawatan_obgyn->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveykep_obgyn").Survey({
    model: survey_keperawatan_obgyn,
    onComplete: sendDataToServerkepobgyn
});
</script>