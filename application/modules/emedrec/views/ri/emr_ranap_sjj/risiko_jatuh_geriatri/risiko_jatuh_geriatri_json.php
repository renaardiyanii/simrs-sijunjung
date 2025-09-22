<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="RisikoJatuhGeriatri"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("risiko_jatuh_geriatri.json",FILE_USE_INCLUDE_PATH);?>;





var risiko_jatuh_geriatri = new Survey.Model(surveyJSON);



<?php 
if($jatuh_geriatri){ 
      ?>
    risiko_jatuh_geriatri.data = <?php echo isset($jatuh_geriatri->formjson)?$jatuh_geriatri->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#RisikoJatuhGeriatri").Survey({
    model: risiko_jatuh_geriatri,
    // onComplete: sendDataToServer
});
</script>