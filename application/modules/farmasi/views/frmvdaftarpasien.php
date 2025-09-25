<?php
	$this->load->view('layout/header_left.php');
?>

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

.flex {
    display: flex;
}

.justify-arround {
    justify-content: space-around;
}

h2 {
    font-weight: bold;
}

.input-group-text i.mdi.mdi-calendar {
    font-size: 18px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

/* Style for the white background div */
.input-group {
    background-color: white;
    /* Add a border for visual separation */
}

.input-group-test {
    border: 1px solid #ccc;

}



/* Style for the icon */
.input-group-text i.mdi.mdi-calendar {
    font-size: 18px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

.dataTables_filter {
    display: none;
}

.dataTables_length {
    display: none;
}

.dataTables_info {
    margin-left: 1em;
    margin-bottom: 1em;
}

.paginate_button {
    margin-right: 1em;
    margin-bottom: 1em;
}
</style>
<script src="<?php echo base_url('assets/form/sweetalert2@11.js') ?>"></script>

<section class="content-header">
    <?php
		echo $this->session->flashdata('success_msg');
	?>
</section>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <h2>DAFTAR ANTRIAN PASIEN FARMASI</h2>

        <div class="row p-t-0 mt-3 mb-3">
            <div class="col-sm-4">
                <div class="input-group input-group-test d-flex align-items-center">
                    <input type="text" class="form-control" id="datepicker-proses" placeholder="Pilih Tanggal">

                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group input-group-test d-flex align-items-center">
                    <input type="text" class="form-control" id="inputcustom-proses" placeholder="Cari Pasien..">
                </div>
            </div>
            <div class="col-sm-4 row d-flex justify-content-end">
                <!-- <div class="mr-2">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#obatModal">Cek
                                Harga Obat</button>
                        </span>
                    </div>
                </div> -->
                <div class="mr-2">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success" onclick="openDashboardAntrian()">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard Antrian Farmasi
                            </button>
                        </span>
                    </div>
                </div>
                <div class="">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#myModal">Registrasi
                                Pasien Luar</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-block">
                <div class="table-responsive m-t-0">

                    <!-- example datatable server side -->
                    <table class="table table-striped table-bordered" id="table-artikel">
                        <thead>
                            <tr>
                                <th>No. Antrian</th>
                                <th>Aksi</th>
                                <th>Tanggal Kunjungan</th>
                                <th>No BPJS</th>
                                <th>No RM</th>
                                <th>No Registrasi</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <!-- <th>Kelas</th> -->
                                <th>Ruang</th>
                                <th>Cara Bayar</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo form_open('farmasi/Frmcdaftar/daftar_pasien_luar');?>
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-success">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Registrasi Pasien Luar</h4>
				</div>
				<div class="modal-body">
				<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_nama">Nama</p>
						<div class="col-sm-7">
							<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
							<input type="text" class="form-control" name="nama" id="nama">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Usia</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="usia" id="usia">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Jenis Kelamin</p>
						<div class="col-sm-7">
							<select name="jk" id="jk" class="form-control">
								<option value="L">Laki-laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="alamat" id="alamat">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 control-label col-form-label">Tanggal Lahir</p>
						<div class="col-sm-7">
							<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="dokter" id="dokter" placeholder="Isi Jika Ada">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button class="btn btn-primary" type="submit">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php echo form_close();?>


<script>
var table;

function create_sep(no_register) {
    // window.open('<?php //echo base_url() . 'bpjs/sep/cetakan_sep/'; ?>' + no_register, '_blank');
    Swal.fire({
            title: "Apakah Anda ingin cetak sep?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "OK",
            cancelButtonText: "Batal"
        }).then((confirmResult) => {
            if (confirmResult.isConfirmed) {
                $.ajax({
				url: `<?php echo base_url('bpjs/sep/get_noregister_noregister') ?>/` + no_register,
				beforeSend: function() {

				},
				success: function(data) {
                    // console.log(data);
                    if(!data){
                        new swal("Gagal", "Silahkan Registrasi Ulang", "error");
                        return;
                    }
                    if(data.no_sep !==''){
                        window.open('<?php echo base_url() . 'bpjs/sep/cetakan_sep/'; ?>' + no_register, '_blank');
                        return;
                    }

                    var noreg = no_register;
                    $.ajax({
                        url: `<?php echo base_url('bpjs/sep/insert_sep') ?>/` + data.no_register,
                        beforeSend: function() {

                        },
                        success: function(data) {
                            if (data.metaData.code === '200') {
                                $('#no_sep').val(data.response.sep.noSep);
                                window.open('<?php echo base_url() . 'bpjs/sep/cetakan_sep/'; ?>' + noreg, '_blank');
                            } else {
                                new swal("Peringatan!", data.metaData.message, "warning");
                            }
                        },
                        error: function(xhr) {
                            new swal("Peringatan!", 'Hubungi Admin IT', "warning");

                        },
                        complete: function() {

                        }
                    });
                    swal("Sukses", "Silahkan Cetak SEP", "success");
				},
				error: function(xhr) {
					new swal("Peringatan!", 'Hubungi Admin IT', "warning");

				},
				complete: function() {

				}
			});
            }
        });
}

$(document).ready(function() {
    table = $("#table-artikel").DataTable({
        language: {
            emptyTable: 'Belum ada antrian pasien farmasi',
            paginate: {
                previous: 'Sebelumnya',
                next: 'Selanjutnya'
            }
        },
        infoCallback: function(settings, start, end, max, total, pre) {
            return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    // Generate nomor antrian
                    let nomorAntrian = `F-${String(data.noantrian).padStart(3, '0')}`;

                    // Generate tombol panggil berdasarkan status
                    let tombolPanggil = '';
                    if (data.checkin === '1' && data.waktu_masuk_farmasi) {
                        // Sudah selesai
                        tombolPanggil = `<span class="btn btn-secondary btn-xs disabled">
                            <i class="fa fa-check"></i> Selesai
                        </span>`;
                    } else if (data.checkin === '1') {
                        // Sudah dipanggil tapi belum selesai
                        tombolPanggil = `
                            <button onclick="panggilAntrianFarmasi('${data.no_register}','${nomorAntrian}','${data.nama}')" class="btn btn-success btn-xs" title="Panggil Antrian">
                                <i class="fa fa-volume-up"></i> Panggil
                            </button><br>
                            <button onclick="selesaiAntrianFarmasi('${data.no_register}','${nomorAntrian}','${data.nama}')" class="btn btn-info btn-xs mt-1" title="Selesai Pelayanan">
                                <i class="fa fa-check"></i> Selesai
                            </button>`;
                    } else {
                        // Belum dipanggil
                        tombolPanggil = `
                            <button onclick="panggilAntrianFarmasi('${data.no_register}','${nomorAntrian}','${data.nama}')" class="btn btn-success btn-xs" title="Panggil Antrian">
                                <i class="fa fa-volume-up"></i> Panggil
                            </button><br>
                            <button class="btn btn-secondary btn-xs mt-1 disabled" title="Panggil terlebih dahulu">
                                <i class="fa fa-check"></i> Selesai
                            </button>`;
                    }

                    return `<strong>${nomorAntrian}</strong><br>${tombolPanggil}`;
                }
            },

            { data: null, render: function (data, type, row) {
                // console.log(row);
                var button = '';
                if (parseInt(data.jml_resep) && data.wkt_telaah_obat != null && data.waktu_selesai_farmasi == null) {
                    button = `
                        <button class="btn btn-primary btn-sm mt-1" onclick="resep('${data.no_register}')">Resep</button>
                        <button class="btn btn-primary btn-sm mt-1" onclick="telaah('${data.no_register}')">Telaah Obat</button>
                         <button class="btn btn-danger btn-sm mt-1"  onclick="selesai('${data.no_register}')">Selesai</button>
                        <button class="btn btn-info btn-sm mt-1" onclick="create_sep('${data.no_register}')">Cetak SEP</button>`;
                
                    } else if(parseInt(data.jml_resep) && data.wkt_telaah_obat != null && data.waktu_selesai_farmasi != null) {
                    button = `
                        <button class="btn btn-primary btn-sm mt-1"  onclick="resep('${data.no_register}')">Resep</button>
                        <button class="btn btn-primary btn-sm mt-1"  onclick="telaah('${data.no_register}')">Telaah Obat</button>
                        <button class="btn btn-primary btn-sm mt-1"  onclick="selesai('${data.no_register}')">Selesai</button>
                        <button class="btn btn-info btn-sm mt-1" onclick="create_sep('${data.no_register}')">Cetak SEP</button>`;
                
                    }else{
                         button = `
                        <button class="btn btn-primary btn-sm mt-1"  onclick="resep('${data.no_register}')">Resep</button>
                        <button class="btn btn-danger btn-sm mt-1"  onclick="telaah('${data.no_register}')">Telaah Obat</button>
                        <button class="btn btn-danger btn-sm mt-1"  onclick="selesai('${data.no_register}')">Selesai</button>
                        <button class="btn btn-info btn-sm mt-1" onclick="create_sep('${data.no_register}')">Cetak SEP</button>`;
                    }
                return button;
            }},
            { data: "tgl_kunjungan", render: function (data) {
                return moment(data).format("D MMMM YYYY h:mm");
            }},
            // { data: "no_sep" },
            { data: "no_kartu", defaultContent: "-",
              render: function(data, type, row) {
                return data || row.no_sep || "-";
              }
            },
            { data: "no_cm", defaultContent: "-" },
            { data: "no_register" },
            { data: "nama" },
            { data: "alamat", defaultContent: "-" },
            { data: "bed", defaultContent: "-" },
            { data: "cara_bayar", defaultContent: "-" }
        ]
    });
    $("#datepicker-proses").datepicker({
        beforeShow: function(input, inst) {
            inst.dpDiv.css({
                top: $(input).offset().top + $(input).outerHeight(),
                left: $(input).offset().left
            });
        },
        dateFormat: 'yy-mm-dd'
    });



    $('#inputcustom-proses').keyup(function() {
        table.search($(this).val()).draw();
    })

    $("#datepicker-proses").on('change', function() {
        $.ajax({
            url: `<?php echo site_url('farmasi/Frmcdaftar/get_daftar_resep_pasien/'); ?>/${this.value}`,
            success: function(response) {
                var formattedData = response.map(function(item) {
                return {
                    waktu_selesai_farmasi: item.waktu_selesai_farmasi || null,
                    waktu_masuk_farmasi: item.waktu_masuk_farmasi || null,
                    wkt_telaah_obat: item.wkt_telaah_obat || null,
                    no_register: item.no_register,
                    no_kartu: item.no_kartu || '-',
                    jml_resep: item.jml_resep || 0,
                    tgl_kunjungan: item.tgl_kunjungan,
                    no_sep: item.no_sep || '-',
                    no_cm: item.no_cm || '-',
                    nama: item.nama,
                    alamat: item.alamat || '-',
                    bed: item.bed || '-',
                    cara_bayar: item.cara_bayar,
                    tgl: item.tgl_kunjungan,
                    noantrian: item.noantrian || 1,
                    checkin: item.checkin || '0',
                };
            });

            // Clear the DataTable and add the formatted data
            table.clear().rows.add(formattedData).draw();
            }
        });
    });
    $.ajax({
        url: `<?php echo site_url('farmasi/Frmcdaftar/get_daftar_resep_pasien/'.date('Y-m-d')); ?>`,
        success: function(response) {
            console.log('Response from server:', response);
            var formattedData = response.map(function(item, index) {
            return {
                waktu_selesai_farmasi: item.waktu_selesai_farmasi || null,
                waktu_masuk_farmasi: item.waktu_masuk_farmasi || null,
                wkt_telaah_obat: item.wkt_telaah_obat || null,
                no_register: item.no_register || '',
                no_kartu: item.no_kartu || item.no_sep || '-',
                jml_resep: item.jml_resep || 0,
                tgl_kunjungan: item.tgl_kunjungan || new Date().toISOString(),
                no_sep: item.no_sep || '-',
                no_cm: item.no_cm || '-',
                nama: item.nama || 'Nama tidak tersedia',
                alamat: item.alamat || '-',
                bed: item.bed || '-',
                cara_bayar: item.cara_bayar || '-',
                tgl: item.tgl_kunjungan || item.tgl || new Date().toISOString(),
                noantrian: item.noantrian || (index + 1),
                checkin: item.checkin || '0',
            };
        });
        console.log('Formatted data:', formattedData);

        // Clear the DataTable and add the formatted data
        table.clear().rows.add(formattedData).draw();
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            console.error('Response:', xhr.responseText);
        }
    });
})

