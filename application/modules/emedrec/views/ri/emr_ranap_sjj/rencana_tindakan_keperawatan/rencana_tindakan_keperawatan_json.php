<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="RencanaTindakanKeperawatan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("rencana_tindakan_keperawatan.json",FILE_USE_INCLUDE_PATH);?>;





var rencana_tindakan_keperawatan = new Survey.Model(surveyJSON);



<?php 
if($rencana_keperawatan){ 
      ?>
    rencana_tindakan_keperawatan.data = <?php echo isset($rencana_keperawatan->formjson)?$rencana_keperawatan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#RencanaTindakanKeperawatan").Survey({
    model: rencana_tindakan_keperawatan,
    // onComplete: sendDataToServer
});
</script>