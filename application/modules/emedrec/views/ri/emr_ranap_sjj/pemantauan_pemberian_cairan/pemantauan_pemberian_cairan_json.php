<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PemantauanPemberianCairan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pemantauan_pemberian_cairan.json",FILE_USE_INCLUDE_PATH);?>;





var pemantauan_pemberian_cairan = new Survey.Model(surveyJSON);



<?php 
if($pemantauan_cairan){ 
      ?>
    pemantauan_pemberian_cairan.data = <?php echo isset($pemantauan_cairan->formjson)?$pemantauan_cairan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PemantauanPemberianCairan").Survey({
    model: pemantauan_pemberian_cairan,
    // onComplete: sendDataToServer
});
</script>