<?php
$this->load->view('layout/header_form');
?>

<div class="card m-5">
    <div class="body">
        <!-- <a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/disfagia/' . $no_ipd) ?>"
            class="btn btn-primary">Lihat Disfagia</a> -->
        <div id="surveydisfagia"></div>
    </div>
</div>

<script>
Survey.StylesManager.applyTheme("modern");
surveydisfagiajson =
    <?php echo file_get_contents("disfagia.json", FILE_USE_INCLUDE_PATH); ?>;
var surveydisfagia = new Survey.Model(surveydisfagiajson);


function sendDataToserverDisfagia(survey) {

    $.ajax({
        url: "<?php echo base_url('iri/rictindakan/insert_disfagia/') ?>",
        type: 'POST',
        data: {
            no_ipd: '<?php echo $no_ipd; ?>',
            no_reg: '<?php echo $noreg_old; ?>',
            
            disfagia_json: JSON.stringify(survey.data)
        },
        datatype: 'json',

        beforeSend: function() {},
        complete: function() {
            //stopPreloader();
        },
        success: function(data) {
            // new swal('Berhasil!','Data Berhasil Disimpan','success');
            location.reload();
        },
        error: function(e) {
            new swal('Gagal!', 'Gagal Disimpan Karena ' + e, 'error');

        }
    });

}
<?php
    if ($disfagia) {
    ?>
surveydisfagia.data = <?= $disfagia->formjson ?>;
<?php
    }
    ?>
surveydisfagia.render("surveydisfagia");
surveydisfagia
    .onComplete
    .add(function(result) {
        sendDataToserverDisfagia(result);
    });
</script>