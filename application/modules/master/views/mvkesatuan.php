    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 

    <style type="text/css">
.demo-radio-button label{min-width:120px;margin-top: 13px;font-size: 14px;}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.card-actions a {
    cursor: pointer;
    color: #ffffff;
    opacity: 1;
    padding-left: 12px;
    font-size: 14px;
}
</style>

<div class="row"> 
  <div class="card-block"> 
    <div class="col-md-12">
      <div class="card">          
        <div class="card-body bg-primary">
          <h4 class="text-white card-title mb-0">Daftar Kesatuan</h4>                                   
        </div>
        <div class="card-body">
          <div class="message-box contact-box">
              <h2 class="add-ct-btn"><button type="button" class="btn btn-circle btn-lg btn-success waves-effect waves-dark">+</button></h2>
              <br>


           
            <div id="accordion" class="nav-accordion" role="tablist" aria-multiselectable="true">
              <?php //$kesatuan_1 = '';
                    foreach ($kesatuan1 as $item) { 
                      //if ($kesatuan_1 != $item->kst_id) { ?>
                        <div class="card card-outline-danger m-b-15">                          
                            <div class="card-header" role="tab" id="heading-<?php echo $item->kst_id; ?>">
                              <div class="card-actions">
                                  <a href="javascript:void(0)" class="text-white" data-toggle="tooltip" title="" data-original-title="Tambah"><i class="fa fa-plus"></i></a>
                                  <a href="javascript:void(0)" class="text-white" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                  <a href="javascript:void(0)" class="text-white" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                              </div>
                              <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $item->kst_id; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $item->kst_id; ?>">
                                <h5 class="mb-0 text-white"><?php echo $item->kst_nama; ?></h5> 
                              </a>
                            </div> 
                          
                          <div id="collapse-<?php echo $item->kst_id; ?>" class="collapse" role="tabpanel" aria-labelledby="heading-<?php echo $item->kst_id; ?>" aria-expanded="false" style="">
                              <div class="card-block"> 

                                <?php //$kesatuan_1 = '';
                                      foreach ($kesatuan2 as $kes2) {                                         
                                        if ($kes2->kst_id == $item->kst_id) {  ?>
                                       <div id="accordion2-<?php echo $kes2->kst2_id; ?>" class="nav-accordion" role="tablist" aria-multiselectable="true">
                                          <div class="card card-outline-info m-b-15">                                            
                                            <div class="card-header" role="tab" id="heading2-<?php echo $kes2->kst2_id; ?>">
                                              <div class="card-actions">
                                                  <a href="javascript:void(0)" class="text-white" data-toggle="tooltip" title="" data-original-title="Tambah"><i class="fa fa-plus"></i></a>
                                                  <a href="javascript:void(0)" class="text-white" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                  <a href="javascript:void(0)" class="text-white" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>
                                              </div>
                                              <a class="collapsed" data-toggle="collapse" data-parent="#accordion2-<?php echo $kes2->kst2_id; ?>" href="#collapse2-<?php echo $kes2->kst2_id; ?>" aria-expanded="false" aria-controls="collapse2-<?php echo $kes2->kst2_id; ?>">
                                                <h5 class="mb-0 text-white"><?php echo $kes2->kst2_nama; ?></h5>
                                              </a> 
                                            </div> 
                                            <div id="collapse2-<?php echo $kes2->kst2_id; ?>" class="collapse" role="tabpanel" aria-labelledby="heading2-<?php echo $kes2->kst2_id; ?>" aria-expanded="false" style="">
                                                <div class="card-block"> 
                                                  <div class="table-responsive">
                                                      <table class="table product-overview">       
                                                          <tbody>
                                                            <?php foreach ($kesatuan3 as $kes3) { 
                                                                    if ($kes3->kst2_id == $kes2->kst2_id) { ?>
                                                                    <tr>
                                                                        <td width="90%"><?php echo $kes3->kst3_nama; ?> </td>                                                
                                                                        <td width="10%"><a href="javascript:void(0)" class="text-inverse p-r-10" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-pencil-square-o"></i></a> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a></td>
                                                                    </tr> 
                                                            <?php   } 
                                                                  } ?>                                                   
                                                          </tbody>
                                                      </table>
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                
                                     <?php   }
                                      //$kesatuan_1 = $item->kst_id; 
                                      } ?>

                              </div>
                          </div>
                        </div>
                      <?php 
                      //}
                    //$kesatuan_1 = $item->kst_id; 
                    } ?>
            </div> <!-- accordion -->




            <br/>
            <button id="btnRefresh" class="btn btn-warning">Refresh</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 


