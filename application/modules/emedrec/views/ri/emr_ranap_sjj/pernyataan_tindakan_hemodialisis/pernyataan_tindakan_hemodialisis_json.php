<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PernyataanTindakanHemodialisis"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pernyataan_tindakan_hemodialisis.json",FILE_USE_INCLUDE_PATH);?>;





var pernyataan_tindakan_hemodialisis = new Survey.Model(surveyJSON);



<?php 
if($per_tind_hemo){ 
      ?>
    pernyataan_tindakan_hemodialisis.data = <?php echo isset($per_tind_hemo->formjson)?$per_tind_hemo->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PernyataanTindakanHemodialisis").Survey({
    model: pernyataan_tindakan_hemodialisis,
    // onComplete: sendDataToServer
});
</script>