<?php
$this->load->view('layout/header_form');
// var_dump($no_ipd);die();
?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->

<div class="card m-5">
    <div class="card-header">
		<div class="d-flex justify-content-between">
            <?php echo form_open('iri/rictindakan/search_kio_libur');?>
            <div class="form-group row">
                <div class="col-sm-8">
                    <input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_resep">
                    <input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
                </div>
    
                <div class="col-sm-4">
                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
    <div class="body">
        <div id="SurveyKartuIntruksiObatLibur"></div>
    </div>
</div>

<script>
    // Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");
    Survey.CustomWidgetCollection.Instance.setActivatedBy("select2", "type");
    Survey.StylesManager.applyTheme("modern");

    surveyJSONKIOLibur = <?php echo file_get_contents("kio_libur.json", FILE_USE_INCLUDE_PATH); ?>;

    function sendDataToServerKIOLibur(survey) {

        if (survey.data.question2.length > 0) {
            survey.data.question2.map((e, index) => {
                // jika belom stop , jangan ditambahkan. 
                // jika sudah ada tgl Stop , jgn ditambahkan.
                if (survey.data.question2[index].tglstop == undefined) {
                    // jika ada stop , maka tambahkan tgl sekarang
                    if (survey.data.question2[index].stop != undefined) {
                        let yourDate = new Date()

                        survey.data.question2[index].tglstop = yourDate.toISOString().split('T')[0];
                    }
                }
            })
        }

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/KIO_resep_libur/') ?>',
            data: {
                no_ipd: '<?php echo $no_ipd; ?>',
                kio_json: JSON.stringify(survey.data),
                tgl_resep: survey.data.question3
            },
            success: function(data) {

                // location.reload();


            },
            error: function(data) {

            }
        });
        console.log(JSON.stringify(survey.data));

    }


    var survey_kartu_intruksi_obatLibur = new Survey.Model(surveyJSONKIOLibur);


    <?php

	if(isset($kio_libur)){ ?> 

		survey_kartu_intruksi_obatLibur.data = <?= isset($kio_libur->kio)?$kio_libur->kio:null ?>;

	<?php } 
   // else { if(isset($kio_resep)){
    ?>

     






    // survey.css = myCss;
    $("#SurveyKartuIntruksiObatLibur").Survey({
        model: survey_kartu_intruksi_obatLibur,
        onComplete: sendDataToServerKIOLibur
    });

    // setupPageSelector(survey);
</script>