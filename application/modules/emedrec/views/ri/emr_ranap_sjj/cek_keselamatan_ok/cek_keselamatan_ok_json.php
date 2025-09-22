<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="CekKeselamatanOK"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("cek_keselamatan_ok.json",FILE_USE_INCLUDE_PATH);?>;





var cek_keselamatan_ok = new Survey.Model(surveyJSON);



<?php 
if($keselamatan_ok){ 
      ?>
    cek_keselamatan_ok.data = <?php echo isset($keselamatan_ok->formjson)?$keselamatan_ok->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#CekKeselamatanOK").Survey({
    model: cek_keselamatan_ok,
    // onComplete: sendDataToServer
});
</script>