<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="LapPendampingAnes"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("lap_pendamping_anestesi.json",FILE_USE_INCLUDE_PATH);?>;





var lap_pendamping_anestesi = new Survey.Model(surveyJSON);



<?php 
if($pendamping_anes){ 
      ?>
    lap_pendamping_anestesi.data = <?php echo isset($pendamping_anes->formjson)?$pendamping_anes->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#LapPendampingAnes").Survey({
    model: lap_pendamping_anestesi,
    // onComplete: sendDataToServer
});
</script>