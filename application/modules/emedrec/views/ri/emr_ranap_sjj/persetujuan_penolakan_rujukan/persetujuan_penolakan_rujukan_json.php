<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PersetujuanPenolakanRujukan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("persetujuan_penolakan_rujukan.json",FILE_USE_INCLUDE_PATH);?>;





var persetujuan_penolakan_rujukan = new Survey.Model(surveyJSON);



<?php 
if($per_per_rujukan){ 
      ?>
    persetujuan_penolakan_rujukan.data = <?php echo isset($per_per_rujukan->formjson)?$per_per_rujukan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PersetujuanPenolakanRujukan").Survey({
    model: persetujuan_penolakan_rujukan,
    // onComplete: sendDataToServer
});
</script>