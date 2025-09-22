<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->

<div class="card m-5">
    <div class="body">
    <div id="SelisihTarif"></div>

    </div>
</div>

<script>

// Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

surveyJSONSelisihTarif = <?php echo file_get_contents("selisih_tarif.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerSelisihTarif(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/selisih_tarif/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                selisih_tarif_json:JSON.stringify(survey.data),
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


    var selisih_tarif_view = new Survey.Model(surveyJSONSelisihTarif);
    

    <?php if($selisih_tarif->num_rows()){ ?>
		selisih_tarif_view.data = <?= $selisih_tarif->row()->formjson; ?>
	<?php }else{ ?>
        selisih_tarif_view.data =  {"question1":{"text1":"<?= $data_pasien[0]['nama'] ?>",
            "text2":"<?= $data_pasien[0]['no_identitas'] ?>",
            "text3":"<?= $data_pasien[0]['alamat'] ?>"}}
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SelisihTarif").Survey({
    model: selisih_tarif_view,
    onComplete: sendDataToServerSelisihTarif
});
</script>