<?php $this->load->view('layout/header_form') ?>
<?php
$objective_perawat = "";
$assesment_dokter = "";
$assesment = "";

$resultAll = $catatan_serah_terima->result();
$endresultserahterima = end($resultAll);
$objSerahTerima = isset($endresultserahterima->formjson) ? json_decode($endresultserahterima->formjson) : null;

if (isset($soap_pasien_rj->objective_perawat)) {
    $objective_perawat .= $soap_pasien_rj->objective_perawat;
}

if (isset($soap_pasien_rj->assesment_dokter)) {
    $assesment_dokter .= $soap_pasien_rj->assesment_dokter;
}

if (isset($assesment_keperawatan->table1)) {
    foreach ($assesment_keperawatan->table1 as $val) {
        $assesment .= $val->tindakan . ' ' . $val->nama_obat_infus . ' ' . $val->dosis_frekuensi . ' ' . $val->cara_pemberian . '\n';
    }
}
?>
<style>
    .container-cover {
        background-color: transparent;
    }

    .ml-8 {
        /* margin-left:7em; */
    }
</style>

<!-- <button class="btn btn-primary ml-8" onclick="window.open(base_url)" target="_blank">Assesment Awal Medis</button> -->

<div class="card m-5">
    <div class="card-header">
        <a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/cetak_serah_terima_asuhan_pasien_iri/' . $no_ipd . '/' . $data_pasien[0]['noregasal']) ?>" class="btn btn-primary">Lihat Serah Terima</a>

    </div>

    <div class="card-body">
        <div id="surveySerahTerima"></div>
    </div>


</div>

