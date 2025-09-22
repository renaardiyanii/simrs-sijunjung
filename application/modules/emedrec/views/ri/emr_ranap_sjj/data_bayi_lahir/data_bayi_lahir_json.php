<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="DataBayiLahir"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("data_bayi_lahir.json",FILE_USE_INCLUDE_PATH);?>;





var data_bayi_lahir = new Survey.Model(surveyJSON);



<?php 
if($data_bayi){ 
      ?>
    data_bayi_lahir.data = <?php echo isset($data_bayi->formjson)?$data_bayi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#DataBayiLahir").Survey({
    model: data_bayi_lahir,
    // onComplete: sendDataToServer
});
</script>