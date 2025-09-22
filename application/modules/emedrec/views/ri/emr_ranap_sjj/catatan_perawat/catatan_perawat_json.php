<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="CatatanPerawat"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("catatan_perawat.json",FILE_USE_INCLUDE_PATH);?>;





var catatan_perawat = new Survey.Model(surveyJSON);



<?php 
if($cat_perawat){ 
      ?>
    catatan_perawat.data = <?php echo isset($cat_perawat->formjson)?$cat_perawat->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#CatatanPerawat").Survey({
    model: catatan_perawat,
    // onComplete: sendDataToServer
});
</script>