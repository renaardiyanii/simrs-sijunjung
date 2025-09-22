<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="CatatanAnestesiPemulihan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("catatan_anestesi_pemulihan.json",FILE_USE_INCLUDE_PATH);?>;





var catatan_anestesi_pemulihan = new Survey.Model(surveyJSON);



<?php 
if($cat_anes_pemulihan){ 
      ?>
    catatan_anestesi_pemulihan.data = <?php echo isset($cat_anes_pemulihan->formjson)?$cat_anes_pemulihan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#CatatanAnestesiPemulihan").Survey({
    model: catatan_anestesi_pemulihan,
    // onComplete: sendDataToServer
});
</script>