function resep(noreg) {
    // ini untuk yg dulu

    // window.open(`<?php //echo base_url('farmasi/frmcdaftar/permintaan_obat/') ?>/${noreg}/PETUGAS`, '_blank');
    // ini untuk yg baru
    window.open(`<?= base_url('farmasi/frmcdaftar/permintaan_obat_petugas?no_register=') ?>${noreg}`, '_blank');
}

function telaah(noreg) {
    window.open(`<?= base_url('farmasi/Frmcdaftar/telaah_obat/') ?>/${noreg}`, '_blank');

}

function selesai(noreg) {
    $.ajax({
        dataType: "json",
        type: 'POST',
        url: `<?php echo site_url('farmasi/Frmcdaftar/selesai_resep/'); ?>${noreg}`,
        success: function(response) {
            if(response.code == 200){
                location.reload();
            }
           new  swal({
                    title: "Success",
                    text: "Berhasil Simpan Data",
                    type: "success",
                    showConfirmButton: true
                },
                function() {
                    $.ajax({
                        url: `<?php echo site_url('farmasi/Frmcdaftar/get_daftar_resep_pasien/'.date('Y-m-d')); ?>`,
                        success: function(response) {
                            // console.log(response);
                            var formattedData = response.map(function(item) {
                            return {
                                waktu_selesai_farmasi: item.waktu_selesai_farmasi || null,
                                waktu_masuk_farmasi: item.waktu_masuk_farmasi || null,
                                wkt_telaah_obat: item.wkt_telaah_obat || null,
                                no_register: item.no_register,
                                no_kartu: item.no_kartu || '-',
                                jml_resep: item.jml_resep || 0,
                                tgl_kunjungan: item.tgl_kunjungan,
                                no_sep: item.no_sep || '-',
                                no_cm: item.no_cm || '-',
                                nama: item.nama,
                                alamat: item.alamat || '-',
                                bed: item.bed || '-',
                                cara_bayar: item.cara_bayar,
                                tgl: item.tgl_kunjungan,
                                noantrian: item.noantrian || 1,
                                checkin: item.checkin || '0',
                            };
                        });

                        // Clear the DataTable and add the formatted data
                        table.clear().rows.add(formattedData).draw();
                        }
                    });
                });
        }
    });
}

