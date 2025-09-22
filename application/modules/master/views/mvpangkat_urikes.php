<?php
  $this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
  $(function() {
    $('#example').DataTable();
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  

    var v0 = $("#forminputket_urikes").validate({
      rules: {
        kasir: {
          required: true
        },
        deskripsi: {
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
             var formData = new FormData( $("#forminputket_urikes")[0] );
              $.ajax({
              type:'post',
              url: "<?php echo base_url('master/Mcpangkat_urikes/insert_pangkat_urikes/')?>",
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
                      $('#myModal').modal('hide'); 
                      console.log(data);
                      table_pangkat_urikes();
                      $("#forminputket_urikes")[0].reset();
              },
              error: function(){
                          alert("error");
              }
              });           
        }
    });

    var v01 = $("#formeditket_urikes").validate({
      rules: {
        edit_deskripsi: {
          required: true        
        },
        edit_kasir:{
            required:true
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
        var formData = new FormData( $("#formeditket_urikes")[0] );
        $.ajax({
        type:'post',
        url: "<?php echo base_url('master/mcpangkat_urikes/edit_pangkat_urikes/')?>",
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
                alert("Data Berhasil Dirubah");
                $('#editModal').modal('hide'); 
                console.log(data);
                table_pangkat_urikes();
        },
        error: function(){
                    alert("error");
        }
        });           
        }
    });

    table_pangkat_urikes();

  }); 

  function edit_pangkat_urikes(urutan,pangkat,pokpangkat,pangkat_id,intensif) {
    $("#formeditket_urikes")[0].reset();
    $('#edit_id_hidden').val(pangkat_id);
    $('#edit_nama').val(pangkat);
    $('#edit_pokpangkat').val(pokpangkat).trigger('change');
    $('#edit_urutan').val(urutan).trigger('change');
    $('#edit_intensif').val(intensif).trigger('change');
    /*$.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php //echo base_url('master/mcloket/get_data_edit_loket')?>",
      data: {
        id: id
      },
      success: function(data){
    //alert(data[0].id);
        $('#edit_id').val(data[0].id);
        $('#edit_id_hidden').val(data[0].id);
        $('#edit_kasir').val(data[0].pokdiet);
      },
      error: function(){
        alert("error");
      }
    });*/
  }


  function delete_pangkat_urikes(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcpangkat_urikes/delete_pangkat_urikes')?>",
      data: {
        id: id
      },
      success: function(data){
    //alert(data[0].id);
        alert("Data Berhasil Dinonaktifkan");
        table_pangkat_urikes();
      },
      error: function(){
        alert("error");
      }
    });
  }

  function table_pangkat_urikes(){
    table = $('#table_pangkat_urikes').DataTable({
        ajax: "<?php echo site_url();?>master/Mcpangkat_urikes/show_pangkat_urikes/",
        columns: [
            { data: "id" },
            { data: "id" },
            { data: "kasir" },
            { data: "deskripsi" },
            { data: "status" },
            { data: "kode" },
            { data: "aksi"}
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 1, "asc" ],[ 1, "asc" ]]
    });
}


