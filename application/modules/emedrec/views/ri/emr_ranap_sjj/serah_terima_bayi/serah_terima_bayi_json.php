<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="SerahTerimaBayi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("serah_terima_bayi.json",FILE_USE_INCLUDE_PATH);?>;





var serah_terima_bayi = new Survey.Model(surveyJSON);



<?php 
if($terima_bayi){ 
      ?>
    serah_terima_bayi.data = <?php echo isset($terima_bayi->formjson)?$terima_bayi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#SerahTerimaBayi").Survey({
    model: serah_terima_bayi,
    // onComplete: sendDataToServer
});
</script>