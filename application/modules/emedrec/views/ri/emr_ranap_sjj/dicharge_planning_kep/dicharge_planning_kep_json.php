<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="DichargePlanning"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("dicharge_planning_kep.json",FILE_USE_INCLUDE_PATH);?>;





var dicharge_planning_kep = new Survey.Model(surveyJSON);



<?php 
if($dicharge_planning){ 
      ?>
    dicharge_planning_kep.data = <?php echo isset($dicharge_planning->formjson)?$dicharge_planning->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#DichargePlanning").Survey({
    model: dicharge_planning_kep,
    // onComplete: sendDataToServer
});
</script>