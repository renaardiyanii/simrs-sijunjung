<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>

<script type="text/javascript">
  var table_pasien;

  $(document).ready(function() {
    // Clock pickers

    var dietgizi = "<?php echo $idpokdiet;?>";
    if(dietgizi!=''){
      $('#record_gizi').val(dietgizi).change();
    }
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });

    $('.select2').select2();
    $('.date_picker').datepicker({
      format: "yyyy-mm-dd",
      //endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });      

    // tablegizipasien(); 
      table_pasien = $('#table-pasien').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      // "language": {
      //   "searchPlaceholder": " No. SEP, Nama"
      // },
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('gizi/show_pasien_gizi').'/'.$no_ipd;?>",
        "type": "post"
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "15%",
        "targets": 6 // column index 
      }
      // ,{ "width": "18%", "targets": 3 },{ "width": "10%", "targets": 2 },{ "width": "7%", "targets": 0 }
      ],
   
    });

    $("#form_add_diet").submit(function(event) {
      document.getElementById("btn-diet").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'irj/rjcpelayanan/insert_dietpasien'; ?>",
          dataType: "JSON",
          data: $('#form_add_diet').serialize(),
          success: function(data){   
          if (data == true) {
            document.getElementById("btn-diet").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
              swal("Sukses", "Jenis Diet berhasil disimpan.", "success");
          } else {
            document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          swal("Error", "Gagal menginput Jenis Diet. Silahkan coba lagi.", "error");            
          }
          },
          error:function(event, textStatus, errorThrown) { 
            document.getElementById("btn-diet").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          },
          timeout: 0
      });
    event.preventDefault();
  });

    var v00 = $("#forminputmenupasien").validate({
      rules: {
        iddiet: {
          required: true
        },
        ket_waktu: {
          required: true
        },
        tanggal:{
          required: true
        }
      },
    highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
     errorElement: "span",
     errorClass: "help-block help-block-error",
     submitHandler: function(form) {
          var formData = new FormData( $("#forminputmenupasien")[0] );
          $.ajax({
            type:'post',
            url: "<?php echo base_url('gizi/insert_gizipasien/')?>",
            type : 'POST', 
            data : formData,
            async : false,
            cache : false,
            contentType : false,
            processData : false,
            beforeSend:function()
            {
            },      
            complete:function()
            {
                //stopPreloader();
            },
            success:function(data)
            {       
                    alert("Data Berhasil Disimpan");                    
                    // console.log(data);
                    $("#forminputmenupasien")[0].reset();
                    table_pasien.ajax.reload();
            },
            error: function(){
                        alert("error");
            }
          });           
        }
    });
      
  });

// function tablegizipasien(){
//     table_pasien = $('#table-pasien').DataTable({ 
//       "processing": true,
//       "serverSide": true,
//       "order": [],
//       // "language": {
//       //   "searchPlaceholder": " No. SEP, Nama"
//       // },
//       "lengthMenu": [
//         [ 10, 25, 50, -1 ],
//         [ '10 rows', '25 rows', '50 rows', 'Show all' ]
//       ],
//       "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
//       "ajax": {
//         "url": "<?php echo site_url('gizi/show_pasien_gizi').'/'.$no_ipd;?>",
//         "type": "post"
//       },
//       "columnDefs": [{ 
//         "orderable": false, //set not orderable
//         "width": "15%",
//         "targets": 6 // column index 
//       }
//       // ,{ "width": "18%", "targets": 3 },{ "width": "10%", "targets": 2 },{ "width": "7%", "targets": 0 }
//       ],
   
//     });
// }

function delete_menu(id) {       
  swal({
        title: "Hapus Menu",
        text: "Hapus Menu tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (hapus)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'gizi/delete_menu/'; ?>"+id,
            dataType: "JSON",                    
            success: function(data){  
              if (data == true) {
                table_pasien.ajax.reload();
                swal("Sukses", "Menu berhasil dihapus.", "success");
              } else {
                swal("Error", "Gagal menghapus Menu. Silahkan coba lagi.", "error");            
              }
            },
            error:function(event, textStatus, errorThrown) {    
                swal("Error", "Gagal Menghapus Data.", "error");
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });           
      });   
}

</script>

