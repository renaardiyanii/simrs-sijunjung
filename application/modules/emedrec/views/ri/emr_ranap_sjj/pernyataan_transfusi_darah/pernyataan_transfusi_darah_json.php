<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PernyataanTransfusiDarah"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pernyataan_transfusi_darah.json",FILE_USE_INCLUDE_PATH);?>;





var pernyataan_transfusi_darah = new Survey.Model(surveyJSON);



<?php 
if($per_trans_darah){ 
      ?>
    pernyataan_transfusi_darah.data = <?php echo isset($per_trans_darah->formjson)?$per_trans_darah->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PernyataanTransfusiDarah").Survey({
    model: pernyataan_transfusi_darah,
    // onComplete: sendDataToServer
});
</script>