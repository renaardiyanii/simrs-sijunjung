<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianKepAnak"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_kep_anak.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_keo_anak = new Survey.Model(surveyJSON);



<?php 
if($kep_anak){ 
      ?>
    pengkajian_keo_anak.data = <?php echo isset($kep_anak->formjson)?$kep_anak->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianKepAnak").Survey({
    model: pengkajian_keo_anak,
    // onComplete: sendDataToServer
});
</script>