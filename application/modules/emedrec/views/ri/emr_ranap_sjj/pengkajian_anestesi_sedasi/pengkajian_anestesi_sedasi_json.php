<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianAnestesiSedasi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_anestesi_sedasi.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_anestesi_sedasi = new Survey.Model(surveyJSON);



<?php 
if($peng_anestesi_sedasi){ 
      ?>
    pengkajian_anestesi_sedasi.data = <?php echo isset($peng_anestesi_sedasi->formjson)?$peng_anestesi_sedasi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianAnestesiSedasi").Survey({
    model: pengkajian_anestesi_sedasi,
    // onComplete: sendDataToServer
});
</script>