<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianKeperawatanObgyn"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_keperawatan_obgyn.json",FILE_USE_INCLUDE_PATH);?>;





var keperawatan_obgyn = new Survey.Model(surveyJSON);



<?php 
if($keperawatanobgyn){ 
      ?>
    keperawatan_obgyn.data = <?php echo isset($keperawatanobgyn->formjson)?$keperawatanobgyn->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianKeperawatanObgyn").Survey({
    model: keperawatan_obgyn,
    // onComplete: sendDataToServer
});
</script>