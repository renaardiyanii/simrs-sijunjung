<?php 
$this->load->view('layout/header_form');
// var_dump($data_pasien_daftar_ulang)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="Surveyasuhangizi"></div>

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

surveyJSONasuhan_gizi = <?php echo file_get_contents("asuhan_gizi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer_asuhangizin(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_asuhan_gizi/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                asuhan_gizi_json:JSON.stringify(survey.data),
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


    var survey_asuhan_gizi = new Survey.Model(surveyJSONasuhan_gizi);

    <?php
	if(isset($asuhan_gizi)){ ?>
		survey_asuhan_gizi.data = <?= isset($asuhan_gizi->formjson)?$asuhan_gizi->formjson:'' ?>;
	<?php } else { ?>
      
   <?php } ?>
    

// survey.css = myCss;
$("#Surveyasuhangizi").Survey({
    model: survey_asuhan_gizi,
    onComplete: sendDataToServer_asuhangizin
});
</script>