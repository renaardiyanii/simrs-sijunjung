<?php

if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}



// var dump the decoded data
// var_dump($decodedData);

?>
<!-- import swall from cdn -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4>BPJS - Backdate Kunjungan / Fingerprint</h4>
    </div>
  </div>
<div class="card">
  <div class="card-body p-4">
    <form>
        <div class="form-group">
            <label for="no_kartu">No Kartu</label>
            <input type="text" class="form-control" id="no_kartu" name="no_kartu" value="<?= $decodedData->no_kartu ?>">
        </div>

        <div class="form-group">
            <label for="tgl_pelayanan">Tanggal Pelayanan</label>
            <input type="date" class="form-control" id="tgl_pelayanan" name="tgl_pelayanan" value="<?= date('Y-m-d',strtotime($decodedData->tgl_kunjungan)) ?>">
        </div>
        <!-- Jenis Pelayanan -->
        <div class="form-group">
            <label for="jenis_pelayanan">Jenis Pelayanan</label>
            <select name="jenis_pelayanan" id="jenis_pelayanan" class="form-control" value="1">
                <option value="2">Rawat Jalan</option>
                <option value="1">Rawat Inap</option>
            </select>
        </div>

        <div class="form-group">
            <label for="jenis_pengajuan">Jenis Pengajuan</label>
            <select name="jenis_pengajuan" id="jenis_pengajuan" class="form-control">
                <option value="1">Pengajuan Backdate</option>
                <option value="2">Pengajuan Finger</option>
                <option value="3">Approval Backdate</option>
                <option value="4">Approval Finger</option>
            </select>
        </div>
        <!-- keterangan -->
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
        </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<script>
    // create function on submit hit post api  
    $('form').submit(function(e){
        e.preventDefault();
        var no_kartu = $('#no_kartu').val();
        var tgl_pelayanan = $('#tgl_pelayanan').val();
        var jenis_pelayanan = $('#jenis_pelayanan').val();
        var jenis_pengajuan = $('#jenis_pengajuan').val();
        var keterangan = $('#keterangan').val();
        $.ajax({
            url: '<?= base_url('bpjs/finger/submit_finger') ?>',
            type: 'POST',
            data: {
                no_kartu: no_kartu,
                tgl_pelayanan: tgl_pelayanan,
                jenis_pelayanan: jenis_pelayanan,
                jenis_pengajuan: jenis_pengajuan,
                keterangan: keterangan
            },
            success: function(data){
                console.log(data);
                // show swall
                Swal.fire({
                    title: data.metaData.code === "201"?"Warning":'Success',
                    text: data.metaData.code === "201"?data.metaData.message:data.response,
                    icon: data.metaData.code === "201"?'error':'success',
                    confirmButtonText: 'Ok'
                });
            }
        });
    });
</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 