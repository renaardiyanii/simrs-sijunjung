<!DOCTYPE html>
<html>
<style>
				.signature-sep {
					font-size: 8px;
				}
				.content-sep {
					font-size: 8px;
					padding: 1px, 2px, 2px;
					font-weight: 600;
				}
				.note-sep {
					font-size: 7px;
					font-style: italic;
				}
				.header-sep {
					border-bottom: 1px solid #000; 
					font-size: 9px;
				}
				</style>

<table class="content-sep" border="0">
					<tr>
						<td width="20%" style="border-bottom:1px solid #000;">
								<img src="assets/images/logos/logobpjs.png" alt="img" height="50" style="padding-right:5px;">
						</td>
						<td width="60%" class="header-sep">
							<p align="center">
								<br>
								<b>SURAT ELEGIBILITAS PESERTA</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width="20%" style="border-bottom:1px solid #000;" align="right">
								<img src="<?= base_url('assets/img/logo_bpjs.png') ?>" alt="img" height="45" style="padding-right:5px;">
						</td>
					</tr>
					<br>
					<tr>
						<td width="11%" style="font-size: 10px;">No. SEP</td>
						<td width="2%">:</td>
						<td width="45%" style="font-weight: bold; font-size:10px;"><?= isset($data) ? $data->response->noSep : '-'; ?></td>
						<td width="10%"></td>
						<td width="2%"></td>
						<td width="30%"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>:</td>
						<td>".date('d-m-Y', strtotime($fields->tgl_sep))."</td>
						<td>Peserta</td>
						<td>:</td>
						<td>$fields->peserta</td>
					</tr>		
					<tr>
						<td style="font-size: 8px;">No. Kartu</td>
						<td>:</td>
						<td style="font-size: 8px;">".$fields->no_kartu." ( MR : ".$fields->no_mr." )</td>
						<td>COB</td>
						<td>:</td>
						<td>$fields->cob</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>:</td>
						<td>".$fields->nm_peserta."</td>
						<td>Jenis Rawat</td>
						<td>:</td>
						<td>$fields->jns_rawat</td>
					</tr>		
					<tr>
						<td style="font-size: 8px;">Tgl. Lahir</td>
						<td>:</td>
						<td style="font-size: 8px;">".date('d-m-Y', strtotime($fields->tgl_lahir))." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Kelamin : ".$fields->jns_kelamin."</td>
						<td>Kelas Rawat</td>
						<td>:</td>
						<td>$fields->kls_rawat</td>
					</tr>
					<tr>
						<td>No. Telepon</td>
						<td>:</td>
						<td>$fields->no_telp</td>
						<td>Penjamin</td>
						<td>:</td>
						<td>$fields->penjamin</td>
					</tr>				
					<tr>
						<td>Poli Tujuan</td>
						<td>:</td>
						<td>$fields->poli_tujuan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Faskes Perujuk</td>
						<td>:</td>
						<td>$fields->asal_faskes</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td>:</td>
						<td colspan="3">$fields->diag_awal</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>:</td>
						<td>$fields->catatan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan="3">
							<font class="note-sep"><br>
								* Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
								* SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
						<td width="18%" align="center">Pasien / Keluarga Pasien</td>
						<td width="3%"></td>
						<td width="18%" align="center">Petugas RS</td>
					</tr>		
					<tr>
						<td>Cetakan Ke ".$fields->cetakan_ke."</td>
						<td>:</td>
						<td>".$date->format('d-m-Y H:i:s')."</td>
						<td width="18%" align="center">

							<img src="data:image/png;base64,".$qrCodeBase64." alt="QR Code" />
						</td>
						<td width="3%"></td>
						<td width="18%" align="center">

						<img src="data:image/png;base64,".$qrCodeBase64." alt="QR Code" />

						</td>
					</tr>										
				</table>
</html>