<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="EdukasiAnestesiSedasi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("edukasi_anestesi_sedasi.json",FILE_USE_INCLUDE_PATH);?>;





var edukasi_anestesi_sedasi = new Survey.Model(surveyJSON);



<?php 
if($ed_anestesi_sedasi){ 
      ?>
    edukasi_anestesi_sedasi.data = <?php echo isset($ed_anestesi_sedasi->formjson)?$ed_anestesi_sedasi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#EdukasiAnestesiSedasi").Survey({
    model: edukasi_anestesi_sedasi,
    // onComplete: sendDataToServer
});
</script>