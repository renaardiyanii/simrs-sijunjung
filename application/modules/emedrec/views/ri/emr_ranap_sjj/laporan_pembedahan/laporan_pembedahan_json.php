<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="LaporanPembedahan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("laporan_pembedahan.json",FILE_USE_INCLUDE_PATH);?>;





var laporan_pembedahan = new Survey.Model(surveyJSON);



<?php 
if($pembedahan){ 
      ?>
    laporan_pembedahan.data = <?php echo isset($pembedahan->formjson)?$pembedahan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#LaporanPembedahan").Survey({
    model: laporan_pembedahan,
    // onComplete: sendDataToServer
});
</script>