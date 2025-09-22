<div style="min-height:750px">
    <table width="100%" border="1">
        <tr >
            <td colspan="2" height="100px">
                <p ><b>Pemeriksaan Fisik</b></p>
                <p >Status Generalis (temuan yang signifikan)</p>
            </td>
            <td colspan="2">
                <p >Pendamping saat pasien pindah</p>
                <p style="line-height: 0px;">Nama petugas : <?= isset($data->nama_petugas)?$data->nama_petugas:'' ?></p>
            </td>
            </tr>
            <tr style="height: 100px;">
                <td colspan="4"><p ><b>Status Lokalia (temuan yang signifikan)</b></p>
                <p><?= isset($data->status_lokalis)?$data->status_lokalis:'' ?></p>
            </td>
            </tr>
            <tr style="height: 100px;">
                <td colspan="4"><p >Pemeriksaan penunjang /diagnostik yang sudah dilakukan  (EKG,Lab,dll)</p>
                <p><?= isset($data->pemeriksaan_penunjang)?$data->pemeriksaan_penunjang:'' ?></p></td>
            </tr>
            <tr style="height: 100px;">
                <td colspan="4"><p >Intervensi/Tindakan yang sudah dilakukan :</p>
                <p><?= isset($data->intervensi)?$data->intervensi:'' ?></p></td>
            </tr>
            <tr style="height: 100px;">
                <td colspan="4"><p >Diet</p>
                <p><?= isset($data->diet)?$data->diet:'' ?></p></td>
            </tr>
            <tr style="height: 100px;">
                <td colspan="4"><p >Rencana Perawatan Selanjutnya:</p>
                <p><?= isset($data->rencana_perawatan)?$data->rencana_perawatan:'' ?></p></td>
            </tr>
        </tr>
    </table><br><br><br><br><br><br>
    <br><br><br><br>

    <p style="text-align:right;font-size:12px">2</p>
</div>


