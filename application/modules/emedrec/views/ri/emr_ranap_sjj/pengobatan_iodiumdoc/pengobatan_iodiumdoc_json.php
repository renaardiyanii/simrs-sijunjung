<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengobatanIodiumdoc"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengobatan_iodiumdoc.json",FILE_USE_INCLUDE_PATH);?>;





var pengobatan_iodiumdoc = new Survey.Model(surveyJSON);



<?php 
if($surat_iodiumdoc){ 
      ?>
    pengobatan_iodiumdoc.data = <?php echo isset($surat_iodiumdoc->formjson)?$surat_iodiumdoc->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengobatanIodiumdoc").Survey({
    model: pengobatan_iodiumdoc,
    // onComplete: sendDataToServer
});
</script>