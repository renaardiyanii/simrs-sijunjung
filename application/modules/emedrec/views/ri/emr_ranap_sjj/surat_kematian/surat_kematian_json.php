<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="SuratKematian"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("surat_kematian.json",FILE_USE_INCLUDE_PATH);?>;





var surat_kematian = new Survey.Model(surveyJSON);



<?php 
if($sur_kematian){ 
      ?>
    surat_kematian.data = <?php echo isset($sur_kematian->formjson)?$sur_kematian->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#SuratKematian").Survey({
    model: surat_kematian,
    // onComplete: sendDataToServer
});
</script>