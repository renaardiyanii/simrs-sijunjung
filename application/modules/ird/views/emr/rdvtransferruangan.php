<?php 
$this->load->view('layout/header_form');
?>
<?php
$assesment_medik_igd = isset($assesment_medik_igd[0]->formjson)?json_decode($assesment_medik_igd[0]->formjson):null;
$assesment_keperawatan = isset($assesment_keperawatan[0]->formjson)?json_decode($assesment_keperawatan[0]->formjson):null;
 //var_dump($data_pasien_daftar_ulang);

function convert_intervensi($codeintervensi)
{
    switch($codeintervensi){
        case '1':
            return '- Observasi tingkat kesadaran,reaksi dan ukuran pupil, fungsi sensorik motorik \n';
        case '2':
            return '- Observasi tanda-tanda vital : TD, Nadi, RR, Suhu \n';
        case '3':
            return '- Monitor pernafasan : irama, pengembangan dinding dada, penggunaan otot tambahan pernafasan, bunyi nafas \n';
        case '4':
            return '- Lakukan pemasangan oksimetri \n';
        case '5':
            return '- Observasi produk sputum, jumlah, warna dan kekentalan \n';
        case '6':
            return '- Berikan posisi semi fowler atau posisi miring yang aman \n';
        case '7':
            return '- Lakukan pemasangan OPA \n';
        case '8':
            return '- Lakukan suction bila perlu \n';
        case '9':
            return '- Ajarkan pasien untuk nafas dalam dan batuk efektif \n';
        case '10':
            return '- Kompres \n';
        case '11':
            return '- Observasi turgor kulit \n';
        case '12':
            return '- Ajarkan tentang teknik non farmakologi \n';
        case '13':
            return '- Pantau reflek batuk, reflek muntah dan kemampuan menelan \n';
        case '14':
            return '- Monitor tanda hiperglikemia/hipoglikemia \n';
        case '15':
            return '- Lakukan kumbah lambung \n';
        case '20':
            return '- Nebulizer \n';
        case '21':
            return '- Pemasangan  NGT  \n';
        case '22':
            return '- Pemasangan  DC \n';
        case '23':
            return '- Heachting aff / jahit luka \n';
        case '24':
            return '- Pemberian Obat \n';
        case '25':
            return '- DC Shock \n';
        case '26':
            return '- RJP \n';
        
        default:
            return '';
    }
}
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
    <div id="surveyTransferRuangan"></div>

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

var surveyJsonTransferRuangan = <?php echo file_get_contents(__DIR__ ."/form/transfer_ruangan.json");?>;

function sendDataToTransferRuangan(survey) {
    //send Ajax request to your web server.
    // alert("The results are:" + JSON.stringify(survey.data));
    $.ajax({
        type: "POST",
        url: '<?= base_url('ird/rdcpelayanan/transfer_ruangan/') ?>',
        data: {
            no_register : '<?= $data_pasien_daftar_ulang->no_register ?>',
            formjson:JSON.stringify(survey.data),
        },
        success: function(data)
        {
            
            location.reload();
           

        },
        error: function(data)
        {
            
        }
    }); 
    
}

