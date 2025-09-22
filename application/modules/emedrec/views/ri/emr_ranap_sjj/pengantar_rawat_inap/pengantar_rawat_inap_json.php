<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengantarRawatInap"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengantar_rawat_inap.json",FILE_USE_INCLUDE_PATH);?>;





var pengantar_rawat_inap = new Survey.Model(surveyJSON);



<?php 
if($peng_ranap){ 
      ?>
    pengantar_rawat_inap.data = <?php echo isset($peng_ranap->formjson)?$peng_ranap->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengantarRawatInap").Survey({
    model: pengantar_rawat_inap,
    // onComplete: sendDataToServer
});
</script>