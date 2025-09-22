<?php
    $this->load->view("layout/header_left");
?>

<div class="card ">
    <div class="card-header">
        <h2>Referensi Poli Fingerprint</h2>
        <hr>
    </div>
    <div class="body p-4">
        <table id="table-datatables" class="table table-bordered " style="width:100%;important;">
            <thead>
                <tr>
                    <th>Kode Subspesialis</th>
                    <th>Nama Subspesialis</th>
                    <th>Kode Poli</th>
                    <th>Nama Poli</th>
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

        // Make AJAX request to the API
        $.ajax({
            url: `${baseurl}/antrol/referensipolifinger?hit=1`, // Update the API endpoint
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.metadata.code === 1) {
                    // Data retrieval successful, populate the table
                    var dataList = response.response;
                    var tbody = $('#data-body');
                    // Loop through the data and append rows to the table
                    $.each(dataList, function(index, data) {
                        var row = '<tr>' +
                            '<td>' + data.kodesubspesialis + '</td>' +
                            '<td>' + data.namasubspesialis + '</td>' +
                            '<td>' + data.kodepoli + '</td>' +
                            '<td>' + data.namapoli + '</td>' +
                            '</tr>';
                        tbody.append(row);
                    });

                    // Initialize DataTables
                    $('#table-datatables').DataTable({
                        "width": "100%"
                    });
                } else {
                    // Handle error if needed
                    $('#data-body').empty();
                    $('#data-body').append('<tr><td style="text-align:center" colspan="4">Data Kosong</td></tr>')
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
