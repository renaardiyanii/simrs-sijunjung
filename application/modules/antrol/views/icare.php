<?php
    $this->load->view("layout/header_left");
?>
<style>
    <style>
        iframe {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            border: none;
            display: block;
        }
    </style>
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="card ">
    <div class="card-header">
        <h2>ICare BPJS Kesehatan</h2>
        <hr>
    </div>
    <div class="body p-4">
        <div class="mb-4">
            <div>
                <label for="pilihan">Pilih Dokter</label>
                <select id="pilihan" class="form-control">
                    <option value="">--Silahkan Pilih Dokter--</option>
                </select>
            </div>
            <div>
                <label for="noidentitas" >Nomor Kartu BPJS</label>                
                <input type="text" class="form-control" id="noidentitas">
            </div>
            <button class="btn btn-primary mt-2 mb-2" onclick="searchPasien()">Cari</button>
        </div>
        <!-- <iframe src="" id="myIframe"></iframe> -->
        <table id="table-datatables" class="table table-bordered ">
            <thead>
                <tr>
                    <th>Link</th>
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
        caridokter();
    });

    function caridokter(){
        $.ajax({
            url: `${baseurl}/antrol/referensidokter?hit=1`, // Update the API endpoint
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.metadata.code === 1) {
                    var html = '';
                    response.response.map((e)=>{
                        html+=`
                        <option value="${e.kodedokter}">${e.namadokter}</option>
                        `;
                    })
                    $("#pilihan").html(html);
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
    }
    
    function searchPasien() {
        var pilihan = $('#pilihan').val();
        var noidentitas = $('#noidentitas').val();

        if(pilihan != '' && noidentitas != ''){
            // Make AJAX request to the API
            $.ajax({
                url: `${baseurl}/antrol/icare?hit=1&pilihan=${pilihan}&nokartu=${noidentitas}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response)
                    if(response.metaData.code === 200){

                        $("iframe").attr("src", response.response.url);
                        // document.getElementById('myIframe').contentWindow.location.reload();
                        $("#data-body").html(`
                        <tr>
                            <td><a href="${response.response.url}" target="_blank">${response.response.url}</a></td>
                        </tr>
                        `);
                    }else{
                        Swal.fire({
                            title: "Peringatan",
                            text: `${response.metaData.message}`,
                            icon: "error"
                        });
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
