<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PersiapanPerawatanDirumah"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("persiapan_perawatan_dirumah.json",FILE_USE_INCLUDE_PATH);?>;





var persiapan_perawatan_dirumah = new Survey.Model(surveyJSON);



<?php 
if($persiapan_dirumah){ 
      ?>
    persiapan_perawatan_dirumah.data = <?php echo isset($persiapan_dirumah->formjson)?$persiapan_dirumah->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PersiapanPerawatanDirumah").Survey({
    model: persiapan_perawatan_dirumah,
    // onComplete: sendDataToServer
});
</script>