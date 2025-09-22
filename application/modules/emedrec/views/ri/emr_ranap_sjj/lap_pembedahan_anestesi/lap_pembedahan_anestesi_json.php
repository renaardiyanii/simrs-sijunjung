<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="LapPembedahanAnestesi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("lap_pembedahan_anestesi.json",FILE_USE_INCLUDE_PATH);?>;





var lap_pembedahan_anestesi_lokal = new Survey.Model(surveyJSON);



<?php 
if($anes_lokal){ 
      ?>
    lap_pembedahan_anestesi_lokal.data = <?php echo isset($anes_lokal->formjson)?$anes_lokal->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#LapPembedahanAnestesi").Survey({
    model: lap_pembedahan_anestesi_lokal,
    // onComplete: sendDataToServer
});
</script>