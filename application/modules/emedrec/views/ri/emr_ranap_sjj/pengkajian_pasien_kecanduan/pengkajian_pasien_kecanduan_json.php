<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianPasienKecanduan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_pasien_kecanduan.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_kecanduan = new Survey.Model(surveyJSON);



<?php 
if($peng_kecanduan){ 
      ?>
    pengkajian_kecanduan.data = <?php echo isset($peng_kecanduan->formjson)?$peng_kecanduan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianPasienKecanduan").Survey({
    model: pengkajian_kecanduan,
    // onComplete: sendDataToServer
});
</script>