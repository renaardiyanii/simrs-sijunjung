<?php
  $this->load->view("layout/header_horizontal");        
?>
  <style type="text/css">
    .radio-naik-kelas label{min-width:70px;}
  </style>
  <script type="text/javascript">
    var table_diagnosa;
    var table_procedure; 
    $(function() {   
      tarif_rs();    
      $('#cetak_klaim').hide();
      $('#kirim_online').hide();    
      
      $('#div_upgrade_class_class').hide();
      $('#div_upgrade_class_los').hide();
      $('#div_add_payment_pct').hide();

      $('#div_icu_los').hide();
      $('#div_ventilator_hour').hide();

      $('#upgrade_class_ind').change(function () {
        if ($('#upgrade_class_ind').is(":checked")) {
          $('#div_upgrade_class_class').show();
          $('#div_upgrade_class_los').show();
          $('#div_add_payment_pct').show();
        } else {
          $('#div_upgrade_class_class').hide();
          $('#div_upgrade_class_los').hide();
          $('#div_add_payment_pct').hide();
        }
      });

      $('#icu_indicator').change(function () {
        if ($('#icu_indicator').is(":checked")) {
          $('#div_icu_los').show();
          $('#div_ventilator_hour').show();
        } else {
          $('#div_icu_los').hide();
          $('#div_ventilator_hour').hide();
        }
      });

      $(document).on("click",".reedit_claim",function() {
        var getLink = $(this).attr('href');
        swal({
          title: "Edit Ulang Klaim",
          text: "Batalkan status final dan edit ulang klaim?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya (edit ulang)",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
          }, function() {
              $.ajax({
                type: "POST",
                url: "<?php echo base_url().'ina_cbg/klaim/reedit_claim'; ?>",
                dataType: "JSON",
                data: {'nomor_sep' : getLink},
                success: function(result){  
                  if (result.metadata.code) {                  
                    if (result.metadata.code == '200') {
                      swal("Sukses", "Klaim berhasil di edit ulang.", "success");
                    } else {
                      swal("Error", result.metadata.message, "error");
                    }
                  } else {
                    swal("Error", "Koneksi Service Gagal.", "error");
                  }
                  get_status('<?php echo $no_register; ?>');
                },
                error:function(event, textStatus, errorThrown) {    
                  swal("Gagal edit ulang klaim",textStatus, "error");     
                  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
              });                          
        });
        return false;
      });

      $(document).on("click",".delete_claim",function() {      
        swal({
          title: "Hapus Klaim",
          text: "Hapus klaim tersebut?",
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
                url: "<?php echo base_url().'ina_cbg/klaim/delete_claim'; ?>",
                dataType: "JSON",
                data: {'nomor_sep' : '<?php echo $data_pasien->no_sep; ?>'},
                success: function(result){  
                  if (result.metadata.message) {                    
                    if (result.metadata.code == '200') {
                      swal("Sukses", "Klaim berhasil dihapus.", "success");
                    } else {
                      swal("Error", result.metadata.message, "error");
                    }
                  } else {
                    swal("Error", "Koneksi Service Gagal.", "error");
                  }
                },
                error:function(event, textStatus, errorThrown) {    
                  swal("Gagal menghapus klaim.",textStatus, "error");     
                  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
              });           
        });
        return false;
      });

      $(".autocomplete_diagnosa").autocomplete({  
        minLength: 2,  
        source : function( request, response ) {
            $.ajax({
              url: '<?php echo site_url('diagnosa/autocomplete_irj')?>',
              dataType: "json",
              data: {
                  term: request.term
              },
              success: function (data) {
                if(!data.length){
                  var result = [{
                   label: 'Data tidak ditemukan', 
                   value: response.term
                  }];
                  response(result);
                } else {
                  response(data);                  
                }                  
              }
            });
        },      
        minLength: 1,     
        select: function (event, ui) {          
            $('#diagnosa_separate').val(ui.item.id_icd+'@'+ui.item.nm_diagnosa);                    
        }
      }).on("focus", function () {
          $(this).autocomplete("search", $(this).val());
      }); 
      
      $(".autocomplete_procedure").autocomplete({  
        minLength: 2,  
        source : function( request, response ) {
            $.ajax({
              url: '<?php echo site_url('procedure/autocomplete_irj')?>',
              dataType: "json",
              data: {
                  term: request.term
              },
              success: function (data) {
                if(!data.length){
                  var result = [{
                   label: 'Data tidak ditemukan', 
                   value: response.term
                  }];
                  response(result);
                } else {
                  response(data);                  
                }                  
              }
            });
        },      
        minLength: 1,     
        select: function (event, ui) {          
            $('#procedure_separate').val(ui.item.id_tind+'@'+ui.item.nm_tindakan);                    
        }
      }).on("focus", function () {
          $(this).autocomplete("search", $(this).val());
      }); 

      $.ui.autocomplete.prototype._renderItem = function (ul, item) {        
        var t = String(item.value).replace(
                new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
                "<span class='ui-state-highlight'>$&</span>");
        return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a style='display:inline-block;width: 100%;'>" + t + "</a>")
            .appendTo(ul);
      };  
      $(".autocomplete_diagnosa").autocomplete("option", "appendTo", "#form_diagnosa");
      $(".autocomplete_procedure").autocomplete("option", "appendTo", "#form_procedure");  

      table_diagnosa = $('#table_diagnosa').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],
        "lengthMenu": [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "ajax": {
          "url": "<?php echo site_url('diagnosa/show_irj')?>",
          "type": "POST",
          "dataType": 'JSON',
          "data": function (data) {
            data.no_register = '<?php echo $no_register;?>';
          }        
        },
        "columnDefs": [{ 
          "orderable": false, //set not orderable
          "targets": [0,4] // column index 
        }],
      });

      table_procedure = $('#table_procedure').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],
        "lengthMenu": [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "ajax": {
          "url": "<?php echo site_url('procedure/show_irj')?>",
          "type": "POST",
          "dataType": 'JSON',
          "data": function (data) {
            data.no_register = '<?php echo $no_register;?>';
          }        
        },
        "columnDefs": [{ 
          "orderable": false, //set not orderable
          "targets": [0,4] // column index 
        }],
      });

      get_diagnosa('<?php echo $data_pasien->no_sep; ?>');
      get_procedure('<?php echo $data_pasien->no_sep; ?>');
      get_status('<?php echo $no_register; ?>');    
    });

    function get_status(no_register){
      $.ajax({
        type: "GET",
        url: "<?php echo base_url().'ina_cbg/klaim/claim_status_ajax/'.$no_register; ?>",
        dataType: "JSON",
        success: function(result) {     
          if (result.status_kirim) {    
            if (result.status_kirim == 1) {
              $('#status_kirim').html('Terkirim');
            } else {
              $('#status_kirim').html('-');
            }
          } else {
            $('#status_kirim').html('-');
          }
          // if (result.tarif_poli_eks) {    
          //   if (result.tarif_poli_eks > 0) {
          //     $("#kelas_rawat_1").prop("checked", true);
          //     $('#div_poli_eks').show();
          //     $('#tarif_poli_eks').val(result.tarif_poli_eks);
          //   } else {
          //     $("#kelas_rawat_3").prop("checked", true);
          //     $('#div_poli_eks').hide();
          //   }
          // }
          if (result.status_klaim) {            
            if(result.status_klaim == 1 || result.status_klaim == 2) {
              $('#cetak_klaim').hide();
              $('#kirim_online').hide();
              $('#status').val(result.status_klaim);
              document.getElementById("btn-final").innerHTML = '<button type="button" class="btn btn-info pull-right" id="btn-grouper" onclick="submit_klaim()">Grouper / Final Klaim</button>';
            } else if(result.status_klaim == 3) {              
              $('#status').val(result.status_klaim);
              $('#cetak_klaim').show();
              $('#kirim_online').show();
              document.getElementById("btn-final").innerHTML = '<a href="<?php echo $data_pasien->no_sep; ?>" class="btn btn-primary reedit_claim"><i class="fa fa-pencil-square-o"></i> Edit Ulang Klaim</a>';
            } else {
              $('#cetak_klaim').hide();
              $('#kirim_online').hide();
              $('#status').val(0);
              document.getElementById("btn-final").innerHTML = '<button type="button" class="btn btn-info pull-right" id="btn-grouper" onclick="submit_klaim()">Grouper / Final Klaim</button>';
            }
          } else {
            $('#cetak_klaim').hide();
            $('#kirim_online').hide();
            $('#status').val(0);
            document.getElementById("btn-final").innerHTML = '<button type="button" class="btn btn-info pull-right" id="btn-grouper" onclick="submit_klaim()">Grouper / Final Klaim</button>';                                  
          }          
        },
        error:function(event, textStatus, errorThrown) {
          swal("Gagal load status klaim",textStatus, "error"); 
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });
    }

    function get_diagnosa(no_sep){
      $.ajax({
        type: "GET",
        url: "<?php echo base_url().'ina_cbg/klaim/get_diagnosa/'; ?>"+no_sep,
        dataType: "json",
        success: function(data){
          var diags = [];
          var diagnosa;         
          if (data.diagnosa_utama == '') {
            diagnosa = '';
          } else {
            diags.push(data.diagnosa_utama);    
            $.each(data.diagnosa_tambahan, function(i, item) {
                diags.push(item);
              })          
            diagnosa = diags.join('#');         
          }                     
          $('#diagnosa').val(diagnosa);
          $('#show_diagnosa').html(diagnosa);
        },
        error:function(event, textStatus, errorThrown) {
          swal("Gagal load data diagnosa.",textStatus, "error"); 
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }        
      });
    }

    function get_procedure(no_sep){
      $.ajax({
        type: "GET",
        url: "<?php echo base_url().'ina_cbg/klaim/get_procedure/'; ?>"+no_sep,
        dataType: "JSON",
        success: function(result){
          var procedures = [];
          var procedure;          
          if (result.procedure_utama == '') {
            procedure = '';
          } else {
            procedures.push(result.procedure_utama);
            $.each(result.procedure_tambahan, function(i, item) {
                procedures.push(item);
              })          
            procedure = procedures.join('#');             
          }                    
          $('#procedure').val(procedure);
          $('#show_procedure').html(procedure);
        },
        error:function(event, textStatus, errorThrown) {
          swal("Gagal load data procedure",textStatus, "error"); 
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });
    }  

    function send_claim_individual(no_sep) {   
      swal({
        title: "Kirim Klaim Online",
        text: "Yakin akan mengirim klaim online?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (kirim)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
            $.ajax({
              type: "POST",
              url: "<?php echo base_url().'ina_cbg/klaim/send_claim_individual'; ?>",
              dataType: "JSON",
              data: {'no_sep' : no_sep},
              success: function(result){  
                if (result.metadata.code) {              
                  if (result.metadata.code == '200' && result.response.data[0].kemkes_dc_status == 'sent') {
                    swal("Sukses", "Proses kirim klaim online berhasil.", "success");
                  } else if (result.metadata.code == '400') {
                    swal("Koneksi Gagal", "Gagal mengirim klaim online.", "error");
                  } else {
                    swal("Gagal kirim klaim online", result.metadata.message, "error");
                  } 
                } else {
                  swal("Error", "Koneksi Service Gagal.", "error");
                }   
                get_status('<?php echo $no_register; ?>');             
              },
              error:function(event, textStatus, errorThrown) {                     
                swal("Gagal kirim klaim online.",textStatus, "error");     
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);          
              }
            });           
      });       
    }

    function claim_final(nomor_sep){   
      document.getElementById("btn-final").innerHTML = '<button type="button" class="btn btn-primary">Processing...</button>'; 
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ina_cbg/klaim/claim_final'; ?>",
        dataType: "JSON",
        data: {'nomor_sep' : nomor_sep},
        success: function(data){  
          console.log(data);
          if (data.metadata.code) {              
            if (data.metadata.code == '200') {
              swal("Sukses", "Final Klaim Berhasil.", "success");
            } else {
              swal("Error", data.metadata.message, "error");
            }
          } else {
            swal("Error", "Koneksi Service gagal.", "error");
          }
          get_status('<?php echo $no_register; ?>'); 
        },
        error:function(event, textStatus, errorThrown) {    
          get_status('<?php echo $no_register; ?>'); 
          swal("Gagal Final Klaim",textStatus, "error");     
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);           
        }
      });
    } 

    function submit_klaim(){
      document.getElementById("btn-grouper").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ina_cbg/klaim/set_claim'; ?>",
        dataType: "JSON",
        data: $('#claim_form').serialize(),
        success: function(result){          
          if (result.metadata.code) {
            if (result.metadata.code == '200') {
              window.open('<?php echo base_url().'ina_cbg/klaim/cetak_klaim/'.$data_pasien->no_sep; ?>', '_blank');
              swal("Sukses", "Grouper/Finalisasi Berhasil.", "success");
            } else {
              swal("Gagal Grouper/Finalisasi", result.metadata.message, "error");
            }  
          } else {
            swal("Gagal Grouper/Finalisasi", "Koneksi Service gagal.", "error");
          }
          // document.getElementById("btn-grouper").innerHTML = 'Grouper / Final Klaim';
          get_status('<?php echo $no_register; ?>');                    
        },
        error:function(event, textStatus, errorThrown) {             
            document.getElementById("btn-grouper").innerHTML = 'Grouper / Final Klaim';
            get_status('<?php echo $no_register; ?>');                  
            swal("Gagal Grouper/Finalisasi", errorThrown, "error"); 
            console.log('Response Message: '+ textStatus + ' , HTTP Response: '+errorThrown);
        }
      });
    }   
     
    function pilih_payor(payor_cd) {
      if (payor_cd==='JKN') {
        document.getElementById("payor_id").value = '3'; 
      } else if (payor_cd==='001') {
        document.getElementById("payor_id").value = '5'; 
      } else if (payor_cd==='999') {
        document.getElementById("payor_id").value = '1'; 
      } else {
        document.getElementById("payor_id").value = '3'; 
      }
    } 

    function insert_diagnosa(){
      document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'diagnosa/insert_irj'; ?>",
        dataType: "JSON",
        data: $('#form_diagnosa').serialize(),
        success: function(result) {          
          if (result.metadata.code) {            
            if (result.metadata.code == '200') {                  
              table_diagnosa.ajax.reload();
              get_diagnosa('<?php echo $data_pasien->no_sep; ?>');
              $('#modal_diagnosa').modal('hide');
              swal("Sukses", "Diagnosa berhasil disimpan.", "success");
            } else {        
              swal("Gagal menginput diagnosa", result.metadata.message, "error");            
            }      
            document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            document.getElementById("form_diagnosa").reset(); 
          }
        },
        error:function(event, textStatus, errorThrown) { 
          document.getElementById("form_diagnosa").reset();
          document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';  
          swal("Gagal menginput diagnosa", textStatus, "error");
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });
    }
    function insert_procedure(){
      document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'procedure/insert_irj'; ?>",
        dataType: "JSON",
        data: $('#form_procedure').serialize(),
        success: function(result){   
          if (result.metadata.code) {            
            if (result.metadata.code == '200') {   
              document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
              table_procedure.ajax.reload();
              get_procedure('<?php echo $data_pasien->no_sep; ?>');
              $('#modal_procedure').modal('hide');
              document.getElementById("form_procedure").reset(); 
              swal("Sukses", "Prosedur berhasil disimpan.", "success");
            } else {
              document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
              swal("Gagal menginput procedure", result.metadata.message, "error");            
            }                  
          }  
        },
        error:function(event, textStatus, errorThrown) {           
          document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';  
          swal("Gagal menginput procedure", textStatus, "error");       
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });
    }

    function delete_diagnosa(id) {       
      swal({
        title: "Hapus Diagnosa",
        text: "Hapus diagnosa tersebut?",
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
              url: "<?php echo base_url().'diagnosa/delete_irj'; ?>",
              dataType: "JSON",   
              data: {"id_diagnosa_pasien" : id,"no_register" : "<?php echo $no_register; ?>"},                 
              success: function(result){           
                if (result == true) {
                  table_diagnosa.ajax.reload();
                  document.getElementById("form_diagnosa").reset();
                  get_diagnosa('<?php echo $data_pasien->no_sep; ?>');
                  swal("Sukses", "Diagnosa berhasil dihapus.", "success");
                } else {
                  swal("Error", "Gagal menghapus diagnosa.", "error");            
                }
              },
              error:function(event, textStatus, errorThrown) {    
                  swal("Gagal menghapus diagnosa", textStatus, "error");
                  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
              }
            });           
      });   
    }

    function delete_procedure(id) {       
      swal({
        title: "Hapus Prosedur",
        text: "Hapus prosedur tersebut?",
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
              url: "<?php echo base_url().'procedure/delete_irj'; ?>",
              dataType: "JSON",                    
              data: {"id" : id,"no_register" : "<?php echo $no_register; ?>"},  
              success: function(result){  
                if (result == true) {
                  table_procedure.ajax.reload();
                  get_procedure('<?php echo $data_pasien->no_sep; ?>');
                  document.getElementById("form_procedure").reset();
                  swal("Sukses", "Prosedur berhasil dihapus.", "success");
                } else {
                  swal("Error", "Gagal menghapus procedure.", "error");            
                } 
              },
              error:function(event, textStatus, errorThrown) {    
                swal("Gagal Menghapus procedure", textStatus, "error");
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
              }
            });           
      });   
    }

    function set_utama_procedure(id) {
      swal({
        title: "Set Utama",
        text: "Set utama prosedur tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya",
        showLoaderOnConfirm: true,
        closeOnConfirm: true
        }, function() {
            $.ajax({
              type: 'POST',
              url: "<?php echo site_url('procedure/set_utama_irj')?>",
              dataType:"JSON",
              data: {"id" : id},
              success: function(data){                
                if (data == true) {
                  table_procedure.ajax.reload();
                  get_procedure('<?php echo $data_pasien->no_sep; ?>');
                  swal("Sukses", "Prosedur berhasil di set utama.", "success");
                } else {
                  swal("Error", "Gagal men-set utama prosedur.", "error");            
                }               
              },
              error:function(event, textStatus, errorThrown) {
                swal("Gagal men-set utama prosedur", textStatus, "error");
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
              },
            });           
      });
    }

    function set_utama_diagnosa(id_diagnosa_pasien) {
      swal({
        title: "Set Utama",
        text: "Set utama diagnosa tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya",
        showLoaderOnConfirm: true,
        closeOnConfirm: true
        }, function() {
            $.ajax({
              type: 'POST',
              url: "<?php echo site_url('diagnosa/set_utama_irj')?>",
              dataType:"JSON",
              data: {"id_diagnosa_pasien" : id_diagnosa_pasien},
              success: function(data){                
                if (data == true) {
                  table_diagnosa.ajax.reload();
                  get_diagnosa('<?php echo $data_pasien->no_sep; ?>');
                  swal("Sukses", "Diagnosa berhasil di set utama.", "success");
                } else {
                  swal("Error", "Gagal men-set utama diagnosa.", "error");            
                }               
              },
              error:function(event, textStatus, errorThrown) {
                swal("Gagal men-set utama diagnosa", textStatus, "error");  
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
              },
            });           
      });
    }

    function tarif_rs(){  
      $(".load_input").addClass("load_input"); 
      $('#total_tarif_rs').html('<img src="<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>">'); 
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ina_cbg/pasien/show_tarifrs/'.$no_register; ?>",
        dataType: "JSON",      
        success: function(result){  
          var total = 0;             
          if (result) {  
            $(".load_input").removeClass("load_input");          
            total = parseInt(result.tarif_prosedur_non_bedah)+
                    parseInt(result.tarif_prosedur_bedah)+
                    parseInt(result.tarif_konsultasi)+
                    parseInt(result.tarif_tenaga_ahli)+
                    parseInt(result.tarif_keperawatan)+
                    parseInt(result.tarif_penunjang)+
                    parseInt(result.tarif_radiologi)+
                    parseInt(result.tarif_laboratorium)+
                    parseInt(result.tarif_pelayanan_darah)+
                    parseInt(result.tarif_rehabilitasi)+
                    parseInt(result.tarif_kamar)+
                    parseInt(result.tarif_rawat_intensif)+
                    parseInt(result.tarif_obat)+
                    parseInt(result.tarif_alkes)+
                    parseInt(result.tarif_bmhp)+
                    parseInt(result.tarif_sewa_alat);  
            $('#total_tarif_rs').html(total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));  
            $('#prosedur_non_bedah').val(result.tarif_prosedur_non_bedah);  
            $('#prosedur_bedah').val(result.tarif_prosedur_bedah);  
            $('#konsultasi').val(result.tarif_konsultasi);  
            $('#tenaga_ahli').val(result.tarif_tenaga_ahli);  
            $('#keperawatan').val(result.tarif_keperawatan);  
            $('#penunjang').val(result.tarif_penunjang);  
            $('#radiologi').val(result.tarif_radiologi);  // daftar_ulang_irj
            $('#laboratorium').val(result.tarif_laboratorium);  // daftar_ulang_irj 
            $('#pelayanan_darah').val(result.tarif_pelayanan_darah);  
            $('#rehabilitasi').val(result.tarif_rehabilitasi);  
            $('#kamar').val(result.tarif_kamar);  
            $('#rawat_intensif').val(result.tarif_rawat_intensif);  
            $('#obat').val(result.tarif_obat);   // daftar_ulang_irj
            $('#alkes').val(result.tarif_alkes);  // daftar_ulang_irj
            $('#bmhp').val(result.tarif_bmhp);  
            $('#sewa_alat').val(result.tarif_sewa_alat);          
          } else {
            $(".load_input").removeClass("load_input");           
            $('#total_tarif_rs').html(total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));  
            $('#prosedur_non_bedah').val(0);  
            $('#prosedur_bedah').val(0); 
            $('#konsultasi').val(0); 
            $('#tenaga_ahli').val(0); 
            $('#keperawatan').val(0); 
            $('#penunjang').val(0); 
            $('#radiologi').val(0);
            $('#laboratorium').val(0);
            $('#pelayanan_darah').val(0); 
            $('#rehabilitasi').val(0); 
            $('#kamar').val(0);  
            $('#rawat_intensif').val(0);  
            $('#obat').val(0);
            $('#alkes').val(0);
            $('#bmhp').val(0); 
            $('#sewa_alat').val(0);                  
          }
        },
        error:function(event, textStatus, errorThrown) {       
          $(".load_input").removeClass("load_input");     
          swal("Gagal load data tarif rs", textStatus, "error");     
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }    
      });
    }

    function save_tarif_rs(){    
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ina_cbg/pasien/save_tarif_rs'; ?>",
        dataType: "JSON",      
        data: {
            'no_register' : '<?php echo $no_register; ?>',          
            'prosedur_non_bedah' : $('#prosedur_non_bedah').val() ,
            'prosedur_bedah' : $('#prosedur_bedah').val(),
            'konsultasi' : $('#konsultasi').val() ,
            'tenaga_ahli' : $('#tenaga_ahli').val()  ,
            'keperawatan' : $('#keperawatan').val() ,
            'penunjang' : $('#penunjang').val() ,
            'radiologi' : $('#radiologi').val(),
            'laboratorium' : $('#laboratorium').val(),
            'pelayanan_darah' : $('#pelayanan_darah').val() ,
            'rehabilitasi' : $('#rehabilitasi').val(),
            'kamar' : $('#kamar').val(),
            'rawat_intensif' : $('#rawat_intensif').val() ,
            'obat' : $('#obat').val(),
            'alkes' : $('#alkes').val(),
            'bmhp' : $('#bmhp').val() ,
            'sewa_alat' : $('#sewa_alat').val()
        },
        success: function(data){              
          if (data == true) {  
            tarif_rs(); 
            swal("Sukses", "Tarif RS berhasil di simpan.", "success");        
          } else {
            swal("Error", "Gagal menyimpan tarif rs", "error");
          }
        },
        error:function(event, textStatus, errorThrown) {       
          swal("Gagal menyimpan tarif rs", textStatus, "error");        
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }    
      });
    }

    function set_naik_kelas(naik_kelas){
      if (naik_kelas==='1') {
        $('#div_upgrade_class_class').show();
        $('#div_upgrade_class_los').show();
        $('#div_add_payment_pct').show();
      } else {    
        $('#div_upgrade_class_class').hide();
        $('#div_upgrade_class_los').hide();
        $('#div_add_payment_pct').hide();
      }
    }
  </script>
  <?php if($this->session->flashdata('alert_new_claim')) { ?>
    <script type="text/javascript">
      swal("Gagal Hapus", "<?php echo $this->session->flashdata('alert_new_claim'); ?>", "error");
    </script>
  <?php } ?>
  <br>
  <div class="col-md-12">
    <div class="row">    
    <?php if(!$data_pasien) { ?>
      <div class="col-md-12">
        <div class="alert alert-danger" style="width: 100%">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
          <h3 class="text-danger"><i class="fa fa-ban"></i> Data tidak ditemukan.</h3> Data Pasien dengan No. Registrasi <?php echo $no_register; ?> Tidak Ditemukan.
        </div>   
      </div>           
    <?php } else { ?>   
      <div class="col-md-12">
        <div class="card">
          <div class="card-block">
            <form id="claim_form">
              <div class="col-12">
                <div class="d-flex flex-wrap">
                    <div>
                    <h3 class="card-title"><i class="fa fa-user"></i> <?php echo $data_pasien->nama; ?> | <?php echo $no_register; ?></h3>
                    </div>
                    <div class="ml-auto">
                      <div class="box-tools pull-right">
                        <h4 class="card-title">Status Kirim : <span id="status_kirim"></span></h4>
                      </div>
                    </div>
                </div>
              </div>         
              <br>
              <div class="col-md-12">        
                <div class="row">
                  <div class="col-md-4 border-right">                        
                    <div class="form-group">
                      <label for="no_rm">No. RM</label>
                        <input type="text" class="form-control" id="no_rm" name="no_rm" value="<?php echo $data_pasien->no_cm; ?>">
                    </div> 
                    <div class="form-group">
                      <label for="no_sep">No. SEP</label>
                        <input type="text" class="form-control" id="no_sep" name="no_sep" value="<?php echo $data_pasien->no_sep; ?>">
                    </div>                            
                    <div class="form-group">
                      <label>Tanggal Lahir</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="tgl_lahir" name="tgl_lahir" value="<?php echo date("Y-m-d", strtotime($data_pasien->tgl_lahir)); ?>">
                      </div>                  
                    </div>       
                    <div class="form-group">
                      <label for="kode_tarif">Kode Tarif</label>
                      <select name="kode_tarif" id="kode_tarif" class="form-control">
                        <option value="BP" selected>TARIF RS KELAS B PEMERINTAH</option>
                        <option value="CP">TARIF RS KELAS C PEMERINTAH</option>
                      </select>                    
                    </div>      
                    <div class="form-group">
                      <label for="gender">Jenis Rawat</label>                 
                      <div class="demo-checkbox">
                          <input class="filled-in" name="upgrade_class_ind" id="upgrade_class_ind" type="checkbox" value="1">
                          <label for="upgrade_class_ind">Naik Kelas</label>   
                          <input class="filled-in" name="icu_indicator" id="icu_indicator" type="checkbox" value="1"  onclick="set_rawat_intensif(this.value);">
                          <label for="icu_indicator">Ada Rawat Intensif</label>                      
                      </div>   
                    </div>                                                                                                           
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4 border-right">
                      <div class="form-group">
                        <label for="no_kartu">No. Kartu</label>
                          <input type="text" class="form-control" id="no_kartu" name="no_kartu" value="<?php echo $data_pasien->no_kartu; ?>">
                      </div>                              
                    <div class="form-group">
                      <label>Tanggal Masuk</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="tgl_masuk" name="tgl_masuk" value="<?php echo $data_pasien->tgl_masuk; ?>">
                      </div>                  
                    </div>
                    <div class="form-group">
                      <label>Tanggal Pulang</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="tgl_pulang" name="tgl_pulang" value="<?php echo $data_pasien->tgl_keluar; ?>">
                      </div>                  
                    </div>      
                    <div class="form-group">
                      <label for="gender">Jenis Kelamin</label>                 
                      <div class="demo-radio-button">
                        <input name="gender" type="radio" id="add_laki" class="with-gap add_gender" value="1" <?php if($data_pasien->gender == 'L') echo 'checked'; ?> />
                        <label for="add_laki">Laki-laki</label> 
                        <input name="gender" type="radio" id="add_perempuan" class="with-gap add_gender" value="2" <?php if($data_pasien->gender == 'P') echo 'checked'; ?> />
                        <label for="add_perempuan">Perempuan</label>              
                      </div>   
                    </div> 
                    <div class="form-group" id="div_icu_los">
                      <label for="icu_los"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Untuk perbaikan tarif: <br>Masukan total jumlah hari rawat intensif"> Rawat Intensif (hari)</label>
                      <input type="text" class="form-control text-center" id="icu_los" name="icu_los" value="0">
                    </div>                            
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">                                                 
                      <div class="form-group" hidden>
                        <label for="payor_id">Payor Id</label>
                          <input type="text" class="form-control" id="payor_id" name="payor_id">
                      </div> 
                      <div class="form-group">
                        <label for="payor_cd">Jaminan / Cara Bayar</label>
                        <select name="payor_cd" id="payor_cd" class="form-control" onchange="pilih_payor(this.value)">
                          <option value="JKN" selected>JKN</option>
                          <option value="001">JAMKESDA</option>
                          <option value="999">PASIEN BAYAR</option>
                        </select>                    
                      </div> 
                      <div class="form-group">
                        <label for="nama_dokter">DPJP</label>
                        <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="<?php echo $nm_dokter; ?>">
                      </div>  
                      <div class="form-group">
                        <label for="discharge_status">Cara Pulang</label>
                        <select name="discharge_status" id="discharge_status" class="form-control">
                          <option value="1"
                          <?php if ($data_pasien->keadaanpulang == 'PULANG' || $data_pasien->keadaanpulang == 'PULANG PAKSA'): echo 'selected' ?> 
                          <?php endif ?>>Atas persetujuan dokter</option>
                          <option value="2" 
                          <?php if ($data_pasien->keadaanpulang == 'DIRUJUK RS LAIN'): echo 'selected' ?> 
                          <?php endif ?>>Dirujuk</option>
                          <option value="3">Atas permintaan sendiri</option>
                          <option value="4"
                          <?php if ($data_pasien->keadaanpulang == 'MENINGGAL'): echo 'selected' ?> 
                          <?php endif ?>>Meninggal</option>
                          <option value="5">Lain-lain</option>
                        </select>                    
                      </div>  
                      <div class="form-group">
                        <label for="kelas_rawat">Kelas Rawat</label>          
                        <div class="demo-radio-button">
                          <input name="kelas_rawat" type="radio" id="kelas_rawat_1" class="form-control with-gap" value="1" <?php if($data_pasien->kelas_bpjs == 'I') echo 'checked'; ?>/>
                          <label for="kelas_rawat_1">Kelas 1</label> 
                          <input name="kelas_rawat" type="radio" id="kelas_rawat_2" class="form-control with-gap" value="2" <?php if($data_pasien->kelas_bpjs == 'II') echo 'checked'; ?>/>
                          <label for="kelas_rawat_2">Kelas 2</label> 
                          <input name="kelas_rawat" type="radio" id="kelas_rawat_3" class="form-control with-gap" value="3" <?php if($data_pasien->kelas_bpjs == 'III') echo 'checked'; ?>/>
                          <label for="kelas_rawat_3">Kelas 3</label>              
                        </div>  
                      </div>                                                                          
                      <div class="form-group" id="div_ventilator_hour">
                        <label for="ventilator_hour"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Untuk perbaikan tarif:<br/>Masukkan total jumlah jam pemakaian ventilator"> Ventilator (jam)</label>
                        <input type="text" class="form-control text-center" id="ventilator_hour" name="ventilator_hour" value="0">
                      </div>                                                   
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->            
                </div>
                <!-- /.row -->                     
                <div class="row"> 
                  <div class="col-md-4">                                            
                    <div class="form-group" id="div_upgrade_class_class">
                      <label for="naik_kelas_rawat"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Masukkan kenaikan kelas yang diambil pasien.">Naik Kelas Rawat</label>
                      <div class="demo-radio-button radio-naik-kelas">
                        <input name="upgrade_class_class" type="radio" id="naik_kelas_rawat_2" class="form-control with-gap" value="kelas_2"/>
                        <label style="font-size: 14.5px;margin-bottom: 12px" for="naik_kelas_rawat_2">Kelas 2</label> 
                        <input name="upgrade_class_class" type="radio" id="naik_kelas_rawat_1" class="form-control with-gap" value="kelas_1"/>
                        <label style="font-size: 14.5px;margin-bottom: 12px" for="naik_kelas_rawat_1">Kelas 1</label>                     
                        <input name="upgrade_class_class" type="radio" id="naik_kelas_rawat_vip" class="form-control with-gap" value="vip"/>
                        <label style="font-size: 14.5px;margin-bottom: 12px" for="naik_kelas_rawat_vip">Kelas VIP</label>  
                        <input name="upgrade_class_class" type="radio" id="naik_kelas_rawat_vvip" class="form-control with-gap" value="vvip"/>
                        <label style="font-size: 14.5px;margin-bottom: 12px" for="naik_kelas_rawat_vvip">Kelas VVIP</label>              
                      </div>
                    </div>  
                  </div>             
                  <div class="col-md-4">                                                                       
                    <div class="form-group" id="div_upgrade_class_los">
                      <label for="upgrade_class_los"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Masukkan jumlah hari naik kelas rawat.">Lama (hari)</label>
                      <input type="text" class="form-control text-center" id="upgrade_class_los" name="upgrade_class_los" value="">
                    </div>                                               
                  </div>   
                  <div class="col-md-4"> 
                    <div class="form-group" id="div_add_payment_pct">
                      <label for="add_payment_pct"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Koefisien pengali sesuai peraturan yang berlaku. <br>Silakan klik kemudian ketik persentasenya <br>atau gunakan tombol panah atas/bawah">Koefisien Tambahan Biaya Naik Kelas</label>         
                      <input type="text" class="form-control text-center" id="add_payment_pct" name="add_payment_pct" value="0"> 
                    </div> 
                  </div>                                  
                </div>
                <!-- /.row -->        
                <div class="row">  
                  <div class="col-md-12">         
                    <input type="hidden" class="form-control" id="diagnosa" name="diagnosa" value="">
                    <input type="hidden" class="form-control" id="procedure" name="procedure" value="">
                    <!-- No. Register Pelayanan -->
                    <input type="hidden" class="form-control" id="no_register" name="no_register" value="<?php echo $no_register; ?>">

                    <!-- Jenis Rawat 1 = rawat inap, 2 = rawat jalan -->
                    <input type="hidden" class="form-control" id="jenis_rawat" name="jenis_rawat" value="2">   

                    <input type="hidden" class="form-control text-center" id="tarif_poli_eks" name="tarif_poli_eks" value="0">               
                    <!-- NIK pada user (Personnel Registration) di Aplikasi E-Klaim -->
                    <input type="hidden" class="form-control" id="coder_nik" name="coder_nik" value="<?php echo $coder_nik; ?>">

                    <!-- Berat Lahir -->
                    <input type="hidden" class="form-control" id="birth_weight" name="birth_weight" value="0">

                    <!-- Activities of Daily Living -->
                    <input type="hidden" class="form-control" id="adl_sub_acute" name="adl_sub_acute">
                    <input type="hidden" class="form-control" id="adl_chronic" name="adl_chronic">

                    <!-- Jika ada Naik Kelas -->
                    <!-- <input type="hidden" class="form-control" id="upgrade_class_ind" name="upgrade_class_ind" value="0"> -->
                    <!-- <input type="hidden" class="form-control" id="upgrade_class_class" name="upgrade_class_class" value=""> -->
                    <!-- <input type="hidden" class="form-control" id="upgrade_class_los" name="upgrade_class_los" value=""> -->
                    <!-- <input type="hidden" class="form-control" id="add_payment_pct" name="add_payment_pct" value="">   -->  
                    <!-- add_payment_pct adalah koefisien tambahan biaya khusus jika pasien naik ke kelas VIP -->             

                    <!-- Jika Pasien Masuk ICU -->
                    <!-- <input type="hidden" class="form-control" id="icu_indikator" name="icu_indikator" value="0"> -->
                    <!-- <input type="hidden" class="form-control" id="icu_los" name="icu_los" value="">     -->              
                    <!-- <input type="hidden" class="form-control" id="ventilator_hour" name="ventilator_hour"> -->

                    <input type="hidden" class="form-control" id="cob_cd" name="cob_cd" value="#">
                    
                    <input type="hidden" class="form-control" id="status" name="status" value="0"> 
                    <!-- Status Klaim di SIMRS -->                                                 
                  </div>    
                  <div class="col-md-12">              
                    <div id="accordion" class="nav-accordion" role="tablist" aria-multiselectable="true">
                      <div class="card card-outline-default">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTarif" aria-expanded="false" aria-controls="collapseTarif">
                          <div class="card-header" role="tab" id="headingTarif">
                            <h5 class="mb-0"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total nilai tertagih pada perawatan dalam satu episode,<br> tidak termasuk item tagihan pada <strong>Tarif Non INA-CBG</strong> yang tersebut dibawah.">Tarif Rumah Sakit : <span class="font-weight-bold" id="total_tarif_rs" style="display:inline-block;border-left:0;font-size:1.1em;text-align:left;font-family: sans-serif;"></span> <i class="indicator fa fa-chevron-down pull-right"></i></h5>
                          </div> 
                        </a>
                        <div id="collapseTarif" class="collapse" role="tabpanel" aria-labelledby="headingTarifs">
                            <div class="card-block"> 
                              <div class="message-box contact-box">                          
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif untuk tindakan medik non-operatif dan non-invasif (tidak dilakukan di kamar operasi), seperti contoh : kateterisasi jantung.">Prosedur Non Bedah</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="prosedur_non_bedah" id="prosedur_non_bedah">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif untuk tindakan medik operatif maupun invasif yang dilakukan di kamar operasi.">Prosedur Bedah</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="prosedur_bedah" id="prosedur_bedah">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="left" title="Total tarif untuk konsul, visite atau pun pemeriksaan <br>oleh dokter umum/spesialis/sub-spesialis dalam satu episode.">Konsultasi</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="konsultasi" id="konsultasi">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif untuk konsul atau visite tenaga ahli dalam satu episode, seperti contoh: konsul nutrisionis atau fisioterapis.">Tenaga Ahli</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="tenaga_ahli" id="tenaga_ahli">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif untuk tindakan keperawatan seperti buka jahitan, perawatan luka, dan lainnya dalam satu episode.">Keperawatan</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="keperawatan" id="keperawatan">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="left" title="Total tarif untuk tindakan penunjang di luar laboratorium maupun<br> radiologi dalam satu episode, seperti contoh Echo, EKG, Holter, dll.">Penunjang</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="penunjang" id="penunjang">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif untuk pemeriksaan radiologi dalam satu episode, <br>meliputi diantaranya X-Ray, USG, MRI, CT-Scan, Angiogram, dll.">Radiologi</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="radiologi" id="radiologi">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif untuk pemeriksaan laboratorium dalam satu episode, <br>meliputi diantaranya Mikrobiologi, Patologi Anatomi, Patologi Klinik, Hematologi, Hemostasis, dll.">Laboratorium</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="laboratorium" id="laboratorium">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="left" title="Total tarif pemakaian darah dalam satu episode.">Pelayanan Darah</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="pelayanan_darah" id="pelayanan_darah">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif untuk tindakan rehabilitasi, meliputi Fisioterapi, <br>Terapi Okupasi, Rehabilitasi Psikososial, dll.">Rehabilitasi</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="rehabilitasi" id="rehabilitasi">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif kamar/akomodasi pasien dalam satu episode, <br>termasuk recovery room, tarif administrasi pasien baik rawat jalan maupun rawat inap.">Kamar / Akomodasi</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="kamar" id="kamar">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="left" title="Total tarif kamar/akomodasi pasien di ruang intensif dalam satu episode.<br> Misal: ICU, ICCU, NICU, PICU, HCU, dll.">Rawat Intensif</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="rawat_intensif" id="rawat_intensif">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif obat-obatan yang diberikan kepada pasien dalam satu episode,<br> termasuk obat kemoterapi dan obat kronis.">Obat</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="obat" id="obat">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif alat kesehatan yang diberikan kepada pasien dalam satu episode.<br> Misalkan: Stent, Implan, dll">Alkes</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="alkes" id="alkes">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="left" title="BMHP = Bahan Medis Habis Pakai. Yaitu total tarif bahan medis habis pakai,<br> di luar paket perawatan yang diberikan kepada pasien selama satu episode perawatan,<br> seperti contoh : pemakaian oksigen, jelly, alkohol, dsb.">BMHP</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="bmhp" id="bmhp">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group row">
                                      <label class="col-sm-7 col-form-label"><h6><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Total tarif sewa alat medis yang digunakan dalam tindakan tertentu, <br>seperti contoh: Ventilator, Nebulizer, Syringe Pump, dll.">Sewa Alat</h6></label>
                                      <div class="col-sm-5">
                                        <input class="form-control text-center load_input" type="text" name="sewa_alat" id="sewa_alat">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-8">
                                      <div class="demo-checkbox">
                                          <input class="filled-in" id="agree" type="checkbox" value="ya" disabled checked>
                                          <label for="agree"><small>Menyatakan bahwa data tarif tersebut di atas adalah benar sesuai dengan kondisi yang sesungguhnya.</small></label>
                                          <button type="button" class="btn btn-danger m-t-10" id="simpan-tarif-rs" onclick="save_tarif_rs()"><i class="fa fa-floppy-o"></i> Simpan</button> 
                                      </div>
                                  </div>
                                </div>                           
                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="card card-outline-default">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseDiagnosa" aria-expanded="false" aria-controls="collapseDiagnosa">
                          <div class="card-header" role="tab" id="headingDiagnosa">
                            <h5 class="mb-0"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Kode diagnosa akan dicheck terhadap versi ICD-10 yang berlaku. <br>Jika ada kode yang tidak terdaftar atau berlaku, maka kode tersebut tidak akan tersimpan.">Diagnosa (ICD-10) : <span class="font-weight-bold" id="show_diagnosa" style="display:inline-block;border-left:0;font-size:1em;text-align:left;font-family: sans-serif;"></span> <i class="indicator fa fa-chevron-down pull-right"></i></h5> 
                          </div> 
                        </a>
                        <div id="collapseDiagnosa" class="collapse" role="tabpanel" aria-labelledby="headingDiagnosa">
                            <div class="card-block">                                                                             
                              <button type="button" class="btn btn-info waves-effect waves-dark m-b-15 pull-right" data-toggle="modal" data-target="#modal_diagnosa"><i class="fa fa-plus"></i> Tambah Diagnosa</button>                            
                              <div class="table-responsive">
                                <table id="table_diagnosa" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>ID Diagnosa</th>
                                      <th>Catatan</th>
                                      <th class="text-center">Klasifikasi</th>
                                      <th class="text-center">Aksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>                              
                                  </tbody>
                                </table>
                              </div> <!-- table-responsive -->                           
                            </div>
                        </div>
                      </div>
                      <div class="card card-outline-default">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseProcedure" aria-expanded="false" aria-controls="collapseProcedure">
                          <div class="card-header" role="tab" id="headingProcedure">
                            <h5 class="mb-0"><img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-placement="right" title="Kode procedure akan dicheck terhadap versi ICD-9-CM yang berlaku.<br> Jika ada kode yang tidak terdaftar atau berlaku, maka kode tersebut tidak akan tersimpan.">Prosedur (ICD-9-CM) : <span class="font-weight-bold" id="show_procedure" style="display:inline-block;border-left:0;font-size:1em;text-align:left;font-family: sans-serif;"></span> <i class="indicator fa fa-chevron-down pull-right"></i></h5> 
                          </div>  
                        </a>
                        <div id="collapseProcedure" class="collapse" role="tabpanel" aria-labelledby="headingProcedure">
                            <div class="card-block">                          
                              <button type="button" class="btn btn-info waves-effect waves-dark m-b-15 pull-right" data-toggle="modal" data-target="#modal_procedure"><i class="fa fa-plus"></i> Tambah Prosedur</button>
                              <div class="table-responsive">
                                <table id="table_procedure" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Prosedur</th>
                                      <th>Catatan</th>
                                      <th class="text-center">Klasifikasi</th>
                                      <th class="text-center">Aksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>                              
                                  </tbody>
                                </table>
                              </div> <!-- table-responsive -->                           
                            </div>
                        </div>
                      </div>
                    </div>                
                  </div> <!-- col-md-12 -->                                         
                </div>
                <!-- /.row -->                    
              </div>
            </form>       

            <div class="form-actions">
              <div class="col-md-12"> 
                <hr> 
                <button type="button" class="btn btn-danger delete_claim">Hapus Klaim</button>     
                <a href="<?php echo site_url('ina_cbg/klaim/cetak_klaim/'.$data_pasien->no_sep.'')?>" target="_blank" class="btn btn-warning" id="cetak_klaim"><i class="fa fa-print"></i> Cetak Klaim</a> 
                <button type="button" class="btn btn-success" id="kirim_online" onclick="send_claim_individual('<?php echo $data_pasien->no_sep; ?>')"><i class="fa fa-paper-plane"></i> Kirim Klaim Online</button>               
                <div class="pull-right" id="btn-final"></div>              
              </div>   
            </div> 
            <br>               
          </div>
          <!-- /.card-block -->  
        </div>
        <!-- /.card -->
      </div> 
    <?php } ?>
    </div>
  </div>
  <div class="modal fade" id="modal_diagnosa" tabindex="-1" role="dialog" aria-labelledby="modal_diagnosa">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Diagnosa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="form_diagnosa">
          <div class="modal-body">                                                
            <input type="hidden" class="form-control" name="noreg_diag" id="noreg_diag" value="<?php echo $no_register; ?>">
            <input type="hidden" class="form-control" value="<?php echo $data_pasien->id_poli;?>" name="id_poli">
            <input type="hidden" name="tgl_kunjungan" value="<?php echo $data_pasien->tgl_masuk;?>">
            <div class="form-group">
              <label for="id_diagnosa" class="control-label">Diagnosa (ICD-10)</label>                
              <input type="text" class="form-control autocomplete_diagnosa"  name="id_diagnosa" id="id_diagnosa" style="max-width:450px;font-size:15px;">
              <input type="hidden" class="form-control " name="diagnosa_separate" id="diagnosa_separate">                
            </div>        
            <div class="form-group">
              <label for="diagnosa_text" class="control-label">Catatan</label>              
              <textarea class="form-control" name="diagnosa_text" id="diagnosa_text" cols="30" rows="5" style="resize:vertical"></textarea>
            </div>                                                                                                                        
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btn-diagnosa" onclick="insert_diagnosa()"><i class="fa fa-floppy-o"></i> Simpan</button>
          </div>
        </form> 
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal_procedure" tabindex="-1" role="dialog" aria-labelledby="modal_procedure">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Prosedur</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="form_procedure">
          <div class="modal-body">                                                
            <input type="hidden" class="form-control" name="noreg_procedure" id="noreg_procedure" value="<?php echo $no_register; ?>">
            <input type="hidden" class="form-control" value="<?php echo $data_pasien->id_poli;?>" name="id_poli">
            <input type="hidden" name="tgl_kunjungan" value="<?php echo $data_pasien->tgl_masuk;?>">
            <div class="form-group">
              <label for="id_procedure" class="control-label">Prosedur (ICD-9-CM)</label>                
              <input type="text" class="form-control autocomplete_procedure"  name="id_procedure" id="id_procedure" style="max-width:450px;font-size:15px;">
              <input type="hidden" class="form-control " name="procedure_separate" id="procedure_separate">                
            </div>        
            <div class="form-group">
              <label for="procedure_text" class="control-label">Catatan</label>              
              <textarea class="form-control" name="procedure_text" id="procedure_text" cols="30" rows="5" style="resize:vertical"></textarea>
            </div>                                                                                                                        
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btn-procedure" onclick="insert_procedure()"><i class="fa fa-floppy-o"></i> Simpan</button>
          </div>
        </form> 
      </div>
    </div>
  </div>  
<?php
  $this->load->view("layout/footer_horizontal");
?> 