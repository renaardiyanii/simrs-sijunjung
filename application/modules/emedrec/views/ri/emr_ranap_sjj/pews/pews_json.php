<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PEWS"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pews.json",FILE_USE_INCLUDE_PATH);?>;





var pews_anak = new Survey.Model(surveyJSON);



<?php 
if($pews){ 
      ?>
    pews_anak.data = <?php echo isset($pews->formjson)?$pews->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PEWS").Survey({
    model: pews_anak,
    // onComplete: sendDataToServer
});
</script>