<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="AssesmentUlangNyeri"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("assesment_ulang_nyeri.json",FILE_USE_INCLUDE_PATH);?>;





var assesment_ulang_nyeri = new Survey.Model(surveyJSON);



<?php 
if($ulang_nyeri){ 
      ?>
    assesment_ulang_nyeri.data = <?php echo isset($ulang_nyeri->formjson)?$ulang_nyeri->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#AssesmentUlangNyeri").Survey({
    model: assesment_ulang_nyeri,
    // onComplete: sendDataToServer
});
</script>