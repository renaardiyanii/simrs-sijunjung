<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="CatatanPaliatif"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("cat_khusus_paliatif.json",FILE_USE_INCLUDE_PATH);?>;





var cat_khusus_paliatif = new Survey.Model(surveyJSON);



<?php 
if($cat_paliatif){ 
      ?>
    cat_khusus_paliatif.data = <?php echo isset($cat_paliatif->formjson)?$cat_paliatif->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#CatatanPaliatif").Survey({
    model: cat_khusus_paliatif,
    // onComplete: sendDataToServer
});
</script>