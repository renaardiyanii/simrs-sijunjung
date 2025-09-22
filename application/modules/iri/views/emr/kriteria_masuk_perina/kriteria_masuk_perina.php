<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveymasuk_perina"></div>

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

surveyJSONmasuk_perina = <?php echo file_get_contents("kriteria_masuk_perina.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServermasuk_perina(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_kriteria_masuk_perina/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                kriteria_masuk_perina_json:JSON.stringify(survey.data),
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


    var survey_masuk_perina = new Survey.Model(surveyJSONmasuk_perina);

    <?php if($masuk_perina){ ?>
		survey_masuk_perina.data = <?php echo isset($masuk_perina->formjson)?$masuk_perina->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveymasuk_perina").Survey({
    model: survey_masuk_perina,
    onComplete: sendDataToServermasuk_perina
});
</script>