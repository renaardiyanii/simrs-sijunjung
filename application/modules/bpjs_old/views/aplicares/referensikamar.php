<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);

?>

<div class="card m-5">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Referensi Kamar
        </div>
    </div>
    <div class="card-body">
        <p id="totalRefKamar">Total Item : -</p>
        <table class="table" width="100%">
            <thead>
                <tr>
                    <td>Nama Kelas</td>
                    <td>Kode Kelas</td>
                </tr>
            </thead>
            <tbody id="referensiKamar">
                
            </tbody>
        </table>

        
    </div>
</div>



<script>
$(document).ready(function(){
    $.ajax({
        url: `<?= base_url('bpjs/aplicares/refkamar') ?>`,
        beforeSend: function() {
            $("#referensiKamar").html('<tr><td colspan="2" style="text-align:center;">Sedang Mengambil Data...</td></tr>')
        },
        success: function(data) {
            let html = '';
            if(data.metadata.code === 1){
                data.response.list.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.namakelas}</td>
                        <td>${e.kodekelas}</td>
                    </tr>
                    `;
                });
                $("#referensiKamar").html(html);
                $('#totalRefKamar').html('Total Item : '+data.metadata.totalitems);
            }
        },
        error: function(xhr) {
            $("#referensiKamar").html('<tr><td colspan="2">Gagal Mengambil Data...</td></tr>')
        },
        complete: function() {

        }
    });
})
</script>