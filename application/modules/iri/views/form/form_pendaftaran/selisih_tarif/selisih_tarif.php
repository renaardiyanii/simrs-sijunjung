<?php 
	$tahunpj = '';
	$gen = isset($general_consent[0]->formjson)?json_decode($general_consent[0]->formjson):'';
	if($gen != ''){
		$birthDate = isset($gen->question23->tgl_lahir)?new DateTime( $gen->question23->tgl_lahir.' 00:00:00'):'';
		if($birthDate != ''){
			$today = new DateTime("today");
			$tahunpj = $today->diff($birthDate)->y. ' Tahun';
		}
	}

?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="SelisihTarif"></div>



<script>
    // Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

    Survey.StylesManager.applyTheme("modern");

    surveyJSONSelisihTarif = <?php echo file_get_contents("selisih_tarif.json", FILE_USE_INCLUDE_PATH); ?>;

    function sendDataToServerSelisihTarif(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/selisih_tarif/') ?>',
            data: {
                no_ipd: '<?php echo $no_ipd; ?>',
                selisih_tarif_json: JSON.stringify(survey.data),
            },
            success: function(data) {

                location.reload();


            },
            error: function(data) {

            }
        });
        //  console.log(JSON.stringify(survey.data));

    }


    var selisih_tarif_view = new Survey.Model(surveyJSONSelisihTarif);


    <?php if ($selisih_tarif) { ?>
        selisih_tarif_view.data = <?= $selisih_tarif->formjson; ?>
    <?php } else { ?>
        selisih_tarif_view.data = {
            "data": {
                "text1": "<?php echo isset($data_pasien_iri->nmpjawabri) ? $data_pasien_iri->nmpjawabri : '' ?>",
                "text2": "<?php echo isset($data_pasien_iri->noidpjawab) ? $data_pasien_iri->noidpjawab : '' ?>",
                "text3": "<?php echo isset($data_pasien_iri->alamatpjawabri) ? $data_pasien_iri->alamatpjawabri : '' ?>",
                'text4':'<?php echo $tahunpj ?>',
            },
            "question1": {
                "text1": "<?php echo isset($data_pasien[0]['nama']) ? $data_pasien[0]['nama'] : "" ?>",
                "text2": "<?php echo isset($data_pasien[0]['no_identitas']) ? $data_pasien[0]['no_identitas'] : "" ?>",
                'text3':'<?php echo isset($data_pasien[0]['alamat']) ? trim($data_pasien[0]['alamat']) : '' ?>',
            },
            "question2": "<?php echo isset($data_pasien_iri->hubpjawabri) ? $data_pasien_iri->hubpjawabri : "" ?>"
        }
    <?php } ?>

    // survey_ews.showNavigationButtons = false;







    // survey.css = myCss;
    $("#SelisihTarif").Survey({
        model: selisih_tarif_view,
        onComplete: sendDataToServerSelisihTarif
    });
</script>