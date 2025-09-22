<?php
    $this->load->view("layout/header_left");
?>

<div class="card">
    <div class="card-header">
        <h2>Dashboard Per Tanggal</h2>
        <hr>
    </div>
    <div class="body p-4">
        <div class="row mb-4">
            <div class="col">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" class="form-control" onchange="handle()">
            </div>
            <div class="col">
                <label for="waktu">Waktu</label>
                <select id="waktu" class="form-control" onchange="handle()">
                    <option value="rs">Waktu RS</option>
                    <option value="server">Waktu Server</option>
                </select>
            </div>
        </div>
        <table id="table-datatables" class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>KDPPK</th>
                    <th>Waktu Task1</th>
                    <th>Avg Waktu Task4</th>
                    <th>Jumlah Antrean</th>
                    <th>Avg Waktu Task3</th>
                    <th>Nama Poli</th>
                    <th>Avg Waktu Task6</th>
                    <th>Avg Waktu Task5</th>
                    <th>NMPPK</th>
                    <th>Avg Waktu Task2</th>
                    <th>Avg Waktu Task1</th>
                    <th>Kode Poli</th>
                    <th>Waktu Task5</th>
                    <th>Waktu Task4</th>
                    <th>Waktu Task3</th>
                    <th>Insert Date</th>
                    <th>Tanggal</th>
                    <th>Waktu Task2</th>
                    <th>Waktu Task6</th>
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
    $(document).ready(function () {
        // Initialize Select2 and DataTables
        $("#poli").select2();
        $('#table-datatables').DataTable({
            "width": "100%"
        });
    });

    function handle() {
        var tanggal = $('#tanggal').val();
        var waktu = $('#waktu').val();

        // Check if both tanggal and waktu are provided
        if (tanggal !== '' && waktu !== '') {
            $.ajax({
                url: `${baseurl}/antrol/dashboard?tanggal=${tanggal}&waktu=${waktu}`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.metadata.code === 200) {
                        $('#table-datatables').DataTable().destroy();
                        var dataList = response.response.list;
                        var tbody = $('#data-body');

                        // Clear existing rows in the table body
                        tbody.empty();

                        // Loop through the data and append rows to the table
                        $.each(dataList, function (index, data) {
                            var row = '<tr>' +
                                '<td>' + data.kdppk + '</td>' +
                                '<td>' + data.waktu_task1 + '</td>' +
                                '<td>' + data.avg_waktu_task4 + '</td>' +
                                '<td>' + data.jumlah_antrean + '</td>' +
                                '<td>' + data.avg_waktu_task3 + '</td>' +
                                '<td>' + data.namapoli + '</td>' +
                                '<td>' + data.avg_waktu_task6 + '</td>' +
                                '<td>' + data.avg_waktu_task5 + '</td>' +
                                '<td>' + data.nmppk + '</td>' +
                                '<td>' + data.avg_waktu_task2 + '</td>' +
                                '<td>' + data.avg_waktu_task1 + '</td>' +
                                '<td>' + data.kodepoli + '</td>' +
                                '<td>' + data.waktu_task5 + '</td>' +
                                '<td>' + data.waktu_task4 + '</td>' +
                                '<td>' + data.waktu_task3 + '</td>' +
                                '<td>' + data.insertdate + '</td>' +
                                '<td>' + data.tanggal + '</td>' +
                                '<td>' + data.waktu_task2 + '</td>' +
                                '<td>' + data.waktu_task6 + '</td>' +
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
                        $('#data-body').append('<tr><td style="text-align:center" colspan="20">Data Kosong</td></tr>')
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error if needed
                    console.error('Error:', status, error);
                }
            });
        } else {
            // Inform the user to choose tanggal and waktu
            alert('Please choose tanggal and waktu');
        }
    }
</script>
<?php
    $this->load->view("layout/footer_left");
?>
