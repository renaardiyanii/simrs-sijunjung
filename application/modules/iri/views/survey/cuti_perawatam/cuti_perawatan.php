<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div class="card m-5">
    <div class="body">
    <div id="SurveyCutiPerawatan"></div>

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

surveyJSONCutiPerawatan = <?php echo file_get_contents("cuti_perawatan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerCutiPerawatan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/cuti_perawatan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                cuti_perawatan_json:JSON.stringify(survey.data),
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


    var survey_cuti_perawatan = new Survey.Model(surveyJSONCutiPerawatan);
    


    <?php if($cuti_perawatan){ ?>
		survey_cuti_perawatan.data = <?= $cuti_perawatan->formjson; ?>
	<?php }else{ ?>
        
      
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyCutiPerawatan").Survey({
    model: survey_cuti_perawatan,
    onComplete: sendDataToServerCutiPerawatan
});
</script>