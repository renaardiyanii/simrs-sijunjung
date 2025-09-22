<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="LembarPPI"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("lembar_ppi.json",FILE_USE_INCLUDE_PATH);?>;





var lembar_ppi = new Survey.Model(surveyJSON);



<?php 
if($lembarppi){ 
      ?>
    lembar_ppi.data = <?php echo isset($lembarppi->formjson)?$lembarppi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#LembarPPI").Survey({
    model: lembar_ppi,
    // onComplete: sendDataToServer
});
</script>