<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="ResikoJatuhAnak"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("resiko_jatuh_anak.json",FILE_USE_INCLUDE_PATH);?>;





var resiko_jatuh_anak = new Survey.Model(surveyJSON);



<?php 
if($jatuh_anak){ 
      ?>
    resiko_jatuh_anak.data = <?php echo isset($jatuh_anak->formjson)?$jatuh_anak->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#ResikoJatuhAnak").Survey({
    model: resiko_jatuh_anak,
    // onComplete: sendDataToServer
});
</script>