<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypenolakan_medis"></div>

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

surveyJSONpenolakan_medis = <?php echo file_get_contents("penolakan_tindakan_medis.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpenolakan_medis(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_penolakan_tindakan_medis/') ?>',
            data: {
                no_register : '<?php echo $no_ipd;?>',
                penolakan_tindakan_medis_json:JSON.stringify(survey.data),
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


    var survey_penolakan_medis = new Survey.Model(surveyJSONpenolakan_medis);

    <?php if($penolakan_tindakan_medis){ ?>
		survey_penolakan_medis.data = <?php echo isset($penolakan_tindakan_medis->formjson)?$penolakan_tindakan_medis->formjson:''; ?>
	<?php }else{ ?>
       
        survey_penolakan_medis.data =  {"mt_bio_pasien1":{"nama":"<?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:''?>",
            "jk":"<?= isset($data_pasien[0]['sex'])?$data_pasien[0]['sex']:''?>",
            "alamat":"<?= isset($data_pasien[0]['alamat'])?$data_pasien[0]['alamat']:''?>"}}
    <?php } ?>
    

// survey.css = myCss;
$("#surveypenolakan_medis").Survey({
    model: survey_penolakan_medis,
    onComplete: sendDataToServerpenolakan_medis
});
</script>