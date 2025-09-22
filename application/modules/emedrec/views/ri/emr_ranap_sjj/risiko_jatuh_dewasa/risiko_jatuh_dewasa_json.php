<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="RisikoJatuhDewasa"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("risiko_jatuh_dewasa.json",FILE_USE_INCLUDE_PATH);?>;





var risiko_jatuh_dewasa = new Survey.Model(surveyJSON);



<?php 
if($jatuh_dewasa){ 
      ?>
    risiko_jatuh_dewasa.data = <?php echo isset($jatuh_dewasa->formjson)?$jatuh_dewasa->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#RisikoJatuhDewasa").Survey({
    model: risiko_jatuh_dewasa,
    // onComplete: sendDataToServer
});
</script>