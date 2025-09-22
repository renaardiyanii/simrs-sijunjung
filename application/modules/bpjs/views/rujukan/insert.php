<?php
  if ($role_id == 1) {
      $this->load->view("layout/header_left");
  } else {
      $this->load->view("layout/header_horizontal");
  }
?>


<div class="card">
  <div class="card-header">
    Pembuatan Rujukan
  </div>
  <div class="card-body m-4">
    <form id="formrujukan">
        <div class="mb-3 row">
            <label for="tipeRujukan" class="col-sm-4 col-form-label">Tipe Rujukan</label>                  
            <div class="demo-radio-button  ml-4">                    
                <input class="with-gap" type="radio" name="tipeRujukan" value="0" id="penuh" required onchange="changeRujukan('penuh')">
                <label for="penuh">Penuh</label>
                <input class="with-gap" type="radio" name="tipeRujukan" value="1" id="partial" required onchange="changeRujukan('parsial')">
                <label for="partial">Partial</label>
                <input class="with-gap" type="radio" name="tipeRujukan" value="2" id="rujuk_balik" required onchange="changeRujukan('balik')">
                <label for="rujuk_balik">Rujuk Balik</label>
            </div>  
        </div>
        <div class="mb-3 row">
            <input type="hidden" name="noSEP" id="nosepupdate" value="<?= $nosep ?>">
            <label for="tgl" class="col-sm-4 col-form-label">Tgl. Rujukan</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" id="tgl" name="tgl" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jnsPelayanan" class="col-sm-4 col-form-label">Pelayanan</label>
            <div class="col-sm-8">
                <select name="jnsPelayanan" id="jnsPelayanan" class="form-control" required >
                    <option value="">--Pilih Pelayanan--</option>
                    <option value="2" selected>Rawat Jalan</option>
                    <option value="1">Rawat Inap</option>
                </select>
            </div>
        </div>

        

        <div class="mb-3 row">
            <label for="jnsPelayanan" class="col-sm-4 col-form-label">Diagnosa</label>
            <div class="col-sm-8">
                <select class="form-control" name="diagnosa" id="diagnosa" style="width: 100%;" required>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jnsPelayanan" class="col-sm-4 col-form-label">Kode Faskes</label>
            <div class="col-sm-8">
                <select class="form-control" id="kodefaskes" onchange="gantiFaskes(this.value)">
                  <option value="">Silahkan Dipilih</option><option value="1">Faskes 1</option><option value="2" >Faskes 2 / RS</option>
                </select>
            </div>
        </div>
        

        <div class="mb-3 row">
            <label for="ppk_dirujuk"  class="col-sm-4 col-form-label">Dirujuk ke</label>
            <div class="col-sm-8">
              <select class="form-control" name="ppk_dirujuk" id="ppk_dirujuk" style="width: 100%;" required onchange="showSpesialis(this.value)">             
              </select>
            </div>
        </div>  
        <!-- <div class="mb-3 row">
            <label for="spesialis"  class="col-sm-4 col-form-label">Spesialis/Subspesialis</label>
            <div class="col-sm-8">
              <select class="form-control" name="spesialis" id="spesialis" style="width: 100%;" required>             
              </select>
            </div>
        </div>     -->
        <input type="hidden" name="spesialis" id="spesialis">
        <table class="isspesialisshow table">
          <tr>
            <th>Spesialis</th>
            <th>Kapasitas</th>
            <th>Jumlah Rujukan</th>
            <th>Persentase</th>
          </tr>
          <tbody id="hasil"></tbody>
        </table>

        <div class="form-group">
            <label for="catatan">Catatan Rujukan</label>
            <textarea class="form-control" name="catatan" id="catatan" cols="30" rows="5" placeholder="Isi catatan apabila ada."></textarea>
        </div>
    </form>
    <button id="btnsubmit" class="btn btn-primary" onclick="insertrujukan()">Simpan</button>
  </div>
