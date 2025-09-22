<?php
  $this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();
  } );
  //---------------------------------------------------------

  $(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  

    var v0 = $("#forminputmenudiet").validate({
      rules: {
        tglok: {
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
             tablekeldiet();
        }
    });

    var v00 = $("#forminputkeldiet").validate({
      rules: {
        idpokdiet: {
          required: true,
          maxlength: 3          
        },
        pokdiet:{
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
        var formData = new FormData( $("#forminputkeldiet")[0] );
        $.ajax({
        type:'post',
        url: "<?php echo base_url('master/mcgizi/insert_keldiet/')?>",
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
                tablekeldiet();
        },
        error: function(){
                    alert("error");
        }
        });           
        }
    });

    var v01 = $("#formeditkeldiet").validate({
      rules: {
        edit_idpokdiet: {
          required: true,
          maxlength: 3          
        },
        edit_pokdiet:{
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
        var formData = new FormData( $("#formeditkeldiet")[0] );
        $.ajax({
        type:'post',
        url: "<?php echo base_url('master/mcgizi/edit_keldiet/')?>",
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
                $('#editModal').modal('hide'); 
                console.log(data);
                tablekeldiet();
        },
        error: function(){
                    alert("error");
        }
        });           
        }
    });

    tablekeldiet();

  }); 

  function edit_keldiet(idpokdiet) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcgizi/get_data_edit_keldiet')?>",
      data: {
        idpokdiet: idpokdiet
      },
      success: function(data){
    //alert(data[0].idpokdiet);
        $('#edit_idpokdiet').val(data[0].idpokdiet);
        $('#edit_idpokdiet_hidden').val(data[0].idpokdiet);
        $('#edit_pokdiet').val(data[0].pokdiet);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function delete_keldiet(idpokdiet) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcgizi/delete_keldiet')?>",
      data: {
        idpokdiet: idpokdiet
      },
      success: function(data){
    //alert(data[0].idpokdiet);
        alert("Data Berhasil Dihapus");
        tablekeldiet();
      },
      error: function(){
        alert("error");
      }
    });
  }

  function tablekeldiet(){
    table = $('#tablekeldiet').DataTable({
        ajax: "<?php echo site_url();?>master/mcgizi/show_keldiet/",
        columns: [
            { data: "idpokdiet" },
            { data: "idpokdiet" },
            { data: "pokdiet" },
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
          <h3 >DAFTAR KELOMPOK DIET</h3><hr>
        </div>

        <div class="">

          <div class="col-xs-9">
          </div>

          <form class="form-horizontal" method="POST" id="forminputkeldiet">
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Kelompok Diet Baru</button>
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
                  <h4 class="modal-title"><i class="fa fa-plus"></i> Kelompok Diet</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">ID Kelompok Diet</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Ex: M00" name="idpokdiet" id="idpokdiet">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Nama Kelompok Diet</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="pokdiet" id="pokdiet">
                    </div>
                  </div>                  
                </div>
        
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Tambah Kelompok Baru</button>
                </div>
              </div>
            </div>
          </div>
          
          </form>
    <hr>
          <br/> 
          <br/> 
          
                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" id="tablekeldiet">
                            <thead>
                                <tr>
                                    <th>ID Kel Diet</th>
                                    <th>ID Kel Diet</th>
                                    <th>Nama Kelompok Diet</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>                            
                        </table>
          
            
             <!--   <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_keltind('<?php //echo $row->idpokdiet;?>')"><i class="fa fa-edit"></i></button>
          <a type="button" class="btn btn-danger btn-xs" href="<?php //echo base_url('master/mckeltind/delete_keltind/'.$row->idpokdiet)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>-->

           <form class="form-horizontal" method="POST" id="formeditkeldiet">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Kelompok Diet</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Kelompok Diet</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_idpokdiet" id="edit_idpokdiet" disabled>
                      <input type="hidden" class="form-control" name="edit_idpokdiet_hidden" id="edit_idpokdiet_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Kelompok Diet</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_pokdiet" id="edit_pokdiet">
                    </div>
                  </div>                                 
                </div>
<!--               </div> -->
        
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Kelompok Diet</button>
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
