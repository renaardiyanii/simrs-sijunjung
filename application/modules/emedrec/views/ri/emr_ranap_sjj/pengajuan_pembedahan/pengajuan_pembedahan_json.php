<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengajuanPembedahan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengajuan_pembedahan.json",FILE_USE_INCLUDE_PATH);?>;





var pengajuan_pembedahan = new Survey.Model(surveyJSON);



<?php 
if($pengajuan_bedah){ 
      ?>
    pengajuan_pembedahan.data = <?php echo isset($pengajuan_bedah->formjson)?$pengajuan_bedah->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengajuanPembedahan").Survey({
    model: pengajuan_pembedahan,
    // onComplete: sendDataToServer
});
</script>