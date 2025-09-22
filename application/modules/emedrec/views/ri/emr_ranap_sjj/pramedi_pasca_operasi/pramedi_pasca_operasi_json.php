<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PramedPascaOP"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pramedi_pasca_operasi.json",FILE_USE_INCLUDE_PATH);?>;





var pramedi_pasca_operasi = new Survey.Model(surveyJSON);



<?php 
if($pramed_operasi){ 
      ?>
    pramedi_pasca_operasi.data = <?php echo isset($pramed_operasi->formjson)?$pramed_operasi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PramedPascaOP").Survey({
    model: pramedi_pasca_operasi,
    // onComplete: sendDataToServer
});
</script>