<script type='text/javascript'>
$(function() {
  $('#btnAdd').addClass('disabled');
  $( "#dialog-confirm" ).hide();
  $('#btnSimpan').click(function(){
    $.ajax({
      type: 'POST',
      url: $('#idform').attr( 'action' ),
      data: $('#idform').serialize(),
      success: function( response ) {
        if(!response.success)
        {
          //set_feedback(response.message,'error_message',true);
        }
        else
        {
          //set_feedback(response.message,'success_message',false);
          window.location.reload(true);
        }
      },
      dataType:'json'
    });
  });
  $('#accordion').accordion({
        collapsible: true,
        active: false,
        height: 'fill',
        header: '> div > .h3'
    }).sortable({
        items: '.s_panel',
    update: function (event, ui) {
      var a = $(this).sortable("serialize", {
        attribute: "id"
      });
      var r = $(this).sortable( "toArray" );
      $.ajax({
        data: {data:r},
        type: 'POST',
        url: '<?php echo site_url('admin/updateOrderMenu'); ?>',
        success: function( response ) {
          //alert(response);
        }
      });
    }
    });

    $('#accordion').on('accordionactivate', function (event, ui) {
        if (ui.newPanel.length) {
            $('#accordion').sortable('disable');
        } else {
            $('#accordion').sortable('enable');
        }
    });
  
  $( ".sortable" ).sortable({
    update: function (event, ui) {
      var a = $(this).sortable("serialize", {
        attribute: "id"
      });
      var r = $(this).sortable( "toArray" );
      $.ajax({
        data: {data:r},
        type: 'POST',
        url: '<?php echo site_url('admin/updateOrderMenu'); ?>',
        success: function( response ) {
          //alert(response);
        }
      });
    }
  });
    
  $( "#btnRefresh" ).click(function() {
    window.location.reload(true);
  });
  
  $( "#btnAdd" ).click(function() {   
    $("#id").val('');
    $("#title").val('');
    $("#url").val('');
    $("#parent_id").val(0);
  });
});

function editMenu(vid){
  $.ajax({
    data: {id:vid},
    type: 'POST',
    url: '<?php echo site_url('admin/menuInfo'); ?>',
    dataType:'json',
    success: function( response ) {
      $('#btnAdd').removeClass('disabled');
      $("#id").val(response.page_id);
      $("#title").val(response.title);
      $("#url").val(response.url);
      $("#parent_id").val(response.parent_id);      
    }
  });
  return false;
}

function dropMenu(vid){
  $.ajax({
    data: {id:vid},
    type: 'POST',
    url: '<?php echo site_url('admin/hasChildMenu'); ?>',
    dataType:'json',
    success: function( response ) {
      if (response.hasChild){
        $( "#dialog-confirm" ).html("Menu memiliki submenu. <br/>Menu tidak dapat dihapus.");
        $( "#dialog-confirm" ).dialog({
          resizable: false,
          modal: true,
          buttons: {
          "Oke": function() {
            $( this ).dialog( "close" );
          }
          }
        });
      }else{
        swal({
              title: "Hapus Menu",
              text: "Yakin akan menghapus menu tersebut?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Hapus",
              showLoaderOnConfirm: true,
              closeOnConfirm: true
              }, function() {
            $.ajax({
              data: {id:vid},
              type: 'POST',
              url: '<?php echo site_url('admin/dropMenu'); ?>',
              dataType:'json',
              success: function( response ) {
                if (response.success){
                  window.location.reload(true);
                  swal("Sukses","Berhasil menghapus data.", "success"); 
                }else swal("Error","Gagal menghapus data.", "error"); 
              }
            });           
            });
      
      }
    }
  });
  
  return false;
}
</script>