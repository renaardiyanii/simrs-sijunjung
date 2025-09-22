<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div class="card m-5">
    <div class="body">
    <div id="SurveyRingkasanPulangIgd"></div>

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

surveyJSONRingkasanPulangIgd = <?php echo file_get_contents("ringkasan_pulang_ird.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerRingkasanPulangIgd(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/ringkasan_pulang_igd/') ?>',
            data: {
                no_ipd : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                ringkasan_pulang_rd_json:JSON.stringify(survey.data),
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


    var survey_ringkasan_pulang_igd = new Survey.Model(surveyJSONRingkasanPulangIgd);
    


    <?php if($ringkasan_pulang){ ?>
		survey_ringkasan_pulang_igd.data = <?= $ringkasan_pulang->formjson; ?>
	<?php }else{ ?>
       
       survey_ringkasan_pulang_igd.data = {
            "diagnosa": "<?php 
                if (isset($diagnosa)) {
                    foreach ($diagnosa as $diag) { 
                        echo $diag->id_diagnosa . '-' . $diag->diagnosa . '(' . $diag->klasifikasi_diagnos . ')\\n';
                    }
                } 
            ?>",
            "tindakan": "<?php 
                if (!empty($get_data_tind)) {
                    foreach ($get_data_tind as $row) {
                        if (!empty($row->nmtindakan)) {
                            echo '- ' . str_replace("\n", " ", $row->nmtindakan) . "\\n";
                        }
                    }
                }
            ?>",
            "penatalaksana": [
                <?php if (!empty($get_obat)) : ?>
                    <?php foreach ($get_obat as $i => $obat) : ?>
                    {
                       
                        "nama_obat": "<?= isset($obat->nm_obat) ? addslashes($obat->nm_obat) : '' ?>",
                        "dosis": "<?= isset($obat->signa) ? $obat->signa : '' ?>"
                    }<?= $i < count($get_obat) - 1 ? ',' : '' ?>

                    <?php endforeach; ?>
                <?php endif; ?>
                ]

        };


        <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyRingkasanPulangIgd").Survey({
    model: survey_ringkasan_pulang_igd,
    onComplete: sendDataToServerRingkasanPulangIgd
});
</script>