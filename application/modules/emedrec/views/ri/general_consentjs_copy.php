 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-----SurveyJS ---->
    <script src="<?php echo site_url('assets/surveyjs/knockout-latest.js'); ?>"></script>
    <script src="<?php echo site_url('assets/surveyjs/survey.ko.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/surveyjs/survey.ko.min.js'); ?>"></script>
    
    <script src="<?php echo site_url('assets/surveyjs/ckeditor.js'); ?>"></script>
    <script src="<?php echo site_url('assets/surveyjs/surveyjs.widgets.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo site_url('assets/surveyjs/survey.min.css'); ?>">
</head>
<body>
    
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div id="surveyContainer"></div>
            <div id="surveyResult"></div>
        </div>
    </div>
</div>
<script>
        json_data = {
            "question2":
            {
                "tgldaftarri":"<?= $general_consent[0]->tgl_masuk; ?>",
                "waktu":"<?= $general_consent[0]->jam_masuk; ?>",
                "idrg":"<?= $general_consent[0]->idrg; ?>",
                "klsiri":"<?= $general_consent[0]->klsiri; ?>"
            },
            "question1":{
                "nama":"<?= $general_consent[0]->nmpjawabri; ?>",
                "tgl_lahir":"<?= $general_consent[0]->tgllahirpjawabri; ?>",
                "hub":"<?= $general_consent[0]->hubpjawabri; ?>",
                "alamat":"<?= $general_consent[0]->alamatpjawabri; ?>",
                "no_hp":'<?= $general_consent[0]->notlppjawab; ?>'
                },
            "carabayar":"<?= $general_consent[0]->carabayar; ?>    ",
            "ttd_pasien":"<?= $general_consent[0]->ttd_penanggungjawab; ?>",
            "ttd_petugas":"<?= $general_consent[0]->ttd_petugas; ?>"
            };
        surveyJSON = <?php echo str_replace(array("\r\n", "\n", "\r"), "", file_get_contents(__DIR__ ."/surveyjs/RM-001b-RI.json"));?>;
        Survey.StylesManager.applyTheme("modern");
        var survey = new Survey.Model(surveyJSON);
        survey.data = json_data;
        
        // sendDataToServer(survey){
            // alert(JSON.stringify(survey.data));
        // }

        



       
        survey.render("surveyContainer");
        survey
            .onComplete
            .add(function (result) {
                // alert(JSON.stringify(result.data));
                console.log(JSON.stringify(result.data));
                // sendDataToServer(result);
                // document
                //     .querySelector('#surveyResult')
                //     .textContent = "Result JSON:\n" + JSON.stringify(result.data, null, 3);
            });
</script>
</body>
</html>