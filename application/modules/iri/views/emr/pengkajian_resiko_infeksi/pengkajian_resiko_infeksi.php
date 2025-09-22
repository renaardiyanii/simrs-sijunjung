<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyresiko_infeksi"></div>

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

surveyJSONresiko_infeksi = <?php echo file_get_contents("pengkajian_resiko_infeksi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerresiko_infeksi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_pengkajian_resiko_infeksi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_resiko_infeksi_json:JSON.stringify(survey.data),
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


    var survey_resiko_infeksi = new Survey.Model(surveyJSONresiko_infeksi);

    <?php if($resiko_infeksi){ ?>
		survey_resiko_infeksi.data = <?php echo isset($resiko_infeksi->formjson)?$resiko_infeksi->formjson:''; ?>
	<?php }else{ ?>
        survey_resiko_infeksi.data = {"question1":{"text1":"<?= isset($ruang[0]['nmruang'])?$ruang[0]['nmruang']:''?>"},
        "question2": <?= json_encode(isset($data_igd->diagnosa) ? str_replace(['(utama)', '(tambahan)'], ["(utama)", "(tambahan)"], $data_igd->diagnosa) : '') ?>,
      
    }

    <?php } ?>
    

// survey.css = myCss;
$("#surveyresiko_infeksi").Survey({
    model: survey_resiko_infeksi,
    onComplete: sendDataToServerresiko_infeksi
});
</script>