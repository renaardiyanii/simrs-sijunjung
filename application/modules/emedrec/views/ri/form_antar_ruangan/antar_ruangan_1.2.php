<div style="min-height:870px">
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
    </table>
</div>

<div style="display: inline; position: relative;font-size: 12px;">
    <div style="float: left;text-align: center;">
        <p>Hal 2 dari 3</p>    
    </div>
    <div style="float: right;text-align: center;">
        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
    </div>     
</div> 