// Fungsi untuk memainkan chime/ding sound seperti di bandara
function playAirportChime(volume = 1.0) {
    // Create audio context
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();

    // Create oscillator for the chime sound
    const oscillator1 = audioContext.createOscillator();
    const oscillator2 = audioContext.createOscillator();
    const gainNode = audioContext.createGain();

    // Connect the nodes
    oscillator1.connect(gainNode);
    oscillator2.connect(gainNode);
    gainNode.connect(audioContext.destination);

    // Set frequencies for two-tone chime (C and G notes)
    oscillator1.frequency.setValueAtTime(523.25, audioContext.currentTime); // C5
    oscillator2.frequency.setValueAtTime(783.99, audioContext.currentTime); // G5

    // Set volume
    gainNode.gain.setValueAtTime(volume * 0.3, audioContext.currentTime);

    // Create envelope for natural sound
    gainNode.gain.exponentialRampToValueAtTime(volume * 0.1, audioContext.currentTime + 0.1);
    gainNode.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 1.5);

    // Start and stop the oscillators
    oscillator1.start(audioContext.currentTime);
    oscillator2.start(audioContext.currentTime);
    oscillator1.stop(audioContext.currentTime + 1.5);
    oscillator2.stop(audioContext.currentTime + 1.5);

    return 1500; // Return duration in milliseconds
}

