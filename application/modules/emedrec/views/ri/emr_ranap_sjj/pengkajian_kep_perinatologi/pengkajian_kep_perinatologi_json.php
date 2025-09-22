<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianKeperawatanPerinatologi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_kep_perinatologi.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_kep_perinatologi = new Survey.Model(surveyJSON);



<?php 
if($kep_perina){ 
      ?>
    pengkajian_kep_perinatologi.data = <?php echo isset($kep_perina->formjson)?$kep_perina->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianKeperawatanPerinatologi").Survey({
    model: pengkajian_kep_perinatologi,
    // onComplete: sendDataToServer
});
</script>