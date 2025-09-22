<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="KontrolIntensive"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("kontrol_intensive.json",FILE_USE_INCLUDE_PATH);?>;





var kontrol_intensive = new Survey.Model(surveyJSON);



<?php 
if($kontrol_intens){ 
      ?>
    kontrol_intensive.data = <?php echo isset($kontrol_intens->formjson)?$kontrol_intens->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#KontrolIntensive").Survey({
    model: kontrol_intensive,
    // onComplete: sendDataToServer
});
</script>