<?php
$this->load->view('layout/header_form');
?>

<div class="card m-5">
    <div class="body">
        <a target="_blank"
            href="<?= base_url('emedrec/C_emedrec_iri/assesment_keperawatan_geriatri_rawat_inap/' . $no_ipd) ?>"
            class="btn btn-primary">Lihat Assesment Keperawatan Geriatri</a>
        <div id="surveyassesmentkeperawatangeriatrirawatinap"></div>

    </div>
</div>

<script>
Survey.StylesManager.applyTheme("modern");
surveyassesmentkeperawatangeriatrirawatinapjson =
    <?php echo file_get_contents("assesment_keperawatan_geriatri_rawat_inap.json", FILE_USE_INCLUDE_PATH); ?>;
var surveyassesmentkeperawatangeriatrirawatinap = new Survey.Model(surveyassesmentkeperawatangeriatrirawatinapjson);


function sendDataToserverAssesmentKeperawatanGeriatriRawatInap(survey) {

    $.ajax({
        url: "<?php echo base_url('iri/rictindakan/insert_assesment_keperawatan_geriatri_rawat_inap/') ?>",
        type: 'POST',
        data: {
            no_ipd: '<?php echo $no_ipd; ?>',
            keperawatan_geriatri_rawat_inap_json: JSON.stringify(survey.data)
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
    if ($assesment_keperawatan_geriatri_rawat_inap) {
    ?>
surveyassesmentkeperawatangeriatrirawatinap.data = <?= $assesment_keperawatan_geriatri_rawat_inap->formjson ?>;
<?php
    }
    ?>
surveyassesmentkeperawatangeriatrirawatinap.render("surveyassesmentkeperawatangeriatrirawatinap");
surveyassesmentkeperawatangeriatrirawatinap
    .onComplete
    .add(function(result) {
        sendDataToserverAssesmentKeperawatanGeriatriRawatInap(result);
    });
</script>