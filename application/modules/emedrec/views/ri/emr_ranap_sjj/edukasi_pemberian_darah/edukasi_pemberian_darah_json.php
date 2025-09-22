<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="EdukasiPemberianDarah"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("edukasi_pemberian.json",FILE_USE_INCLUDE_PATH);?>;





var edukasi_pemberian_darah = new Survey.Model(surveyJSON);
    

   


$("#EdukasiPemberianDarah").Survey({
    model: edukasi_pemberian_darah,
    // onComplete: sendDataToServer
});
</script>