var surveyTransferRuangan = new Survey.Model(surveyJsonTransferRuangan);
<?php 
if($transfer_ruangan!=null){
?>
surveyTransferRuangan.data = <?= $transfer_ruangan->formjson ?>;
// surveyTransferRuangan.setValue('question5',)
<?php } else{ ?>
surveyTransferRuangan.data = {"tgl_masuk":"<?= date('Y-m-d',strtotime($data_pasien_daftar_ulang->tgl_kunjungan)) ?>",
    "asal_ruang_rawat":"<?= $data_pasien_daftar_ulang->id_poli == 'BA00'?'Rawat Darurat':'Rawat Jalan' ?>",
   "dokter_yang_merawat":"<?= $data_pasien_daftar_ulang->dokter.'-'.$data_pasien_daftar_ulang->iduser ?>",
//    "dokter_penanggung_jawab":"<?php // $data_pasien_daftar_ulang->dokter ?>",
   "diagnosa_utama":"<?php
   
   if(isset($diagnosa_pasien)){foreach($diagnosa_pasien as $val){
       if($val->klasifikasi_diagnos == 'utama'){
           echo $val->id_diagnosa.' - '.$val->diagnosa;
       }
   }}
   ?>",
   "diagnosa_sekunder":"<?php
   $sekunder = '';
   if(isset($diagnosa_pasien)){foreach($diagnosa_pasien as $val){
       if($val->klasifikasi_diagnos != 'utama'){
          echo  $val->id_diagnosa.' - '.$val->diagnosa.'\n';
       }
   }}
   
   ?>",
   "e":"<?= isset($data_fisik->e_gcs)?$data_fisik->e_gcs:'' ?>",
   "m":"<?= isset($data_fisik->m_gcs)?$data_fisik->m_gcs:'' ?>",
   "v":"<?= isset($data_fisik->v_gcs)?$data_fisik->v_gcs:'' ?>",
   "tekanan_darah":"<?= isset($data_fisik->sitolic) && isset($data_fisik->diatolic)?$data_fisik->sitolic.'/'.$data_fisik->diatolic:'' ?>",
   "suhu":"<?= isset($data_fisik->suhu)?$data_fisik->suhu:'' ?>",
   "nadi":"<?= isset($data_fisik->nadi)?$data_fisik->nadi:'' ?>",
   "pernafasan":"<?= isset($data_fisik->pernafasan)?$data_fisik->pernafasan:'' ?>",
   "pemeriksaan_fisik":"<?= isset($assesment_medik_igd->status_generalis_dokter)?str_replace(["\n","\r",PHP_EOL],'\n',$assesment_medik_igd->status_generalis_dokter):'' ?>",
   "status_lokalis":"<?= isset($assesment_medik_igd->status_lokalis_dokter)?str_replace(["\n","\r",PHP_EOL],'\n',$assesment_medik_igd->status_lokalis_dokter):'' ?>",
   "pemeriksaan_penunjang":"<?= isset($soap_pasien_rj)?trim(str_replace(['<br>',"\r","\n",PHP_EOL],'\n',$soap_pasien_rj->pemeriksaan_penunjang_dokter)):'' ?>",
//    "intervensi":"<?php 
//    $result = '';
//    if(isset($assesment_keperawatan->intervensi1)){
//        for($i=0;$i<count($assesment_keperawatan->intervensi1);$i++){
//            $result.= convert_intervensi($assesment_keperawatan->intervensi1[$i]);
//        }
//    }

//    if(isset($assesment_keperawatan->berikan_oksigen)){
//        if($assesment_keperawatan->berikan_oksigen[0] == "16"){
//            $tambahan1 = '- Berikan Oksigen ';
//            if(isset($assesment_keperawatan->check_oksigen)){
//                $result .=$tambahan1.' : '.$assesment_keperawatan->check_oksigen.' \n';
//            }
//        }
//    }
//    if(isset($assesment_keperawatan->imobilitas)){
//     if($assesment_keperawatan->imobilitas[0] == "17"){
//         $tambahan1 = '- Imobilisasi daerah cedera : Pasang bidai / spalak / sling \n';
//         $result .=$tambahan1;
//     }
//     }

//     if(isset($assesment_keperawatan->lakukan_perawatan_luka)){
//         if($assesment_keperawatan->lakukan_perawatan_luka[0] == "17"){
//             $tambahan1 = '- Lakukan Perawatan Luka \n';
//             $result .=$tambahan1;
//         }
//     }

//     if(isset($assesment_keperawatan->Lainnya)){
//         if($assesment_keperawatan->Lainnya[0] == "17"){
//             $tambahan1 = '- Lainnya';
//             if(isset($assesment_keperawatan->check_lainnya4)){
//                 $result.= $tambahan1.' : '.$assesment_keperawatan->check_lainnya4.' \n';
//             }
//         }
//     }

//     if(isset($assesment_keperawatan->terapi_cairan)){
//         if($assesment_keperawatan->terapi_cairan[0] == "18"){
//             $tambahan1 = '- Terapi cairan';
//             if(isset($assesment_keperawatan->check_terapi)){
//                 $result.= $tambahan1.' : '.$assesment_keperawatan->check_terapi.' \n';
//             }
//         }
//     }
//     if(isset($assesment_keperawatan->pemberian)){
//         if($assesment_keperawatan->pemberian[0] == "19"){
//             $tambahan1 = '- Pemberian Oksigen';
//             if(isset($assesment_keperawatan->check_pemberian)){
//                 $result.= $tambahan1.' : '.$assesment_keperawatan->check_pemberian.' \n';
//             }
//         }
//     }

//     if(isset($assesment_keperawatan->pemberian)){
//         if($assesment_keperawatan->pemberian[0] == "19"){
//             $tambahan1 = '- Pemberian Oksigen';
//             if(isset($assesment_keperawatan->check_pemberian)){
//                 $result.= $tambahan1.' : '.$assesment_keperawatan->check_pemberian.' \n';
//             }
//         }
//     }

//     if(isset($assesment_keperawatan->nebulizer)){
//         for($i=0;$i<count($assesment_keperawatan->nebulizer);$i++){
//             $result.= convert_intervensi($assesment_keperawatan->nebulizer[$i]);
//         }
//     }

//     if(isset($assesment_keperawatan->lainnyaa1)){
//         if($assesment_keperawatan->lainnyaa1[0] == "lainnyaa1"){
//             $tambahan1 = '- Lainnya';
//             if(isset($assesment_keperawatan->check_lainnya2)){
//                 $result.= $tambahan1.' : '.$assesment_keperawatan->check_lainnya2.' \n';
//             }
//         }
//     }
    
    

//    echo $result;
//    ?>",
   "question5":[
       <?php 
        $result = "";
        if(isset($assesment_medik_igd->question5)){
            foreach($assesment_medik_igd->question5 as $val){
                $obat = "";
                $jumlah_frekwensi = "";
                $dosis = "";
                $cara_pemberian = "";
                if(isset($val->nama_obat)){
                    $obat = $val->nama_obat; 
                }
                if(isset($val->jumlah_frekwensi)){
                    $jumlah_frekwensi = $val->jumlah_frekwensi;
                }
                if(isset($val->dosis)){
                    $dosis = $val->dosis;
                }
                if(isset($val->cara_pemberian)){
                    $cara_pemberian = $val->cara_pemberian;
                }
                $result .=  '{
                  "nama_obat":"'.$obat.'",'.
                  '"jumlah_frekwensi":"'.$jumlah_frekwensi.'",
                  "dosis":"'.$dosis.'",
                  "cara_pemberian":"'.$cara_pemberian.'",
                },';
            }
        }
        echo $result;
        ?>
   ]
}
<?php } ?>


// survey.css = myCss;
$("#surveyTransferRuangan").Survey({
    model: surveyTransferRuangan,
    onComplete: sendDataToTransferRuangan
});
</script>