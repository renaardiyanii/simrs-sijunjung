    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?>
    <head>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="/assets/mdb2/css/mdb.min.css" />
    </head>

    <script type='text/javascript'>
    $(function() {
      $('.auto_search_by_nocm').autocomplete({
        serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nocm',
        onSelect: function (suggestion) {
          $('#cari_no_cm').val(''+suggestion.no_cm);
          $('#no_medrec_baru').val(''+suggestion.no_medrec);
        }
      });

      $('#tbl-rawatjalan').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          }
      });

      $('#tbl-rawatdarurat').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          }
      });

      $('#tbl-rawatinap').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          }
      });

      table_lab = $('#table_lab').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          },
          columns: [
                { data: "nm_tindakan" },
                { data: "hasil" },
            ],
          // "serverSide": true,

      });

      $('#tbl-ok').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          }
      });

      table_obat = $('#table_obat').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          },
          columns: [
                { data: "tgl_kunjungan" },
                { data: "nama_obat" },
                { data: "item_obat" },
                { data: "signa" },
            ],
      });

      table_radiologi = $('#table_radiologi').DataTable({
          "language": {
          "emptyTable": "Data tidak tersedia."
          },
          columns: [
                { data: "nm_dokter" },
                { data: "hasil_1" },
                { data: "hasil_2" },
                { data: "hasil_3" },
                { data: "hasil_4" },
                { data: "hasil_5" },
                { data: "hasil_pengirim" },
            ],
      })    
    });

    function data_lab(no_reg) {
      // var result;
      var lab = document.getElementById("detail-lab");
      var far = document.getElementById("detail-farm");
      var rad = document.getElementById("detail-rad");

      lab.style.display = "block";
      far.style.display = "none";
      rad.style.display = "none";
  
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('emedrec/C_emedrec/get_detail_lab')?>",
        data: {
          no_reg: no_reg
        },
        success: function(data){
          // data = JSON.parse(data);
          table_lab.clear().draw();
          table_lab.rows.add(data);
          table_lab.columns.adjust().draw(); 
        },
        error: function(){
          alert("error");
        }
      });
    }

    function data_obat(no_reg) {
      // var result;
      var lab = document.getElementById("detail-lab");
      var far = document.getElementById("detail-farm");
      var rad = document.getElementById("detail-rad");

      lab.style.display = "none";
      far.style.display = "block";
      rad.style.display = "none";
  
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('emedrec/C_emedrec/get_detail_obat')?>",
        data: {
          no_reg: no_reg
        },
        success: function(data){
          // data = JSON.parse(data);
          table_obat.clear().draw();
          table_obat.rows.add(data);
          table_obat.columns.adjust().draw(); 
        },
        error: function(){
          alert("error");
        }
      });
    }  

    function data_radiologi(no_reg) {
      // var result;
      var lab = document.getElementById("detail-lab");
      var far = document.getElementById("detail-farm");
      var rad = document.getElementById("detail-rad");

      lab.style.display = "none";
      far.style.display = "none";
      rad.style.display = "block";
  
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('emedrec/C_emedrec/get_detail_radiologi')?>",
        data: {
          no_reg: no_reg
        },
        success: function(data){
          // data = JSON.parse(data);
          table_radiologi.clear().draw();
          table_radiologi.rows.add(data);
          table_radiologi.columns.adjust().draw(); 
        },
        error: function(){
          alert("error");
        }
      });
    }  
    </script>
    
    <?php echo $this->session->flashdata('success_msg'); ?>
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-2">
            <?php 
                $attributes = array('class' => '');
                echo form_open('emedrec/C_emedrec/pasien', $attributes);?>
              <div class="form-outline">
                  <input type="search" id="cari_no_cm" name="cari_no_cm" class="auto_search_by_nocm form-control" />
                  <label class="form-label" for="cari_no_cm">NO. RM</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-action">
                <button type="submit" class="btn waves-effect waves-light btn-info" type="button">
                  <i class="fa fa-search"></i> Cari Pasien
                </button>
              </div> 
            </div>
            <?php echo form_close();?>

            <div class="col-md-4">
            <?php
                if ($data_pasien!="") {
                  foreach($data_pasien as $row){
                  ?>

                  <div class="row">
                    <div class="col-md-7">
                      <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                        <input type="text" id="nama" name="" class="form-control" value="<?php echo strtoupper($row->nama);?>" readonly/>
                        <label class="form-label" for="nama">Nama</label>
                      </div>
                    </div>

                    <div class="col-md-5">
                      <?php
                        if($row->sex == "L"){
                      ?>
                        <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                          <input type="text" id="gender" name="gender" class="form-control" value="LAKI-LAKI" readonly/>
                          <label class="form-label" for="gender">Jenis Kelamin</label>
                        </div>
                      
                      <?php
                        }
                        else{
                      ?>
                      <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                          <input type="text" id="gender" name="gender" class="form-control" value="PEREMPUAN" readonly/>
                          <label class="form-label" for="gender">Jenis Kelamin</label>
                        </div>
                      <?php
                        }
                      ?>
                      
                    </div>
                  </div>
                  
                                   
                  <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                    <input type="text" id="no_cm" name="no_cm" class="form-control" value="<?php echo strtoupper($row->no_cm);?>" readonly/>
                    <label class="form-label" for="no_cm">No. RM</label>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-7">
                      <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                        <input type="text" id="tmpt_lahir" name="tmpt_lahir" class="form-control" value="<?php echo strtoupper($row->tmpt_lahir);?>" readonly/>
                        <label class="form-label" for="tmpt_lahir">Tempat Lahir</label>
                      </div>
                    </div>
                    
                    <div class="col-md-5">
                      <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                        <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control" value="<?php echo substr($row->tgl_lahir,0,10);?>" readonly/>
                        <label class="form-label" for="tgl_lahir">Tanggal Lahir</label>
                      </div>
                    </div>
                  </div>
                  

                  <div class="form-outline" style="margin-bottom: calc(var(--bs-gutter-x)/2)">
                    <textarea type="text" id="alamat" name="alamat" rows="4" class="form-control" readonly><?php echo strtoupper($row->alamat);?></textarea>
                    <label class="form-label" for="no_cm">Alamat</label>
                  </div>
                  
              <?php
              
              }}
              ?>
            </div>

            <?php
              if ($data_pasien != "") {
                foreach($data_pasien as $row){
            ?>
            <div class="col-md-4">
              <a href="<?php echo site_url('irj/rjcregistrasi/cetak_identitas/').'/'.$row->no_cm; ?>" type="button" class="btn waves-effect waves-light btn-floating btn-info"  target="_blank">
                <i class="fas fa-print"></i>
              </a>
              <button class="btn waves-effect waves-light btn-floating btn-danger" type="button">
                <i class="fas fa-edit"></i>
              </button>
            </div>
            <?php
                }}
            ?>
          </div>

          <div class="row">
            <div class="col-md-12">
            
            
            </div> 
          </div>          
        </div>          
      </div>
    </div>
                
    <div class="container-fluid">
      <!-- Tabs navs -->
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header">
                  <ul class="nav nav-tabs nav-justified card-header-tabs" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a
                        class="nav-link active"
                        id="ex1-tab-rawatjalan"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-rawatjalan"
                        role="tab"
                        aria-controls="ex1-tabs-rawatjalan"
                        aria-selected="true"
                        >Rawat Jalan</a
                      >
                    </li>
                    <li class="nav-item" role="presentation">
                      <a
                        class="nav-link"
                        id="ex1-tab-rawatinap"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-rawatinap"
                        role="tab"
                        aria-controls="ex1-tabs-rawatinap"
                        aria-selected="false"
                        >Rawat Inap</a
                      >
                    </li>
                    <li class="nav-item" role="presentation">
                      <a
                        class="nav-link"
                        id="ex1-tab-rawatdarurat"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-rawatdarurat"
                        role="tab"
                        aria-controls="ex1-tabs-rawatdarurat"
                        aria-selected="false"
                        >Rawat Darurat</a
                      >
                    </li>
                    
                    <!-- <li class="nav-item" role="presentation">
                      <a
                        class="nav-link"
                        id="ex1-tab-lab"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-lab"
                        role="tab"
                        aria-controls="ex1-tabs-lab"
                        aria-selected="false"
                        >Laboratorium</a
                      >
                    </li>
                    <li class="nav-item" role="presentation">
                      <a
                        class="nav-link"
                        id="ex1-tab-ok"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-ok"
                        role="tab"
                        aria-controls="ex1-tabs-ok"
                        aria-selected="false"
                        >OK</a
                      >
                    </li>
                    <li class="nav-item" role="presentation">
                      <a
                        class="nav-link"
                        id="ex1-tab-farmasi"
                        data-mdb-toggle="tab"
                        href="#ex1-tabs-farmasi"
                        role="tab"
                        aria-controls="ex1-tabs-farmasi"
                        aria-selected="false"
                        >Farmasi</a
                      >
                    </li> -->
                  </ul>
                  <!-- Tabs navs -->
            </div>
            <div class="card-body">
                <div class="row">
                  

                  <!-- Tabs content -->
                  <div class="tab-content" id="ex2-content">
                    <!-- Rawat Jalan-->
                    <div class="tab-pane fade show active" id="ex1-tabs-rawatjalan" role="tabpanel" aria-labelledby="ex1-tab-rawatjalan">
                      <div class="table-responsive m-t-0">
                      <table id="tbl-rawatjalan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
                          <tr>
                            <th>No. Registrasi</th>
                            <th>Tanggal</th>
                            <th>Poliklinik</th>								
                            <th>Dokter</th>
                            <th>Diagnosa</th>
                            <th>Laboratorium</th>
                            <th>Radiologi</th>
                            <th>Farmasi</th>
                            <!-- <th width="100px">Aksi</th> -->
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          if ($data_pasien_irj != "") {
                            foreach($data_pasien_irj as $row){
                            ?>
                            <tr>
                              <td><a href=""><?php echo $row->noregister;?></a></td>
                              <td><?php echo $row->tgl;?></td>
                              <td><?php echo $row->dokter;?></td>									
                              <td><?php echo $row->poli;?></td>
                              <td><?php echo $row->diagnosa;?></td>
                              <td><button class="btn btn-success btn-rounded" style='margin-bottom: 3px;' onclick="data_lab('<?php echo $row->noregister;?>')"><i class="fas fa-edit" style="margin-right: 3px"></i>Detail</button></td>
                              <td><button class="btn btn-danger btn-rounded" style='margin-bottom: 3px;' onclick="data_radiologi('<?php echo $row->noregister;?>')"><i class="fas fa-edit" style="margin-right: 3px"></i>Detail</button></td>
                              <td><button class="btn btn-primary btn-rounded" style='margin-bottom: 3px;' onclick="data_obat('<?php echo $row->noregister;?>')"><i class="fas fa-edit" style="margin-right: 3px"></i>Detail</button></td>
                              <!-- <td><a href="" class="btn btn-danger btn-xs" style='width:90px;margin-bottom: 3px;'>HTML</a></td> -->
                            </tr>
                          <?php } 
                            }
                          ?>
                        </tbody>
                      </table>
                      </div>
                    </div>

                    <!-- Rawat Inap-->
                    <div class="tab-pane fade" id="ex1-tabs-rawatinap" role="tabpanel" aria-labelledby="ex1-tab-rawatinap">
                    <div class="table-responsive m-t-0">
                      <table id="tbl-rawatinap" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
                          <tr>
                            <th>No. IPD</th>
                            <th>No. Registrasi</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>								
                            <th>Dokter</th>
                            <!-- <th>Tgl Lahir</th>
                            <th width="40px">Aksi</th> -->
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          if ($data_pasien_iri != "") {
                            foreach($data_pasien_iri as $row){
                            ?>
                            <tr>
                              <td><?php echo $row->no_ipd;?></td>
                              <td><?php echo $row->noregasal;?></td>
                              <td><?php echo $row->tgl_masuk;?></td>	
                              <td><?php echo $row->tgl_keluar;?></td>								
                              <td><?php echo $row->dokter;?></td>
                            </tr>
                          <?php } 
                            }
                          ?>
                        </tbody>
                      </table>
                      </div>
                    </div>

                    <!-- Rawat Darurat-->
                    <div class="tab-pane fade" id="ex1-tabs-rawatdarurat" role="tabpanel" aria-labelledby="ex1-tab-rawatdarurat">
                    <div class="table-responsive m-t-0">
                      <table id="tbl-rawatdarurat" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
                          <tr>
                            <th>No. Registrasi</th>
                            <th>Tanggal</th>
                            <th>Poliklinik</th>								
                            <th>Dokter</th>
                            <th>Diagnosa</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                          if ($data_pasien_ird !="") {
                            foreach($data_pasien_ird as $row){
                            ?>
                            <tr>
                              <td><a href=""><?php echo $row->noregister;?></a></td>
                              <td><?php echo $row->tgl;?></td>
                              <td><?php echo $row->dokter;?></td>									
                              <td><?php echo $row->poli;?></td>
                              <td><?php echo $row->diagnosa;?></td>
                            </tr>
                          <?php } 
                            }
                          ?>
                        </tbody>
                      </table>
                      </div>
                    </div>
                  </div>
                  <!-- Tabs content -->
                  </div> 
                </div>
              
        </div>
      </div>
    </div>

    <div class="container-fluid" id="detail-lab" style="display: none">
      <div class="row">
        <div class="card">
          <div class="card-header">
            <h3>Detail Laboratorium</h3>
          </div>
          <div class="card-body">
            <table id="table_lab" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
              <thead>
                <tr>
                  <th>Jenis Tindakan</th>
                  <th>Hasil Lab</th>
                </tr>
              </thead>
              <tbody>
              
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid" id="detail-farm" style="display: none">
      <div class="row">
        <div class="card">
          <div class="card-header">
            <h3>Detail Farmasi</h3>
          </div>
          <div class="card-body">
            <table id="table_obat" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Obat</th>
                  <th>Qty</th>
                  <th>Signa</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid" id="detail-rad" style="display: none">
      <div class="row">
        <div class="card">
          <div class="card-header">
            <h3>Detail Radiologi</h3>
          </div>
          <div class="card-body">
            <table id="table_radiologi" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama Dokter</th>
                  <th>Hasil 1</th>
                  <th>Hasil 2</th>
                  <th>Hasil 3</th>								
                  <th>Hasil 4</th>
                  <th>Hasil 5</th>
                  <th>Hasil Pengirim</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if ($data_pasien!="") {
                  foreach($data_pasien as $row){
                  ?>
                  <tr>
                    <td><?php echo $row->no_cm;?></td>
                    <td><?php echo strtoupper($row->nama);?></td>
                    <td><?php echo $row->jenis_identitas." - ".$row->no_identitas;?></td>
                    <td><?php echo $row->no_kartu;?></td>									
                    <td><?php echo $row->alamat;?></td>
                    <td><?php echo date('d-m-Y',strtotime($row->tgl_lahir));?></td>
                    <td>
                      <a href="<?php echo site_url('irj/rjcregistrasi/daftarulang/'.$row->no_medrec); ?>" class="btn btn-primary btn-xs" style='width:85px;margin-bottom: 3px;'>Daftar Ulang</a><br>
                      <a href="<?php echo site_url('medrec/el_record/pasien/'.$row->no_medrec); ?>" class="btn btn-danger btn-xs" style='width:85px;'>Rekam Medik</a>
                      <!--<a href="<?php echo site_url('medrec/Rme/histori/'.$row->no_cm); ?>" class="btn btn-danger btn-xs" target='_blank' style='width:85px;'>Rekam Medik</a>-->
                    </td>
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
    
    <!-- MDB -->
    <script type="text/javascript" src="/assets/mdb2/js/mdb.min.js"></script>
    <!-- Custom scripts -->
    <script type="text/javascript">
      var a = document.getElementById('disc-50');
      a.onclick = function () {
        Clipboard_CopyTo("T9TTVSQB");
        var div = document.getElementById('code-success');
        div.style.display = 'block';
        setTimeout(function () {
          document.getElementById('code-success').style.display = 'none';
        }, 900);
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