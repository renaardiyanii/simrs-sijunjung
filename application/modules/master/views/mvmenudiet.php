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

    $('.select2').select2();
    var v00 = $("#forminputmenudiet").validate({
      rules: {
        iddiet: {
          required: true
        },
        idmenu_diet: {
          required: true
        },
        keldiet:{
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
          var formData = new FormData( $("#forminputmenudiet")[0] );
          $.ajax({
            type:'post',
            url: "<?php echo base_url('master/mcgizi/insert_menudiet/')?>",
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
                    $("#forminputmenudiet")[0].reset();
                    console.log(data);
                    tablemenudiet();
            },
            error: function(){
                        alert("error");
            }
          });           
        }
    });

    var v01 = $("#formeditmenudiet").validate({
      rules: {
        edit_iddiet: {
          required: true,
          maxlength: 5          
        },
        edit_idmenu_diet:{
          required:true
        },
        edit_keldiet:{
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
        var formData = new FormData( $("#formeditmenudiet")[0] );
        $.ajax({
        type:'post',
        url: "<?php echo base_url('master/mcgizi/edit_menudiet/')?>",
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
                $("#formeditmenudiet")[0].reset();
                tablemenudiet();
        },
        error: function(){
                    alert("error");
        }
        });           
        }
    });

    tablemenudiet();
  }); 


  function edit_menudiet(iddiet) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcgizi/get_data_edit_menudiet')?>",
      data: {
        iddiet: iddiet
      },
      success: function(data){
        $('#edit_iddiet').val(data[0].iddiet);
        $('#edit_iddiet_hidden').val(data[0].iddiet);
        $('#edit_keldiet').val(data[0].idkel_diet).change();        
        $('#edit_idmenu_diet').val(data[0].idmenu_diet).change();
      },
      error: function(){
        alert("error");
      }
    });
  }

  function delete_menudiet(iddiet) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcgizi/delete_menudiet')?>",
      data: {
        iddiet: iddiet
      },
      success: function(data){
        //alert(data[0].idpokdiet);
        alert("Data Berhasil Dihapus");
        tablemenudiet();
      },
      error: function(){
        alert("error");
      }
    });
  }

  function tablemenudiet(){
    table = $('#tablemenudiet').DataTable({
        ajax: "<?php echo site_url();?>master/mcgizi/show_menudiet/",
        columns: [
            { data: "iddiet" },
            { data: "iddiet" },
            { data: "pokdiet" },
            { data: "nama_menu" },
            { data: "komposisi" },
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
          <h3 >DAFTAR Menu Diet</h3><hr>
        </div>

        <div class="">

          <div class="col-xs-9">
          </div>

          
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Menu Diet Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <form class="form-horizontal" method="POST" id="forminputmenudiet">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i> Menu Diet</h4>
                </div>
                <div class="modal-body">
                      <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">ID Menu Diet</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Ex: DT00" name="iddiet" id="idmenu_diet">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Kelompok Diet</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="keldiet" id="keldiet" required>
                        <option value="">-Pilih Kelompok Diet-</option>
                        <?php 
                          foreach($keldiet as $row1){
                            echo '<option value="'.$row1->idpokdiet.'">'.$row1->pokdiet.'</option>';
                          }
                        ?>                        
                      </select>                      
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_idmenu_diet">Menu Gizi</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="idmenu_diet" id="idmenu_diet" required>
                        <option value="">-Pilih Menu Gizi-</option>
                        <?php 
                          foreach($menu as $row1){
                            echo '<option value="'.$row1->idmenu_diet.'">'.$row1->nama_menu.' | '.$row1->komposisi.'</option>';
                          }
                        ?>                        
                      </select>                      
                    </div>
                  </div>

                  <!--<div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Grup Report</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="grupreport" id="grupreport" required onchange="grupreport_change(this.value)">
                        <option value="">-Pilih Grup Report-</option>
                        <?php 
                          /*foreach($grupreport as $row1){
                            echo '<option value="'.$row1->grupreport.'">'.$row1->grupreport.'</option>';
                          }*/
                        ?>
                        <option value="a">Lainnya</option>
                      </select>
                      <input type="text" class="form-control" name="grupreport_lain" id="grupreport_lain" >
                    </div>
                  </div>

                </div>-->

                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Tambah Menu Diet Baru</button>
                </div>
              </div>
            </div>
          </div>
          
          </form>
        </div>
    <hr>
          <br/> 
          <br/> 
          
                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" id="tablemenudiet">
                            <thead>
                                <tr>
                                    <th>ID Diet</th>
                                    <th>ID Diet</th>
                                    <th>Nama Diet</th>
                                    <th>Nama Menu</th>
                                    <th>Komposisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>                            
                        </table>
          
            
             <!--   <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_keltind('<?php //echo $row->idpokdiet;?>')"><i class="fa fa-edit"></i></button>
          <a type="button" class="btn btn-danger btn-xs" href="<?php //echo base_url('master/mckeltind/delete_keltind/'.$row->idpokdiet)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>-->

           
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <form class="form-horizontal" method="POST" id="formeditmenudiet">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Menu Diet</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Menu Diet</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_iddiet" id="edit_iddiet" disabled>
                      <input type="hidden" class="form-control" name="edit_iddiet_hidden" id="edit_iddiet_hidden">
                    </div>
                  </div>
                                                
               <!--  </div>
                </div> -->
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Kelompok Diet</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="edit_keldiet" id="edit_keldiet" required>
                        <option value="">-Pilih Kelompok Diet-</option>
                        <?php 
                          foreach($keldiet as $row1){
                            echo '<option value="'.$row1->idpokdiet.'">'.$row1->pokdiet.'</option>';
                          }
                        ?>                        
                      </select>                      
                    </div>
                  </div>

                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Menu Gizi</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="edit_idmenu_diet" id="edit_idmenu_diet" required>
                        <option value="">-Pilih Menu Gizi-</option>
                        <?php 
                          foreach($menu as $row1){
                            echo '<option value="'.$row1->idmenu_diet.'">'.$row1->nama_menu.' | '.$row1->komposisi.'</option>';
                          }
                        ?>                        
                      </select>                      
                    </div>
                  </div>
        
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Menu Diet</button>
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
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
