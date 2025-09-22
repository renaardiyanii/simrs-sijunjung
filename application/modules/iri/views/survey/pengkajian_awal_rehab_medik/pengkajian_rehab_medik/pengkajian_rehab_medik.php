<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->

<div class="card m-5">
    <div class="body">
    <div id="PengkajianRehabMedik"></div>

    </div>
</div>

<script>

// Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

surveyJSONPengkajianRehabMedik = <?php echo file_get_contents("pengkajian_rehab_medik.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPengkajianRehabMedik(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/pengkajian_rehab_medik/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                pengkajian_rehab_medik_json:JSON.stringify(survey.data),
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


    var pengkajian_rehab_medik_view = new Survey.Model(surveyJSONPengkajianRehabMedik);
    

    <?php if($pengkajian_rehab_medik->num_rows()){ ?>
		pengkajian_rehab_medik_view.data = <?= $pengkajian_rehab_medik->row()->formjson; ?>
	<?php }else{ ?>
        pengkajian_rehab_medik_view.data =
        {"question1":{"text1":"<?= $data_pasien[0]['no_cm'] ?>",
            "text2":"<?= $data_pasien[0]['nama'] ?>",
            "text3":"<?= $data_pasien[0]['tgl_lahir'] ?>",
           }};
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#PengkajianRehabMedik").Survey({
    model: pengkajian_rehab_medik_view,
    onComplete: sendDataToServerPengkajianRehabMedik
});
</script>