// Fungsi untuk mengatur suara Indonesia yang natural
function setIndonesianVoice(utterance) {
    const voices = speechSynthesis.getVoices();

    // Priority order for Indonesian voices
    const preferredVoices = [
        'id-ID', 'Indonesian', 'Bahasa Indonesia',
        'id_ID', 'id', 'Google Indonesian'
    ];

    let selectedVoice = null;

    // First try to find exact Indonesian voice
    for (const preferredName of preferredVoices) {
        selectedVoice = voices.find(voice =>
            voice.lang.toLowerCase().includes('id') ||
            voice.name.toLowerCase().includes(preferredName.toLowerCase())
        );
        if (selectedVoice) break;
    }

    // If no Indonesian voice, try to find a female voice (usually clearer)
    if (!selectedVoice) {
        selectedVoice = voices.find(voice =>
            voice.name.toLowerCase().includes('female') ||
            voice.name.toLowerCase().includes('woman')
        );
    }

    // Use default voice if available
    if (!selectedVoice && voices.length > 0) {
        selectedVoice = voices[0];
    }

    if (selectedVoice) {
        utterance.voice = selectedVoice;
        console.log('Selected voice:', selectedVoice.name, selectedVoice.lang);
    }
}

// Fungsi untuk konversi angka ke bahasa Indonesia
function convertNumberToIndonesian(numberString) {
    const number = parseInt(numberString);

    if (number === 0) return 'nol';
    if (number < 10) return ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'][number];
    if (number < 100) {
        const tens = Math.floor(number / 10);
        const ones = number % 10;
        const tensWord = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'][tens];
        if (number < 20) {
            const teens = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
            return teens[number - 10];
        }
        if (ones === 0) return tensWord;
        const onesWord = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'][ones];
        return `${tensWord} ${onesWord}`;
    }
    if (number < 1000) {
        const hundreds = Math.floor(number / 100);
        const remainder = number % 100;
        const hundredsWord = hundreds === 1 ? 'seratus' : `${convertNumberToIndonesian(hundreds.toString())} ratus`;
        if (remainder === 0) return hundredsWord;
        return `${hundredsWord} ${convertNumberToIndonesian(remainder.toString())}`;
    }

    // For numbers >= 1000, fall back to digit-by-digit
    return numberString.split('').map(digit => ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'][parseInt(digit)]).join(' ');
}

// Fungsi untuk Text-to-Speech announcement dengan aksen Indonesia yang natural
function playQueueAnnouncement(queueNumber, loket) {
    if ('speechSynthesis' in window) {
        // Get volume default to 100%
        const volumeLevel = 1.0;

        // Play airport chime first
        const chimeDuration = playAirportChime(volumeLevel);

        // Wait for chime to finish, then play announcement
        setTimeout(() => {
            // Split queue number for better pronunciation
            const queueParts = queueNumber.split('-');
            const letter = queueParts[0]; // F
            const number = queueParts[1]; // 001

            // Convert number to natural Indonesian pronunciation
            const numberWords = convertNumberToIndonesian(number);

            // Natural Indonesian announcement with airport-style intro
            const text = `Perhatian, nomor antrian ${letter} ${numberWords}, silakan menuju ke loket ${loket}.`;

            const utterance = new SpeechSynthesisUtterance(text);

            // Set Indonesian language and voice parameters
            utterance.lang = 'id-ID';
            utterance.rate = 0.8; // Slightly slower for clarity
            utterance.pitch = 1.0; // Standard pitch
            utterance.volume = volumeLevel;

            // Wait for voices to load and select best Indonesian voice
            if (speechSynthesis.getVoices().length === 0) {
                speechSynthesis.addEventListener('voiceschanged', function() {
                    setIndonesianVoice(utterance);
                    speechSynthesis.speak(utterance);
                }, {
                    once: true
                });
            } else {
                setIndonesianVoice(utterance);
                speechSynthesis.speak(utterance);
            }

            console.log(`Farmasi Announcement: "${text}"`);
        }, chimeDuration + 200); // Small pause after chime
    }
}

// Fungsi untuk memanggil antrian farmasi
function panggilAntrianFarmasi(no_register, no_antrian, nama_pasien) {
    if (confirm('Apakah Anda yakin ingin memanggil antrian ' + no_antrian + ' (' + nama_pasien + ')?')) {
        // Play announcement sound first
        playQueueAnnouncement(no_antrian, 'FARMASI');

        // Disable tombol panggil untuk mencegah double click
        const panggilBtn = $(`button[onclick*="panggilAntrianFarmasi('${no_register}"]`);
        panggilBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('antrol/panggil_antrian_farmasi'); ?>',
            data: {
                no_register: no_register,
                no_antrian: no_antrian,
                nama_pasien: nama_pasien
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success');

                    // Update tombol secara real-time tanpa refresh
                    updateTombolStatus(no_register, no_antrian, nama_pasien, 'dipanggil');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                    // Kembalikan tombol jika error
                    panggilBtn.prop('disabled', false).html('<i class="fa fa-volume-up"></i> Panggil');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', 'Terjadi kesalahan sistem: ' + error, 'error');
                // Kembalikan tombol jika error
                panggilBtn.prop('disabled', false).html('<i class="fa fa-volume-up"></i> Panggil');
            }
        });
    }
}

