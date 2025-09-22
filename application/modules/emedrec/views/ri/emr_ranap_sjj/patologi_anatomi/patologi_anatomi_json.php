<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PatologiAnatomi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("patologi_anatomi.json",FILE_USE_INCLUDE_PATH);?>;





var patologi_anatomi = new Survey.Model(surveyJSON);



<?php 
if($pa){ 
      ?>
    patologi_anatomi.data = <?php echo isset($pa->formjson)?$pa->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PatologiAnatomi").Survey({
    model: patologi_anatomi,
    // onComplete: sendDataToServer
});
</script>