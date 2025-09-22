<?php
    $this->load->view("layout/header_left");
?>

<div class="card ">
    <div class="card-header">
        <h2>Jadwal Dokter</h2>
        <hr>
    </div>
    <div class="body p-4">
        <div class="row mb-4">
            <div class="col">
                <label for="poli">Poliklinik</label>
                <select id="poli" class="form-control" onchange="handle()">
                    <option value="">--Silahkan Pilih Poliklinik--</option>
                    <?php
                    foreach($poli as $v){
                        echo '<option value="'.$v->poli_bpjs.'">'.$v->nm_poli.'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <label for="tanggal" >Tanggal</label>
                <input type="date" id="tanggal" class="form-control" onchange="handle()">
            </div>
        </div>
        <table id="table-datatables" class="table table-bordered ">
            <thead>
                <tr>
                    <th>Nama Poli</th>
                    <th>Nama Subspesialis</th>
                    <th>Kode Subspesialis</th>
                    <th>Kode Poli</th>
                    <th>Nama Dokter</th>
                    <th>Hari</th>
                    <th>Kapasitas Pasien</th>
                    <th>Libur</th>
                    <th>Nama Hari</th>
                    <th>Jadwal</th>
                </tr>
            </thead>
            <tbody id="data-body">
            </tbody>
        </table>
    </div>
</div>
<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-datatablenew.js"></script>
<script>
    $(document).ready(function(){
        $("#poli").select2();
        $('#table-datatables').DataTable({
            "width": "100%"
        });
    });
    
    function handle(){
        var kodepoli = $('#poli').val();
        var tanggal = $('#tanggal').val();
        if(kodepoli !== '' && tanggal !== ''){
            $.ajax({
                url: `${baseurl}/antrol/jadwaldokter?hit=1&kodepoli=${kodepoli}&tanggal=${tanggal}`,
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
    
                        // Loop through the data and append rows to the table
                        $.each(dataList, function(index, data) {
                            var row = '<tr>' +
                                '<td>' + data.namapoli + '</td>' +
                                '<td>' + data.namasubspesialis + '</td>' +
                                '<td>' + data.kodesubspesialis + '</td>' +
                                '<td>' + data.kodepoli + '</td>' +
                                '<td>' + data.namadokter + '</td>' +
                                '<td>' + data.hari + '</td>' +
                                '<td>' + data.kapasitaspasien + '</td>' +
                                '<td>' + data.libur + '</td>' +
                                '<td>' + data.namahari + '</td>' +
                                '<td>' + data.jadwal + '</td>' +
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
                        $('#data-body').append('<tr><td style="text-align:center" colspan="10">Data Kosong</td></tr>')
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error if needed
                    console.error('Error:', status, error);
                }
            });
        }

    }
</script>
<?php
    $this->load->view("layout/footer_left");
?>
