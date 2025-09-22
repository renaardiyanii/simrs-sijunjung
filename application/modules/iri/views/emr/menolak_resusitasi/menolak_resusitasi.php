<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyresusitasi"></div>

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

surveyJSONresusitasi = <?php echo file_get_contents("surat_menolak_resusitasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerresusitasi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_surat_menolak_resusitasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                surat_menolak_resusitasi_json:JSON.stringify(survey.data),
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


    var survey_resusitasi = new Survey.Model(surveyJSONresusitasi);

    <?php if($surat_resusitasi){ ?>
		survey_resusitasi.data = <?php echo isset($surat_resusitasi->formjson)?$surat_resusitasi->formjson:''; ?>
	<?php }else{ ?>
        survey_resusitasi.data = {"question2":{"text1":"<?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:''?>",
            "text2":"<?= isset($data_pasien[0]['tgl_lahir'])?date('d/m/Y',strtotime($data_pasien[0]['tgl_lahir'])):''?>"}}

    <?php } ?>
    

// survey.css = myCss;
$("#surveyresusitasi").Survey({
    model: survey_resusitasi,
    onComplete: sendDataToServerresusitasi
});
</script>