// Fungsi untuk update tombol status secara real-time
function updateTombolStatus(no_register, no_antrian, nama_pasien, status) {
    // Cari cell yang berisi tombol untuk no_register ini
    const targetCell = $(`td`).filter(function() {
        return $(this).html().includes(no_antrian) && $(this).html().includes('panggilAntrianFarmasi');
    });

    if (targetCell.length > 0) {
        let newButtonHtml = '';

        if (status === 'dipanggil') {
            // Status sudah dipanggil - tombol panggil aktif, tombol selesai aktif
            newButtonHtml = `
                <strong>${no_antrian}</strong><br>
                <button onclick="panggilAntrianFarmasi('${no_register}','${no_antrian}','${nama_pasien}')" class="btn btn-success btn-xs" title="Panggil Antrian">
                    <i class="fa fa-volume-up"></i> Panggil
                </button><br>
                <button onclick="selesaiAntrianFarmasi('${no_register}','${no_antrian}','${nama_pasien}')" class="btn btn-info btn-xs mt-1" title="Selesai Pelayanan">
                    <i class="fa fa-check"></i> Selesai
                </button>`;
        } else if (status === 'selesai') {
            // Status sudah selesai
            newButtonHtml = `<strong>${no_antrian}</strong><br><span class="btn btn-secondary btn-xs disabled">
                <i class="fa fa-check"></i> Selesai
            </span>`;
        }

        targetCell.html(newButtonHtml);
    }
}

