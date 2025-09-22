<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PersetujuanBayiTabung"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("persetujuan_bayi_tabung.json",FILE_USE_INCLUDE_PATH);?>;





var persetujuan_bayi_tabung = new Survey.Model(surveyJSON);



<?php 
if($bayi_tabung){ 
      ?>
    persetujuan_bayi_tabung.data = <?php echo isset($bayi_tabung->formjson)?$bayi_tabung->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PersetujuanBayiTabung").Survey({
    model: persetujuan_bayi_tabung,
    // onComplete: sendDataToServer
});
</script>