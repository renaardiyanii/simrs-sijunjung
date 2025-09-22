<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="MedisRanapNeonatus"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("medis_ranap_neonatus.json",FILE_USE_INCLUDE_PATH);?>;





var medis_ranap_neonatus = new Survey.Model(surveyJSON);



<?php 
if($medis_neo){ 
      ?>
    medis_ranap_neonatus.data = <?php echo isset($medis_neo->formjson)?$medis_neo->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#MedisRanapNeonatus").Survey({
    model: medis_ranap_neonatus,
    // onComplete: sendDataToServer
});
</script>