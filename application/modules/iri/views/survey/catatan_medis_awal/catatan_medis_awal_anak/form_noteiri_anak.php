<div class="pl-4 pt-2">
	<a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_rawat_inap_anak/'.$no_ipd.'/'.$data_pasien[0]['no_medrec'].'/'.$data_pasien[0]['no_cm']) ?>" class="btn btn-primary">Lihat Catatan Medis Awal Anak</a>
</div>
   
<div id="surveyContainerMedisAnak"></div>


   <script type='text/javascript'>
$(document).ready(function(){
	Survey.StylesManager.applyTheme("modern");
	var survey_anak =  <?php echo file_get_contents("form_noteiri_anak.json",FILE_USE_INCLUDE_PATH); ?>;


	function sendDataToAssesmentAnak(survey) {
		Swal.fire({
			title: 'Simpan Data?',
			text: "Apakah Anda Yakin Dengan data Tersebut!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Simpan Data'
			}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
						url: "<?php echo base_url('iri/rictindakan/insert_assesment_awal_medis')?>",
						type : 'POST',
						data : {
							no_ipd:'<?php echo $no_ipd ;?>',
							formjson_anak: JSON.stringify(survey.data)
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
							new swal('Berhasil!','Data Berhasil Disimpan','success');
							window.location.reload();
						},
							error: function(e){
								new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');

							}
					});
				};
	
			});
	}
	var surveyAnak = new Survey.Model(survey_anak);
	<?php
	if($assesment_medis_iri->row()){ ?>
		surveyAnak.data = <?= $assesment_medis_iri->row()->formjson_anak?$assesment_medis_iri->row()->formjson_anak:'' ?>
	<?php } ?>
	


	// survey.isSinglePage = true;
	$("#surveyContainerMedisAnak").Survey({
		model: surveyAnak,
		onComplete: sendDataToAssesmentAnak
	});
});


</script>
									

