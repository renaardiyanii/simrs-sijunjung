<?php 
$this->load->view('layout/header_form');
?>


<div class="card m-5">
    <div class="body">
	<div id="surveyEdukasiPasien"></div>

    </div>
</div>

<script type='text/javascript'>
// $(document).ready(function(){
	Survey.StylesManager.applyTheme("modern");
	var surveyEdukasiPasienJSON =  <?php echo file_get_contents("edukasi_pasien.json",FILE_USE_INCLUDE_PATH) ?>;


	function sendDataToEdukasiPasien(survey) {
		$.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_edukasi_pasien/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                formjson:JSON.stringify(survey.data),
            },
            success: function(data)
            {
            
                location.reload();
                

            },
            error: function(data)
            {
                
            }
        }); 

	}
	var surveyEdukasiPasien = new Survey.Model(surveyEdukasiPasienJSON);

	<?php if($catatan_edukasi->num_rows()){ ?>
		surveyEdukasiPasien.data = <?= $catatan_edukasi->row()->formjson; ?>
	<?php }else{ ?>
		surveyEdukasiPasien.setValue('ruangan_ranap','<?= $data_pasien[0]['nmruang'] ?>');
	<?php } ?>


	// survey.isSinglePage = true;
	$("#surveyEdukasiPasien").Survey({
		model: surveyEdukasiPasien,
		onComplete: sendDataToEdukasiPasien
	});
// });


</script>
									

