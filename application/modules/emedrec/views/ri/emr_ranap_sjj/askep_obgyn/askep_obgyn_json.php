<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="AskepObgyn"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("askep_obgyn.json",FILE_USE_INCLUDE_PATH);?>;





var askep_obgyn = new Survey.Model(surveyJSON);



<?php 
if($obgyn){ 
      ?>
    askep_obgyn.data = <?php echo isset($obgyn->formjson)?$obgyn->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#AskepObgyn").Survey({
    model: askep_obgyn,
    // onComplete: sendDataToServer
});
</script>