</div>
<script>

  $(document).ready(function(){
    $(".isspesialisshow").hide();
  });

  function changeRujukan(tiperujukan)
  {
    if(tiperujukan == 'penuh')
    {
      $("#kodefaskes").val('2');
      gantiFaskes('2');
    }else if(tiperujukan == 'balik')
    {
      var now = new Date();

      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);

      var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

      $("#tgl").val(today)
      $("#kodefaskes").val('1');
      gantiFaskes('1');
    }
  }

  function setSpesialis(v)
  {
    $("#" + $("#spesialis").val() +"-btn").removeClass("btn-primary");
    $("#spesialis").val(v);
    $("#" + v +"-btn").addClass("btn-primary");
  }

  function showSpesialis(v)
  {
    console.log($('[name="tipeRujukan"]').val());
    if($('input[name="tipeRujukan"]:checked').val() == '1' || $('input[name="tipeRujukan"]:checked').val() == '2'){
      console.log("MASUK SINI");
      return;
    }
    $(".isspesialisshow").hide();
    
    $.ajax({
      url: "<?php echo base_url().'bpjs/rujukan/list_spesialistik_rujukan?ppkrujukan='; ?>" + v + '&tglrujukan=' + $("#tgl").val(),
      success: function(result) {  
        if (result.metaData.code == '200') {   
          html = '';
          result.response.list.map((e)=>{
            html+=`
            <tr>
              <td>
              <button id="${e.kodeSpesialis}-btn" class="btn" type="button"  onclick="setSpesialis('${e.kodeSpesialis}')">${e.namaSpesialis}</button></td>
              <td>${e.kapasitas}</td>
              <td>${e.jumlahRujukan}</td>
              <td>${e.persentase}</td>
            </tr>
            `;
          });  
          $("#hasil").html(html);
          $(".isspesialisshow").show();
            
        } else {
          $("#hasil").html("");
          $(".isspesialisshow").hide();
          swal("Peringatan", result.metaData.message, "error");   
        }           
      },
      error:function(event, textStatus, errorThrown) {    
          swal("Gagal ",formatErrorMessage(event, errorThrown), "error");    
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    }); 
  }

  function insertrujukan(){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/rujukan/create'; ?>",
        dataType: "JSON", 
        data: $("#formrujukan").serialize(),
        success: function(result) {  
          if (result.metaData.code == '200') {     
            window.open('<?php echo base_url().'bpjs/rujukan/cetak_rujukan/'; ?>'+result.response.rujukan.noRujukan, '_blank');
            swal("Sukses", "Silahkan Cetak Rujukan", "success");       
          } else {
            swal("Gagal Membuat Rujukan", result.metaData.message, "error");   
          }           
        },
        error:function(event, textStatus, errorThrown) {    
            $("#btn-create").html('<i class="fa fa-paper-plane-o"></i> Buat Rujukan'); 
            $('#modal-create').modal('hide');
            swal("Gagal Membuat Rujukan",formatErrorMessage(event, errorThrown), "error");    
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      }); 
  }

  // $('#spesialis').select2({
  //     placeholder: '-- Ketik Kode atau Nama Poli --',
  //     minimumInputLength: 3,
  //     language: { inputTooShort: function () { return 'Ketik minimal 3 Karakter'; } },
  //     ajax: {
  //       type: 'GET',
  //       url: '<?php //echo base_url().'bpjs/referensi/poliklinik'; ?>',
  //       dataType: 'JSON',          
  //       delay: 250,
  //       processResults: function (data) {            
  //         return {
  //           results: data
  //         };
  //       },
  //       cache: true
  //     }
  //   });
    $('#diagnosa').select2({
      placeholder: '-- Ketik Kode atau Nama Diagnosa --',
      minimumInputLength: 3,
      language: { inputTooShort: function () { return 'Ketik minimal 3 Karakter'; } },
      ajax: {
        type: 'GET',
        url: '<?php echo base_url().'bpjs/referensi/diagnosa_select2'; ?>',
        dataType: 'JSON',          
        delay: 250,
        processResults: function (data) {            
          return {
            results: data
          };
        },
        cache: true
      }
    });

    

    function gantiFaskes(val)
    {
      $('#ppk_dirujuk').select2({
        placeholder: '-- Ketik Kode atau Nama PPK --',
        minimumInputLength: 3,
        language: { inputTooShort: function () { return 'Ketik minimal 3 Karakter'; } },
        ajax: {
          type: 'GET',
          url: '<?php echo base_url().'bpjs/referensi/faskes_select2'; ?>',
          data: function (term, page) {
            return {
              q: term,
              asal_rujukan: val
            };
          },
          dataType: 'JSON',          
          delay: 250,
          processResults: function (data) {            
            return {
              results: data
            };
          },
          cache: true
        }
      });
    }
</script>

<?php
  if ($role_id == 1) {
      $this->load->view("layout/footer_left");
  } else {
      $this->load->view("layout/footer_horizontal");
  }
?>