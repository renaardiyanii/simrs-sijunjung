<?php 

$resultAll = isset($intruksi_obat)?$intruksi_obat:null;
// $endresultintruksiobat = end($resultAll);
// var_dump($endresultintruksiobat);die();
?>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

<div id="surveyintruksiobat"></div>
<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonIntruksiObat = <?php echo file_get_contents("intruksi_obat.json",FILE_USE_INCLUDE_PATH);?>;
   

    var surveyIntruksiobat = new Survey.Model(surveyJsonIntruksiObat);

//   console.log(surveyIntruksiobat.data);
    function sendDataToServerIntruksiObat(survey) {
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/intruksi_obat/')?>",
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
                //location.reload();
                console.log(data);
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }

    <?php if($resultAll){ ?>
        surveyIntruksiobat.data = <?= $resultAll->formjson ?>;
    <?php } ?>
  
    surveyIntruksiobat.render("surveyintruksiobat");
    surveyIntruksiobat
        .onComplete
        .add(function (result) {
            sendDataToServerIntruksiObat(result);
        });
</script>