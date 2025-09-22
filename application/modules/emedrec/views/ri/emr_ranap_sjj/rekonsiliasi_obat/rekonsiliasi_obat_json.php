<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="RekonsiliasiObat"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("rekonsiliasi_obat.json",FILE_USE_INCLUDE_PATH);?>;





var rekonsiliasi_obat = new Survey.Model(surveyJSON);



<?php 
if($rekon_obat){ 
      ?>
    rekonsiliasi_obat.data = <?php echo isset($rekon_obat->formjson)?$rekon_obat->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#RekonsiliasiObat").Survey({
    model: rekonsiliasi_obat,
    // onComplete: sendDataToServer
});
</script>