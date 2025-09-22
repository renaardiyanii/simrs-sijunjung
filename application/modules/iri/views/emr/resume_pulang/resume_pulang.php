<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="card-header ">
        <div class="d-flex justify-content-between">
			<div class="d-flex">
             <button class="btn btn-danger pull-right" id="hapusData" data-id="<?= $no_ipd ?>">Ambil Data</button>
              
			</div>
		</div>
    </div>

    <div class="body">
        <div id="surveyresume_pulang"></div>
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
Survey.CustomWidgetCollection.Instance.setActivatedBy("select2", "type");

surveyJSONresume_pulang = <?php echo file_get_contents("resume_pulang.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerresume_pulang(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_resume_pulang/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                resume_pulang_json:JSON.stringify(survey.data),
                obat_pulang:JSON.stringify(survey.data.question15),
                tgl_resep_pulang:JSON.stringify(survey.data.question16),
                obat_pulang_racikan:JSON.stringify(survey.data.question19),
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


    var survey_resume_pulang = new Survey.Model(surveyJSONresume_pulang);

    <?php if($resume_pulang){ ?>
		survey_resume_pulang.data = <?php echo isset($resume_pulang->formjson)?$resume_pulang->formjson:''; ?>
	<?php }else{ ?>
        <?php
            function has_riwayat($obj) {
                return isset($obj) && is_object($obj) && !empty($obj->riwayat_penyakit);
            }

            if (has_riwayat($keluhan_pemfisik_neonatus)) {
                $keluhan = $keluhan_pemfisik_neonatus;
            } elseif (has_riwayat($keluhan_pemfisik_anak)) {
                $keluhan = $keluhan_pemfisik_anak;
            } else {
                $keluhan = $keluhan_pemfisik;
            }

        ?>

        survey_resume_pulang.data = {
            "question1": {
                "text1": "<?= isset($data_pasien[0]['tgl_masuk']) ? $data_pasien[0]['tgl_masuk'] : '' ?>",
                "text3": "<?= isset($ruang[0]['nmruang']) ? $ruang[0]['nmruang'] : '' ?>",
                "text4": "<?= isset($ruang[0]['carabayar']) ? $ruang[0]['carabayar'] : '' ?>",
                "text2": "<?= isset($subjective_last->tanggal_pemeriksaan) ? date('Y-m-d',strtotime($subjective_last->tanggal_pemeriksaan)) : '' ?>",
            },
            "question2": <?= json_encode(isset($keluhan->keluhan) ? $keluhan->keluhan : '') ?>,
            "question3": <?= json_encode(isset($keluhan->riwayat_penyakit) ? $keluhan->riwayat_penyakit : '') ?>,
            "question4": <?= json_encode(isset($keluhan->pem_fisik) ? $keluhan->pem_fisik : '') ?>,
            "question5": <?= json_encode(isset($keluhan->pem_penunjang) ? $keluhan->pem_penunjang : '') ?>,
            "question6": <?= json_encode(isset($keluhan->diagnosa_kerja) ? $keluhan->diagnosa_kerja : '') ?>,
            "question7": <?= json_encode(isset($keluhan->diagnosa_kerja) ? $keluhan->diagnosa_kerja : '') ?>,
            "question11": <?= json_encode(isset($keluhan->rencana_pengobatan) ? $keluhan->rencana_pengobatan : '') ?>,
            "question12": <?= json_encode(
                "Keluhan : ".  "\n" .
                (isset($subjective_last->subjective) ? $subjective_last->subjective : ''). "\n \n" .
                "Pemeriksaan fisik : " .  "\n" .
                "Tekanan darah : " . 
                (isset($pem_fisik_last->sitolic) ? $pem_fisik_last->sitolic . '/' . $pem_fisik_last->diatolic : '') . "\n" .
                "BB : " . 
                (isset($pem_fisik_last->bb) ? $pem_fisik_last->bb : '') . "\n" .
                "Nadi : " . 
                (isset($pem_fisik_last->nadi) ? $pem_fisik_last->nadi : '') . "\n" .
                "Saturasi Oksigen : " . 
                (isset($pem_fisik_last->oksigen) ? $pem_fisik_last->oksigen : '') . "\n" .
                "Frekuensi Nafas : " . 
                (isset($pem_fisik_last->frekuensi_nafas) ? $pem_fisik_last->frekuensi_nafas : '') . "\n" .
                "Suhu : " . 
                (isset($pem_fisik_last->suhu) ? $pem_fisik_last->suhu : '')
            ) ?>
        };

    <?php } ?>
    

// survey.css = myCss;
$("#surveyresume_pulang").Survey({
    model: survey_resume_pulang,
    onComplete: sendDataToServerresume_pulang
});
</script>

<script>
    $(document).ready(function () {
    $('#hapusData').on('click', function () {
        var id = $(this).data('id');
        console.log(id); // ini akan tampil jika data-id ada

        $.ajax({
            url: "<?= base_url('iri/rictindakan/delete_resume/') ?>" + id, // gabungkan di JS
            type: "POST",
            data: { no_ipd: id },
            success: function (response) {
                location.reload();
            },
            error: function () {
                alert('Gagal menghapus data!');
            }
        });
    });
});

</script>