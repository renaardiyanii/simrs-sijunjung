<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianMedisKB"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_medis_kb.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_medis_kb = new Survey.Model(surveyJSON);



<?php 
if($medis_kb){ 
      ?>
    pengkajian_medis_kb.data = <?php echo isset($medis_kb->formjson)?$medis_kb->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianMedisKB").Survey({
    model: pengkajian_medis_kb,
    // onComplete: sendDataToServer
});
</script>