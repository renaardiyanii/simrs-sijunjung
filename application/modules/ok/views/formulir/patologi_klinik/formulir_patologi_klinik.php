<?php
 $this->load->view('header_form');
?>

<div class="card m-5">
    <div class="body">
        <!-- <a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/formulir_patologi_klinik/' . $no_ipd) ?>"
            class="btn btn-primary">Lihat Formulir Patologi Klinik </a> -->
        <div id="surveyformulirpatologiklinik"></div>

    </div>
</div>

<script>
Survey.StylesManager.applyTheme("modern");
surveyformulirpatologiklinikjson =
    <?php echo file_get_contents("formulir_patologi_klinik.json", FILE_USE_INCLUDE_PATH); ?>;
var surveyformulirpatologiklinik = new Survey.Model(surveyformulirpatologiklinikjson);


function sendDataToserverFormulirPatologiKlinik(survey) {

    $.ajax({
        url: "<?php echo base_url('iri/rictindakan/insert_formulir_patologi_klinik/') ?>",
        type: 'POST',
        data: {
            no_ipd: '<?php echo $no_register; ?>',
            formulir_patologi_klinik_json: JSON.stringify(survey.data)
        },
        datatype: 'json',

        beforeSend: function() {},
        complete: function() {
            //stopPreloader();
        },
        success: function(data) {
            //new swal('Berhasil!', 'Data Berhasil Disimpan', 'success');
            location.reload();
        },
        error: function(e) {
            new swal('Gagal!', 'Gagal Disimpan Karena ' + e, 'error');

        }
    });

}

<?php
    if (isset($patologi_klinik)) {
    ?>
surveyformulirpatologiklinik.data = <?= $patologi_klinik->formjson ?>;
<?php
    }
    ?>
surveyformulirpatologiklinik.render("surveyformulirpatologiklinik");
surveyformulirpatologiklinik
    .onComplete
    .add(function(result) {
        sendDataToserverFormulirPatologiKlinik(result);
    });
</script>