<?php 
$this->load->view('layout/header_form');
// var_dump($data_pasien_daftar_ulang)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="Surveyasuhangizianak"></div>

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

surveyJSONasuhan_gizi_anak = <?php echo file_get_contents("asuhan_gizi_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer_asuhangizi_anak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_asuhan_gizi_anak/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                asuhan_gizi_anak_json:JSON.stringify(survey.data),
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


    var survey_asuhan_gizi_anak = new Survey.Model(surveyJSONasuhan_gizi_anak);

    <?php
	if(isset($asuhan_gizi_anak)){ ?>
		survey_asuhan_gizi_anak.data = <?= isset($asuhan_gizi_anak->formjson)?$asuhan_gizi_anak->formjson:'' ?>
	<?php } else { ?>
      
   <?php } ?>
    

// survey.css = myCss;
$("#Surveyasuhangizianak").Survey({
    model: survey_asuhan_gizi_anak,
    onComplete: sendDataToServer_asuhangizi_anak
});
</script>