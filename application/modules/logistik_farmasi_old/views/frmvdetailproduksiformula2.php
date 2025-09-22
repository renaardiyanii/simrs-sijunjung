<?php
  $this->load->view('layout/header_left.php');
?>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script> 
<script type='text/javascript'>

$(document).ready(function () {
    $(".js-example-basic-single").select2({
            placeholder: "Select an option"
        });


        $('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>logistik_farmasi/Frmcproduksi/insert_detail_formula",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Obat';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									window.location.reload();
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit Obat';
            $('#editModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
    }); 
});

function edit_obat(id_obat) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcproduksi/get_data_edit_obat')?>",
      data: {
        id_obat: id_obat
      },
      success: function(data){
        console.log(data);
        $('#edit_id_obat_hidden').val(data[0].id_obat);
        let html = '';
                if(data.length){
                    $('#pilihbatch').empty();
                    html+= '<option value="" selected>Silahkan Pilih</option>';
                    data.map((i)=>{
                        html+= `
                        <option value="${i.id_inventory}">${'(batch -'+i.batch_no+','+i.expire_date+','+i.qty+')'}</option>
                        `;
                        console.log(data)
                    })

                    $('#pilihbatch').html(html);
                  
                    console.log(data)
                    return true;
                }
     
      },
      error: function(){
        alert("error");
      }
    });
  }


 


  
</script>

<div class="panel-body" style="width:100%">
    <div class="col-md-16">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-info">
                Detail  Obat
            </div>
            <div class="ribbon-content">
           
                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Nama Obat</p>
                   
                    <div class="col-sm-6">
                        <!-- <p>:</p>  -->
                        <p>: <?php echo $data_header->nm_obat ?></p>     
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Qty</p>
                    <div class="col-sm-6">
                        <p>: <?php echo$data_header->qty ?></p> 
                             
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">No Batch</p>
                    <div class="col-sm-6">
                    <p>: <?php echo $data_header->batch_no ?></p> 
                          
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Expire Date</p>
                    <div class="col-sm-6">
                    <p>: <?php echo $data_header->exp_date ?></p> 
                              
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Tanggal Produksi</p>
                    <div class="col-sm-6">
                    <p>: <?php echo $data_header->tgl_produksi ?></p> 
                           
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>


<div class="panel-body" style="width:100%">
    <div class="col-md-16">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-info">
                Bahan Produksi
            </div>
            <div class="ribbon-content">
            <table class="display nowrap table table-hover table-bordered table-striped"
                cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><p align="center">No</p></th>
                    <th><p align="center">Nama Obat</p></th>
                    <th><p align="center">Dosis</p></th>
                    <th><p align="center">Aksi</p></th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 1;
                foreach ($data_obat_detail_produksi as $row) {
                ?>
                    <tr>
                        <td align="center"><?php echo $i++; ?></td>
                        <td align="center"><?php echo $row->nm_obat; ?></td>
                        <td align="center" ><?php echo $row->dosis; ?></td>
                        <td align="center" > 
                        <button type="button" title="Edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_obat('<?php echo $row->id_obat;?>')"><i class="fa fa-edit"></i></button>
                           
                        </td>
                    <tr>
                <?php
                   }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="panel-body" style="width:100%">
    <div class="col-md-16">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-info">
                Detail Bahan Obat Produksi
            </div>
            <div class="ribbon-content">
            <table class="display nowrap table table-hover table-bordered table-striped"
                cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><p align="center">No</p></th>
                    <th><p align="center">Nama Obat</p></th>
                    <th><p align="center">Batch</p></th>
                    <th><p align="center">qty</p></th>
                </tr>
                </thead>
                <tbody>

                <?php
                $i = 1;
                foreach ($data_bahan_produksi as $row) {
                ?>
                    <tr>
                        <td align="center"><?php echo $i++; ?></td>
                        <td align="center"><?php echo $row->nm_obat; ?></td>
                        <td align="center" ><?php echo $row->batch_no; ?></td>
                        <td align="center" ><?php echo $row->qty; ?></td>
                        <td align="center" > 
                            <a href="<?php echo site_url("logistik_farmasi/Frmcproduksi/hapus_detail_produksi_formula/".$row->id.'/'.$row->id_produksi.'/'.$id_obat); ?>"
                            class="btn btn-danger btn-xs">hapus</a>
                           
                        </td>
                    <tr>
                <?php
                   }
                ?>
                </tbody>
            </table><br><br>
            <div class="col-xs-6" align="right">
                <div class="form-inline" align="right">
                    <div class="input-group">
                        <div class="form-group">
                        <a href="<?php echo site_url("logistik_farmasi/Frmcproduksi/insert_selesai_produksi/".$id_produksi); ?>"
                        class="btn btn-primary">Selesai Produksi</a>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModal"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Bahan</h4>
                  </div>
                  <div class="modal-body"> 
                                                            

                    <div class="form-group row">
                        <p class="col-sm-2 form-control-label " id="tindakan">Batch</p>
                        <div class="col-sm-6">
                                <select id="pilihbatch" name="cari_obat_sub" class="form-control" width="100%">
                                    <option value="">Silahkan Pilih batch</option>
                                </select>
                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <p class="col-sm-2 form-control-label" id="lcomment">qty</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="qty" id="qty">      
                        </div>
                    </div>

                    <input type="hidden" class="form-control" name="id_produksi" id="id_produksi" value = "<?php echo $id_produksi?>">  
                    <input type="hidden" class="form-control" name="obat_utama" id="obat_utama" value = "<?php echo $id_obat?>">  

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-edit">Edit Obat</button>
                  </div>
                </div>
              </div>
            </div>
          </form>






<?php
  $this->load->view('layout/footer_left.php');
?>