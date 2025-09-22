<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="ResumePulangKeperawatan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("resume_pasien_pulang_keperawatan.json",FILE_USE_INCLUDE_PATH);?>;





var resume_pasien_pulang_keperawatan = new Survey.Model(surveyJSON);



<?php 
if($resume_pulang_keperawatan){ 
      ?>
    resume_pasien_pulang_keperawatan.data = <?php echo isset($resume_pulang_keperawatan->formjson)?$resume_pulang_keperawatan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#ResumePulangKeperawatan").Survey({
    model: resume_pasien_pulang_keperawatan,
    // onComplete: sendDataToServer
});
</script>