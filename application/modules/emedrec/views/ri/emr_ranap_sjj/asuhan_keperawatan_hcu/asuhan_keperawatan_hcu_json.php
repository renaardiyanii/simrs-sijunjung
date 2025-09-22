<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="AsuhanKeperawatanHCU"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("asuhan_keperawatan_hcu.json",FILE_USE_INCLUDE_PATH);?>;





var askep_hcu = new Survey.Model(surveyJSON);



<?php 
if($kep_hcu){ 
      ?>
    askep_hcu.data = <?php echo isset($kep_hcu->formjson)?$kep_hcu->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#AsuhanKeperawatanHCU").Survey({
    model: askep_hcu,
    // onComplete: sendDataToServer
});
</script>