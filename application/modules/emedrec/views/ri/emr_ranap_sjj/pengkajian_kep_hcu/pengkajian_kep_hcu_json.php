<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PengkajianKepHCU"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pengkajian_kep_hcu.json",FILE_USE_INCLUDE_PATH);?>;





var pengkajian_kep_hcu = new Survey.Model(surveyJSON);



<?php 
if($kep_hcu){ 
      ?>
    pengkajian_kep_hcu.data = <?php echo isset($kep_hcu->formjson)?$kep_hcu->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PengkajianKepHCU").Survey({
    model: pengkajian_kep_hcu,
    // onComplete: sendDataToServer
});
</script>