<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" /> -->
<!-- <script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div>
		<div id="surveyContainer"></div>
		<div id="surveyResult"></div>
</div>
<script>
        surveyJSON = <?php echo str_replace(array("\r\n", "\n", "\r"), "", file_get_contents(__DIR__ ."/emr/assesment_dokter.json"));?>;
   
var survey = new Survey.Model(surveyJSON);
Survey.StylesManager.applyTheme("modern");

        function sendDataToServer(survey) {
      
            
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('irj/rjcpelayanan/insert_assesment/'.$no_ipd); ?>',
                data: {
                 
                    formjson: JSON.stringify(survey.data)
                },
                success: function(data){
                },
                dataType: 'json'
                });


                // DISINI MASUKIN SWAL
                
        }
        <?php
            $a = $this->db->query("SELECT formjson FROM pemeriksaan_fisik WHERE no_register='$no_ipd'")->result();
            $b = '';
            // var_dump($a);
            foreach($a as $val){
                $b = $val->formjson;
            }
            if($b){

            
        ?>
            survey.data = <?= $b; ?>;
        <?php } ?>

        survey.render("surveyContainer");
        survey
            .onComplete
            .add(function (result) {

                sendDataToServer(result);
                // document
                //     .querySelector('#surveyResult')
                //     .textContent = "Result JSON:\n" + JSON.stringify(result.data, null, 3);
            });
</script>