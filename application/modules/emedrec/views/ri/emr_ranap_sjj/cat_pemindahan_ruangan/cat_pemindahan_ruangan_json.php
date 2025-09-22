<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="CatPemindahanRuangan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("cat_pemindahan_ruangan.json",FILE_USE_INCLUDE_PATH);?>;





var cat_pemindahan_ruangan = new Survey.Model(surveyJSON);



<?php 
if($pemindahan_ruangan){ 
      ?>
    cat_pemindahan_ruangan.data = <?php echo isset($pemindahan_ruangan->formjson)?$pemindahan_ruangan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#CatPemindahanRuangan").Survey({
    model: cat_pemindahan_ruangan,
    // onComplete: sendDataToServer
});
</script>