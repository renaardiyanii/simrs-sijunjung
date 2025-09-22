<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>

    <script type='text/javascript'> 
    $(function() {
      $('.auto_search_by_nocm').autocomplete({
        serviceUrl: '<?php echo site_url();?>/emedrec/C_emedrec_autocomplete/data_pasien_by_nocm',
        onSelect: function (suggestion) {
          $('#cari_no_cm').val(''+suggestion.no_cm);
          $('#no_medrec_baru').val(''+suggestion.no_medrec);
        }
      });

      table_pasien = $('#table_pasien').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          },
          // "serverSide": true,
      });
    }); 
    </script>
    
    <?php echo $this->session->flashdata('success_msg'); ?>

    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-2">
            <?php 
                $attributes = array('class' => '');
                echo form_open('emedrec/C_emedrec_iri/pasien_iri', $attributes);?>
              <div class="form-outline">
                  <input type="search" id="cari_no_cm" name="cari_no_cm" class="auto_search_by_nocm form-control" />
                  <label class="form-label" for="cari_no_cm">NO. RM</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-action">
                <button  class="btn waves-effect waves-light btn-info" type="submit">
                  <i class="fa fa-search"></i> Cari Pasien
                </button>
              </div> 
            </div>
            <?php echo form_close();?>       
        </div>          
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-body">
              <table id="table_pasien" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
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
                    <td><?php echo $row->tgl_lahir;?></td>
                    <td><?php echo $row->tmpt_lahir;?></td>
                    <td><a class="btn  waves-effect waves-light btn-floating btn-info" style='margin-bottom: 3px;' href="<?php echo site_url('emedrec/C_emedrec_iri/rekam_medis_detail/'.$row->no_cm); ?>"><i class="fas fa-folder" style="margin-right: 3px"></i></button></td>
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
      
                
    

    
    
    <!-- MDB -->
    <script type="text/javascript" src="<?php echo site_url('/assets/mdb2/js/mdb.min.js'); ?>"></script>
    <!-- Custom scripts -->
    <script type="text/javascript">
      var a = document.getElementById('disc-50');
      // a.onclick = function () {
      //   Clipboard_CopyTo("T9TTVSQB");
      //   var div = document.getElementById('code-success');
      //   div.style.display = 'block';
      //   setTimeout(function () {
      //     document.getElementById('code-success').style.display = 'none';
      //   }, 900);
      };

      function Clipboard_CopyTo(value) {
        var tempInput = document.createElement("input");
        tempInput.value = value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
      }
    </script>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>