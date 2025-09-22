<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="LembarIntruksi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("lembar_intruksi.json",FILE_USE_INCLUDE_PATH);?>;





var lembar_intruksi = new Survey.Model(surveyJSON);



<?php 
if($intruksi){ 
      ?>
    lembar_intruksi.data = <?php echo isset($intruksi->formjson)?$intruksi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#LembarIntruksi").Survey({
    model: lembar_intruksi,
    // onComplete: sendDataToServer
});
</script>