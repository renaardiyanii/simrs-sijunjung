<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianAwalMedisRanap"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_awal_ranap.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_awal_medis_ri = new Survey.Model(surveyJSON);



<?php 
if($pengkajian_awal_ranap){ 
      ?>
    pengkajian_awal_medis_ri.data = <?php echo isset($pengkajian_awal_ranap->formjson)?$pengkajian_awal_ranap->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianAwalMedisRanap").Survey({
    model: pengkajian_awal_medis_ri,
    // onComplete: sendDataToServer
});
</script>