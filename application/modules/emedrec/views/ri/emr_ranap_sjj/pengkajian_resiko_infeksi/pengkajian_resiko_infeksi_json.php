<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianResikoInfeksi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_resiko_infeksi.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_resiko_infeksi = new Survey.Model(surveyJSON);



<?php 
if($peng_resiko_infeksi){ 
      ?>
    pengkajian_resiko_infeksi.data = <?php echo isset($peng_resiko_infeksi->formjson)?$peng_resiko_infeksi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianResikoInfeksi").Survey({
    model: pengkajian_resiko_infeksi,
    // onComplete: sendDataToServer
});
</script>