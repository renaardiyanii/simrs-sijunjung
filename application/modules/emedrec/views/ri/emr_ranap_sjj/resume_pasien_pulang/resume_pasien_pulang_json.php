<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="ResumePasienPulang"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("resume_pasien_pulang.json",FILE_USE_INCLUDE_PATH);?>;





var resume_pasien_pulang = new Survey.Model(surveyJSON);



<?php 
if($resume_pulang){ 
      ?>
    resume_pasien_pulang.data = <?php echo isset($resume_pulang->formjson)?$resume_pulang->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#ResumePasienPulang").Survey({
    model: resume_pasien_pulang,
    // onComplete: sendDataToServer
});
</script>