

<table id="data" border="1" cellspacing="0" cellpadding="0">
    <tr style="height: 50px;">
        <td class="text-center" style="width: 20%;">
            <span>
                Tanggal Masuk :<br><br><?= isset($data->tgl_masuk)?$data->tgl_masuk:''; ?>
            </span>
        </td>
        <td class="text-center" style="width: 20%;">Tanggal Pindah: <br><br><?= isset($data->tgl_pindah)? date('d-m-Y',strtotime($data->tgl_pindah)):''; ?></td>
        <td class="text-center" style="width: 30%;">Asal ruang rawat:<br><br><span><?= isset($data->asal_ruang_rawat)?$data->asal_ruang_rawat:''; ?></span></td>
        <td class="text-center" style="width: 30%;">Ruang rawat selanjutnya:<br><br><?= isset($data->ruang_rawat_selanjutnya)?$data->ruang_rawat_selanjutnya:'' ?></td>
    </tr>
    <tr>
        <td class="text-center" colspan="2">
            <span>Dokter yang merawat</span><br><br><br>
            <span><?= isset($data->dokter_yang_merawat)?$data->dokter_yang_merawat:''; ?></span>
        </td>
        <td class="text-center align-center" colspan="2">
            <span>Dokter Penanggung Jawab Pelayanan ( DPJP):</span><br><br>
            <div class="flex row">
                <span><?= isset($data->dokter_penanggung_jawab)?$data->dokter_penanggung_jawab:'' ?></span><br><br><br>
                <!-- <img src="<?= base_url('#') ?>" height="50px" alt=""> -->
            </div>
        </td>
       
    </tr>
    <tr>
        <td colspan="2">
            <div class="ml-1">
                <span>Diagnosa Utama</span><br><br>
                <span><?= isset($data->diagnosa_utama)?$data->diagnosa_utama:''; ?></span><br><br>
            </div>
        </td>
        <td colspan="2">
            <span>Perlu menjadi perhatian</span><br>
            <table width="100%" class="ml-1 mt-025">
                <tr>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->perlu)?in_array('alergi',$data->perlu)?"checked":"":'' ?>><label for="">Alergi </label> 
                    </td>
                    <td>
                        <label for=""> Sebutkan: <?= isset($data->check_alergi)?$data->check_alergi:'' ?></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->perlu)?in_array('mrssa',$data->perlu)?"checked":"":'' ?>><label for="">MRSA</label> 
                    </td>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->perlu)?in_array('lainnya',$data->perlu)?"checked":"":'' ?>><label for="">Lain-lain <?= isset($data->check_lainnya)?$data->check_lainnya:'' ?></label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td rowspan="2" colspan="2">
            <div class="ml-1">
                <span>Diagnosa Sekunder</span><br><br>
                <span><?= isset($data->diagnosa_sekunder)?$data->diagnosa_sekunder:''; ?></span><br><br>
            </div>
        </td>
        <td colspan="2">
            <label for="" class="ml-1">Alasan Pemindahan pasien:</label><br><br>
            <label for="">1. kondisi pasien</label>
            <input type="checkbox" name="" id="" <?= isset($data->kondisi_pasien)?in_array('memburuk',$data->kondisi_pasien)?"checked":"":''; ?>><label for="">Memburuk</label>
            <input type="checkbox" name="" id="" <?= isset($data->kondisi_pasien)?in_array('stabil',$data->kondisi_pasien)?"checked":"":''; ?>><label for="">Stabil</label>
            <input type="checkbox" name="" id="" <?= isset($data->kondisi_pasien)?in_array('tidak_ada_perubahan',$data->kondisi_pasien)?"checked":"":''; ?>><label for="">Tidak ada perubahan</label>
            <br><br>
            <label for="">2. Fasilitas</label>
            <input type="checkbox" name="" id="" <?= isset($data->fasilitas)?in_array('kurang_memadari',$data->fasilitas)?"checked":"":''; ?>><label for="">Kurang Memadai</label>
            <input type="checkbox" name="" id="" <?= isset($data->fasilitas)?in_array('membutuhkan_peralatan',$data->fasilitas)?"checked":"":''; ?>><label for="">Membutuhkan peralatan yang lebih baik</label>
            <br><br>
            <label for="">3. Tenaga</label>
            <input type="checkbox" name="" id="" <?= isset($data->tenaga)?in_array('membutuhkan_tenaga_yang',$data->tenaga)?"checked":"":''; ?>><label for="">Membutuhkan tenaga yang lebih ahli</label>
            <input type="checkbox" name="" id="" <?= isset($data->tenaga)?in_array('jumlah_tenaga_kurang',$data->tenaga)?"checked":"":''; ?>><label for="">Jumlah tenaga kurang</label>
            <br><br>
            <label for="">4. Lain-lain sebutkan : <?= isset($data->lainya)?$data->lainya:'';  ?></label>
            <br><br>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <label for="">Metode pemindahan pasien :</label><br><br>
            <input type="checkbox" name="" id="" <?= isset($data->metode_pemindahan_pasien)?$data->metode_pemindahan_pasien == "kursi_roda"?"checked":"":'' ?> ><label for="">Kursi Roda </label>
            <input type="checkbox" name="" id="" <?= isset($data->metode_pemindahan_pasien)?$data->metode_pemindahan_pasien == "brankar"?"checked":"":'' ?>><label for="">Brankar</label>
            <input type="checkbox" name="" id="" <?= isset($data->metode_pemindahan_pasien)?$data->metode_pemindahan_pasien == "tempat_tidur"?"checked":"":'' ?>><label for="">Tempat Tidur</label>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <label for="">Derajat Transfer Pasien</label>
            <br><br>
            <input type="checkbox" name="" id="" <?= isset($data->derajat_transfer_pasien)?in_array("derajat0",$data->derajat_transfer_pasien)?"checked":"":'' ?>><label for="">Derajat 0</label>
            <input type="checkbox" name="" id="" <?= isset($data->derajat_transfer_pasien)?in_array("derajat1",$data->derajat_transfer_pasien)?"checked":"":'' ?>><label for="">Derajat 1</label>
            <input type="checkbox" name="" id="" <?= isset($data->derajat_transfer_pasien)?in_array("derajat2",$data->derajat_transfer_pasien)?"checked":"":'' ?>><label for="">Derajat 2</label>
            <input type="checkbox" name="" id="" <?= isset($data->derajat_transfer_pasien)?in_array("derajat3",$data->derajat_transfer_pasien)?"checked":"":'' ?>><label for="">Derajat 3</label>                
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <label for="">Pasien / Keluarga mengetahui dan menyetujui mengenai
                Alasan pemindahan
                </label><br>
            <input type="checkbox" name="" id="" <?= isset($data->pasien_keluarga_mengetahui)?$data->pasien_keluarga_mengetahui == "ya"?"checked":"":'' ?>><label for="">Ya</label><br>
            <input type="checkbox" name="" id="" <?= isset($data->pasien_keluarga_mengetahui)?$data->pasien_keluarga_mengetahui == "tidak"?"checked":"":'' ?>><label for="">Tidak</label><br>
            <label for="">Keluarga yang member persetujuan</label><br>
            <label for="">Nama : <?= isset($data->keluarga_yang_memberi_persetujuan->nama)?$data->keluarga_yang_memberi_persetujuan->nama:''?></label><br>
            <label for="">Hubungan : <?= isset($data->keluarga_yang_memberi_persetujuan->hubungan)?$data->keluarga_yang_memberi_persetujuan->hubungan:''?> </label><br><br>
            <div class="flex justify-between">
                <label for="">Tanda tangan :...........................</label>
            </div>
        </td>
        <td colspan="2">
            <br>
            <label class="ml-1 mt-1" for="">Peralatan yang menyertai pasien saat pindah</label>
            <table width="70%">
                <tr>
                    <td colspan="2">
                        <input type="checkbox" name="" id="" <?= isset($data->peralatan_yang_menyertai_pasien_saat_pindah)?in_array("portable",$data->peralatan_yang_menyertai_pasien_saat_pindah)?"checked":"":'' ?>><label for="">Portable O² Kebutuhan<?= isset($data->check_portable)?' '.$data->check_portable.' ':'' ?>1/Menit</label>
                    </td>    
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->peralatan_yang_menyertai_pasien_saat_pindah)?in_array("alat_penghisap",$data->peralatan_yang_menyertai_pasien_saat_pindah)?"checked":"":'' ?>><label for="">Alat Penghisap</label>
                    </td>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->peralatan_yang_menyertai_pasien_saat_pindah)?in_array("bagging",$data->peralatan_yang_menyertai_pasien_saat_pindah)?"checked":"":'' ?>><label for="">Kateter Urin</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->peralatan_yang_menyertai_pasien_saat_pindah)?in_array("kateter_urin",$data->peralatan_yang_menyertai_pasien_saat_pindah)?"checked":"":'' ?>><label for="">Bagging</label>
                    </td>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->peralatan_yang_menyertai_pasien_saat_pindah)?in_array("pompa_infus",$data->peralatan_yang_menyertai_pasien_saat_pindah)?"checked":"":'' ?>><label for="">Pompa Infus</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->peralatan_yang_menyertai_pasien_saat_pindah)?in_array("ngt",$data->peralatan_yang_menyertai_pasien_saat_pindah)?"checked":"":'' ?>><label for="">NGT</label>
                    </td>
                    <td>
                        <input type="checkbox" name="" id="" <?= isset($data->peralatan_yang_menyertai_pasien_saat_pindah)?in_array("ventilator",$data->peralatan_yang_menyertai_pasien_saat_pindah)?"checked":"":'' ?>><label for="">Ventilator</label> 
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <label for="">Keadaan pasien saat pindah</label><br>
            <label for="">Kesadaran (GCS) : E : <?= isset($data->e)?$data->e:''; ?>   </label>
            <label for="">M : <?= isset($data->m)?$data->m:''; ?></label>
            <label for="">V : <?= isset($data->v)?$data->v:''; ?></label>
            <br>
            <label for="">Tekanan Darah : <?= isset($data->tekanan_darah)?$data->tekanan_darah:''; ?> mmHg,</label>
            <label for="">Suhu : <?= isset($data->suhu)?$data->suhu:''; ?> °C</label>
            <label for="">Nadi : <?= isset($data->nadi)?$data->diagnosa_utama:''; ?> X/menit</label>
            <br>
            <label for="">Pernafasan <?= isset($data->pernafasan)?$data->pernafasan:''; ?> x/menit</label>
            <br>
            <label for="">Penggunaan Oksigen : <?= isset($data->penggunaan_oksigen)?$data->penggunaan_oksigen:''; ?> L/Mnt,</label>
            <label for="">Cairan Parenteral : <?= isset($data->cairan_parental)?$data->cairan_parental:''; ?> cc/24 Jam,</label>
            <label for="">Transfusi : <?= isset($data->transfusi)?$data->transfusi:''; ?> cc</label>
            <br>
            <label for="">Penggunaan Cateter : <?= isset($data->penggunaan_cateter)?$data->penggunaan_cateter == "ya"?'Ada':'<ins>/Tidak</ins>':''; ?>, Pemakaian ke : <?= isset($data->pemakaian)?$data->pemakaian:''; ?> </label>
            <label for="">Tgl :  </label>
            <label for="">Jam :  </label>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <label for="">*) beri tanda pada kondisi yang paling sesuai</label>
            <br>
            <table>
                <tr>
                    <td style="width: 25%;font-size:8pt;"><b>INFORMASI MEDIS</b></td>
                    <td style="width: 25%;font-size:8pt;"><b>Gangguan</b></td>
                    <td style="width: 25%;font-size:8pt;"><b>Inkontinensia</b></td>
                    <td style="width: 25%;font-size:8pt;"><b>Potensial untuk dilakukan rehabilitasi</b></td>
                </tr>
                <tr>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("disabilitas",$data->gangguan)?"checked":"":''?>> Disabilitas</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("mental",$data->gangguan)?"checked":"":'' ?>> Mental</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->inkontinensia)?in_array("urin",$data->inkontinensia)?"checked":"":'' ?>> Urin</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->potensial)?in_array("baik",$data->potensial)?"checked":"":'' ?>> Baik</td>
                </tr>
                <tr>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("amputasi",$data->gangguan) ?"checked":"":'' ?>> Amputasi</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("pendengaran",$data->gangguan)?"checked":"":'' ?>> Pendengaran</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->inkontinensia)?in_array("alvi",$data->inkontinensia)?"checked":"":'' ?>> Alvi</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->potensial)?in_array("sedang",$data->potensial)?"checked":"":'' ?>> Sedang</td>
                </tr>
                <tr>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("paralis",$data->gangguan)?"checked":"":'' ?>> Paralis</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("sensasi",$data->gangguan)?"checked":"":'' ?>> Sensasi</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->inkontinensia)?in_array("saliva",$data->inkontinensia)?"checked":"":'' ?>> Saliva  </td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->potensial)?in_array("buruk",$data->potensial)?"checked":"":'' ?>> Buruk</td>
                </tr>
                <tr>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("konstraktur",$data->gangguan)?"checked":"":'' ?>> Kontraktur</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("bicara",$data->gangguan)?"checked":"":'' ?>> Bicara</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("ulkus_dekubitus",$data->gangguan)?"checked":"":'' ?>> Ulkus dekubitus</td>
                    <td><input style="font-size:8pt" type="checkbox" name="" id="" <?= isset($data->gangguan)?in_array("penglihatan",$data->gangguan)?"checked":"":'' ?>> Penglihatan</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table><br><br><br><br><br><br><br><br><br>
<p style="text-align:right;font-size:12px">1</p>

