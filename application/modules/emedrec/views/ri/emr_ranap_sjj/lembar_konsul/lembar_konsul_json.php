<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="LembarKonsul"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("lembar_konsul.json",FILE_USE_INCLUDE_PATH);?>;





var lembar_konsul = new Survey.Model(surveyJSON);



<?php 
if($konsul){ 
      ?>
    lembar_konsul.data = <?php echo isset($konsul->formjson)?$konsul->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#LembarKonsul").Survey({
    model: lembar_konsul,
    // onComplete: sendDataToServer
});
</script>