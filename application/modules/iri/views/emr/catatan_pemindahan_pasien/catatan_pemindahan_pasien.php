<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveycat_pemindahan"></div>

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

surveyJSONcatpemindahan = <?php echo file_get_contents("catatan_pemindahan_pasien.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServercatpemindahan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_catatan_pemindahan_pasien/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                catatan_pemindahan_pasien_json:JSON.stringify(survey.data),
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


    var survey_edukasi_cat_pemindahan_pasien = new Survey.Model(surveyJSONcatpemindahan);

    <?php if($cat_pemindahan_pasien){ ?>
		survey_edukasi_cat_pemindahan_pasien.data = <?php echo isset($cat_pemindahan_pasien->formjson)?$cat_pemindahan_pasien->formjson:''; ?>
	<?php }else{ ?>
        survey_edukasi_cat_pemindahan_pasien.data = {
            "question4": <?= json_encode(isset($data_igd->diagnosa) ? str_replace(['(utama)', '(tambahan)'], ["(utama)", "(tambahan)"], $data_igd->diagnosa) : '') ?>
        }

    <?php } ?>
    

// survey.css = myCss;
$("#surveycat_pemindahan").Survey({
    model: survey_edukasi_cat_pemindahan_pasien,
    onComplete: sendDataToServercatpemindahan
});
</script>