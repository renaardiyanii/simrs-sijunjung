<?php 
$data = (isset($surat_persetujuan_iri[0]->formjson)?json_decode($surat_persetujuan_iri[0]->formjson):'');
// var_dump();die();
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="SelisihTarif"></div>



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
    

    <?php if($selisih_tarif) { ?>
		selisih_tarif_view.data = <?= $selisih_tarif->formjson; ?>
	<?php }else{ ?>
        selisih_tarif_view.data =  {"question1":{"text1":"<?= $data_pasien[0]['nama'] ?>",
        "text2":"<?= $data_pasien[0]['no_identitas'] ?>",
        "text3":"<?= $data_pasien[0]['alamat'] ?>"},
        "data":{"text1":"<?php echo isset($data_pasien_iri->nmpjawabri)?$data_pasien_iri->nmpjawabri:'' ?>",
            "text2":"<?php echo  isset($data_pasien_iri->kartuidpjawab)?$data_pasien_iri->kartuidpjawab:'' ?>",
            "text4":"",
            "text3":"<?php echo isset($data_pasien_iri->alamatpjawabri)?$data_pasien_iri->alamatpjawabri:"" ?>"},
        "question2":"<?php echo isset($data_pasien_iri->hubpjawabri)?$data_pasien_iri->hubpjawabri:"" ?>",
        "question7":"<?php echo isset($data->ttd_1)?$data->ttd_1:"" ?>"
    }

        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SelisihTarif").Survey({
    model: selisih_tarif_view,
    onComplete: sendDataToServerSelisihTarif
});
</script>