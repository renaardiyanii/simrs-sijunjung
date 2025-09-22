<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianMedisAnak"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("medis_ranap_anak.json",FILE_USE_INCLUDE_PATH);?>;





var medis_ranap_anak = new Survey.Model(surveyJSON);



<?php 
if($medis_anak){ 
      ?>
    medis_ranap_anak.data = <?php echo isset($medis_anak->formjson)?$medis_anak->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianMedisAnak").Survey({
    model: medis_ranap_anak,
    // onComplete: sendDataToServer
});
</script>