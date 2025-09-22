<?php 
 
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="PengkajianResikoJatuhAnak"></div>
<script>

// Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

surveyJSONPengkajianREsikoJatuhAnak = <?php echo file_get_contents("pengkajian_resiko_jatuh_anak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPengkajianResikoJatuhAnak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/pengkajian_resiko_jatuh_anak/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                pengkajian_resiko_jatuh_anak_json:JSON.stringify(survey.data),
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


    var pengkajian_resiko_jatuh_anak_view = new Survey.Model(surveyJSONPengkajianREsikoJatuhAnak);
    

    <?php if($pengkajian_resiko_jatuh_anak->num_rows()){ ?>
		pengkajian_resiko_jatuh_anak_view.data = <?= $pengkajian_resiko_jatuh_anak->row()->formjson; ?>
	<?php }else{ ?>
        
      
        <?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#PengkajianResikoJatuhAnak").Survey({
    model: pengkajian_resiko_jatuh_anak_view,
    onComplete: sendDataToServerPengkajianResikoJatuhAnak
});
</script>