</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row" id="row">
    <div class="col-sm-12">
      <div class="card card-block">
        <div class="card-title">
          <h3 >DAFTAR PANGKAT URIKES</h3><hr>
        </div>

        <div class="">

          <div class="col-xs-9">
          </div>

          <form class="form-horizontal" method="POST" id="forminputket_urikes">
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Pangkat Urikes Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i>Tambah Pangkat</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl">Nama pangkat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama_pangkat" id="nama_pangkat">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Kelompok pangkat</p>
                    <div class="col-sm-6">
                    <select name="pokpangkat" id="pokpangkat" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" read>
                    <option value="">- Pilih Kelompok -</option>
                    <?php 
                      foreach($pokpangkat as $row){    
                          echo '<option value="'.$row->pokpangkat.'">'.$row->pokpangkat.'</option>'; 
                        }
                    ?>                              
                  </select> 
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Urutan Pangkat</p>
                    <div class="col-sm-6">
                       <select name="urutan" id="urutan" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" read>
                    <option value="">- Pilih Urutan -</option>
                    <?php 
                      foreach($urutan as $row){    
                          echo '<option value="'.$row->urutan.'">'.$row->urutan.'-'.$row->pangkat.'</option>'; 
                        }
                    ?>                              
                  </select> 
                    </div>
                  </div>                  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Tingkat Intensif</p>
                    <div class="col-sm-6">
                     <select name="intensif" id="intensif" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" read>
                    <option value="">- Pilih Tingkat -</option>
                    <?php 
                      foreach($intensif as $row){    
                          echo '<option value="'.$row->intensif.'">'.$row->intensif.'</option>'; 
                        }
                    ?>                              
                  </select> 
                    </div>
                  </div>
                                  
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Tambah pangkat Urikes Baru</button>
                </div>
              </div>
            </div>
          </div>
          
          </form>
    <hr>
          <br/> 
          <br/> 
          
                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" id="table_pangkat_urikes">
                            <thead>
                                <tr>
                                    <th>Urutan Pangkat</th>
                                    <th>Urutan Pangkat</th>
                                    <th>Nama Pangkat</th>
                                    <th>Kelompok Pangkat</th>
                                    <th>Tingkat Intensif</th>
                                    <th>Kode Pangkat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>                            
                        </table>
          
            
             <!--   <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_keltind('<?php //echo $row->id;?>')"><i class="fa fa-edit"></i></button>
          <a type="button" class="btn btn-danger btn-xs" href="<?php //echo base_url('master/mckeltind/delete_keltind/'.$row->id)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>-->

           <form class="form-horizontal" method="POST" id="formeditket_urikes">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit pangkat Urikes</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama pangkat Urikes</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nama" id="edit_nama">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kelompok Pangkat</p>
                    <div class="col-sm-6">
                      <select name="edit_pokpangkat" id="edit_pokpangkat" class="js-states form-control form-control-line select2" style="width: 100%" required>
                          <option value=""></option>
                          <?php 
                          foreach($pokpangkat as $row){ 
                            if ($row->pokpangkat == $value->pokpangkat) {
                              echo '<option value="'.$value->pokpangkat.'" selected>'.$row->pokpangkat.'</option>';
                            } else {echo '<option value="'.$row->pokpangkat.'">'.$row->pokpangkat.'</option>';}
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Urutan Pangkat</p>
                    <div class="col-sm-6">
                      <select name="edit_urutan" id="edit_urutan" class="js-states form-control form-control-line select2" style="width: 100%" required>
                          <option value=""></option>
                          <?php 
                          foreach($urutan as $row){ 
                            if ($row->urutan == $value->urutan) {
                              echo '<option value="'.$value->urutan.'" selected>'.$row->urutan.'</option>';
                            } else {echo '<option value="'.$row->urutan.'">'.$row->urutan.' - '.$row->pangkat.'</option>';}
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Tingkat Intensif</p>
                    <div class="col-sm-6">
                      <select name="edit_intensif" id="edit_intensif" class="js-states form-control form-control-line select2" style="width: 100%" required>
                          <option value=""></option>
                          <?php 
                          foreach($intensif as $row){ 
                            if ($row->intensif == $value->intensif) {
                              echo '<option value="'.$value->intensif.'" selected>'.$row->intensif.'</option>';
                            } else {echo '<option value="'.$row->intensif.'">'.$row->intensif.'</option>';}
                          }
                          ?>
                      </select>
                    </div>
                  </div>                                     
                </div>
<!--               </div> -->
                <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit pangkat Urikes</button>
                </div>
              </div>
            </div>
            </form>
          </div>          
        </div>
      </div>
    </div>
</section>

<?php
  $this->load->view('layout/footer_left.php');
?>
