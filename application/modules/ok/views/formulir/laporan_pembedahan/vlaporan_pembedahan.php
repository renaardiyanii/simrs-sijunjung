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

surveyJSONLaporanPembedahan = <?php echo file_get_contents("laporan_pembedahan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerLaporanPembedahan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_laporan_pembedahan/') ?>',
            data: {
                no_register : '<?php echo $no_register ;?>',
				id_ok : '<?php echo $id ;?>',
                laporan_pembedahan_json:JSON.stringify(survey.data),
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


    var survey_laporan_pembedahan = new Survey.Model(surveyJSONLaporanPembedahan);
    
    <?php if($laporan_pembedahan){ ?>
		survey_laporan_pembedahan.data = <?= $laporan_pembedahan->formjson; ?>
	<?php }else{ ?>
        
        <?php } ?>


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyLaporanOperasi").Survey({
    model: survey_laporan_pembedahan,
    onComplete: sendDataToServerLaporanPembedahan
});
</script>