<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="IdentifikasiBayi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("identifikasi_bayi.json",FILE_USE_INCLUDE_PATH);?>;





var identifikasi_bayi = new Survey.Model(surveyJSON);



<?php 
if($iden_bayi){ 
      ?>
    identifikasi_bayi.data = <?php echo isset($iden_bayi->formjson)?$iden_bayi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#IdentifikasiBayi").Survey({
    model: identifikasi_bayi,
    // onComplete: sendDataToServer
});
</script>