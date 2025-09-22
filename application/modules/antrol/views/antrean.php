<?php
    $this->load->view("layout/header_left");
?>

<div class="card">
    <div class="card-header">
        <h2>Antrean Pendaftaran</h2>
        <hr>
    </div>
    <div class="body p-4">
        <div class="row mb-4">
            <div class="col">
                <label for="inputType">Cari berdasarkan</label>
                <select id="inputType" class="form-control" onchange="handleInputType()">
                    <option value="kodebooking">Kode Booking</option>
                    <option value="tanggal">Tanggal</option>
                    <option value="antrian_belum_dilayani">Antrian Belum Dilayani</option>
                </select>
            </div>
            <div class="col">
                <label for="inputValue">Input Value</label>
                <input type="text" id="inputValue" class="form-control" placeholder="Enter Value" onkeyup="handle()" onchange="handle()">
            </div>
        </div>
        <table id="table-datatables" class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Booking</th>
                    <th>Nomor Rekam Medis</th>
                    <th>NIK</th>
                    <th>No. Kapsul</th>
                    <th>No. Antrean</th>
                    <th>No. HP</th>
                    <th>Tanggal</th>
                    <th>Peserta</th>
                    <th>Status</th>
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

    function handleInputType() {
        var inputType = $('#inputType').val();
        var inputValueField = $('#inputValue');

        if (inputType === 'antrian_belum_dilayani') {
            inputValueField.val('');
            handle()
        }

        // Switch input field type based on the selected input type
        if (inputType === 'tanggal') {
            inputValueField.attr('type', 'date');
        } else {
            inputValueField.attr('type', 'text');
        }

    }

    function handle() {
        var inputType = $('#inputType').val();
        var inputValue = $('#inputValue').val();

        if (inputType === 'antrian_belum_dilayani') {
            inputValue = '1';
        }

        // Check if inputType and inputValue are provided
        if (inputType !== '' && inputValue !== '') {
            $.ajax({
                url: `${baseurl}/antrol/antrean?${inputType}=${inputValue}`,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.metadata.code === 200) {
                        $('#table-datatables').DataTable().destroy();
                        var dataList = response.response;
                        var tbody = $('#data-body');

                        // Clear existing rows in the table body
                        tbody.empty();

                        // Loop through the data and append rows to the table
                        $.each(dataList, function (index, data) {
                            var row = '<tr>' +
                                '<td>' + data.kodebooking + '</td>' +
                                '<td>' + data.norekammedis + '</td>' +
                                '<td>' + data.nik + '</td>' +
                                '<td>' + data.nokapst + '</td>' +
                                '<td>' + data.noantrean + '</td>' +
                                '<td>' + data.nohp + '</td>' +
                                '<td>' + data.tanggal + '</td>' +
                                '<td>' + (data.ispeserta ? 'Yes' : 'No') + '</td>' +
                                '<td>' + data.status + '</td>' +
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
                        $('#data-body').append('<tr><td style="text-align:center" colspan="15">Data Kosong</td></tr>')
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error if needed
                    console.error('Error:', status, error);
                }
            });
        } else {
            // Inform the user to choose inputType and provide inputValue
            alert('Please choose input type and provide input value');
        }
    }
</script>
<?php
    $this->load->view("layout/footer_left");
?>
