<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="DaftarPemberianTerapi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("daftar_pemberian_obat.json",FILE_USE_INCLUDE_PATH);?>;





var daftar_pemberian_terapi = new Survey.Model(surveyJSON);



<?php 
if($dpo){ 
      ?>
    daftar_pemberian_terapi.data = <?php echo isset($dpo->formjson)?$dpo->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#DaftarPemberianTerapi").Survey({
    model: daftar_pemberian_terapi,
    // onComplete: sendDataToServer
});
</script>