<div class="card m-5">
    <div class="card-header">
        <h5>Riwayat Serah Terima</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered datatable" id="dataTables-assesment" style="width:100%;" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tgl Pemeriksaan</th>
                    <th>Nama Pemeriksa</th>
                    <th>Sebagai</th>
                    <th>Situations</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if ($catatan_serah_terima->num_rows()) {
                    foreach ($catatan_serah_terima->result() as $value) {
                        $json_value = json_decode($value->formjson);
                ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= isset($json_value->waktu) ? date('d/m/Y H:i:s', strtotime($json_value->waktu)) : '-' ?></td>
                            <td><?= isset($json_value->petugas1) ? $json_value->petugas1 : '-' ?></td>
                            <td><?= isset($json_value->profesi) ? $json_value->profesi : '-' ?></td>
                            <td><?= isset($json_value->situations) ? (strlen($json_value->situations) > 20) ? substr($json_value->situations, 0, 20) . '...' : $json_value->situations : '-'; ?></td>
                            <td>
                                <button type="button" class="btn btn-info dataparsingserahterima " data-ruang_rawat="<?= $json_value->ruang_rawat ?>" data-diagnosis_medis="<?= $json_value->diagnosis_medis ?>" data-waktu="<?= isset($json_value->waktu) ? $json_value->waktu : '' ?>" data-profesi="<?= isset($json_value->profesi) ? $json_value->profesi : '' ?>" data-petugas1="<?= isset($json_value->petugas1) ? $json_value->petugas1 : '' ?>" data-petugas2="<?= isset($json_value->petugas2) ? $json_value->petugas2 : '' ?>" data-situations="<?= isset($json_value->situations) ? $json_value->situations : '' ?>" data-background="<?= isset($json_value->background) ? $json_value->background : '' ?>" data-asessment="<?= isset($json_value->asessment) ? $json_value->asessment : '' ?>" data-recommendation="<?= isset($json_value->recommendation) ? $json_value->recommendation : '' ?>"> Terapkan Data </button>
                                <?php
                                if (isset($json_value->petugas1) && isset($json_value->petugas2)) {
                                    if (explode('-', $json_value->petugas1)[1] == $user->userid || explode('-', $json_value->petugas2)[1]  == $user->userid || $user->userid == 1) {
                                ?>
                                        <button type="button" class="btn btn-info dataedit " data-id="<?= $value->id ?>" data-ruang_rawat="<?= $json_value->ruang_rawat ?>" data-diagnosis_medis="<?= $json_value->diagnosis_medis ?>" data-waktu="<?= $json_value->waktu ?>" data-profesi="<?= $json_value->profesi ?>" data-petugas1="<?= $json_value->petugas1 ?>" data-petugas2="<?= $json_value->petugas2 ?>" data-situations="<?= $json_value->situations ?>" data-background="<?= $json_value->background ?>" data-asessment="<?= $json_value->asessment ?>" data-recommendation="<?= $json_value->recommendation ?>"> Edit Data </button>
                                <?php }
                                } ?>
                            </td>
                        </tr>

                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td style="text-align:center;" colspan="6">Tidak ada Data</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>





<script>
    var widget = {
        name: "emptyRadio",
        isFit: function(question) {
            return question.getType() === 'radiogroup';
        },
        isDefaultRender: true,
        afterRender: function(question, el) {
            var $el = $(el);
            $el.find("input:radio").click(function(event) {
                var UnCheck = "UnCheck",
                    $clickedbox = $(this),
                    radioname = $clickedbox.prop("name"),
                    $group = $('input[name|="' + radioname + '"]'),
                    doUncheck = $clickedbox.hasClass(UnCheck),
                    isChecked = $clickedbox.is(':checked');
                if (doUncheck) {
                    $group.removeClass(UnCheck);
                    $clickedbox.prop('checked', false);
                    question.value = null;
                } else if (isChecked) {
                    $group.removeClass(UnCheck);
                    $clickedbox.addClass(UnCheck);
                }
            });
        },
        willUnmount: function(question, el) {}
    };

    // kalo ada petugas 1 ya update
    // kalo ada petugas 1 & 2 ya 0 artinya balik lagi ke insert baru
    id_serah_terima_petugas = <?= isset($objSerahTerima->petugas1) ? (isset($objSerahTerima->petugas2) ? 0 : $endresultserahterima->id) : 0; ?>;
    Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

    Survey.StylesManager.applyTheme("modern");

    var surveyJsonSerahTerima = <?php echo file_get_contents("catatan_serah_terima.json", FILE_USE_INCLUDE_PATH); ?>;

    function sendDataToSerahTerima(survey) {
        //send Ajax request to your web server.
        // alert("The results are:" + JSON.stringify(survey.data));
        $.ajax({
            type: "POST",
            url: "<?= base_url('iri/rictindakan/serah_terima/') ?>",
            data: {
                no_register: '<?= isset($endresultserahterima->no_register) ? $endresultserahterima->no_register : $no_ipd ?>',
                formjson: JSON.stringify(survey.data),
                id: id_serah_terima_petugas
            },
            success: function(data) {
                location.reload();
                //    alert(data);
            },
            error: function(data) {}
        });

    }

    var surveySerahTerima = new Survey.Model(surveyJsonSerahTerima);
    surveySerahTerima.setValue("ruang_rawat", "<?= $data_pasien[0]['nm_ruang'] ?>");
    // edit data

    // $(document).ready(function(){
    id_serah_terima = 1;


    // });

    $('.dataedit').click(function() {
        // var value = $(this).data('value');
        var id = $(this).data('id');
        surveySerahTerima.data = {
            "ruang_rawat": $(this).data('ruang_rawat'),
            "diagnosis_medis": $(this).data('diagnosis_medis'),
            "waktu": $(this).data('waktu'),
            "profesi": $(this).data('profesi'),
            "petugas1": $(this).data('petugas1'),
            "petugas2": $(this).data('petugas2'),
            "situations": $(this).data('situations'),
            "background": $(this).data('background'),
            "asessment": $(this).data('asessment'),
            "recommendation": $(this).data('recommendation')
        };
        // console.log(value.id);
        id_serah_terima_petugas = id;
        // alert(id_serah_terima);
        // alert(id_serah_terima);
        // console.log(id_serah_terima);
    });

    $('.dataparsingserahterima').click(function() {
        // var value = $(this).data('value');
        let situations = $(this).data('situations');
        let background = $(this).data('background');
        let asessment = $(this).data('asessment');
        let recommendation = $(this).data('recommendation');

        surveySerahTerima.setValue('situations', situations);
        surveySerahTerima.setValue('background', background);
        surveySerahTerima.setValue('asessment', asessment);
        surveySerahTerima.setValue('recommendation', recommendation);
    });

    <?php
    if (isset($endresultserahterima->no_register)) {
        if (!isset($objSerahTerima->petugas2)) {
    ?>
            surveySerahTerima.data = <?= $endresultserahterima->formjson ?>;
        <?php } else { ?>
            surveySerahTerima.data = {
                "ruang_rawat": "<?= $data_pasien[0]['nm_ruang'] ?>",
                "diagnosis_medis": "<?= '( ' . $data_pasien[0]['diagmasuk'] . ' ) ' . $data_pasien[0]['nm_diagmasuk'] ?>"
            }
        <?php }
    } else { ?>
        surveySerahTerima.data = {
            "ruang_rawat": "<?= $data_pasien[0]['nm_ruang'] ?>",
            "diagnosis_medis": "<?= '( ' . $data_pasien[0]['diagmasuk'] . ' ) ' . $data_pasien[0]['nm_diagmasuk'] ?>"
        }
    <?php } ?>

    // survey.css = myCss;
    $("#surveySerahTerima").Survey({
        model: surveySerahTerima,
        onComplete: sendDataToSerahTerima
    });

    $('.datatable').DataTable({});
</script>