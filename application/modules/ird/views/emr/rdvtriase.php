<?php 
$this->load->view('layout/header_form');
?>
<?php 
$data_keperawatan = isset($assesment_keperawatan[0]->formjson)?json_decode($assesment_keperawatan[0]->formjson):null;
?>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div class="card m-5">
    <div class="body">
    <div id="surveyTriase"></div>

    </div>
</div>



<script>

Survey.StylesManager.applyTheme("modern");

var surveyJSONTriase = <?php echo file_get_contents(__DIR__ ."/form/triase.json");?>;
 

function sendDataToServerTriase(survey) {
    // console.log(JSON.stringify(survey.data))
    $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/insert_triase/') ?>',
            data: {
                data:JSON.stringify(survey.data),
                no_register: "<?php echo $no_register; ?>",
            },
            success: function(data)
            { 
               
                        location.reload();
                   
            },
            error: function(data)
            {
              
            }
        });
    // swal('Berhasil!','Data Berhasil Disimpan!','success');
}

var surveyTriase = new Survey.Model(surveyJSONTriase);

<?php 
if($triase!= ''){
?>

surveyTriase.data = <?= $triase[0]->formjson; ?>;

<?php }else{ ?>

    surveyTriase.data =
        {"keluhan_utama":"<?= isset($data_keperawatan->riwayat_kesehatan)?str_replace(["\n","\r",PHP_EOL],'\n',$data_keperawatan->riwayat_kesehatan):'' ?>",
    "suhu1":"<?= isset($data_fisik->suhu)?$data_fisik->suhu:'' ?>",
    "tekanan_darah":"<?= isset($data_fisik->sitolic) && isset($data_fisik->diatolic)?$data_fisik->sitolic.'/'.$data_fisik->diatolic:'';?>",
    "nadi":"<?= isset($data_fisik->nadi)?$data_fisik->nadi:'';?>",
    "nafas":"<?= isset($data_fisik->pernafasan)?$data_fisik->pernafasan:'';?>",
    "spotwo":"<?= isset($data_fisik->spotwo)?$data_fisik->spotwo:'';?>",
    "gcs1":{"e":"<?= isset($data_fisik->e_gcs)?$data_fisik->e_gcs:'';?>",
        "v":"<?= isset($data_fisik->v_gcs)?$data_fisik->v_gcs:''; ?>",
        "m":"<?= isset($data_fisik->m_gcs)?$data_fisik->m_gcs:''; ?>"},
        "pupil1":"<?= isset($data_fisik->pupil)?$data_fisik->pupil == "isokor"?$data_fisik->pupil:$data_fisik->pupil.'-'.$data_fisik->value_anisokor??"":''; ?>",
    "suhu":"<?= isset($data_fisik->suhu)?$data_fisik->suhu:'' ?>",
    "e":"<?= isset($data_fisik->e_gcs)?$data_fisik->e_gcs:'';?>",
    "m":"<?= isset($data_fisik->m_gcs)?$data_fisik->m_gcs:''; ?>",
    "v":"<?= isset($data_fisik->v_gcs)?$data_fisik->v_gcs:''; ?>"};


<?php } ?>



$("#surveyTriase").Survey({
    model: surveyTriase,
    onComplete: sendDataToServerTriase
});
</script>