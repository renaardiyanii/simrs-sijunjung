<?php 
$this->load->view('layout/header_form');
$data = isset($form_a_evaluasi->formjson)?json_decode($form_a_evaluasi->formjson):null;
// var_dump($data_pasien[0]['tgl_keluar']);die();
?>

<div class="card m-5">
    <div class="body">
    <div id="surveyformaevaluasi"></div>

    </div>
</div>

<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonFormA = <?php echo file_get_contents("formaevaluasi.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyFormA = new Survey.Model(surveyJsonFormA);


    function sendDataToServerFormA(survey) {
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/form_a_evaluasi/')?>",
            type : 'POST',
            data : {
                no_ipd:'<?php echo $no_ipd ;?>',
                formjson: JSON.stringify(survey.data),
            },
            datatype:'json',
        
            beforeSend:function()
            {
            },      
            complete:function()
            {
            //stopPreloader();
            },
            success:function(data)
            {
                // new swal('Berhasil!','Data Berhasil Disimpan','success');
                location.reload();
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }
    <?php if($form_a_evaluasi){ ?>
        surveyFormA.data = <?= $form_a_evaluasi->formjson ?>;
    <?php } else { ?>
        surveyFormA.data = {"tgl_keluar":"<?php echo $data_pasien[0]['tgl_keluar'] ?>",
        "diagnosa":"<?php 
            foreach($diagnosa as $diag) {
                echo $diag->diagnosa.' ('.$diag->klasifikasi_diagnos.')\n';
            }
        ?>"},
    <?php } ?>
    surveyFormA.render("surveyformaevaluasi");
    surveyFormA
        .onComplete
        .add(function (result) {
            sendDataToServerFormA(result);
        });
</script>