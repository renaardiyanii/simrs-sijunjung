<?php 
$this->load->view('layout/header_form');
// var_dump($data_pasien_daftar_ulang)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyRegisHIV"></div>

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

surveyJSONRegisHIV = <?php echo file_get_contents("formulir_regis_hiv.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerRegisHIV(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/insert_regis_hiv/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                Formulir_regis_hiv_json:JSON.stringify(survey.data),
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


    var survey_RegisHiv = new Survey.Model(surveyJSONRegisHIV);

    <?php
	if(isset($formulir_hiv)){ ?>
		survey_RegisHiv.data = <?= isset($formulir_hiv->formjson)?$formulir_hiv->formjson:'' ?>;
	<?php } else { ?>
        survey_RegisHiv.data = {
            "question9":{"text1":"<?php echo $data_pasien_daftar_ulang->nama;?>","text2":"<?php echo $data_pasien_daftar_ulang->alamat;?>","text4":"<?php echo $data_pasien_daftar_ulang->sex;?>","text5":"<?php echo $data_pasien_daftar_ulang->status;?>","text6":"<?php echo $data_pasien_daftar_ulang->pendidikan;?>","text7":"<?php echo $data_pasien_daftar_ulang->pekerjaan;?>"
                }
        }
   <?php } ?>
    

// survey.css = myCss;
$("#SurveyRegisHIV").Survey({
    model: survey_RegisHiv,
    onComplete: sendDataToServerRegisHIV
});
</script>