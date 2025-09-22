<?php
$this->load->view('layout/header_left.php');
?>

<link href="<?= base_url(); ?>assets/surveyjs/modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url(); ?>assets/surveyjs/survey.jquery.min.js"></script>

<style>
    .modal-dialog {
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 5px;
    }

    .modal-content {
        width: 275%;
        height: 100%;
        border-radius: 0;
        color: #333;
        overflow: auto;
    }

    .close {
        color: black ! important;
        opacity: 1.0;
    }
</style>
<script type='text/javascript'>
    $(document).ready(function() {
        $('#datatable2').DataTable();

    });
</script>
<section class="content-header">
    <?php
    echo $this->session->flashdata('success_msg');
    ?>
</section>

<div class="card">
    <div class="card-body p-5">
        <h4 class="card-title">Detail Resep</h4>
        <hr>
        <div class="form-group">
            <table id="datatable2" class="display table table-hover table-bordered table-striped " cellspacing="0">
                <thead>
                    <tr>
                        <th align="center">No</th>
                        <th align="center">Obat</th>
                        <th align="center">Tgl.Resep</th>
                        <th align="center">Nama Obat</th>
                        <th align="center">Harga</th>
                        <th align="center">Signa</th>
                        <th align="center">Banyak</th>
                        <th align="center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $ttot = 0;
                    foreach ($hasil as $value) {
                        $ttot += $value->vtot;
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>
                                <?php
                                if ($value->obat_luar == 0) {
                                    echo 'OBAT LUAR';
                                } else {
                                    echo 'OBAT RS';
                                }
                                ?>
                            </td>
                            <td><?= $value->xupdate; ?></td>
                            <td><?php
                                echo $value->nama_obat;
                                if ($value->racikan == '1') {
                                    foreach ($data_tindakan_racik as $row1) {
                                        if ($value->id_resep_pasien == $row1->id_resep_pasien) {
                                            echo '<br>- ' . $row1->nm_obat . ' Dosis ' . $row1->dosis . ', Satuan ' . $row1->satuan . ' (' . $row1->qty . ')';
                                        }
                                    }
                                }
                                ?></td>
                            <td><?= "<div align=\"right\">" . number_format($value->biaya_obat, '0', ',', '.') . "</div>" ?></td>
                            <td><?= $value->signa ?></td>
                            <td><?= "<div align=\"right\">" . number_format($value->qty, '0', ',', '.') . "</div>" ?></td>
                            <td><?= "<div align=\"right\">" . number_format($value->vtot, '0', ',', '.') . "</div>" ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div align="right" class="mt-2" id="total_rekap"><span>
                    <h4>Total Akhir:&nbsp;&nbsp;&nbsp; Rp. <?= number_format($ttot, '2', ',', '.') ?></h4>
                </span></div>

        </div>
    </div>

</div>
<div class="card">
    <div class="card-body">
        <div id="surveyContainerTelaahObat" style="width:100%"></div>
        <div style="padding-left:90px;padding-top:3em;padding-bottom:2em;">
            <a href="<?= base_url('farmasi/Frmcdaftar/') ?>" type="button" class="btn btn-dark waves-effect">Kembali</a>
            <button type="button" class="btn btn-info waves-effect" onclick="save_data()">Simpan</button>&nbsp;&nbsp;
            <a target="_blank" href="<?php echo base_url('emedrec/C_emedrec/cetak_Eresep_telaah/' . ($hasil[0]->no_cm?? '') . '/' . $no_register); ?>" class="btn btn-primary">Cetak Telaah Obat</a>
            <!-- <a target="_blank" href="<?php echo base_url('farmasi/frmckwitansi/cetak_kwitansi_farmasi' . '/' . $no_register); ?>" class="btn btn-primary">Cetak Nota Biaya</a> -->
        </div>
    </div>
</div>

<script>
    surveyJSON = <?php echo file_get_contents(APPPATH . "modules/farmasi/views/telaah_obat/survey/telaah_obat.json"); ?>;
    Survey.StylesManager.applyTheme("modern");
    var survey = new Survey.Model(surveyJSON, "surveyContainerTelaahObat");
    survey.showNavigationButtons = false;





    <?php if (isset($survey_telaah_obat->formjson)) { ?>
        survey.data = <?= $survey_telaah_obat->formjson ?>
    <?php }else { ?>

        survey.data = {"telaah_resep":{"1":"ya","2":"ya","3":"ya","4":"ya","5":"ya","6":"ya","7":"ya","8":"ya","9":"ya"},"verif_penyerahan_obat":{"1":"ya","2":"ya","3":"ya","4":"ya","5":"ya","6":"ya","7":"ya"}}
    <?php } ?>

    survey.onComplete.add(function(survey, options) {
        simpan_data(survey);
    });

    function save_data() {
        survey.completeLastPage();
    }

    function simpan_data(survey) {
        // console.log(survey.data);

        $.ajax({
            type: "POST",
            url: '<?php echo base_url('farmasi/frmcdaftar/insert_telaah/') ?>',
            data: {
                data: JSON.stringify(survey.data),
                no_register: '<?= $no_register ?>'
            },
            success: function(data) {
                // console.log(data)
                new swal({
                        title: "Selesai",
                        text: "Data berhasil disimpan",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                        willClose: () => {
                            window.location.reload();
                        }
                    },
                    function() {
                        window.location.reload();
                    });

            },
            dataType: 'json'
        });
    }
</script>

<?php
$this->load->view('layout/footer_left.php');
?>