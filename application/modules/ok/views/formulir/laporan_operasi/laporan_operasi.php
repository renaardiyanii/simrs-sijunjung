<?php 
// $data_ok = isset($get_data_ok)?$get_data_ok:''; 
//  var_dump($get_data_ok);
$this->load->view('header_form');
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="SurveyLaporanOperasi"></div>
<script>
 

// Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

surveyJSONLaporanOperasi = <?php echo file_get_contents("laporan_operasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerLaporanOperasi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okchasil/laporan_operasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
				id_ok : '<?php echo $id ;?>',
                ews_json:JSON.stringify(survey.data),
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


    var survey_laporan_operasi = new Survey.Model(surveyJSONLaporanOperasi);
    
    <?php if($laporan_operasi){ ?>
		survey_laporan_operasi.data = <?= $laporan_operasi->formjson; ?>
	<?php }else{ ?>
        survey_laporan_operasi.data =
        {"question1":{"Row 1":{"Column 1":"<?= isset($get_data_ok->nm_dokter)?$get_data_ok->nm_dokter:'' ?>",
            "Column 2":"<?= isset($get_data_ok->nm_asis)?$get_data_ok->nm_asis:'' ?>",
            "Column 3":"<?= isset($get_data_ok->perawat_instrumen)?$get_data_ok->perawat_instrumen:'' ?>",
            "Column 4":"<?= isset($get_data_ok->nm_dokter_anes)?$get_data_ok->nm_dokter_anes:'' ?>",
            "Column 5":"<?= isset($get_data_ok->perawat_anas)?$get_data_ok->perawat_anas:'' ?>",
            "Column 6":"<?= isset($get_data_ok->jns_anes)?$get_data_ok->jns_anes:'' ?>",
            "Column 7":"<?= isset($get_data_ok->type_operasi)?$get_data_ok->type_operasi:'' ?>",
            "Column 8":"<?= isset($get_data_ok->nama_diagnosa)?$get_data_ok->nama_diagnosa:'' ?>",
            // "Column 9":"",
            // "Column 10":"",
            "Column 11":"<?= isset($get_data_ok->jenis_tindakan)?$get_data_ok->jenis_tindakan:'' ?>",
            // "Column 12":"",
            // "Column 13":"",
            // "Column 14":"sdf",
            // "Column 15":"sdf",
            // "Column 16":"sdf",
            // "Column 17":"item1",
            "Column 18":"<?= isset($get_data_ok->tgl_jadwal_ok)?date('d-m-Y',strtotime($get_data_ok->tgl_jadwal_ok)):'' ?>",
            "Column 19":"<?= isset($get_data_ok->intime_jadwal_ok)?$get_data_ok->intime_jadwal_ok:'' ?>",
            // "Column 20":"sdf",
            // "Column 21":"sdfsd"
        }},
            // "question2":"sdfs",
            // "question3":"sdfsd",
            // "question4":"sdfsdf"
        }
        <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyLaporanOperasi").Survey({
    model: survey_laporan_operasi,
    onComplete: sendDataToServerLaporanOperasi
});
</script>