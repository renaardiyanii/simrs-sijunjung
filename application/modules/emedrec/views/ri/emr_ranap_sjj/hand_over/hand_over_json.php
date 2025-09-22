<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="HandOver"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("hand_over.json",FILE_USE_INCLUDE_PATH);?>;





var hand_over = new Survey.Model(surveyJSON);



<?php 
if($handover){ 
      ?>
    hand_over.data = <?php echo isset($handover->formjson)?$handover->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#HandOver").Survey({
    model: hand_over,
    // onComplete: sendDataToServer
});
</script>