<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="SuratKelahiran"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("suket_kelahiran.json",FILE_USE_INCLUDE_PATH);?>;





var suket_kelahiran = new Survey.Model(surveyJSON);



<?php 
if($surat_kelahiran){ 
      ?>
    suket_kelahiran.data = <?php echo isset($surat_kelahiran->formjson)?$surat_kelahiran->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#SuratKelahiran").Survey({
    model: suket_kelahiran,
    // onComplete: sendDataToServer
});
</script>