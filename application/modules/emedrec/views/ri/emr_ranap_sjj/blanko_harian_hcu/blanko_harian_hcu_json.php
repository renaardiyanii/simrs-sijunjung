<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="BlankoHarianHCU"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("blanko_harian_hcu.json",FILE_USE_INCLUDE_PATH);?>;





var blanko_harian_hcu = new Survey.Model(surveyJSON);



<?php 
if($harian_hcu){ 
      ?>
    blanko_harian_hcu.data = <?php echo isset($harian_hcu->formjson)?$harian_hcu->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#BlankoHarianHCU").Survey({
    model: blanko_harian_hcu,
    // onComplete: sendDataToServer
});
</script>