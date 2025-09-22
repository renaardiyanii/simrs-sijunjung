<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="RingkasanMasukKeluar"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("ringkasan_masuk_keluar_pasien.json",FILE_USE_INCLUDE_PATH);?>;





var ringkasan_masuk_keluar = new Survey.Model(surveyJSON);



<?php 
if($masuk_keluar){ 
      ?>
    ringkasan_masuk_keluar.data = <?php echo isset($masuk_keluar->formjson)?$masuk_keluar->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#RingkasanMasukKeluar").Survey({
    model: ringkasan_masuk_keluar,
    // onComplete: sendDataToServer
});
</script>