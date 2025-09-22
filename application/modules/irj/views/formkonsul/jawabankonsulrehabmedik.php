<?php 
$this->load->view('layout/header_form');
?>

<?php
// $data_konsultasi = '';
//               if (isset($user_dokter->id_dokter)) {
//                 foreach ($history_konsultasi_pasien_iri->result_array() as $res) {
//                   if (in_array($user_dokter->id_dokter, $res)) {
//                     $data_konsultasi = $res['tgl_jawaban'] == null ? $res['id'] : '';
//                     if ($data_konsultasi != "") {
//                       if (substr($res['id_poli_tujuan'], 1, 4) != 'BK00') {
//               ?>
                  <?php //} else {
//                       ?>
                <?php
//                       }
//                     }
//                   }
//                 }
//                 ?>
//               <?php //}
$id = isset($idasal[0]->id)?json_encode($idasal[0]->id):'';
//var_dump($id); die();
              ?>

<div class="card m-5">
    <div class="body">
    <div id="surveyJawabanKonsulRehab"></div>

    </div>
</div>

<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonKonsulRehab = <?php echo file_get_contents("jawabankonsultasirehabmedik.json",FILE_USE_INCLUDE_PATH);?>;
   

    var surveyJawabanKonsulRehab = new Survey.Model(surveyJsonKonsulRehab);

//   console.log(surveyJawabanKonsulRehab.data);

function sendDataToRehabMedik(survey) {
            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('irj/rjcpelayananfdokter/insert_jawaban_konsul_rehab_medik/'); ?>',
                data: {
                    idasalKonsul: <?= $id; ?>,
                    jawaban_konsul_rehab: JSON.stringify(survey.data)
                },
                success: function(data)  
                { 
                    new swal({
                        title: "Selesai",
                        text: "Data berhasil disimpan",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function () {
                        window.location.reload();
                    });
                         window.location.reload();
                    
                },
                error:function(event, textStatus, errorThrown) {
                    new swal("Error","Data gagal disimpan.", "error"); 
                    console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                },
                dataType: 'json'
                });
        }


        surveyJawabanKonsulRehab.render("surveyJawabanKonsulRehab");

        surveyJawabanKonsulRehab
            .onComplete
            .add(function (result) {
                sendDataToRehabMedik(result);
            });
</script>