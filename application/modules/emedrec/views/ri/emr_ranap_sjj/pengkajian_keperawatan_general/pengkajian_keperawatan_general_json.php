<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianKeperawatanGeneral"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_keperawatan_general.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_general = new Survey.Model(surveyJSON);



<?php 
if($pengkajian_keperawatan_general){ 
      ?>
    pengkajian_general.data = <?php echo isset($pengkajian_keperawatan_general->formjson)?$pengkajian_keperawatan_general->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianKeperawatanGeneral").Survey({
    model: pengkajian_general,
    // onComplete: sendDataToServer
});
</script>