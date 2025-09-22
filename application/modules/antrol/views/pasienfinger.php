<?php
    $this->load->view("layout/header_left");
?>

<div class="card ">
    <div class="card-header">
        <h2>Referensi Pasien Finger Print</h2>
        <hr>
    </div>
    <div class="body p-4">
        <div class="mb-4">
            <div>
                <label for="pilihan">Pilih Identitas</label>
                <select id="pilihan" class="form-control">
                    <option value="">--Silahkan Pilih Identitas--</option>
                    <option value="nik">NIK</option>
                    <option value="noka">Nomor Kartu BPJS</option>
                </select>
            </div>
            <div>
                <label for="noidentitas" >Nomor Identitas</label>                
                <input type="text" class="form-control" id="noidentitas">
            </div>
            <button class="btn btn-primary mt-2 mb-2" onclick="searchPasien()">Cari Pasien</button>
        </div>
        <table id="table-datatables" class="table table-bordered ">
            <thead>
                <tr>
                    <th>Nomor Kartu</th>
                    <th>NIK</th>
                    <th>Tanggal Lahir</th>
                    <th>Daftar FP</th>
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
    
    function searchPasien() {
        var pilihan = $('#pilihan').val();
        var noidentitas = $('#noidentitas').val();

        if(pilihan != '' && noidentitas != ''){
            // Make AJAX request to the API
            $.ajax({
                url: `${baseurl}/antrol/referensipasienfinger?hit=1&pilihan=${pilihan}&noidentitas=${noidentitas}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.metadata.code === 1) {
                        // Data retrieval successful, populate the table
                        var data = response.response;
                        var tbody = $('#data-body');
    
                        // Clear existing rows in the table body
                        tbody.empty();
                        $('#table-datatables').DataTable().destroy();
    
                        // Append row to the table
                        var row = '<tr>' +
                            '<td>' + data.nomorkartu + '</td>' +
                            '<td>' + data.nik + '</td>' +
                            '<td>' + data.tgllahir + '</td>' +
                            '<td>' + data.daftarfp + '</td>' +
                            '</tr>';
                        tbody.append(row);
    
                        // Initialize DataTables
                        $('#table-datatables').DataTable({
                            "width": "100%"
                        });
                    } else {
                        // Handle error if needed
                        console.error('Error:', response.metadata.message);
                        $('#data-body').empty();
                        $('#data-body').append(`<tr><td style="text-align:center" colspan="4">${response.metadata.message}</td></tr>`);
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
