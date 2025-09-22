<?php 
$this->load->view('layout/header_form');
?>


<?php
// var_dump($assesment_gizi->formjson);
// echo '<br>';
// var_dump($assesment_gizi);
$data = isset($assesment_gizi->formjson)?json_decode($assesment_gizi->formjson):null;
// var_dump($data);die();
?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

<div class="card m-5">
    <div class="body">
    <a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/asuhan_gizi/'.$no_ipd) ?>" class="btn btn-primary">Lihat Asuhan Gizi</a>
    <div id="surveyasuhangizi"></div>

    </div>
</div>

<script>
    Survey.StylesManager.applyTheme("modern");
     // ============================================
     async function pembulatan(params){
        if (params.length < 1) {
            this.returnResult(false);
            return false;
        }
        var numbers = params[0];
        var self = this;
        var res = await Math.round(numbers);
        self.returnResult(res);
        return false;
    }

    // =============================================
    
    
    // Survey.FunctionFactory.Instance.register("funcPembulatan", funcPembulatan,true);
    surveyJsonAsuhanGizi = <?php echo file_get_contents("asuhangizi.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyasuhangizi = new Survey.Model(surveyJsonAsuhanGizi);


    function sendDataToServerASuhanGizi(survey) {
        
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_asuhan_gizi/')?>",
            type : 'POST',
            data : {
                no_ipd:'<?php echo $no_ipd ;?>',
                formjson: JSON.stringify(survey.data)
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
                new swal('Berhasil!','Data Berhasil Disimpan','success');
                location.reload();
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }
    <?php if($asuhan_gizi){ ?>
     surveyasuhangizi.data = <?php echo $asuhan_gizi->formjson ?>;
    <?php }else{ ?>
    <?php 
    if(isset($assesment_gizi->formjson)){
        $assesment_gizi = json_decode($assesment_gizi->formjson);
    }
    ?>

    // ====================================
    Survey.FunctionFactory.Instance.register("pembulatan", pembulatan,true);
    // =====================================
    
    surveyasuhangizi.data = {"nm_dpjp":"<?php echo $data_pasien[0]['dokter'];?>",
        "table_alergi":[{
            "telur":"<?= isset($data->alergi_makanan[0]->telur)?$data->alergi_makanan[0]->telur:'' ?>",
            "susu_sapi":"<?= isset($data->alergi_makanan[0]->susu_sapi)?$data->alergi_makanan[0]->susu_sapi:'' ?>",
            "kacang":"<?= isset($data->alergi_makanan[0]->kacang_kedelai)?$data->alergi_makanan[0]->kacang_kedelai:'' ?>",
            "gulten":"<?= isset($data->alergi_makanan[0]->gluten_gandum)?$data->alergi_makanan[0]->gluten_gandum:'' ?>",
            "udang":"<?= isset($data->alergi_makanan[0]->udang)?$data->alergi_makanan[0]->udang:'' ?>",
            "ikan":"<?= isset($data->alergi_makanan[0]->ikan)?$data->alergi_makanan[0]->ikan:'' ?>",
            }]};

    <?php } ?>
    surveyasuhangizi.render("surveyasuhangizi");

   
    surveyasuhangizi
        .onComplete
        .add(function (result) {
            sendDataToServerASuhanGizi(result);
        });
</script>