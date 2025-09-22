<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianJatuhNeonatus"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_jatuh_neonatus.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_jatuh_neonatus = new Survey.Model(surveyJSON);



<?php 
if($jatuh_neonatus){ 
      ?>
    pengkajian_jatuh_neonatus.data = <?php echo isset($jatuh_neonatus->formjson)?$jatuh_neonatus->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianJatuhNeonatus").Survey({
    model: pengkajian_jatuh_neonatus,
    // onComplete: sendDataToServer
});
</script>