// Fungsi untuk menyelesaikan antrian farmasi
function selesaiAntrianFarmasi(no_register, no_antrian, nama_pasien) {
    if (confirm('Apakah Anda yakin ingin menyelesaikan antrian ' + no_antrian + ' (' + nama_pasien + ')?')) {
        // Disable tombol selesai untuk mencegah double click
        const selesaiBtn = $(`button[onclick*="selesaiAntrianFarmasi('${no_register}"]`);
        selesaiBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('antrol/selesai_antrian_farmasi'); ?>',
            data: {
                no_register: no_register,
                no_antrian: no_antrian,
                nama_pasien: nama_pasien
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success');

                    // Update tombol secara real-time tanpa refresh
                    updateTombolStatus(no_register, no_antrian, nama_pasien, 'selesai');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                    // Kembalikan tombol jika error
                    selesaiBtn.prop('disabled', false).html('<i class="fa fa-check"></i> Selesai');
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', 'Terjadi kesalahan sistem: ' + error, 'error');
                // Kembalikan tombol jika error
                selesaiBtn.prop('disabled', false).html('<i class="fa fa-check"></i> Selesai');
            }
        });
    }
}

// Fungsi untuk membuka Dashboard Antrian Farmasi
function openDashboardAntrian() {
    window.open('<?php echo base_url('antrol/dashboard_antrian_farmasi'); ?>', '_blank');
}

// <button class="btn btn-primary btn-sm" onclick="selesai('${data.no_register}')">Selesai</button>
</script>
<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.dataTables1.13.min.js"></script>

<?php
	$this->load->view('layout/footer_left.php');
?>