<?php 
$this->load->view('header_form');
 $diag = (isset($persetujuan_tind_kedokteran->row()->formjson)?json_decode($persetujuan_tind_kedokteran->row()->formjson):''); 
?>
<div id="PersiapanOperasi"></div>
<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("checklist_persiapan_operasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ok/okcdaftar/checklist_persiapan_operasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_register ;?>',
                id_ok : '<?php echo $id ;?>',
                persiapan_operasi_json:JSON.stringify(survey.data),
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


    var persiapan_operasi = new Survey.Model(surveyJSON);
    
    <?php
	if(isset($checklist_persiapan_operasi)){ ?>
		persiapan_operasi.data = <?php echo $checklist_persiapan_operasi->formjson ?>;

	<?php } else { ?>
            persiapan_operasi.data =  
            {"question10":{"Row 1":{"Column 1":"<?php echo $data_pasien->idrg ?>",
                "Column 2":"<?php echo isset($diag->question2->{'Row 1'}->isi_informasi)?$diag->question2->{'Row 1'}->isi_informasi:'' ?>"}}}
            
   <?php } ?>

$("#PersiapanOperasi").Survey({
    model: persiapan_operasi,
    onComplete: sendDataToServer
});
</script>