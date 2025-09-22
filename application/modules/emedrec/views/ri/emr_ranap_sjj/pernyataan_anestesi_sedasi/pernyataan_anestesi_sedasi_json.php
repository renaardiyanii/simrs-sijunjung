<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PernyataanAnestesiSedasi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pernyataan_anestesi_sedasi.json",FILE_USE_INCLUDE_PATH);?>;





var pernyataan_anestesi_sedasi = new Survey.Model(surveyJSON);



<?php 
if($per_anestesi_sedasi){ 
      ?>
    pernyataan_anestesi_sedasi.data = <?php echo isset($per_anestesi_sedasi->formjson)?$per_anestesi_sedasi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PernyataanAnestesiSedasi").Survey({
    model: pernyataan_anestesi_sedasi,
    // onComplete: sendDataToServer
});
</script>