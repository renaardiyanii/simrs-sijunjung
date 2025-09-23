<?php
    $this->load->view("layout/header_left");
?>
<script src="<?php echo base_url('assets/form/sweetalert2@11.js') ?>"></script>
    <!-- Font Awesome CSS -->
<style>
    
#notifications {
    cursor: pointer;
    position: fixed;
    right: 0px;
    z-index: 9999;
    top: 100px;
    margin-bottom: 22px;
    margin-right: 15px;
    max-width: 300px;
}
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: black;
    /* background-color: #fff; */
    /* border-color: #ddd #ddd #fff; */
    /* border-bottom-color: rgb(255, 255, 255); */
    border-bottom: 3px solid black !important;
    background-color: transparent;
}

.nav-tabs .nav-link {
    border: none !important;
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
    border: 1px solid #ccc;
    /* Add a border for visual separation */
}

/* Style for the input field */
.form-control {
    min-height:22px;
    /* border: none; */
    /* Remove the input field border */
}
.borderless{
    border: none!important;

}

/* Style for the icon */
.input-group-text i.mdi.mdi-calendar {
    font-size: 10px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

/* .dataTables_filter {
    display: none;
} */

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

.ui-autocomplete {
    z-index: 1000;
}

.modal_list_rujukan{
    z-index:1050 !important;
}
.modal_buat_sep_irj{
    z-index:1049 !important;
}
</style>
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h2>Daftar Antrean Online BPJS</h2>
            <!-- <button class="btn btn-primary mt-2 mb-2" onclick="tambah_antrean_onsite()">Tambah Antrean Onsite</button> -->
        </div>
        <hr>
    </div>
    <div class="body p-4">
        <!-- 
            Pasien baru & Pasien Lama
         -->
         <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="irj-tab" data-toggle="tab" href="#irj" role="tab" aria-controls="irj"
                    aria-selected="true">Antrian Admisi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="igd-tab" data-toggle="tab" href="#igd" role="tab"
                    aria-controls="igd-tab" aria-selected="true">Antrian Poli</a>
            </li>
        </ul>

        <div class="tab-content mt-4" id="myTabContent">
            <div class="tab-pane fade show active" id="irj" role="tabpanel" aria-labelledby="irj-tab">
                <!-- Pengaturan Loket Default -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="defaultLoketSelect" class="font-weight-bold">Loket Default:</label>
                            <select class="form-control" id="defaultLoketSelect">
                                <option value="">-- Pilih Loket Default --</option>
                                <option value="1">Loket 1</option>
                                <option value="2">Loket 2</option>
                                <option value="3">Loket 3</option>
                                <option value="4">Loket 4</option>
                                <option value="5">Loket 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Status Suara:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableSound">
                                <label class="form-check-label" for="enableSound">
                                    Aktifkan Suara Pemanggilan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="volumeQuickControl" class="font-weight-bold">Volume:</label>
                            <input type="range" class="form-control-range" id="volumeQuickControl" min="0" max="100" value="80">
                            <small class="text-muted">Volume: <span id="volumeQuickDisplay">80%</span></small>
                        </div>
                    </div>
                </div>

                <!-- Tombol Reset Settings -->
                <div class="row mb-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="resetSettingsBtn">
                            <i class="fas fa-undo"></i> Reset Pengaturan
                        </button>
                        <span class="ml-3 text-muted">
                            <i class="fas fa-info-circle"></i>
                            <span id="settingsStatus">Settings disimpan otomatis</span>
                        </span>
                    </div>
                </div>

                <table id="table-datatablespasienbaru" class="table table-bordered " style="width:100%">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Nomor Antrian</th>
                        </tr>
                    </thead>
                    <tbody id="data-bodypasienbaru">
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="igd" role="tabpanel" aria-labelledby="igd-tab">
                <div class="row mb-4">
                    <div class="col">
                        <label for="tanggalpertama">Tanggal Awal</label>
                        <input type="date" id="tanggalpertama" class="form-control" onchange="handle()">
                    </div>
                    <div class="col">
                        <label for="tanggalkedua" >Tanggal Akhir</label>
                        <input type="date" id="tanggalkedua" class="form-control" onchange="handle()">
                    </div>
                </div>
                <div class="mb-4">
                    <table id="table-datatables" class="table table-bordered " style="width:100%">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Kode Booking</th>
                                <th>Tanggal Periksa</th>
                                <th>Angka Antrean   </th>
                                <th>Nama</th>
                                <th>No. RM</th>
                                <th>Poliklinik</th>
                                <th>Dokter</th>
                            </tr>
                        </thead>
                        <tbody id="data-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pemilihan Loket -->
<div class="modal fade" id="loketModal" tabindex="-1" role="dialog" aria-labelledby="loketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="loketModalLabel">
                    <i class="fas fa-microphone"></i> Panggil Antrian
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h4 class="text-primary" id="queueNumberDisplay">Nomor Antrian: -</h4>
                </div>

                <div class="form-group">
                    <label for="loketSelect" class="font-weight-bold">Pilih Loket:</label>
                    <select class="form-control" id="loketSelect" required>
                        <option value="">-- Pilih Loket --</option>
                        <option value="1">Loket 1</option>
                        <option value="2">Loket 2</option>
                        <option value="3">Loket 3</option>
                        <option value="4">Loket 4</option>
                        <option value="5">Loket 5</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="volumeControl" class="font-weight-bold">Volume Pengumuman:</label>
                    <div class="d-flex align-items-center">
                        <input type="range" class="form-control-range flex-grow-1" id="volumeControl" min="0" max="100" value="80">
                        <span class="ml-3 font-weight-bold" id="volumeDisplay">80%</span>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-info" id="testVoiceButton">
                        <i class="fas fa-volume-up"></i> Test Suara
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-success" id="confirmCallButton">
                    <i class="fas fa-microphone"></i> Panggil Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-datatablenew.js"></script>
<script>
    
function tambah_antrean_onsite()
{
    location.href=`${baseurl}antrol/onsite`;
}

function batalantrian(data)
{
    let base64 = btoa(JSON.stringify(data));
    $.ajax({
        url: `${baseurl}/antrol/batalantrean?patient=${base64}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            Swal.fire({
                title: response.metadata.code === 200?"Berhasil!":'Gagal',
                text: response.metadata.message,
                icon: response.metadata.code === 200?"success":'error'
            });
        },
        error:function(xhr, status, error) {
            Swal.fire({
                title: 'Gagal',
                text: 'Hubungi tim it',
                icon:'error'
            });
        }
    });
}


function lihattaskid(data)
{
    let base64 = btoa(JSON.stringify(data));
    $.ajax({
        url: `${baseurl}/antrol/taskid?patient=${base64}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Check if the response has the expected structure
            if (response && response.response) {
                // Create the modal
                let modalContent = '<div class="modal" id="modalnyataskid" tabindex="-1" role="dialog">';
                modalContent += '<div class="modal-dialog modal-lg" role="document">';
                modalContent += '<div class="modal-content">';
                modalContent += '<div class="modal-header">';
                modalContent += '<h5 class="modal-title">Task Information</h5>';
                modalContent += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                modalContent += '<span aria-hidden="true">&times;</span>';
                modalContent += '</button>';
                modalContent += '</div>';
                modalContent += '<div class="modal-body">';
                
                // Create and populate the table
                modalContent += '<table class="table">';
                modalContent += '<thead>';
                modalContent += '<tr>';
                modalContent += '<th>Task ID</th>';
                modalContent += '<th>Task Name</th>';
                modalContent += '<th>Kode Booking</th>';
                modalContent += '<th>Waktu RS</th>';
                modalContent += '<th>Waktu</th>';
                modalContent += '</tr>';
                modalContent += '</thead>';
                modalContent += '<tbody>';
                
                // Populate the table rows with data
                response.response.forEach(function (task) {
                    modalContent += '<tr>';
                    modalContent += '<td>' + task.taskid + '</td>';
                    modalContent += '<td>' + task.taskname + '</td>';
                    modalContent += '<td>' + task.kodebooking + '</td>';
                    modalContent += '<td>' + task.wakturs + '</td>';
                    modalContent += '<td>' + task.waktu + '</td>';
                    modalContent += '</tr>';
                });
                
                modalContent += '</tbody>';
                modalContent += '</table>';
                
                // Close the modal
                modalContent += '</div>';
                modalContent += '<div class="modal-footer">';
                modalContent += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                modalContent += '</div>';
                modalContent += '</div>';
                modalContent += '</div>';
                modalContent += '</div>';
                
                // Append the modal to the body
                $('body').append(modalContent);
                
                // Show the modal
                $('#modalnyataskid').modal('show');
            }
        },
        error:function(xhr, status, error) {
            
        }
    });
}
function panggil(data)
{
    let base64 = btoa(JSON.stringify(data));
    $.ajax({
                url: `${baseurl}/antrol/panggil?data=${base64}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // var utterance = new SpeechSynthesisUtterance('ANTRIAN NOMOR SATU ATAS NAMA ALDI HADISTIAN SILAHKAN KE LOKET');

                    // Optional: Set voice properties (e.g., gender, language)
                    // Uncomment and modify as needed
                    // utterance.voice = speechSynthesis.getVoices().find(voice => voice.name === 'Your Desired Voice');

                    // Speak the text
                    // utterance.lang = 'id-ID';
                    // window.speechSynthesis.speak(utterance);
                    // console.log(response);
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data Nomor Antrian Berhasil Dipanggil",
                        icon: "success"
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error if needed
                    console.error('Error:', status, error);
                }
            });
}

function prosesantrian(data)
{
    // posisi disini jika pasien baru data.flag / task id = 1 ( check in = 1 , dipanggil = 2, selesai = 3)
    // disini filter jika pasien merupakan pasien baru maka update task id 2 ( proses / panggil pasien )
    if(data.pasienbaru === '1'){
        // kemudian redirect ke daftar pasien baru tapi dengan versi data dari antrol
        let base64 = btoa(JSON.stringify(data));
        window.location.href = '<?php echo base_url('irj/rjcregistrasi/regpasien') ?>?patient='+base64
        // kemudian setelah selesai daftar pasien baru, daftar ulang buat sep
        // update task id jadi 3 ( selesai pelayanan )
        
    }else{
        // mengecek terlebih dahulu apakah task id nya tersebut dimulai 1 ? jika ya maka update ke 2 dulu
        // console.table(data);
        // return;
        let base64 = btoa(JSON.stringify(data));
        window.location.href = '<?php echo base_url('irj/rjcregistrasi/daftarulangnew/') ?>'+data.norm+'?reservasi='+base64
        // jika pasien merupakan pasien lama maka posisi data.flag == null (check in = null, dipanggil = null, selesai = 3)
        // kemudian redirect ke daftar ulang buat sep versi antrol
        // update task id jadi 3 ( selesai pelayanan )
    }
    // setelah itu di poli perawat meriksa, langsung update task id ke 4
    // setelah itu di poli dokter meriksa,langsung update task id ke 5
    // setelah itu di farmasi klik resep, langsung update task id ke 6
    // setelah itu penyerahan obat klik serahkan , langsung update task id ke 7
}

function kirimwsbpjs(data)
{
    // console.log(data);
    let base64 = btoa(JSON.stringify(data));
    $.ajax({
        url: `${baseurl}/antrol/kirimwsbpjs?data=${base64}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // coonsole.log(response);
            // var utterance = new SpeechSynthesisUtterance('ANTRIAN NOMOR SATU ATAS NAMA ALDI HADISTIAN SILAHKAN KE LOKET');

            // Optional: Set voice properties (e.g., gender, language)
            // Uncomment and modify as needed
            // utterance.voice = speechSynthesis.getVoices().find(voice => voice.name === 'Your Desired Voice');

            // Speak the text
            // utterance.lang = 'id-ID';
            // window.speechSynthesis.speak(utterance);
            // console.log(response);
            // if(response.metadata.code == 200){
                if(response.metadata.code !== 200 && response.metadata.message === 'data nomorreferensi  belum sesuai.'){
                    // $('#modalnya').modal('show');
                    // return;
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Silahkan Buat Surat Kontrol Terlebih Dahulu!',
                        icon: 'error'
                    });    
                    return;
                }
                Swal.fire({
                    title: response.metadata.code == 200?"Berhasil!":'Gagal',
                    text: response.metadata.message,
                    icon: response.metadata.code == 200?"success":'Gagal'
                });
            // }
        },
        error: function(xhr, status, error) {
            // Handle error if needed
            console.error('Error:', status, error);
        }
    });
}


