<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyKeteranganKematian"></div>

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

surveyJSONketerangankematian = <?php echo file_get_contents("surat_keterangan_kematian.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPengantarRawatInap(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/suket_kematian/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                suket_kematian_json:JSON.stringify(survey.data),
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


    var survey_keterangan_kematian = new Survey.Model(surveyJSONketerangankematian);

    
    <?php if($ket_kematian){ ?>
		survey_keterangan_kematian.data = <?php echo isset($ket_kematian->formjson)?$ket_kematian->formjson:''; ?>
	<?php  }else{ ?>
      
        <?php  } ?>

// survey.css = myCss;
$("#SurveyKeteranganKematian").Survey({
    model: survey_keterangan_kematian,
    onComplete: sendDataToServerPengantarRawatInap
});
</script>