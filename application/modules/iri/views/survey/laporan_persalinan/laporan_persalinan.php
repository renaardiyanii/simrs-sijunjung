<?php $this->load->view('layout/header_form') ?>

<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<div class="card m-5">
		<div class="body">
		<a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/laporan_persalinan/'.$no_ipd) ?>" class="btn btn-primary">Lihat Laporan Persalinan</a>
		<div id="surveyLaporanPersalinan"></div>

    	</div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonLaporanPersalinan = <?php echo file_get_contents("laporan_persalinan.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyLaporanPersalinan = new Survey.Model(surveyJsonLaporanPersalinan);


    function sendDataToServerLaporanPersalinan(survey) {
        
        $.ajax({
						url: "<?php echo base_url('iri/rictindakan/insert_laporan_persalinan')?>",
						type : 'POST',
						data : {
							no_ipd:'<?php echo $no_ipd ;?>',
							formjson: JSON.stringify(survey.data)
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
	if(isset($laporan_persalinan)){ ?>
		surveyLaporanPersalinan.data = <?= $laporan_persalinan->formjson ?>;
	<?php } ?>

	
   
    surveyLaporanPersalinan.render("surveyLaporanPersalinan");
    surveyLaporanPersalinan
        .onComplete
        .add(function (result) {
            sendDataToServerLaporanPersalinan(result);
        });
</script>