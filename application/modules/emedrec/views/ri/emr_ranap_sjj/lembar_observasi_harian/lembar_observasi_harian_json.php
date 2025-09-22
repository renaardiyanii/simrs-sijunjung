<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="LembarObservasiHarian"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("lembar_observasi_harian.json",FILE_USE_INCLUDE_PATH);?>;





var lembar_observasi_harian = new Survey.Model(surveyJSON);



<?php 
if($lembar_harian){ 
      ?>
    lembar_observasi_harian.data = <?php echo isset($lembar_harian->formjson)?$lembar_harian->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#LembarObservasiHarian").Survey({
    model: lembar_observasi_harian,
    // onComplete: sendDataToServer
});
</script>