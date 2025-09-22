<?php 
        if ($role_id == 1) {
          $this->load->view("layout/header_left");
        } else {
          $this->load->view("layout/header_left");
        }
    ?>

<script src="<?= base_url() ?>/assets/js/sweetalert2.js"></script>
<script type='text/javascript'>
$(function() {
    $('.auto_search_by_norm').autocomplete({
        serviceUrl: '<?php echo site_url();?>/emedrec/C_emedrec_autocomplete/data_pasien_by_nomedrec',
        onSelect: function(suggestion) {
            $('#cari_no_rm').val(suggestion.no_cm);
        }
    });

    $('#tbl-rawatjalan').DataTable({
        "language": {
            "emptyTable": "Data tidak tersedia."
        }
    });

    $('#tbl-rawatdarurat').DataTable({
        "language": {
            "emptyTable": "Data tidak tersedia."
        }
    });

    $('#tbl-rawatinap').DataTable({
        "language": {
            "emptyTable": "Data tidak tersedia."
        }
    });

    table_pasien = $('#table_pasien').DataTable({
        "language": {
            "emptyTable": "Data tidak tersedia."
        },
        columns: [{
                data: "no_medrec"
            },
            {
                data: "nama"
            },
            {
                data: "alamat"
            },
            {
                data: 'tgl_lahir'
            },
            {
                data: "tmpt_lahir"
            },
            {
                defaultContent: '<a href="<?php echo site_url('emedrec/C_emedrec/rekam_medik_detail/'); ?>" type="button" class="btn waves-effect waves-light btn-info"><i class="fa fa-download"></i></a>'
            }
        ],
        // "serverSide": true,
    });

    table_obat = $('#table_obat').DataTable({
        "language": {
            "emptyTable": "Data tidak tersedia."
        },
        columns: [{
                data: "tgl_kunjungan"
            },
            {
                data: "nama_obat"
            },
            {
                data: "item_obat"
            },
            {
                data: "signa"
            },
        ],
    });


});

function datapasien() {
    var medrec = $('#cari_no_rm').val();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "<?php echo base_url('emedrec/C_emedrec/get_data_pasien')?>",
        data: {
            no_medrec: medrec
        },
        success: function(data) {
            // data = JSON.parse(data);
            table_pasien.clear().draw();
            table_pasien.rows.add(data);
            table_pasien.columns.adjust().draw();
        },
        error: function() {
            alert("error");
        }
    });
}

function cek_search_per(val_search_per){
	//alert(val_search_per);
	if(val_search_per=='cm'){
		$("#cari_no_rm").css("display", ""); // To unhide
		$("#cari_nama").css("display", "none"); 
	}
	else if(val_search_per=='nama'){
		$("#cari_no_rm").css("display", "none");
		$("#cari_nama").css("display", ""); 
	} 
	else {
		$("#cari_no_rm").css("display", "none");
		$("#cari_nama").css("display", "none"); 
	}
}
</script>

<?php echo $this->session->flashdata('success_msg'); ?>
<div class="row">
    <div class="col-lg-12 col-md-10">
        <div class="card card-outline-info">
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="col-md-8">
                        <?php 
                  $attributes = array('class' => '');
                  echo form_open('emedrec/C_emedrec/pasien', $attributes);?>
                        <div class="form-inline">
                            <select name="search_per" id="search_per" class="form-control"  onchange="cek_search_per(this.value)">
                                <option value="cm">No MR</option>
                                <!-- <option value="kartu">No Kartu</option>
                                <option value="identitas">No Identitas</option> -->
                                <option value="nama">Nama</option>
                                <!-- <option value="alamat">Alamat</option>
                                <option value="tgl">Tanggal Lahir</option> -->
                            </select>

                           
                            <input type="search" id="cari_no_rm" name="cari_no_rm" class="auto_search_by_norm form-control" placeholder="Cari No RM" />
                            <input type="search" style="width:450; display:none" class=" form-control" id="cari_nama" name="cari_nama" placeholder="Pencarian Nama">
                            &nbsp;&nbsp;
                            <button class="btn btn-primary" type="submit">Cari</button>
                            
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="table-responsive m-t-0">
                            <table id="table_pasien" class="display table table-hover table-bordered table-striped"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No. RM</th>
                                        <th>NAMA PASIEN</th>
                                        <th>ALAMAT</th>
                                        <th>TANGGAL LAHIR</th>
                                        <th>TEMPAT LAHIR</th>
                                        <th width="100px">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                  if ($data_pasien != "") {
                    foreach($data_pasien as $row){
                ?>
                                    <tr>
                                        <td><?php echo $row->no_cm;?></td>
                                        <td><?php echo $row->nama;?></td>
                                        <td><?php echo $row->alamat;?></td>
                                        <td><?php echo date('d-m-Y',strtotime($row->tgl_lahir));?></td>
                                        <td><?php echo $row->tmpt_lahir;?></td>
                                        <td><button onclick='detailpasien(<?= json_encode(["ranap"=>$row->ranap,"igd_irj"=>$row->igd_irj,"no_cm"=>$row->no_cm,"no_medrec"=>$row->no_medrec]) ?>)'
                                                class="btn  waves-effect waves-light btn-floating btn-info">
                                                <i class="mdi mdi-clipboard-text"></i>Detail</button></td>
                                        <!-- <td><a href="" class="btn btn-danger btn-xs" style='width:90px;margin-bottom: 3px;'>HTML</a></td> -->
                                    </tr>
                                    <?php } 
                  }
                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
    function detailpasien(data) {
        location.href =
            `<?php echo site_url('emedrec/C_emedrec/rekam_medik_detail/'); ?>${data.no_cm}/${data.no_medrec}`;
        // console.log(data);
        return;
        <?php
            $aksesfull = [1,1012,1029,1025];
            if(!in_array($role_id,$aksesfull)){
            ?>
                if (data.ranap === '0' && data.igd_irj === '0') {
                    $.ajax({
                        method:"post",
                        url: "<?php echo base_url('emedrec/C_emedrec/request_medrec')?>",
                        data: {
                            no_cm: data.no_cm,
                        },
                        success: function(s) {
                            // console.log(data);
                            if(s.akses !== 1){
                                Swal.fire(
                                    'Gagal!',
                                    'Pembatasan Akses Terhadap Pasien!<br>Silahkan hubungi Tim Rekam Medis Untuk Approval Peminjaman Rekam Medis!',
                                    'error'
                                )
                                // return;
                            }else{
                                location.href =`<?php echo site_url('emedrec/C_emedrec/rekam_medik_detail/'); ?>${data.no_cm}/${data.no_medrec}`
                                // return;
                            }

                        },
                        error: function() {
                        }
                    });

                }else{
                    location.href =`<?php echo site_url('emedrec/C_emedrec/rekam_medik_detail/'); ?>${data.no_cm}/${data.no_medrec}`;
                }
        <?php }else{ ?>
        location.href =
            `<?php echo site_url('emedrec/C_emedrec/rekam_medik_detail/'); ?>${data.no_cm}/${data.no_medrec}`;
        <?php } ?>
    }
    </script>


    <!-- MDB -->
    <script type="text/javascript" src="<?php //echo site_url('/assets/mdb2/js/mdb.min.js'); ?>"></script>
    <!-- Custom scripts -->
    </script>
    <?php 
            $this->load->view("layout/footer_left");
      
    ?>