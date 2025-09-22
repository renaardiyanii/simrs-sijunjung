<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PenolakanTindakanMedis"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("penolakan_tindakan_medis.json",FILE_USE_INCLUDE_PATH);?>;





var penolakan_tindakan_medis = new Survey.Model(surveyJSON);



<?php 
if($pen_medis){ 
      ?>
    penolakan_tindakan_medis.data = <?php echo isset($pen_medis->formjson)?$pen_medis->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PenolakanTindakanMedis").Survey({
    model: penolakan_tindakan_medis,
    // onComplete: sendDataToServer
});
</script>