<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyBBL"></div>

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

surveyJSONBBL = <?php echo file_get_contents("bayi_baru_lahir.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerBBL(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_bayi_baru_lahir/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                bayi_baru_lahir_json:JSON.stringify(survey.data),
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


    var survey_BBL = new Survey.Model(surveyJSONBBL);

    <?php if($bayi_baru_lahir){ ?>
		survey_BBL.data = <?php echo isset($bayi_baru_lahir->formjson)?$bayi_baru_lahir->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyBBL").Survey({
    model: survey_BBL,
    onComplete: sendDataToServerBBL
});
</script>