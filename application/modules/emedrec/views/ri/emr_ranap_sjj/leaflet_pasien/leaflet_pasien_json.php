<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="LeafletPasien"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("leaflet_pasien.json",FILE_USE_INCLUDE_PATH);?>;





var leaflet_pasien = new Survey.Model(surveyJSON);



<?php 
if($leaflet){ 
      ?>
    leaflet_pasien.data = <?php echo isset($leaflet->formjson)?$leaflet->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#LeafletPasien").Survey({
    model: leaflet_pasien,
    // onComplete: sendDataToServer
});
</script>