function makebadge(flag)
    {
        var badge = '';
        if(flag != null){
            flag = flag.trim()
        }
        switch(flag){
            case '1':
                badge =`<span class="badge badge-primary">Waktu Tunggu Admisi</span>`;
                break;
            case '2':
                badge =`<span class="badge badge-primary">Mulai Waktu Layan Admisi</span>`;
                break;
            case '3':
                badge =`<span class="badge badge-primary">Mulai Waktu Tunggu poli</span>`;
                break;
            case '4':
                badge =`<span class="badge badge-primary">Mulai Waktu Layan Poli</span>`;
                break;
            case '5':
                badge =`<span class="badge badge-primary">Mulai Waktu Tunggu Farmasi</span>`;
                break;
            case '6':
                badge =`<span class="badge badge-primary">Farmasi Membuat Obat</span>`;
                break;
            case '7':
                badge =`<span class="badge badge-primary">Farmasi Selesai</span>`;
                break;
            case '99':
                badge =`<span class="badge badge-danger">Pasien Batal</span>`;
                break;
            case null:
                badge =`<span class="badge badge-primary">Belum Checkin</span>`;
                break;
        }
        return badge;
    }

    function handle(){
        var tanggalpertama = $('#tanggalpertama').val();
        var tanggalkedua = $('#tanggalkedua').val()
        if(tanggalpertama !== '' && tanggalkedua !== ''){
            $.ajax({
                url: `${baseurl}/antrol?tanggalpertama=${tanggalpertama}&tanggalkedua=${tanggalkedua}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.metadata.code === 200) {
                        $('#table-datatables').DataTable().destroy();
                        // Data retrieval successful, populate the table
                        var dataList = response.response;
                        var tbody = $('#data-body');
    
                        // Clear existing rows in the table body
                        tbody.empty();
    
                        $.each(dataList, function(index, data) {
                            var badge = makebadge(data.flag);
                        
                            var row = '<tr>' +
                                // '<td><button onclick=\'cetaksep(\''+data.kodebooking + '\')\' class="btn btn-primary">Cetak Sep</button>' + 
                                "<td><button onclick=cetaksep('"+data.kodebooking + "') class=\"btn btn-primary\">Cetak Sep</button>" + 
                                
                                // '<td><button onclick=\'prosesantrian('+JSON.stringify(data)+')\' class="btn btn-primary">Proses Antrian</button>'+
                                '<br><button onclick=\'batalantrian('+JSON.stringify(data)+')\' class="btn btn-danger">Batal Antrian</button>'+
                                '<br><button onclick=\'lihattaskid('+JSON.stringify(data)+')\' class="btn btn-info btn-xs">Lihat List Task Id</button>'+
                                '<br><button onclick=\'panggil('+JSON.stringify(data)+')\' class="btn btn-info btn-xs">Panggil</button>'
                                // '<br><button onclick=\'kirimwsbpjs('+JSON.stringify(data)+')\' class="btn btn-info btn-xs">Kirim WS BPJS</button>'+
                                // (data.hitws === '1'?'':'<br><button onclick=\'kirimwsbpjs('+JSON.stringify(data)+')\' class="btn btn-info btn-xs">Kirim WS BPJS</button>'
                                // )
                                +
                                '</td>' +
                                
                                '<td>' + data.kodebooking+ '</td>' +
                                '<td>' + data.tanggalperiksa+'&nbsp;&nbsp;&nbsp;&nbsp;'+ badge + '</td>' +
                                '<td>' + data.angkaantrean+'&nbsp;&nbsp;&nbsp;&nbsp;'+ badge + '</td>' +
                                '<td>' + data.nama + '</td>' +
                                '<td>' + data.norm + '</td>' +
                                '<td>' + data.namapoli + '</td>' +
                                '<td>' + data.namadokter + '</td>' +
                                '</tr>';
                            tbody.append(row);
                        });
    
                        // Initialize DataTables
                        $('#table-datatables').DataTable({
                            "width": "100%"
                        });
                    } else {
                        // Handle error if needed
                        console.error('Error:', response.metadata.message);
                        $('#data-body').empty();
                        $('#data-body').append('<tr><td style="text-align:center" colspan="5">Data Kosong</td></tr>')
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error if needed
                    console.error('Error:', status, error);
                }
            });
        }

    }

    function getpasienbaru() {
        $.ajax({
            url: `http://localhost:8000/adminantrian/v2/getantrianadmisi`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.metadata.code === 200) {
                    // Data retrieval successful, populate the table
                    var dataList = response.response;
                    var tbody = $('#data-bodypasienbaru');
                    tbody.empty(); // Clear existing rows

                    // Loop through the data and append rows to the table
                    $.each(dataList, function(index, data) {
                        var row = $(`
                            <tr>
                                <td>
                                    <button class="btn btn-warning mt-2 btn-panggil-antrian" data-antrian='${JSON.stringify(data)}'>
                                        <i class="fas fa-microphone"></i> Panggil Antrian
                                    </button>
                                    <br>

                                    <a href="<?= base_url('irj/rjcregistrasi/regpasienantrol?id=') ?>${data.id}&loket=${<?= $loket ?>}" class="btn btn-primary mt-2">
                                        <i class="fas fa-user-plus"></i> Proses Antrian
                                    </a>

                                    <br>
                                    <button class="btn btn-danger mt-2 btn-batal-antrian" data-antrian='${JSON.stringify(data)}'>
                                        <i class="fas fa-times"></i> Batal Antrian
                                    </button>

                                </td>
                                <td>A-${String(data.no_antrian).padStart(3, '0')}</td>
                            </tr>`);
                        tbody.append(row);
                    });

                    $('#table-datatablespasienbaru').DataTable();
                } else {
                    console.error('Error:', response.metadata.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        });
    }

    // Global variable untuk menyimpan data antrian yang akan dipanggil
    let currentQueueData = null;

    // Fungsi untuk load settings dari localStorage
    function loadSettings() {
        const defaultLoket = localStorage.getItem('defaultLoket') || '';
        const enableSound = localStorage.getItem('enableSound') === 'true'; // Default OFF
        const volume = localStorage.getItem('volume') || '80';

        $('#defaultLoketSelect').val(defaultLoket);
        $('#enableSound').prop('checked', enableSound);
        $('#volumeQuickControl').val(volume);
        $('#volumeQuickDisplay').text(volume + '%');
        $('#volumeControl').val(volume);
        $('#volumeDisplay').text(volume + '%');
    }

    // Fungsi untuk save settings ke localStorage
    function saveSettings() {
        const defaultLoket = $('#defaultLoketSelect').val();
        const enableSound = $('#enableSound').is(':checked');
        const volume = $('#volumeQuickControl').val();

        localStorage.setItem('defaultLoket', defaultLoket);
        localStorage.setItem('enableSound', enableSound);
        localStorage.setItem('volume', volume);

        // Update status indicator
        $('#settingsStatus').text('Settings tersimpan');
        setTimeout(() => {
            $('#settingsStatus').text('Settings disimpan otomatis');
        }, 2000);
    }

    // Fungsi untuk reset settings
    function resetSettings() {
        localStorage.removeItem('defaultLoket');
        localStorage.removeItem('enableSound');
        localStorage.removeItem('volume');

        // Reset ke default values
        $('#defaultLoketSelect').val('');
        $('#enableSound').prop('checked', false); // Default suara OFF
        $('#volumeQuickControl').val('80');
        $('#volumeQuickDisplay').text('80%');
        $('#volumeControl').val('80');
        $('#volumeDisplay').text('80%');

        $('#settingsStatus').text('Settings direset');
        setTimeout(() => {
            $('#settingsStatus').text('Settings disimpan otomatis');
        }, 2000);
    }

    // Fungsi untuk panggil antrian langsung (tanpa modal jika ada loket default)
    function callQueueDirect(data) {
        console.log('callQueueDirect called with data:', data);
        const defaultLoket = $('#defaultLoketSelect').val();

        if (defaultLoket) {
            // Langsung panggil dengan loket default
            panggilantrian(data, defaultLoket);

            // Play announcement jika suara aktif
            const enableSound = $('#enableSound').is(':checked');
            if (enableSound) {
                const queueNumber = `A-${String(data.no_antrian).padStart(3, '0')}`;
                playQueueAnnouncement(queueNumber, defaultLoket);
            }
        } else {
            // Tampilkan modal jika belum ada loket default
            showLoketModal(data);
        }
    }

    // Fungsi untuk menampilkan modal pemilihan loket
    function showLoketModal(data) {
        console.log('showLoketModal called with data:', data);
        try {
            currentQueueData = data;
            const queueNumber = `A-${String(data.no_antrian).padStart(3, '0')}`;
            console.log('Queue number formatted:', queueNumber);

            $('#queueNumberDisplay').text(`Nomor Antrian: ${queueNumber}`);
            $('#loketSelect').val(localStorage.getItem('defaultLoket') || '');
            $('#loketModal').modal('show');
            console.log('Modal should be visible now');
        } catch (error) {
            console.error('Error in showLoketModal:', error);
            alert('Error: ' + error.message);
        }
    }

    // Fungsi untuk memanggil antrian dengan loket
    function panggilantrian(data, loket) {
        const queueNumber = `A-${String(data.no_antrian).padStart(3, '0')}`;

        // Kirim request ke backend untuk update data dengan loket
        $.ajax({
            url: `<?= base_url('antrol/panggilantrianadmisi') ?>`,
            type: 'POST',
            dataType: 'json',
            data: {
                id: data.id,
                loket: loket,
                no_antrian: data.no_antrian
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        title: "Berhasil!",
                        text: `Antrian ${queueNumber} telah dipanggil ke Loket ${loket}`,
                        icon: "success",
                        timer: 3000
                    });

                    // Refresh data
                    getpasienbaru();
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: response.message || "Terjadi kesalahan saat memanggil antrian",
                        icon: "error"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error calling queue:', error);
                Swal.fire({
                    title: "Error!",
                    text: "Terjadi kesalahan koneksi",
                    icon: "error"
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

    // Fungsi untuk Text-to-Speech announcement dengan aksen Indonesia yang natural
    function playQueueAnnouncement(queueNumber, loket) {
        if ('speechSynthesis' in window) {
            // Get volume from modal control, default to 100% if not set
            const volumeLevel = $('#volumeControl').length ? $('#volumeControl').val() / 100 : 1.0;

            // Play airport chime first
            const chimeDuration = playAirportChime(volumeLevel);

            // Wait for chime to finish, then play announcement
            setTimeout(() => {
                // Split queue number for better pronunciation
                const queueParts = queueNumber.split('-');
                const letter = queueParts[0]; // A
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

                console.log(`Airport Announcement: "${text}"`);
            }, chimeDuration + 200); // Small pause after chime

        } else {
            console.warn('Speech synthesis not supported');
        }
    }

    // Helper function to set Indonesian voice
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
            console.log(`Using voice: ${selectedVoice.name} (${selectedVoice.lang})`);
        }
    }

    // Convert number to natural Indonesian words
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


    function cetaksep(kodebooking) {
        Swal.fire({
            title: "Apakah Anda ingin cetak sep?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "OK",
            cancelButtonText: "Batal"
        }).then((confirmResult) => {
            if (confirmResult.isConfirmed) {
                $.ajax({
				url: `<?php echo base_url('bpjs/sep/get_noregister_booking') ?>/` + kodebooking,
				beforeSend: function() {

				},
				success: function(data) {
                    // console.log(data);
                    if(!data){
                        new swal("Gagal", "Silahkan Registrasi Ulang", "error");
                        return;
                    }
                    if(data.no_sep !==''){
                        window.open('<?php echo base_url() . 'bpjs/sep/cetakan_sep/'; ?>' + data.no_register, '_blank');
                        return;
                    }

                    var noreg = data.no_register;
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

    
    $(document).ready(function(){
        // Load settings dari localStorage
        loadSettings();

        getpasienbaru();

        // Event handler untuk tombol konfirmasi panggil antrian
        $('#confirmCallButton').click(function() {
            const selectedLoket = $('#loketSelect').val();

            if (!selectedLoket) {
                Swal.fire({
                    title: "Peringatan!",
                    text: "Silahkan pilih loket terlebih dahulu",
                    icon: "warning"
                });
                return;
            }

            if (!currentQueueData) {
                Swal.fire({
                    title: "Error!",
                    text: "Data antrian tidak ditemukan",
                    icon: "error"
                });
                return;
            }

            // Update default loket jika belum ada
            if (!$('#defaultLoketSelect').val()) {
                $('#defaultLoketSelect').val(selectedLoket);
                saveSettings();
            }

            // Tutup modal
            $('#loketModal').modal('hide');

            // Panggil antrian dengan loket yang dipilih
            panggilantrian(currentQueueData, selectedLoket);

            // Play announcement jika suara aktif
            const enableSound = $('#enableSound').is(':checked');
            if (enableSound) {
                const queueNumber = `A-${String(currentQueueData.no_antrian).padStart(3, '0')}`;
                playQueueAnnouncement(queueNumber, selectedLoket);
            }
        });

        // Reset modal ketika ditutup
        $('#loketModal').on('hidden.bs.modal', function() {
            currentQueueData = null;
            $('#loketSelect').val('');
            $('#queueNumberDisplay').text('');
        });

        // Event handlers untuk tombol dinamis menggunakan delegation
        $(document).on('click', '.btn-panggil-antrian', function() {
            try {
                const dataStr = $(this).attr('data-antrian');
                const data = JSON.parse(dataStr);
                console.log('Button clicked, data:', data);
                callQueueDirect(data); // Gunakan fungsi baru
            } catch (error) {
                console.error('Error parsing button data:', error);
                alert('Error: Gagal memuat data antrian');
            }
        });

        $(document).on('click', '.btn-batal-antrian', function() {
            try {
                const dataStr = $(this).attr('data-antrian');
                const data = JSON.parse(dataStr);
                console.log('Batal button clicked, data:', data);
                batalantrian(data);
            } catch (error) {
                console.error('Error parsing button data:', error);
                alert('Error: Gagal memuat data antrian');
            }
        });

        // Event handlers untuk settings
        $('#defaultLoketSelect').on('change', function() {
            saveSettings();
        });

        $('#enableSound').on('change', function() {
            saveSettings();
        });

        $('#volumeQuickControl').on('input', function() {
            const volume = $(this).val();
            $('#volumeQuickDisplay').text(`${volume}%`);
            $('#volumeControl').val(volume);
            $('#volumeDisplay').text(`${volume}%`);
            saveSettings();
        });

        // Event handler untuk reset settings
        $('#resetSettingsBtn').on('click', function() {
            Swal.fire({
                title: 'Reset Pengaturan?',
                text: 'Semua pengaturan akan dikembalikan ke default',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    resetSettings();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Pengaturan telah direset',
                        icon: 'success',
                        timer: 1500
                    });
                }
            });
        });

        // Volume control handler
        $('#volumeControl').on('input', function() {
            const volume = $(this).val();
            $('#volumeDisplay').text(`${volume}%`);
            $('#volumeQuickControl').val(volume);
            $('#volumeQuickDisplay').text(`${volume}%`);
            saveSettings();
        });

        // Test voice button handler
        $('#testVoiceButton').click(function() {
            const volume = $('#volumeControl').val() / 100;

            if ('speechSynthesis' in window) {
                // Stop any ongoing speech
                speechSynthesis.cancel();

                // Visual feedback
                $(this).html('<i class="fas fa-spinner fa-spin"></i> Testing...');

                // Play chime first
                const chimeDuration = playAirportChime(volume);

                // Then play test announcement
                setTimeout(() => {
                    const testText = 'Perhatian, nomor antrian A satu, silakan menuju ke loket satu. Terima kasih.';
                    const utterance = new SpeechSynthesisUtterance(testText);
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.8; // sesuai dengan pemanggilan asli
                    utterance.pitch = 1.0;
                    utterance.volume = volume;

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
                }, chimeDuration + 200);

                // Reset button after total duration
                setTimeout(() => {
                    $(this).html('<i class="fas fa-volume-up"></i> Test Suara');
                }, chimeDuration + 4000); // chime + speech duration
            } else {
                alert('Browser tidak mendukung text-to-speech');
            }
        });


        var tanggalpertama = '<?= date('Y-m-d') ?>';
        var tanggalkedua = '<?= date('Y-m-d') ?>';
        // Make AJAX request to the API
        $.ajax({
            url: `${baseurl}/antrol?tanggalpertama=${tanggalpertama}&tanggalkedua=${tanggalkedua}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {

                if (response.metadata.code === 200) {
                    // Data retrieval successful, populate the table
                    var dataList = response.response;
                    var tbody = $('#data-body');

                    // Loop through the data and append rows to the table
                    $.each(dataList, function(index, data) {
                        var badge = makebadge(data.flag);
                        
                        var row = '<tr>' +
                        // '<td><button onclick=\'prosesantrian('+JSON.stringify(data)+')\' class="btn btn-primary">Proses Antrian</button>'+
                            "<td><button onclick=cetaksep('"+data.kodebooking + "') class=\"btn btn-primary\">Cetak Sep</button>" + 
                            '<br><button onclick=\'batalantrian('+JSON.stringify(data)+')\' class="btn btn-danger">Batal Antrian</button>'+
                            '<br><button onclick=\'lihattaskid('+JSON.stringify(data)+')\' class="btn btn-info btn-xs">Lihat List Task Id</button>'+
                            '<br><button onclick=\'panggil('+JSON.stringify(data)+')\' class="btn btn-info btn-xs">Panggil</button>'
                            // (data.hitws === '1'?'':'<br><button onclick=\'kirimwsbpjs('+JSON.stringify(data)+')\' class="btn btn-info btn-xs">Kirim WS BPJS</button>'
                            // )
                            +
                            '</td>' +
                            
                            '<td>' + data.kodebooking+ '</td>' +
                            
                            '<td>' + data.tanggalperiksa+'&nbsp;&nbsp;&nbsp;&nbsp;'+ badge + '</td>' +
                            '<td>' + data.angkaantrean+'&nbsp;&nbsp;&nbsp;&nbsp;'+ badge + '</td>' +
                            '<td>' + data.nama + '</td>' +
                            '<td>' + data.norm + '</td>' +
                            '<td>' + data.namapoli + '</td>' +
                            '<td>' + data.namadokter + '</td>' +
                            '</tr>';
                        tbody.append(row);
                    });
                    $('#table-datatables').DataTable();
                } else {
                    // Handle error if needed
                    console.error('Error:', response.metadata.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle error if needed
                console.error('Error:', status, error);
            }
        });
    });
</script>
<?php
    $this->load->view("layout/footer_left");
?>
