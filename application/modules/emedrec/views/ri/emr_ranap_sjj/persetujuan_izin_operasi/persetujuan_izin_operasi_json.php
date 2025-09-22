<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PersetujuanIzinOperasi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("persetujuan_izin_operasi.json",FILE_USE_INCLUDE_PATH);?>;





var persetujuan_izin_operasi = new Survey.Model(surveyJSON);



<?php 
if($persetujuan_izin_op){ 
      ?>
    persetujuan_izin_operasi.data = <?php echo isset($persetujuan_izin_op->formjson)?$persetujuan_izin_op->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PersetujuanIzinOperasi").Survey({
    model: persetujuan_izin_operasi,
    // onComplete: sendDataToServer
});
</script>