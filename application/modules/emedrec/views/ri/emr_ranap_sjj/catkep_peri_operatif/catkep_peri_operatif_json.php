<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="CatKepPeriOperatif"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("catkep_peri_operatif.json",FILE_USE_INCLUDE_PATH);?>;





var catkep_peri_operatif = new Survey.Model(surveyJSON);



<?php 
if($catkep_perioperatif){ 
      ?>
    catkep_peri_operatif.data = <?php echo isset($catkep_perioperatif->formjson)?$catkep_perioperatif->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#CatKepPeriOperatif").Survey({
    model: catkep_peri_operatif,
    // onComplete: sendDataToServer
});
</script>