<div>
  <div>
    <!-- Main content -->
     <div class="row">
    <div class="col-lg-12 col-md-12">
    <div class="alert alert-info">
                  <form class="form" id="form_add_diet">
            <div class="form-group row">
              <p class="col-sm-2 form-control-label" id="jns_diet">Jenis Diet *</p>
                <div class="col-sm-10">
                  <select id="record_gizi" class="form-control select2" name="record_gizi"  style="width:100%;" required>
                    <option value="">-Pilih Kel Diet-</option>
                    <?php print_r($pasien);
                      foreach($keldiet as $row){
                        echo '<option value="'.$row->idpokdiet;
                        
                        echo '">'.$row->pokdiet.'</option>';
                    }?>
                            </select>
                      </div>
                    </div>
              <input type="hidden" class="form-control" value="<?php echo $pasien[0]['no_medrec'];?>" name="no_medrec">
              <input type="hidden" class="form-control" value="IRJ" name="rawat"> 
              <div class="form-group row">
                <div class="offset-sm-2 col-sm-6">
                                  <button type="submit" class="btn btn-primary" id="btn-diet">Simpan</button>
                              </div>
              </div>
          </form>
                    
                </div>
        <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Gizi Pasien | <?php echo $no_ipd;?></h4></div>
            <div class="card-block">
            <br>

                <form class="form-horizontal" method="POST" id="forminputmenupasien">                   
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Menu Diet *</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="iddiet" id="iddiet" required>
                        <option value="">-Pilih Menu Diet-</option>
                        <?php
                          foreach($menudiet as $row1){
                            echo '<option value="'.$row1->iddiet.'">'.$row1->nama_menu.' | '.$row1->komposisi.'</option>';
                          }
                        ?>
                      </select> 
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tanggal">Tanggal *</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control date_picker" name="tanggal" id="tanggal" required="true">            
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_waktu">Waktu *</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="ket_waktu" id="ket_waktu" required>
                        <option value="">-Pilih Waktu-</option>
                        <option value="PAGI">Pagi</option>
                        <option value="SIANG">Siang</option>
                        <option value="MALAM">Malam</option>
                        <option value="EXTRA">Ekstra</option>
                        <option value="SNACK">Snack</option>
                      </select>        
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_waktu">Catatan</p>
                    <div class="col-sm-6">  
                      <textarea class="form-control" name="note" id="note" rows="6"></textarea>        
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_cbk"></p>
                    <input type="checkbox" id="dietCheckbox"  class="flat-red" name="dietCheckbox"  value="1"><label for="dietCheckbox"> Diet *)</label>    
                   </div>               
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <input type="hidden" class="form-control" value="<?php echo $pasien[0]['bed'];?>" name="idbed">
                  <input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
                  <div class="form-group row">
                  <div class="offset-sm-4 col-sm-8">                  
                    <button class="btn btn-primary" type="submit">Simpan</button>
                  </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-8 form-control-label" id="lbl_cbk">*) Sesuai dengan diet terakhir</p>
                   </div>
              </form>              
              <div class="col-sm-12">
              <hr>
              <div class="table-responsive m-t-0">      
             <table id="table-pasien" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Menu</th>
                  <th>Ruang</th>
                  <th>Tanggal</th>
                  <th>Waktu</th>
                  <th>Catatan</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>                
                </tbody>
              </table>
              </div>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->     
    
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_menudiet">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Menu Diet</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                  <form class="form-horizontal" id="form_diet">
                    <div class="form-group row">
                      <label for="example-number-input" class="col-sm-2 col-form-label">No. Register</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="no_ipd" id="no_ipd" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="example-number-input" class="col-sm-2 col-form-label">No. RM</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="no_cm" id="no_cm" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="example-number-input" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="nama" id="nama" readonly>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="example-number-input" class="col-sm-2 col-form-label">Kelas</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="kelas" id="kelas" readonly>
                      </div>
                    </div>                    
                    <div class="form-group row">
                      <label for="example-number-input" class="col-sm-2 col-form-label">Menu Diet</label>
                      <div class="col-sm-9">
                        <textarea class="form-control" rows="5" name="menu_diet" id="menu_diet"></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="example-number-input" class="col-sm-2 col-form-label">Bed</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="bed" id="bed" readonly>
                      </div>
                    </div>               
                  </form>                              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save_menu()" id="btn-diagnosa"><i class="fa fa-floppy-o"></i> Simpan</button>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>