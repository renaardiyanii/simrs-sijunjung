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

    var v00 = $("#forminputmenu").validate({
      rules: {
        iddiet: {
          required: true
        },
        namadiet: {
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
          var formData = new FormData( $("#forminputmenu")[0] );
          console.log(formData);
          $.ajax({
            type:'post',
            url: "<?php echo base_url('master/mcgizi/insert_menu/')?>",
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
                    tablemenu();
                    selectTipeMakanan();
            },
            error: function(){
                        alert("error");
            }
          });           
        }
    });

    var v01 = $("#formeditmenu").validate({
      rules: {
        edit_iddiet: {
          required: true,
          maxlength: 5          
        },
        edit_namadiet:{
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
        var formData = new FormData( $("#formeditmenu")[0] );
        $.ajax({
        type:'post',
        url: "<?php echo base_url('master/mcgizi/edit_menu/')?>",
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
                tablemenu();
        },
        error: function(){
                    alert("error");
        }
        });           
        }
    });

    tablemenu();
    $('#tipemakanan_lain').hide();
  }); 

  function tipemakanan_change(param1){
    if(param1=='a'){
      $('#tipemakanan_lain').show();
      $("#tipemakanan_lain").prop('required',true);
    }else{
      $('#tipemakanan_lain').hide();
      $("#tipemakanan_lain").prop('required',false);
    }
  }


  function tipemakananedit_change(param1){
    if(param1=='a'){
      $('#edit_tipemakanan_lain').show();
      $("#edit_tipemakanan_lain").prop('required',true);
    }else{
      $('#edit_tipemakanan_lain').hide();
      $("#edit_tipemakanan_lain").prop('required',false);
    }
  }

  function selectTipeMakanan()
  {
    $('#tipemakanan').empty();
    var dropDown = document.getElementById("tipemakanan");
    $('#edit_tipemakanan').empty();
    var dropDown = document.getElementById("edit_tipemakanan");
    //var carId = dropDown.options[dropDown.selectedIndex].value;
    $.ajax({
            type: "POST",
            url: "<?php echo base_url('master/mcgizi/get_tipemakanan/')?>",           
            success: function(data){
                // Parse the returned json data
                var opts = $.parseJSON(data);
                // Use jQuery's each to iterate over the opts value
                $.each(opts, function(i, d) {
                    // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                    $('#tipemakanan').append('<option value="' + d.tipe_makanan + '">' + d.tipe_makanan + '</option>');
                    $('#edit_tipemakanan').append('<option value="' + d.tipe_makanan + '">' + d.tipe_makanan + '</option>');
                });
                $('#tipemakanan').append('<option value="a">Lainnya</option>');
                $('#edit_tipemakanan').append('<option value="a">Lainnya</option>');
            }
        });
  }


  function edit_menu(idmenu_diet) {
    selectTipeMakanan();
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcgizi/get_data_edit_menu')?>",
      data: {
        idmenu_diet: idmenu_diet
      },
      success: function(data){
        //alert(data[0].iddiet);    
        $('#edit_tipemakanan_lain').hide();
        $('#edit_idmenu_diet').val(data[0].idmenu_diet);
        $('#edit_idmenu_diet_hidden').val(data[0].iddiet);
        $('#edit_komposisi').val(data[0].komposisi);        
        $('#edit_nama_menu').val(data[0].nama_menu);
        $('#edit_tipemakanan').val(data[0].tipe_makanan).change();
      },
      error: function(){
        alert("error");
      }
    });
  }

  function delete_menu(idmenu_diet) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcgizi/delete_menu')?>",
      data: {
        idmenu_diet: idmenu_diet
      },
      success: function(data){
        //alert(data[0].idpokdiet);
        alert("Data Berhasil Dihapus");
        tablemenu();
      },
      error: function(){
        alert("error");
      }
    });
  }

  function tablemenu(){
    table = $('#tablemenu').DataTable({
        ajax: "<?php echo site_url();?>master/mcgizi/show_menu/",
        columns: [
            { data: "idmenu_diet" },
            { data: "idmenu_diet" },
            { data: "nama_menu" },
            { data: "komposisi" },
            { data: "tipemakanan" },
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
          <h3 >DAFTAR Menu</h3><hr>
        </div>

        <div class="">

          <div class="col-xs-9">
          </div>

          
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Menu Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <form class="form-horizontal" method="POST" id="forminputmenu">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><i class="fa fa-plus"></i> Menu</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Nama Menu</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama_menu" id="nama_menu">
                    </div>
                  </div>  

                  <!--<div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Kelompok Diet</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="keldiet" id="keldiet" required>
                        <option value="">-Pilih Kelompok Diet-</option>
                        <?php 
                          /*foreach($keldiet as $row1){
                            echo '<option value="'.$row1->idpokdiet.'">'.$row1->pokdiet.'</option>';
                          }*/
                        ?>                        
                      </select>                      
                    </div>
                  </div>-->

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Tipe Makanan</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="tipemakanan" id="tipemakanan" required onchange="tipemakanan_change(this.value)">
                        <option value="">-Pilih Tipe Makanan-</option>
                        <?php 
                          foreach($tipemakanan as $row1){
                            echo '<option value="'.$row1->tipe_makanan.'">'.$row1->tipe_makanan.'</option>';
                          }
                        ?>
                        <option value="a">Lainnya</option>
                      </select>
                      <input type="text" class="form-control" name="tipemakanan_lain" id="tipemakanan_lain" >
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_komposisi">Komposisi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="komposisi" id="komposisi">
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
                  <button class="btn btn-primary" type="submit">Tambah Menu Baru</button>
                </div>
              </div>
            </div>
          </div>
          
          </form>
          </div>
    <hr>
          <br/> 
          <br/> 
          
                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" id="tablemenu">
                            <thead>
                                <tr>
                                    <th>ID Menu</th>
                                    <th>ID Menu</th>
                                    <th>Nama Menu</th>
                                    <th>Tipe Makanan</th>
                                    <th>Komposisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>                            
                        </table>
      
    </div>
</div>
</div>
</section>

<!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
              <form class="form-horizontal" method="POST" id="formeditmenu">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Menu</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Menu</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_iddiet" id="edit_idmenu_diet" disabled>
                      <input type="hidden" class="form-control" name="edit_idmenu_diet_hidden" id="edit_idmenu_diet_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Menu</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nama_menu" id="edit_nama_menu">
                    </div>
                  </div>                                 
               <!--  </div>
                </div> -->

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_pokdiet">Tipe Makanan</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="edit_tipemakanan" id="edit_tipemakanan" required onchange="tipemakananedit_change(this.value)">
                        <option value="">-Pilih Tipe Makanan-</option>
                        <?php 
                          foreach($tipemakanan as $row1){
                            echo '<option value="'.$row1->tipe_makanan.'">'.$row1->tipe_makanan.'</option>';
                          }
                        ?>
                        <option value="a">Lainnya</option>
                      </select>
                      <input type="text" class="form-control" name="edit_tipemakanan_lain" id="edit_tipemakanan_lain" >
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Komposisi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_komposisi" id="edit_komposisi">
                    </div>
                  </div>

        
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Menu</button>
                </div>
              </div>
            </div>
            </form>
          </div>          
        </div>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
