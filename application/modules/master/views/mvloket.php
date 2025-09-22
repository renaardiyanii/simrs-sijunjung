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

    var v0 = $("#forminputloket").validate({
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
             var formData = new FormData( $("#forminputloket")[0] );
              $.ajax({
              type:'post',
              url: "<?php echo base_url('master/mcloket/insert_loket/')?>",
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
                      tableloket();
                      $("#forminputloket")[0].reset();
              },
              error: function(){
                          alert("error");
              }
              });           
        }
    });

    var v01 = $("#formeditloket").validate({
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
        var formData = new FormData( $("#formeditloket")[0] );
        $.ajax({
        type:'post',
        url: "<?php echo base_url('master/mcloket/edit_loket/')?>",
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
                tableloket();
        },
        error: function(){
                    alert("error");
        }
        });           
        }
    });

    tableloket();

  }); 

  function edit_loket(id,kasir,deskripsi,is_active) {
    $("#formeditloket")[0].reset();
    $('#edit_id_hidden').val(id);
    $('#edit_kasir').val(kasir);
    $('#edit_deskripsi').val(deskripsi);
    //$('#edit_isactive').val(is_active);
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

  function delete_loket(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcloket/delete_loket')?>",
      data: {
        id: id
      },
      success: function(data){
    //alert(data[0].id);
        alert("Data Berhasil Dinonaktifkan");
        tableloket();
      },
      error: function(){
        alert("error");
      }
    });
  }

  function tableloket(){
    table = $('#tableloket').DataTable({
        ajax: "<?php echo site_url();?>master/mcloket/show_loket/",
        columns: [
            { data: "id" },
            { data: "id" },
            { data: "kasir" },
            { data: "deskripsi" },
            { data: "status" },
            { data: "aksi"}
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
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
          <h3 >DAFTAR LOKET KASIR</h3><hr>
        </div>

        <div class="">

          <div class="col-xs-9">
          </div>

          <form class="form-horizontal" method="POST" id="forminputloket">
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Loket Kasir Baru</button>
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
                  <h4 class="modal-title"><i class="fa fa-plus"></i> Loket Kasir</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Nama Loket Kasir</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="kasir" id="kasir">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Deskripsi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="deskripsi" id="deskripsi">
                    </div>
                  </div>                  
                </div>
        
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Tambah Loket Baru</button>
                </div>
              </div>
            </div>
          </div>
          
          </form>
    <hr>
          <br/> 
          <br/> 
          
                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" id="tableloket">
                            <thead>
                                <tr>
                                    <th>ID Loket Kasir</th>
                                    <th>ID Loket Kasir</th>
                                    <th>Nama Loket Kasir</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>                            
                        </table>
          
            
             <!--   <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_keltind('<?php //echo $row->id;?>')"><i class="fa fa-edit"></i></button>
          <a type="button" class="btn btn-danger btn-xs" href="<?php //echo base_url('master/mckeltind/delete_keltind/'.$row->id)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>-->

           <form class="form-horizontal" method="POST" id="formeditloket">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Loket Kasir</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Loket Kasir</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_kasir" id="edit_kasir" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Deskripsi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_deskripsi" id="edit_deskripsi">
                    </div>
                  </div>                               
                </div>
<!--               </div> -->
                <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Loket Kasir</button>
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
