<?php 
$this->load->view('layout/header_form');
?>
<?php 
$objective_perawat = "";
$assesment_dokter = "";
$assesment = "";
$kep = $assesment_keperawatan[0]->formjson?json_decode($assesment_keperawatan[0]->formjson):'';
// var_dump($assesment_keperawatan);
if(isset($soap_pasien_rj->objective_perawat)){
    $objective_perawat.=$soap_pasien_rj->objective_perawat;
}

if(isset($soap_pasien_rj->assesment_dokter)){
    $assesment_dokter.= $soap_pasien_rj->assesment_dokter;
}

if(isset($kep->table1)){
    foreach($kep->table1 as $val){
        $assesment .= $val->tindakan.' '.$val->nama_obat_infus.' '.$val->dosis_frekuensi.' '.$val->cara_pemberian.'\n';
        //var_dump($assesment); die();
    }
}

 //var_dump($kep->table1); die();
?>
<style>
.container-cover{
    background-color:transparent;
}
</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div class="card m-5">
    <div class="body">
    <div id="surveySerahTerima"></div>

    </div>
</div>


<script>
    var widget = {
    name: "emptyRadio",
    isFit : function(question) {  
        return question.getType() === 'radiogroup'; 
    },
    isDefaultRender: true,
    afterRender: function(question, el) {
      var $el = $(el);
      $el.find("input:radio").click(function(event){
           var UnCheck = "UnCheck",
                  $clickedbox = $(this),
                  radioname = $clickedbox.prop("name"),
                  $group = $('input[name|="'+ radioname + '"]'),
                  doUncheck = $clickedbox.hasClass(UnCheck),
                  isChecked = $clickedbox.is(':checked');
              if(doUncheck){
                  $group.removeClass(UnCheck);
                  $clickedbox.prop('checked', false);
                  question.value = null;
              }
              else if(isChecked){
                  $group.removeClass(UnCheck);
                  $clickedbox.addClass(UnCheck);
              }
      });    
    },
    willUnmount: function(question, el) {
    }
};

Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

var surveyJsonSerahTerima = <?php echo file_get_contents(__DIR__ ."/form/catatan_serah_terima.json");?>;

function sendDataToSerahTerima(survey) {
    //send Ajax request to your web server.
    // alert("The results are:" + JSON.stringify(survey.data));
    $.ajax({
        type: "POST",
        url: '<?= base_url('ird/rdcpelayanan/serah_terima/') ?>',
        data: {
            no_register : '<?= $data_pasien_daftar_ulang->no_register ?>',
            formjson:JSON.stringify(survey.data),
        },
        success: function(data)
        {
           
            new swal({
            title: "Selesai",
            text: "Data berhasil disimpan",
            type: "success",
            showCancelButton: false,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
                willClose: () => {
                    window.location.reload();
                }
        },
        function () {
            // window.location.reload();
        });
            

        },
        error: function(data)
        {
            
        }
    }); 
    
}

var surveySerahTerima = new Survey.Model(surveyJsonSerahTerima);

<?php 
if($serah_terima!=null){
$dataJson = $serah_terima->formjson?json_decode($serah_terima->formjson):null;
if($dataJson){
?>

surveySerahTerima.data = {
    "ruang_rawat": "<?= isset($dataJson->ruang_rawat)?$dataJson->ruang_rawat:''; ?>",
    "situations": "<?= isset($dataJson->situations)?str_replace([PHP_EOL,"\r","\n"],'\n',$dataJson->situations):"" ?>",
    "background": "<?= isset($dataJson->background)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$dataJson->background):'' ?>",
    "asessment": "<?= str_replace([PHP_EOL,"\r","\n"],'\n',$assesment) ?>",
    "diagnosis_medis": "<?= isset($dataJson->diagnosis_medis)?$dataJson->diagnosis_medis:'' ?>",
    "petugas1": "<?= isset($dataJson->petugas1)?$dataJson->petugas1:'' ?>",
    "recommendation": "<?= isset($dataJson->recommendation)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$dataJson->recommendation):'' ?>"
}
<?php 
}
}else{
?>

surveySerahTerima.data = {
   "ruang_rawat":"<?= $data_pasien_daftar_ulang->id_poli == 'BA00'?'Rawat Darurat':'Rawat Jalan' ?>",
   "situations":"<?= isset($kep->riwayat_kesehatan)?str_replace([PHP_EOL,"\r","\n"],'\n',$kep->riwayat_kesehatan):'' ?>",
   "background":"<?= str_replace([PHP_EOL,"\r","\n","<br>"],['\n'],$objective_perawat) ?>",
   "asessment":"<?= str_replace([PHP_EOL,"\r","\n"],'\n',$assesment) ?>",
   "diagnosis_medis":"<?php
   
   if(isset($diagnosa_pasien)){foreach($diagnosa_pasien as $val){
       if($val->klasifikasi_diagnos == 'utama'){
           echo $val->id_diagnosa.' - '.$val->diagnosa;
       }
   }}
   ?>"
}
<?php } ?>

// survey.css = myCss;
$("#surveySerahTerima").Survey({
    model: surveySerahTerima,
    onComplete: sendDataToSerahTerima
});
</script>