<?php 
$this->load->view('layout/header_form');
?>

<?php 

$resultAll = isset($intruksi_obat)?$intruksi_obat:null;
// $endresultintruksiobat = end($resultAll);
// var_dump($endresultintruksiobat);die();
?>

<div class="card m-5">
    
    <div class="body">
    <div id="surveyintruksiobat"></div>

    </div>
</div>

<div class="card m-5">
    <div class="body">
    <div id="surveytelaah"></div>

    </div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJsonIntruksiObat = <?php echo file_get_contents("oba1.json",FILE_USE_INCLUDE_PATH);?>;
    surveyJsontelaah = <?php echo file_get_contents("obat2.json",FILE_USE_INCLUDE_PATH);?>;
   

    var surveyIntruksiobat = new Survey.Model(surveyJsonIntruksiObat);
    var surveytelaah = new Survey.Model(surveyJsontelaah);
    surveyIntruksiobat.showNavigationButtons = false;

//   console.log(surveyIntruksiobat.data);

function sendDataToServerIntruksiObat(survey) {
            //  console.log(JSON.stringify(survey.data));
          
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('iri/rictindakan/intruksi_obat/'); ?>',
                data: {
                    no_ipd:'<?php echo $no_ipd ;?>',
                    formjson_obat: JSON.stringify(survey.data)
                },
                success: function(data){
                  
                },
                dataType: 'json'
                });
        }


        surveyIntruksiobat.render("surveyintruksiobat");

		<?php
		// var_dump($data_fisik->masalah_keperawatan_json);
		if(isset($resultAll)){
		?>
		surveyIntruksiobat.data = <?= isset($resultAll->formjson)?$resultAll->formjson:''; ?>
		<?php } ?>

        surveyIntruksiobat
            .onComplete
            .add(function (result) {
                sendDataToServerIntruksiObat(result);
            });


    

        function sendDataToServertelaah(survey) {
            surveyIntruksiobat.completeLastPage();

        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/KIO_telaah_obat/')?>",
            type : 'POST',
            data : {
                no_ipd:'<?php echo $no_ipd ;?>',
                telaah: JSON.stringify(survey.data)
              
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
                console.log(data);
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }

    <?php if(isset($resultAll)) {?>
        surveytelaah.data = <?= isset($resultAll->json_telaah)?$resultAll->json_telaah:''; ?>
    <?php } ?>
  
    surveytelaah.render("surveytelaah");
    surveytelaah
        .onComplete
        .add(function (result) {
            sendDataToServertelaah(result);
        });
</script>