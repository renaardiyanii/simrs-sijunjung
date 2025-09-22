<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypersetujuan_penolakan_rujukan"></div>

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

surveyJSONpenolakan_persetujuan_rujukan = <?php echo file_get_contents("penolakan_persetujuan_rujukan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpenolakan_persetujuan_medis(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_penolakan_persetujuan_rujukan/') ?>',
            data: {
                no_register : '<?php echo $no_ipd;?>',
                penolakan_persetujuan_medis_json:JSON.stringify(survey.data),
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


    var survey_penolakan_persetujuan_rujukan = new Survey.Model(surveyJSONpenolakan_persetujuan_rujukan );

    <?php if($pen_per_rujukan){ ?>
		survey_penolakan_persetujuan_rujukan.data = <?php echo isset($pen_per_rujukan->formjson)?$pen_per_rujukan->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypersetujuan_penolakan_rujukan").Survey({
    model: survey_penolakan_persetujuan_rujukan,
    onComplete: sendDataToServerpenolakan_persetujuan_medis
});
</script>