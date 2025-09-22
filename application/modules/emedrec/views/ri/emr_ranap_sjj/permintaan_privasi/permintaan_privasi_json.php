<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PermintaanPrivasi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("permintaan_privasi.json",FILE_USE_INCLUDE_PATH);?>;





var permintaan_privasi = new Survey.Model(surveyJSON);



<?php 
if($permintaan_priv){ 
      ?>
    permintaan_privasi.data = <?php echo isset($permintaan_priv->formjson)?$permintaan_priv->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PermintaanPrivasi").Survey({
    model: permintaan_privasi,
    // onComplete: sendDataToServer
});
</script>