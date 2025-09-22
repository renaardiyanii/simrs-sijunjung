<?php 
$this->load->view('layout/header_form');
// var_dump($diagnosa)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveySuratRujukan"></div>

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

surveyJSONsuratrujukan = <?php echo file_get_contents("surat_rujukan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServersuratrujukan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayananfdokter/surat_rujukan/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                surat_rujukan_json:JSON.stringify(survey.data),
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


    var survey_surat_rujukan = new Survey.Model(surveyJSONsuratrujukan);

    
    <?php if($surat_rujukan){ ?>
		survey_surat_rujukan.data = <?php echo isset($surat_rujukan->formjson)?$surat_rujukan->formjson:''; ?>
	<?php }else{ ?>
        survey_surat_rujukan.data = {
            <?php 
                $lahir = new DateTime($data_pasien_daftar_ulang->tgl_lahir); // Tanggal lahir dari database
                $hariIni = new DateTime(); // Tanggal sekarang
                $umur = $hariIni->diff($lahir)->y; // Menghitung selisih tahun (umur)
                ?>
            
            "question2":{"nama":"<?= isset($data_pasien_daftar_ulang->nama) ? $data_pasien_daftar_ulang->nama : '' ?>","umur": "<?= $umur . ' tahun' ?>","no_kartu":"<?= isset($data_pasien_daftar_ulang->no_kartu) ? $data_pasien_daftar_ulang->no_kartu : '' ?>",
           "diagnosa":"<?php 
            if(isset($diagnosa)){
                foreach($diagnosa as $diag){ 
                    if($diag->klasifikasi_diagnos == 'utama'){
                        echo  $diag->id_diagnosa.'-'.$diag->diagnosa;
                    }
                }
            } ?>"
            }
        }
        
        <?php } ?>

// survey.css = myCss;
$("#SurveySuratRujukan").Survey({
    model: survey_surat_rujukan,
    onComplete: sendDataToServersuratrujukan
});
</script>