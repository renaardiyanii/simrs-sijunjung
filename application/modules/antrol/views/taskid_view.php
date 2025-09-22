<?php $this->load->view("layout/header_left"); ?>

<div class="card ">
    <div class="card-header">
        <h2>Data Task ID</h2>
        <hr>
    </div>
    <div class="body p-4">
        <!-- Form filter (optional) -->
        <form id="filterForm" class="form-inline mb-3">
            <div class="form-group mr-2">
                <label for="tanggalawal">Tanggal Awal: </label>
                <input type="date" class="form-control ml-2" id="tanggalawal" name="tanggalawal">
            </div>
            <div class="form-group mr-2">
                <label for="tanggalakhir">Tanggal Akhir: </label>
                <input type="date" class="form-control ml-2" id="tanggalakhir" name="tanggalakhir">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <button id="btn-export" class="btn btn-success">
                <i class="fa fa-file-excel-o"></i> Export Excel
            </button>
        </form>

        <table id="table-datatables" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Created</th>
                    <th>Nama</th>
                    <th>Kodebooking</th>
                    <th>Hit</th>
                    <th>Request</th>
                    <th>Response</th>
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
    $(document).ready(function(){
        // Fungsi untuk load data taskid berdasarkan filter tanggal
        function loadTaskid(tglAwal, tglAkhir) {
            $.ajax({
                url: `${baseurl}/antrol/referensitaskid?hit=1&tanggalawal=${tglAwal}&tanggalakhir=${tglAkhir}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Kosongkan table body
                    $('#data-body').empty();
                    if (response.metadata.code === 200) {
                        var dataList = response.response;
                        
                        // Loop melalui data dan tambahkan baris ke table
                        $.each(dataList, function(index, data) {
                            var dt = new Date(data.created);
                            var formattedCreated = dt.toLocaleDateString('sv-SE');
                            var row = '<tr>' +
                                '<td>' + data.id + '</td>' +
                                '<td>' + formattedCreated + '</td>' +
                                '<td>' + data.nama + '</td>' +
                                '<td>' + data.kodebooking + '</td>' +
                                '<td>' + data.hit + '</td>' +
                                '<td>' + data.request + '</td>' +
                                '<td>' + data.response + '</td>' +
                                '<td>' + data.status + '</td>' +
                                '</tr>';
                            $('#data-body').append(row);
                        });
                        $('#table-datatables').DataTable();
                    } else {
                        console.error('Error:', response.metadata.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', status, error);
                }
            });
        }
        
        // Set tanggal awal dan akhir default ke hari ini
        var today = new Date().toISOString().split('T')[0];
        $('#tanggalawal').val(today);
        $('#tanggalakhir').val(today);
        loadTaskid(today, today);

        // Event ketika form filter disubmit
        $('#filterForm').on('submit', function(e){
            e.preventDefault();
            var tglAwal = $('#tanggalawal').val();
            var tglAkhir = $('#tanggalakhir').val();
            // Hancurkan DataTable sebelum reload (jika sudah ada)
            if ($.fn.DataTable.isDataTable('#table-datatables')) {
                $('#table-datatables').DataTable().destroy();
            }
            loadTaskid(tglAwal, tglAkhir);
        });

        // Event klik tombol export
        $('#btn-export').on('click', function() {
            var tglAwal = $('#tanggalawal').val();
            var tglAkhir = $('#tanggalakhir').val();
            
            window.location.href = `${baseurl}/antrol/referensitaskid?export=1&tanggalawal=${tglAwal}&tanggalakhir=${tglAkhir}`;
        });
    });
</script>

<?php $this->load->view("layout/footer_left"); ?>
