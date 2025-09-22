<?php
// $skor = (isset($laporan_persalinan->formjson)?json_decode($laporan_persalinan->formjson):''); 
$skor = (isset($laporan_persalinan->formjson)?json_decode($laporan_persalinan->formjson):''); 
// var_dump($skor->question4->{'Row 1'}->{'1'});die();
?>
<div class="pl-4 pt-2">
	<a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/assesment_awal_bayi/'.$no_ipd) ?>" class="btn btn-primary">Lihat Catatan Medis Awal Neonatus</a>
</div>
<div>
		<div id="surveyKeperawatanBayi"></div>
</div>
<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJSONKeperawatanBayi = <?php echo file_get_contents("keperawatan_bayi.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyKeperawatanBayi = new Survey.Model(surveyJSONKeperawatanBayi);
	
    function sendDataToServerKeperawatanBayi(survey) {

        $.ajax({
						url: "<?php echo base_url('iri/rictindakan/insert_assesment_awal_keperawatan_bayi/')?>",
						type : 'POST',
						data : {
							no_ipd:'<?php echo $no_ipd ;?>',
							data: JSON.stringify(survey.data)
						},
						datatype:'json',
					
						beforeSend:function()
						{
						},      
						complete:function()
						{
						//stopPreloader();
						},
						success:function(data)
						{
							// new swal('Berhasil!','Data Berhasil Disimpan','success');
							// location.reload(); 
							window.location.reload();
						},
							error: function(e){
								new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
								
							}
					});
            
    }

    <?php
	if(count($assesment_keperawatan_iri)>0){
	?>
	surveyKeperawatanBayi.data = <?= $assesment_keperawatan_iri[0]->formjson_bayi ?>
	<?php }else{?>
		surveyKeperawatanBayi.data = {"apgar_skore":{"1menit":
			{"1":"<?= isset($skor->question4->{'Row 1'}->{'1'})?$skor->question4->{'Row 1'}->{'1'}:'' ?>",
			"2":"<?= isset($skor->question4->{'Row 1'}->{'2'})?$skor->question4->{'Row 1'}->{'2'}:'' ?>",
			"3":"<?= isset($skor->question4->{'Row 1'}->{'3'})?$skor->question4->{'Row 1'}->{'3'}:'' ?>",
			"4":"<?= isset($skor->question4->{'Row 1'}->{'4'})?$skor->question4->{'Row 1'}->{'4'}:'' ?>",
			"5":"<?= isset($skor->question4->{'Row 1'}->{'5'})?$skor->question4->{'Row 1'}->{'5'}:'' ?>",
			"total_skore":'<?= isset($skor->question4->{'Row 1'}->total_skor)?$skor->question4->{'Row 1'}->total_skor:'' ?>'},
			"2menit":{"1":"<?= isset($skor->question4->{'Row 2'}->{'1'})?$skor->question4->{'Row 2'}->{'1'}:'' ?>",
				"2":"<?= isset($skor->question4->{'Row 2'}->{'2'})?$skor->question4->{'Row 2'}->{'2'}:'' ?>",
				"3":"<?= isset($skor->question4->{'Row 2'}->{'3'})?$skor->question4->{'Row 2'}->{'3'}:'' ?>",
				"4":"<?= isset($skor->question4->{'Row 2'}->{'4'})?$skor->question4->{'Row 2'}->{'4'}:'' ?>",
				"5":"<?= isset($skor->question4->{'Row 2'}->{'5'})?$skor->question4->{'Row 2'}->{'5'}:'' ?>",
				"total_skore":'<?= isset($skor->question4->{'Row 2'}->total_skor)?$skor->question4->{'Row 2'}->total_skor:'' ?>'}}}
		<?php } ?>
       

   
       
    

    surveyKeperawatanBayi.render("surveyKeperawatanBayi");
    surveyKeperawatanBayi
        .onComplete
        .add(function (result) {
            sendDataToServerKeperawatanBayi(result);
        });

        surveyKeperawatanBayi
    .onCurrentPageChanged
    .add(doOnCurrentPageChanged);

	setupPageSelector(surveyKeperawatanBayi);
	doOnCurrentPageChanged(surveyKeperawatanBayi);
</script>