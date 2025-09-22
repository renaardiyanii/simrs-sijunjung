<?php 
            $this->load->view("layout/header_left");
        
    ?>
    <style>
        .ui-autocomplete {
            z-index: 9999;
        }
    </style>
    <script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
    <script type='text/javascript'>
        //-----------------------------------------------Data Table
        $(document).ready(function() {
            $('#example').DataTable({
                "iDisplayLength": 100
            });
        });

        function edit_obat(idpaket) {
            $.ajax({
                type:'POST',
                dataType: 'json',
                url:"<?php echo base_url('master/mcobat/get_data_paket')?>",
                data: {
                    id_paket: idpaket
                },
                success: function(data){
                    $('#edit_id_paket').val(data[0].id_paket);
                    $('#edit_nama_paket').val(data[0].nama_paket);
                },
                error: function(){
                    alert("error");
                }
            });
        }

        function hapus_paket(idpaket) {
            swal({
                title: "Hapus Paket Obat",
                text: "Benar Akan Menghapus Data ini?\nSemua data obat yang berhubungan akan dihapus semua.",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                $.ajax({
                    type:'post',
                    dataType: 'json',
                    url:"<?php echo base_url('master/Mcobat/hapus_paket')?>",
                    data: {
                        id_paket: idpaket
                    },
                    success: function(data){
                        if(data.status=='success'){
                            swal({
                                title: "Selesai",
                                text: "Data Sudah Dihapus",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function () {
                                window.location.reload();
                            });
                        }else {
                            sweetAlert(data.status, "Stock Kurang !", "error");
                        }
                    },
                    error: function(data){

                    }
                });
            });
        }


    </script>
    <section class="content-header">
        <?php
        echo $this->session->flashdata('success_msg');
        ?>
    </section>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block p-b-0">
                    <!-- <div class="box-header">
                      <h3 class="box-title">DAFTAR OBAT</h3>
                    </div> -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Tambah Paket Baru</button>
                        <br/>
                        <br/>

                        <table class="display nowrap table table-hover table-bordered" id="example"
                               cellspacing="0" width="100%">
                            <tr>
                                <td rowspan="2" width="5%"><div align="center">No</div></td>
                                <td rowspan="2" width="25%"><div align="center">Nama Paket</div></td>
                                <td colspan="2" width="50%"><div align="center">Obat</div></td>
                                <td rowspan="2" width="20%"><div align="center">Aksi</div></td>
                            </tr>
                            <tr>
                                <td><div align="center">Nama Obat</div></td>
                                <td width="5%"><div align="center">QTY</div></td>
                            </tr>

                            <tbody id="bodyt">
                            <?php
                            $i=1;
                            foreach($obat as $row){
                                ?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $row->nama_paket;?></td>
                                    <td>
                                        <?php
                                        $item = $this->mmobat->get_paket_obat_detail($row->id_paket)->result();
                                        $racik= $this->mmobat->getdata_resep_racik($row->id_paket)->result();
                                        foreach ($item as $obat) {
                                           
                                            if($obat->racikan == 1){
                                                echo $obat->nama_obat."<br/>";
                                                foreach($racik as $row1){
                                                    if($obat->id == $row1->id_paket_detail){
                                                    echo '- '.$row1->nm_obat. ' ('.$row1->qty.')<br/>';
                                                    }
                                                }
                                            }else{
                                                echo $obat->nm_obat."<br/>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                        foreach ($item as $qty) {
                                            echo $qty->qty."<br/>";
                                        }
                                        ?>
                                    </td>
                                    <td align="center">
                                        <button type="button" class="btn btn-danger btn-xs" onclick="window.location='<?=base_url("master/Mcobat/pengaturan_paket/".$row->id_paket)?>'">Pengaturan</button>
                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_obat('<?php echo $row->id_paket;?>')">Edit</button>
                                        <button type="button" class="btn btn-warning btn-xs" onclick="hapus_paket(<?=$row->id_paket?>)">Hapus</button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                        <?php echo form_open('master/mcobat/save_paket');?>
                        <!-- Modal Edit Obat -->
                        <div class="modal fade" id="addModal" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-success">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Tambah Paket Obat</h4>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Nama Paket Obat</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="nama_paket" id="nama_paket">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>

                        <?php echo form_open('master/mcobat/edit_paket');?>
                        <!-- Modal Edit Obat -->
                        <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-success">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Ubah Paket Obat</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Id Paket</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_id_paket" id="edit_id_paket" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-1"></div>
                                            <p class="col-sm-3 form-control-label">Nama Paket</p>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="edit_nama_paket" id="edit_nama_paket">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" type="submit">Edit Paket</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>

                </div>
            </div>
        </div>
    </div>

    <?php 
       
       $this->load->view("layout/footer_left");
   
?>