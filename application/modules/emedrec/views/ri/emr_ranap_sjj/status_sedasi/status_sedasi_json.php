<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="StatusSedasi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("status_sedasi.json",FILE_USE_INCLUDE_PATH);?>;





var status_sedasi = new Survey.Model(surveyJSON);



<?php 
if($stat_sedasi){ 
      ?>
    status_sedasi.data = <?php echo isset($stat_sedasi->formjson)?$stat_sedasi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#StatusSedasi").Survey({
    model: status_sedasi,
    // onComplete: sendDataToServer
});
</script>