<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="GrafikTandaVital"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("grafik_tanda_vital.json",FILE_USE_INCLUDE_PATH);?>;





var grafik_tanda_vital = new Survey.Model(surveyJSON);



<?php 
if($grafik_tand_vital){ 
      ?>
    grafik_tanda_vital.data = <?php echo isset($grafik_tand_vital->formjson)?$grafik_tand_vital->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#GrafikTandaVital").Survey({
    model: grafik_tanda_vital,
    // onComplete: sendDataToServer
});
</script>