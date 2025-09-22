<?php
    $this->load->view("layout/header_left");
?>

<div class="card">
    <div class="card-header">
        <h2>Dashboard Per Poli Per Dokter Per Hari Per Jam Praktek</h2>
        <hr>
    </div>
    <div class="body p-4">
        <div class="row mb-4">
            <div class="col">
                <label for="kodepoli">Kode Poli</label>
                <input type="text" id="kodepoli" class="form-control" onchange="handle()">
            </div>
            <div class="col">
                <label for="kodedokter">Kode Dokter</label>
                <input type="text" id="kodedokter" class="form-control" onchange="handle()">
            </div>
            <div class="col">
                <label for="hari">Hari</label>
                <input type="text" id="hari" class="form-control" onchange="handle()">
            </div>
            <div class="col">
                <label for="jampraktek">Jam Praktek</label>
                <input type="text" id="jampraktek" class="form-control" onchange="handle()">
            </div>
        </div>
        <table id="table-datatables" class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>Kode Booking</th>
                    <th>Tanggal</th>
                    <th>Kode Poli</th>
                    <th>Kode Dokter</th>
                    <th>Jam Praktek</th>
                    <th>No. Antrean</th>
                    <th>Status</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody id="data-body">
            </tbody>
        </table>
    </div>
</div>
<!-- Add your necessary scripts here -->
<script>
    $(document).ready(function () {
        // Initialize DataTables
        $('#table-datatables').DataTable({
            "width": "100%"
        });
    });

    function handle() {
        var kodepoli = $('#kodepoli').val();
        var kodedokter = $('#kodedokter').val();
        var hari = $('#hari').val();
        var jampraktek = $('#jampraktek').val();

        // Check if all required parameters are provided
        if (kodepoli !== '' && kodedokter !== '' && hari !== '' && jampraktek !== '') {
            $.ajax({
                // Modify the URL to match the new API endpoint
                url: `${baseurl}/antrol/dashboard_per?kodepoli=${kodepoli}&kodedokter=${kodedokter}&hari=${hari}&jampraktek=${jampraktek}`,
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
                                '<td>' + data.kodebooking + '</td>' +
                                '<td>' + data.tanggal + '</td>' +
                                '<td>' + data.kodepoli + '</td>' +
                                '<td>' + data.kodedokter + '</td>' +
                                '<td>' + data.jampraktek + '</td>' +
                                '<td>' + data.noantrean + '</td>' +
                                '<td>' + data.status + '</td>' +
                                // Add more columns as needed
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
                        $('#data-body').append('<tr><td style="text-align:center" colspan="7">Data Kosong</td></tr>')
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error if needed
                    console.error('Error:', status, error);
                }
            });
        } else {
            // Inform the user to choose all required parameters
            // alert('Please choose kodepoli, kodedokter, hari, and jampraktek');
        }
    }
</script>
<?php
    $this->load->view("layout/footer_left");
?>
