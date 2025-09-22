<?php 
$this->load->view('layout/header_form');
// var_dump($diagnosa->diagnosa)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyTransfusiDarah"></div>

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

surveyJSONtransfusidarah = <?php echo file_get_contents("transfusi_darah.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerTransfusiDarah(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/transfusi_darah/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                transfusi_darah_json:JSON.stringify(survey.data),
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


    var survey_transfusi_darah = new Survey.Model(surveyJSONtransfusidarah);

    
    <?php if($transfusi_darah){ ?>
		survey_transfusi_darah.data = <?php echo isset($transfusi_darah->formjson)?$transfusi_darah->formjson:''; ?>
	<?php }else{ ?>
        survey_transfusi_darah.data = {
            "question1": {
                "item1": {
                    "dr": "<?= isset($data_dokter->dokter) ? $data_dokter->dokter : '' ?>",
                    "noreg": "<?= isset($no_cm) ? $no_cm : '' ?>",
                    "nm_os": "<?= isset($data_pasien_daftar_ulang->nama) ? $data_pasien_daftar_ulang->nama : '' ?>",
                    "alamat": "<?= isset($data_pasien_daftar_ulang->alamat) ? $data_pasien_daftar_ulang->alamat : '' ?>",
                    "diagnosa": "<?php 
                        if (isset($diagnosa)) {
                            // $diagnosa_list = '';
                            foreach ($diagnosa as $diag) { 
                              echo   $diag->id_diagnosa . '-' . $diag->diagnosa . '(' . $diag->klasifikasi_diagnos . ')\n';
                            }
                            //  $diagnosa_list;
                        }
                    ?>",
                      "jk": "<?= isset($data_pasien->sex) ? $data_pasien->sex : '' ?>",
                   
                }
            }
        };

        <?php } ?>

// survey.css = myCss;
$("#SurveyTransfusiDarah").Survey({
    model: survey_transfusi_darah,
    onComplete: sendDataToServerTransfusiDarah
});
</script>