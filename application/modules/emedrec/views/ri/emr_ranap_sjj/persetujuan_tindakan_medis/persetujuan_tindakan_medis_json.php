<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PersetujuanTindakanMedis"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("persetujuan_tindakan_medis.json",FILE_USE_INCLUDE_PATH);?>;





var persetujuan_tindakan_medis = new Survey.Model(surveyJSON);



<?php 
if($persetujuan_medis){ 
      ?>
    persetujuan_tindakan_medis.data = <?php echo isset($persetujuan_medis->formjson)?$persetujuan_medis->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PersetujuanTindakanMedis").Survey({
    model: persetujuan_tindakan_medis,
    // onComplete: sendDataToServer
});
</script>