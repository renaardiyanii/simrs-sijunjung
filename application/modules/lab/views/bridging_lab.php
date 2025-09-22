<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Bridging dengan Laboratorium</h4>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table" id="datatable_bridging">
                    <thead>
                        <tr>
                        <th scope="col">No</th>
                        <th scope="col">Id tindakan</th>
                        <th scope="col">Jenis Hasil</th>
                        <th scope="col">Parameter LIS</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($lab as $val){ ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $val->id_tindakan ?></td>
                                <td><?= $val->jenis_hasil ?></td>
                                <td><?= $val->lis ?></td>
                                <td><button type="button" data-lab='<?= json_encode($val); ?>' class="btn btn-primary btn-sm parsingdata" data-toggle="modal" data-target="#exampleModal">Edit</button></td>
                            </tr>
                        <?php 
                        $i++;
                    } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- modal -->
<!-- Modal -->
<form id="submit-hasil">
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Parameter LIS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="jenishasil">Jenis Hasil</label>
            <input type="text" class="form-control" id="jenishasil" readonly>
            <input type="hidden" class="form-control" id="id_jenis_hasil" readonly>
        </div>
        <div class="form-group">
            <label for="parameterlis">Parameter LIS</label>
            <input type="text" class="form-control" id="parameterlis" placeholder="Parameter LIS">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>
<script>
    idlab = 0;
    $(document).on("click", ".parsingdata", function () {
        var lab = $(this).data('lab');
        $('#jenishasil').val(lab.jenis_hasil);
        $('#id_jenis_hasil').val(lab.id_jenis_hasil_lab);
        $('#parameterlis').val(lab.lis);
    });

    $(document).on("submit","#submit-hasil",function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= base_url('lab/labcdaftar/insert_bridging_lab') ?>",
            data: {
                "lis":$('#parameterlis').val(),
                "id_jenis_hasil_lab":$('#id_jenis_hasil').val()
            },
            success: (res)=>{
                if(res.code == 200){
                    Swal.fire(
                        'Berhasil!',
                        'Data berhasil Di Input!',
                        'success'
                    );
                }else{
                    Swal.fire(
                        'Gagal!',
                        'Data Gagal Di Input!',
                        'warning'
                    );
                }
            },
            dataType: 'json'
        });
    });
    
</script>

    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_left");
        }
    ?> 