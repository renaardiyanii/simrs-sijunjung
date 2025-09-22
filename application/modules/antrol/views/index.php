<?php
    $this->load->view("layout/header_left");
?>
<script src="<?php echo base_url('assets/form/sweetalert2@11.js') ?>"></script>
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
                        var row = `
                            <tr>
                                <td>
                                    <button onclick='panggilantrian(${JSON.stringify(data)})' class="btn btn-warning mt-2">
                                        Panggil Antrian
                                    </button>
                                    <br>

                                    <a href="<?= base_url('irj/rjcregistrasi/regpasienantrol?id=') ?>${data.id}&loket=${<?=$loket?>}" class="btn btn-primary">
                                        Proses Antrian
                                    </a>
                                    
                                    <br>
                                    <button onclick='batalantrian(${JSON.stringify(data)})' class="btn btn-danger mt-2">
                                        Batal Antrian
                                    </button>
                                    
                                </td>
                                <td>A-${String(data.no_antrian).padStart(3, '0')}</td>
                            </tr>`;
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

    // Fungsi untuk memanggil antrian
    function panggilantrian(data) {
        // Contoh logika pemanggilan
        alert(`Memanggil Antrian: A-${String(data.no_antrian).padStart(3, '0')}`);
        $.ajax({
            url: `<?= base_url('irj/rjcregistrasi/panggilantrianadmisi?id=') ?>${data.id}&loket=${<?=$loket?>}`,
            type: 'GET',
            dataType: 'json',
        });
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
        getpasienbaru();
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
