<?php
if($assesment_perawat_igd)
{
	$data_igd = json_decode($assesment_perawat_igd->formjson);
}
// var_dump($assesment_keperawatan_iri);
// var_dump($data_fisik);
?>

<hr/>

<div class="ml-4 mt-4">
	Pilih Halaman :
	<select id="pageSelector" onchange="survey.currentPageNo = this.value"></select>
	<a href="<?= base_url('emedrec/c_emedrec_iri/assesment_awal_keperawatan/'.$no_ipd.'/'.$data_pasien[0]['no_cm']); ?>" target="_blank" class="btn btn-primary"> Lihat Assesment </a>
</div>
<hr/>
<div>
		<div id="surveyKeperawatanDewasa"></div>
</div>
<script>
    Survey.StylesManager.applyTheme("modern");
	function doOnCurrentPageChanged(survey) {
		document
			.getElementById('pageSelector')
			.value = survey.currentPageNo;
		document
			.getElementById('surveyPrev')
			.style
			.display = !survey.isFirstPage
				? "inline"
				: "none";
		document
			.getElementById('surveyNext')
			.style
			.display = !survey.isLastPage
				? "inline"
				: "none";
		document
			.getElementById('surveyComplete')
			.style
			.display = survey.isLastPage
				? "inline"
				: "none";
		document
			.getElementById('surveyProgress')
			.innerText = "Page " + (
		survey.currentPageNo + 1) + " of " + survey.visiblePageCount + ".";
		if (document.getElementById('surveyPageNo')) 
			document
				.getElementById('surveyPageNo')
				.value = survey.currentPageNo;
		}
	function setupPageSelector(survey) {
		var selector = document.getElementById('pageSelector');
		for (var i = 0; i < survey.visiblePages.length; i++) {
			var option = document.createElement("option");
			option.value = i;
			option.text = "Page " + (
			i + 1);
			selector.add(option);
		}
	}

    surveyJSONKeperawatanDewasa = <?php echo file_get_contents("assesment_awal_keperawatan.json",FILE_USE_INCLUDE_PATH);?>;
    var survey_dewasa = new Survey.Model(surveyJSONKeperawatanDewasa);

	<?php
	// var_dump($assesment_keperawatan_iri);
	if(count($assesment_keperawatan_iri)>0){
	?>
	survey_dewasa.data = <?= $assesment_keperawatan_iri[0]->formjson ?>
	<?php }else{ ?>
		
		survey_dewasa.data = {
			"kesadaran": "<?= $data_fisik->kesadaran_pasien??''; ?>",
			"question647":"<?= $data_pasien[0]['pendidikan']??''; ?>",
			"question150":"<?= $data_pasien[0]['pekerjaan']??''; ?>","question152":"<?= $data_pasien[0]['wnegara']??'' ?>",
		"assesment_resiko_jatuh":{
			"result":{
				"1":"<?= isset($data_igd->riwayat_jatuh)?$data_igd->riwayat_jatuh == 'ya'?"25":'0':'0' ?>",
				"2":"<?= isset($data_igd->penyakit_penyerta)?$data_igd->penyakit_penyerta == 'ya'?"1":'0':'0' ?>",
				"3":"<?php
				if(isset($data_igd->alat_bantu_jalan)){
					switch($data_igd->alat_bantu_jalan){
						case 'penopang_tongkat':
							echo '15';
							break;
						case 'tidak_ada_bed':
							echo '0';
							break;
						case 'berpegangan':
							echo '30';
							break;
					}

				}else{
					echo '0';
				}
				?>",
				"4":"<?= isset($data_igd->pemakaian_terapi_heparin)?$data_igd->pemakaian_terapi_heparin == 'ya'?"20":'0':'' ?>",
				"5":"<?php
				if(isset($data_igd->cara_berjalan)){
					switch($data_igd->cara_berjalan){
						case 'normal_bed':
							echo '0';
							break;
						case 'lemah':
							echo '10';
							break;
						case 'tergangu':
							echo '20';
							break;
					}
				}else{
					echo '0';
				}
				?>",
				"6":"<?php
				if(isset($data_igd->status_mental)){
					switch($data_igd->status_mental){
						case 'orientasi':
							echo '0';
							break;
						case 'lupa_keterbatasan_diri':
							echo '15';
							break;
					}

				}else{
					echo '0';
				}
				?>",
			}
		},
		"question6":[
			<?= isset($data_igd->check_keamanan)?in_array("pasang_pengaman", $data_igd->check_keamanan)?"pasang_pengaman":"":'' ?>,
			<?= isset($data_igd->check_keamanan)?in_array("penanda_segitiga_resiko", $data_igd->check_keamanan)?"penanda_segitiga_resiko":"":'' ?>,
			<?= isset($data_igd->check_keamanan)?in_array("kunci_roda_tempat_tidur", $data_igd->check_keamanan)?"kunci_roda_tempat_tidur":"":'' ?>
		],
		"question629":"<?= isset($data_igd->keamanan)?$data_igd->keamanan=='ya'?'ya':'tidak':'' ?>",
		"skrining_gizi":{
			"result":{
				"1":"<?php
				if(isset($data_igd->check_parameter)){
					switch($data_igd->check_parameter){
						case 'item1': //1-5
							echo '1';
							break;
						case 'item2'://6-10
							echo '2';
							break;
						case 'item3'://11-15
							echo '3';
							break;
						case 'item4'://>15
							echo '4';
							break;
						case 'item5'://tidak yakin
							echo '2';
							break;
					}

				}else{
					if(isset($data_igd->parameter)){
						switch ($data_igd->parameter) {
							case 'tidak_ada_penurunan':
								echo '0';
								break;
							case 'tidak_yakin':
								echo '0';
								break;
							case 'jika_ya':
								echo '2';
								break;
							
							
						}
					}
				}
				?>",
				"2":"<?php
				if(isset($data_igd->parameter1)){
					switch($data_igd->parameter1){
						case 'ya':
							echo '1';
							break;
						case 'tidak':
							echo '0';
							break;
					}

				}else{
					echo '0';
				}
				?>"
			}
		}
		};

		survey_dewasa.setValue('e','<?= isset($data_fisik->e_gcs)?$data_fisik->e_gcs:''; ?>');
		survey_dewasa.setValue('m','<?= isset($data_fisik->m_gcs)?$data_fisik->m_gcs:''; ?>');
		survey_dewasa.setValue('v','<?= isset($data_fisik->v_gcs)?$data_fisik->v_gcs:''; ?>');
		survey_dewasa.setValue('suhu','<?= isset($data_fisik->suhu)?$data_fisik->suhu:''; ?>');
		survey_dewasa.setValue('nadi','<?= isset($data_fisik->nadi)?$data_fisik->nadi:'' ?>');
		survey_dewasa.setValue('pernafasan','<?= isset($data_fisik->frekuensi_nafas)?$data_fisik->frekuensi_nafas:'' ?>');
		survey_dewasa.setValue('tekanan_darah','<?= isset($data_fisik->sitolic)?$data_fisik->sitolic.'/'.$data_fisik->diatolic:'' ?>');
		survey_dewasa.setValue('tb','<?= isset($data_fisik->tb)?$data_fisik->tb:'' ?>');
		survey_dewasa.setValue('bb','<?= isset($data_fisik->bb)?$data_fisik->bb:'' ?>');
		survey_dewasa.setValue('question380','<?= isset($data_igd->stat_psikologis)?$data_igd->stat_psikologis:'' ?>');
		survey_dewasa.setValue('cara_masuk','<?= isset($data_pasien_rj[0])?$data_pasien_rj[0]['kekhususan']:'' ?>');
		survey_dewasa.setValue('asal_masuk','<?= isset($data_pasien_rj[0])?$data_pasien_rj[0]['id_poli']!='BA00'?'rawat_jalan':'igd':'' ?>');
	<?php } ?>



    function sendDataToServerDewasa(survey) {
        // new Swal ({
		// 	title: 'Simpan Data?',
		// 	text: "Apakah Anda Yakin Dengan data Tersebut!",
		// 	icon: 'warning',
		// 	showCancelButton: true,
		// 	confirmButtonColor: '#3085d6',
		// 	cancelButtonColor: '#d33',
		// 	confirmButtonText: 'Ya, Simpan Data'
		// 	}).then((result) => {
		// 	if (result.isConfirmed) {
				$.ajax({
						url: "<?php echo base_url('iri/rictindakan/insert_assesment_awal_keperawatan/')?>",
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
			// 	};
	
			// });
            
    }

    survey_dewasa.render("surveyKeperawatanDewasa");
    survey_dewasa
        .onComplete
        .add(function (result) {
            sendDataToServerDewasa(result);
        });

		survey_dewasa
    .onCurrentPageChanged
    .add(doOnCurrentPageChanged);

	setupPageSelector(survey_dewasa);
	doOnCurrentPageChanged(survey_dewasa);
</script>