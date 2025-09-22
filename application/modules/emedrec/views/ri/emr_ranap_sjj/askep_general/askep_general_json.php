<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="AskepGeneral"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("askep_general.json",FILE_USE_INCLUDE_PATH);?>;





var askep_general = new Survey.Model(surveyJSON);



<?php 
if($askepgeneral){ 
      ?>
    askep_general.data = <?php echo isset($askepgeneral->formjson)?$askepgeneral->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#AskepGeneral").Survey({
    model: askep_general,
    // onComplete: sendDataToServer
});
</script>