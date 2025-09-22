<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PernyataanRadKontras"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pernyataan_rad_kontras.json",FILE_USE_INCLUDE_PATH);?>;





var pernyataan_rad_kontras = new Survey.Model(surveyJSON);



<?php 
if($per_rad_kontras){ 
      ?>
    pernyataan_rad_kontras.data = <?php echo isset($per_rad_kontras->formjson)?$per_rad_kontras->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PernyataanRadKontras").Survey({
    model: pernyataan_rad_kontras,
    // onComplete: sendDataToServer
});
</script>