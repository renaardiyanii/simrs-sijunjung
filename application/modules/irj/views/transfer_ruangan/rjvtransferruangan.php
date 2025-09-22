<?php  //var_dump($transfer_ruangan);
// var_dump();
$this->load->view('layout/header_form');
?>
<style>
    .container-cover {
        background-color: transparent;
    }
</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>


<div id="surveyTransferRuangan"></div>
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

    Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

    Survey.StylesManager.applyTheme("modern");

    var surveyJsonTransferRuangan = <?php echo file_get_contents(__DIR__ . "/transfer_ruangan.json"); ?>;

    function sendDataToTransferRuangan(survey) {
        //send Ajax request to your web server.
        // alert("The results are:" + JSON.stringify(survey.data));
        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/transfer_ruangan/') ?>',
            data: {
                no_register: '<?= $data_pasien_daftar_ulang->no_register ?>',
                formjson: JSON.stringify(survey.data),
            },
            success: function(data) {

                location.reload();


            },
            error: function(data) {

            }
        });

    }
    var dataResepDokter = '<?php echo json_encode($list_resep_dokter) ?>';
    dataResepDokter = JSON.parse(dataResepDokter);
    // console.log(dataResepDokter);
    var listResepDokter = [];
    if (dataResepDokter.length > 0) {
        dataResepDokter.map((e) => {
            listResepDokter.push({
                "nama_obat": e.nm_obat,
                "jumlah_frekwensi": e.kali_harian,
            });
        })
    }
    var surveyTransferRuangan = new Survey.Model(surveyJsonTransferRuangan);
    <?php
    if (isset($transfer_ruangan)) {
        if ($transfer_ruangan != null) {
    ?>
            surveyTransferRuangan.data = <?= $transfer_ruangan->formjson ?>;
            surveyTransferRuangan.setValue("question5", listResepDokter);
            // surveyTransferRuangan.setValue('question5',)
        <?php }
    } else {

        ?>

        // console.log(listResepDokter);

        surveyTransferRuangan.data = {
            "tgl_masuk": "<?= date('Y-m-d', strtotime($data_pasien_daftar_ulang->tgl_kunjungan)) ?>",
            "asal_ruang_rawat": "<?= $data_pasien_daftar_ulang->id_poli == 'BA00' ? 'Rawat Darurat' : 'Rawat Jalan' ?>",
            "dokter_yang_merawat": "<?= $data_pasien_daftar_ulang->dokter . '-' . $data_pasien_daftar_ulang->iduser ?>",
            //    "dokter_penanggung_jawab":"<?php // $data_pasien_daftar_ulang->dokter 
                                                ?>",
            "diagnosa_utama": "<?php if (isset($soap_pasien_rj[0]->diagnosis_kerja_dokter)) {
                                    echo str_replace('<br>', "", explode('(utama)', $soap_pasien_rj[0]->diagnosis_kerja_dokter)[0]);
                                } ?>",
            "diagnosa_sekunder": "<?php if (isset($soap_pasien_rj[0]->diagnosis_kerja_dokter)) {
                                        echo str_replace('<br>', "", str_replace('(tambahan)', '\n', explode('(utama)', $soap_pasien_rj[0]->diagnosis_kerja_dokter)[0]));
                                    } ?>",
            "e": "<?= isset($data_fisik->e_gcs) ? $data_fisik->e_gcs : '' ?>",
            "m": "<?= isset($data_fisik->m_gcs) ? $data_fisik->m_gcs : '' ?>",
            "v": "<?= isset($data_fisik->v_gcs) ? $data_fisik->v_gcs : '' ?>",
            "tekanan_darah": "<?= isset($data_fisik->sitolic) && isset($data_fisik->diatolic) ? $data_fisik->sitolic . '/' . $data_fisik->diatolic : '' ?>",
            "suhu": "<?= isset($data_fisik->suhu) ? $data_fisik->suhu : '' ?>",
            "nadi": "<?= isset($data_fisik->nadi) ? $data_fisik->nadi : '' ?>",
            "pernafasan": "<?= isset($data_fisik->pernafasan) ? $data_fisik->pernafasan : '' ?>",
            "pemeriksaan_fisik": `<?php if (isset($soap_pasien_rj[0]->objective_dokter)) {
                                        echo str_replace([PHP_EOL, '<br>'], '\n', $soap_pasien_rj[0]->objective_dokter);
                                    } else {
                                        echo isset($soap_pasien_rj[0]->objective_perawat) ? str_replace(['<br>', PHP_EOL], '\n', $soap_pasien_rj[0]->objective_perawat) : '';
                                    } ?>`,
            "status_lokalis": "<?= isset($assesment_medik_igd->status_lokalis_dokter) ? str_replace(["\n", "\r", PHP_EOL], '\n', $assesment_medik_igd->status_lokalis_dokter) : '' ?>",
            "pemeriksaan_penunjang": "<?= isset($soap_pasien_rj[0]->pemeriksaan_penunjang_dokter) ? str_replace(["\n", "\r", PHP_EOL], '\n', $soap_pasien_rj[0]->pemeriksaan_penunjang_dokter) : '' ?>",
            "question5": listResepDokter,

        }
    <?php } ?>


    // survey.css = myCss;
    $("#surveyTransferRuangan").Survey({
        model: surveyTransferRuangan,
        onComplete: sendDataToTransferRuangan
    });
</script>