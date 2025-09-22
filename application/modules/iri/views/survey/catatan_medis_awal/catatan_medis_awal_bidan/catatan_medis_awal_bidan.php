<?php
if(isset($assesment_keperawatan_iri[0]))
{
	$data_perawat = json_decode($assesment_keperawatan_iri[0]->formjson);
}
?>
<hr>
<div class="pl-4 pt-2">
	<a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_bidan/'.$no_ipd) ?>" class="btn btn-primary">Lihat Catatan Medis Awal Kebidanan</a>
</div>
<hr>

<div id="surveyCatatanMedisAwalBidan"></div>
<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonMedisBidan = <?php echo file_get_contents("catatan_medis_awal_bidan.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyCatatanMedisAwalBidan = new Survey.Model(surveyJsonMedisBidan);


    function sendDataToServerMedisBidan(survey) {
        
        $.ajax({
						url: "<?php echo base_url('iri/rictindakan/insert_assesment_awal_medis')?>",
						type : 'POST',
						data : {
							no_ipd:'<?php echo $no_ipd ;?>',
							formjson_bidan: JSON.stringify(survey.data)
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
            
    }


	<?php
	if($assesment_medis_iri->row()){ ?>
		surveyCatatanMedisAwalBidan.data = <?= $assesment_medis_iri->row()->formjson_bidan?$assesment_medis_iri->row()->formjson_bidan:''; ?>
	<?php }else{ ?>
		surveyCatatanMedisAwalBidan.data = {
			"keluhan_utama":"<?= isset($data_perawat->keluhan_utama)?$data_perawat->keluhan_utama:'' ?>",
			"laboratorium":"<?php
				if(isset($data_lab_by_noipd)){foreach($data_lab_by_noipd as $isi){
					
						echo '-'.' '.$isi->id_tindakan.' - '.$isi->jenis_tindakan.'\n';
				
				}}
				?>",
			"radiologi":"<?php
				if(isset($data_radiologi_by_noipd)){foreach($data_radiologi_by_noipd as $val){
					
						echo '-'.' '.$val->id_tindakan.' - '.$val->jenis_tindakan.'\n';
				
				}}
				?>",
			"lain_lain":"<?php
				if(isset($data_elektomedik_by_noipd)){foreach($data_elektomedik_by_noipd as $value){
					
						echo '-'.' '.$value->id_tindakan.' - '.$value->jenis_tindakan.'\n';
				
				}}
				?>"}
		<?php } ?>
   
    surveyCatatanMedisAwalBidan.render("surveyCatatanMedisAwalBidan");
    surveyCatatanMedisAwalBidan
        .onComplete
        .add(function (result) {
            sendDataToServerMedisBidan(result);
        });
</script>