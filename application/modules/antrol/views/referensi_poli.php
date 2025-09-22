<?php
    $this->load->view("layout/header_left");
?>

<div class="card ">
    <div class="card-header">
        <h2>Referensi Poli</h2>
        <hr>
    </div>
    <div class="body p-4">
        <table id="table-datatables" class="table table-bordered " style="width:100%">
            <thead>
                <tr>
                    <th>Nama Poli</th>
                    <th>Nama Subspesialis</th>
                    <th>Kode Subspesialis</th>
                    <th>Kode Poli</th>
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
            url: `${baseurl}/antrol/referensipoli?hit=1`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#loading-row').hide();

                if (response.metadata.code === 1) {
                    // Data retrieval successful, populate the table
                    var dataList = response.response;
                    var tbody = $('#data-body');

                    // Loop through the data and append rows to the table
                    $.each(dataList, function(index, data) {
                        var row = '<tr>' +
                            '<td>' + data.nmpoli + '</td>' +
                            '<td>' + data.nmsubspesialis + '</td>' +
                            '<td>' + data.kdsubspesialis + '</td>' +
                            '<td>' + data.kdpoli + '</td>' +
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
