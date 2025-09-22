<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianDekubitus"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_dekubitus.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_dekubitus = new Survey.Model(surveyJSON);



<?php 
if($peng_dekubitus){ 
      ?>
    pengkajian_dekubitus.data = <?php echo isset($peng_dekubitus->formjson)?$peng_dekubitus->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianDekubitus").Survey({
    model: pengkajian_dekubitus,
    // onComplete: sendDataToServer
});
</script>