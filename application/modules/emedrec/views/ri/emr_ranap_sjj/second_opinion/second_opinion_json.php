<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="SecondOpinion"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("second_opinion.json",FILE_USE_INCLUDE_PATH);?>;





var second_opinion = new Survey.Model(surveyJSON);



<?php 
if($sec_opinion){ 
      ?>
    second_opinion.data = <?php echo isset($sec_opinion->formjson)?$sec_opinion->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#SecondOpinion").Survey({
    model: second_opinion,
    // onComplete: sendDataToServer
});
</script>