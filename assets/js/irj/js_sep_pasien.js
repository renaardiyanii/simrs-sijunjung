let table, tableigd, tableiri;
$(function () {
  table = new DataTable("#table-artikel", {
    processing: true,
    columns: [
      {
        data: "nama",
      },
      {
        data: "no_cm",
      },
      {
        data: "poli",
      },
      {
        data: "no_kartu",
      },
      {
        data: "no_surat",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `<input style="width:80%" type="text" value="${row.no_sep == null ? "" : row.no_sep
            }" class="form-control" id="${row.no_register}">`;
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          // delete row.nama;
          var rows = row;
          //delete rows.nama;

          return `
                    <div class="btn-group dropleft">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>
                        <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick='cetakulangsep(${JSON.stringify(
            rows
          )})'>Cetak Ulang SEP</button>
                        <a target="_blank" href="${baseurl + 'bpjs/sep/edit/' + rows.no_sep}" type="button" class="dropdown-item">Edit SEP</a>
                        
                          <button type="button" class="dropdown-item" onclick='buatsepirj(${JSON.stringify(
            rows
          )})'>Pembuatan SEP</button>
                          <a type="button" class="dropdown-item" onclick='pengajuanbackdatefinger(${JSON.stringify(
            rows
          )})'>Pengajuan Backdate/Finger</a>
                            <button type="button" class="dropdown-item" onclick='perbaruisep(${JSON.stringify(
            rows
          )})'>Perbarui SEP</button>
                            <button type="button" class="dropdown-item" onclick='showmodalsuratkontrol(${JSON.stringify(
            rows
          )})'>Buat Surat Kontrol</button>
                            <button type="button" class="dropdown-item" onclick='perbaruishowmodalsuratkontrol(${JSON.stringify(
            rows
          )})'>Perbarui Surat Kontrol</button>
                            <button type="button" class="dropdown-item" onclick='hapussuratkontrol(${JSON.stringify(
            rows
          )})'>Hapus Surat Kontrol</button>

                         <button type="button" class="dropdown-item"  onclick='pembuatan_rujukan_keluar(${JSON.stringify(
            rows
          )})'>Buat Rujukan</button>
                             <button type="button" class="dropdown-item" onclick='hapus_sep(${JSON.stringify(
            rows
          )})'>Hapus SEP</button>
                        </div>
                    </div>
                  
                    `;
          // return `<button type="button" class="btn btn-danger btn-sm selesai" onclick='perbaruisep(${JSON.stringify(row)})'>Perbarui SEP</button>`;
        },
      },
    ],
    language: {
      emptyTable: "Belum ada Daftar Pasien",
      paginate: {
        previous: "Sebelumnya",
        next: "Selanjutnya",
      },
    },
    ajax: {
      url: urllistirj,
      type: "GET",
      dataSrc: "result",
    },
    infoCallback: function (settings, start, end, max, total, pre) {
      return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
    },
  });
  tableigd = new DataTable("#table-igd", {
    processing: true,
    columns: [
      {
        data: null,
        render: function (data, type, row) {
          return `${row.nama}<br>(${row.no_cm})`;
        },
      },
      {
        data: "no_register",
      },
      {
        data: "no_kartu",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `<input style="width:80%" type="text" value="${row.no_sep == null ? "" : row.no_sep
            }" class="form-control" id="${row.no_register}">`;
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          // delete row.nama;
          var rows = row;
          //delete rows.nama;

          return `
                    <div class="btn-group dropleft">
                    <button type="button" class="btn btn-danger btn-sm selesai" onclick='perbaruisep(${JSON.stringify(
            rows)})'>Perbarui SEP</button>&nbsp;
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>
                        <div class="dropdown-menu">
                        <button type="button" class="dropdown-item" onclick='cetakulangsep(${JSON.stringify(
              rows
            )})'>Cetak Ulang SEP</button>

                        <a target="_blank" href="${baseurl + 'bpjs/sep/edit/' + rows.no_sep}" type="button" class="dropdown-item">Edit SEP</a>
                         
                          <a type="button" class="dropdown-item" onclick='pengajuanbackdatefinger(${JSON.stringify(
              rows
            )})'>Pengajuan Backdate/Finger</a>
                             <button type="button" class="dropdown-item" onclick='hapus_sep(${JSON.stringify(
              rows
            )})'>Hapus SEP</button>
                        </div>
                    </div>
                  
                    `;

          // return `<button type="button" class="btn btn-danger btn-sm selesai" onclick='perbaruisep(${JSON.stringify(
          //   rows
          // )})'>Perbarui SEP</button>`;
        },
      },
    ],
    language: {
      emptyTable: "Belum ada Daftar Pasien",
      paginate: {
        previous: "Sebelumnya",
        next: "Selanjutnya",
      },
    },
    ajax: {
      url: urllistigd,
      type: "GET",
      dataSrc: "result",
    },
    infoCallback: function (settings, start, end, max, total, pre) {
      return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
    },
  });
  tableiri = new DataTable("#table-iri", {
    processing: true,
    searching: true,
    columns: [
      // {
      //   data: null,
      //   render: function (data, type, row) {
      //     return `${row.nama}<br>(${row.no_cm})`;
      //   },
      // },
      {
        data: "nama",
      },
      {
        data: "no_cm",
      },
      {
        data: "no_register",
      },
      {
        data: "no_kartu",
      },
      {
        data: "no_surat",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `<input style="width:80%" type="text" value="${row.no_sep == null ? "" : row.no_sep
            }" class="form-control" id="${row.no_register}">`;
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          var rows = row;
          return `
            <div class="btn-group dropleft">
              <button type="button" class="btn btn-danger btn-sm selesai" onclick='perbaruisep(${JSON.stringify(rows)})'>
                Perbarui SEP
              </button>&nbsp;
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Pilih Aksi
              </button>
              <div class="dropdown-menu">
      
                <button type="button" class="dropdown-item" onclick='cetakulangsepranap(${JSON.stringify(rows)})'>
                  Cetak Ulang SEP
                </button>
      
                <a target="_blank" href="${baseurl + 'bpjs/sep/edit/' + rows.no_sep}" class="dropdown-item">
                  Edit SEP
                </a>
                <button type="button" class="dropdown-item" onclick='showmodalspri(${JSON.stringify(
                  rows
                )})'>Buat SPRI</button>

                <button type="button" class="dropdown-item" onclick='showmodalskdppascarawatinap(${JSON.stringify(
                  rows
                )})'>Buat SKDP Pasca Rawat Inap</button>

                <button type="button" class="dropdown-item" onclick='editshowmodalskdppascarawatinap(${JSON.stringify(
                  rows
                )})'>Edit SKDP Pasca Rawat Inap</button>

                <button type="button" class="dropdown-item" onclick='hapusskdppascarawatinap(${JSON.stringify(
                  rows
                )})'>Hapus SKDP Pasca Rawat Inap</button>


                <button type="button" class="dropdown-item" onclick='perbaruishowmodalspri(${JSON.stringify(
                  rows
                )})'>Edit SPRI</button>
      
                <a target="_blank" href="${baseurl + 'bpjs/sep/buat/' + rows.no_register}" class="dropdown-item">
                  Buat SEP
                </a>
      
                <button type="button" class="dropdown-item" onclick='hapusspri(${JSON.stringify(rows)})'>
                  Hapus SPRI
                </button>
      
                <button type="button" class="dropdown-item" onclick='hapus_sep(${JSON.stringify(rows)})'>
                  Hapus SEP
                </button>
      
              </div>
            </div>`;
        },
      },
      
    ],
    language: {
      emptyTable: "Belum ada Daftar Pasien",
      paginate: {
        previous: "Sebelumnya",
        next: "Selanjutnya",
      },
    },
    ajax: {
      url: urllistiri,
      type: "GET",
      dataSrc: "result",
    },
    infoCallback: function (settings, start, end, max, total, pre) {
      return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
    },
  });

  $("#inputcustom").keyup(function () {
    table.search($(this).val()).draw();
  });
  $("#inputcustom-igd").keyup(function () {
    tableigd.search($(this).val()).draw();
  });

  $("#inputcustom-iri").keyup(function () {
    tableiri.search($(this).val()).draw();
  });

  $("#datepicker").on("change", function () {
    //    console.log(this.value);
    table.ajax.url(urllistirj + "&tglkunjungan=" + this.value);

    // Reload the DataTable with the new AJAX URL
    table.ajax.reload();
  });

  $("#datepicker").datepicker({
    beforeShow: function (input, inst) {
      inst.dpDiv.css({
        top: $(input).offset().top + $(input).outerHeight(),
        left: $(input).offset().left,
      });
    },
    dateFormat: "yy-mm-dd",
  });

  $("#datepicker-igd").on("change", function () {
    //    console.log(this.value);
    tableigd.ajax.url(urllistigd + "&tglkunjungan=" + this.value);

    // Reload the DataTable with the new AJAX URL
    tableigd.ajax.reload();
  });

  $("#datepicker-igd").datepicker({
    beforeShow: function (input, inst) {
      inst.dpDiv.css({
        top: $(input).offset().top + $(input).outerHeight(),
        left: $(input).offset().left,
      });
    },
    dateFormat: "yy-mm-dd",
  });

  $("#datepicker-iri").on("change", function () {
    //    console.log(this.value);
    tableiri.ajax.url(urllistiri + "&tglkunjungan=" + this.value);

    // Reload the DataTable with the new AJAX URL
    tableiri.ajax.reload();
  });

  $("#datepicker-iri").datepicker({
    beforeShow: function (input, inst) {
      inst.dpDiv.css({
        top: $(input).offset().top + $(input).outerHeight(),
        left: $(input).offset().left,
      });
    },
    dateFormat: "yy-mm-dd",
  });
});

function cetakulangsep(val) {
  $.ajax({
    type: 'POST',
    url: `${baseurl}irj/rjcregistrasi/checksepavailable/${val.no_register}`,
    beforeSend: function () {
    },
    success: function (data) {
      if (data.code == 200) {
        window.open(`${baseurl}bpjs/sep/cetakan_sep/${val.no_register}`, '_blank');
        return;
      }
      new swal("Peringatan!", data.message, "warning");
      return;

    },
    error: function (xhr) {
      new swal("Peringatan!", 'Silahkan Kontak Admin IT', "warning");
      return;
    },
    complete: function () {
    },
    dataType: 'json'
  });
}

function cetakulangsepranap(val) {
  $.ajax({
    type: 'POST',
    url: `${baseurl}irj/rjcregistrasi/checksepavailableranap/${val.no_register}`,
    beforeSend: function () {
    },
    success: function (data) {
      if (data.code == 200) {
        window.open(`${baseurl}bpjs/sep/cetakan_sep/${val.no_register}`, '_blank');
        return;
      }
      new swal("Peringatan!", data.message, "warning");
      return;

    },
    error: function (xhr) {
      new swal("Peringatan!", 'Silahkan Kontak Admin IT', "warning");
      return;
    },
    complete: function () {
    },
    dataType: 'json'
  });
}


function gantifaskesrujukan(val) {
  $('#ppkDirujukEdit').select2({
    dropdownParent: $("#modalPembuatanRujukan .modal-content"),
    placeholder: 'Ketik kode atau nama PPK',
    minimumInputLength: 3,
    language: {
      inputTooShort: function (args) {
        return "Ketik kode atau nama PPK";
      },
      noResults: function () {
        return "PPK tidak ditemukan.";
      },
      searching: function () {
        return "Sedang Dicari.....";
      }
    },
    ajax: {
      type: 'GET',
      url: `${baseurl}bpjs/rujukan/ppa_rujukan?kodefaskes=${val}`,
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

function submitRujukan() {
  let data = $('#formRujukanKeluar').serialize();
  // console.log(data);return;
  $.ajax({
    type: 'POST',
    url: `${baseurl}bpjs/rujukan/insert`,
    data: data,
    beforeSend: function () {
      // $('#submitrujukan').attr('disabled',true);
    },
    success: function (data) {
      if (data.metaData.code == '200') {
        window.open(`${baseurl}bpjs/rujukan/cetak_rujukan/` + `${data.response.rujukan.noRujukan}`, '_blank');
        // new swal("Berhasil!",data.metaData.message, "success");

        return;
      }
      new swal("Peringatan!", data.metaData.message, "warning");
      return;

    },
    error: function (xhr) {
      new swal("Peringatan!", 'Silahkan Kontak Admin IT', "warning");
      return;
    },
    complete: function () {
      $('#submitrujukan').attr('disabled', false);
    },
    dataType: 'json'
  });
}


function pembuatan_rujukan_keluar(data) {
  $("#nosep_rujukan").val(data.no_sep);
  $("#modalPembuatanRujukan").modal("toggle");

  $('#modalPembuatanRujukan').on('shown.bs.modal', function (e) {
    $(".autocomplete_diagnosarujukan").select2({
      dropdownParent: $("#modalPembuatanRujukan .modal-content"),
      ajax: {
        url: `${baseurl}irj/rjcpelayanan/select2s_diagnosa`,
        dataType: 'json',
        delay: 250,

        data: function (params) {
          return {
            term: params.term
          };
        },
        processResults: function (data) {
          console.log(data);
          return {
            results: data
          };
        },
        cache: true
      },
      minimumInputLength: 2, // Minimum characters to start searching
      placeholder: 'Search for a diagnosis',
    });
    $('#poliRujukanup').select2({
      dropdownParent: $("#modalPembuatanRujukan .modal-content"),
      placeholder: 'Ketik kode atau nama Poli',
      minimumInputLength: 3,
      language: {
        inputTooShort: function (args) {
          return "Ketik kode atau nama poli";
        },
        noResults: function () {
          return "Poli tidak ditemukan.";
        },
        searching: function () {
          return "Sedang Cari.....";
        }
      },
      ajax: {
        type: 'GET',
        url: `${baseurl}bpjs/referensi/poliklinik`,
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

  });


}

function pengajuanbackdatefinger(data) {
  var data = btoa(JSON.stringify(data));

  window.open(`${baseurl}bpjs/finger/index?data=${data}`, '_blank');
}

function buat_sep_pasien_irj() {
  // Handle katarak checkbox value
  if ($("#katarak_checkbox").is(":checked")) {
    $("#katarak_hidden").val("1");
  } else {
    $("#katarak_hidden").val("0");
  }

  let data = $("#buat_sep_irj").serialize();
  $.ajax({
    method: 'POST',
    data: data,
    url: `${baseurl}/irj/rjcregistrasi/update_daftar_ulang_irj_sep_irj`,
    beforeSend: function () { },
    success: function (v) {
      $.ajax({
        type: "POST",
        url: `${baseurl}bpjs/sep/insert_sep/${$("#irj-no_register").val()}`,
        dataType: "JSON",
        success: function (result) {

          if (result.metaData.code == '200') {
            // if(result.sep_internal !== undefined)
            // {
            //   window.open(`${baseurl}bpjs_v2/sep/cetak_perincian_internal/${$("#no_register").val()}`, '_blank');
            //   swal("Sukses", "Silahkan Cetak SEP", "success");
            //   return;
            // }
            // window.open(`${baseurl}bpjs_v2/sep/cetak_perincian/${$("#irj-no_register").val()}`, '_blank');
            // swal("Sukses", "Silahkan Cetak SEP", "success");
            $('#no_sep').val(result.response.sep.noSep);
            window.open(`${baseurl}bpjs/sep/cetakan_sep/` + $("#irj-no_register").val(), '_blank');
          }
          else {
            swal("Gagal membuat SEP", result.metaData.message, "error");
          }
        },
        error: function (event, textStatus, errorThrown) {
          swal("Gagal membuat SEP", formatErrorMessage(event, errorThrown), "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    },
    error: function (xhr) { },
    complete: function () { },
  });

}

function pilihrujukanini(norujukan, asalrujukan, tglrujukan, ppkrujukan, kodepoli = '') {
  $("#demo").collapse('toggle');
  $("#irj-asalrujukan").val(asalrujukan);
  $("#irj-no_rujukan").val(norujukan);
  $("#irj-tglrujukan").val(tglrujukan);
  $("#irj-kode_ppk").val(ppkrujukan);

  // $("#irj-no_kartu").val(data.no_kartu);
  // $("#irj-no_register").val(data.no_register);
  var noregister = $("#irj-no_register").val();
  var nokartu = $("#irj-no_kartu").val();
  // ambil nomor rujukan berdasarkan nomor kartu bpjs
  $.ajax({
    // check
    url: `${baseurl}/irj/rjcregistrasi/grab_kebutuhan_daftar_ulang_irj_sebelumnya/${noregister}`,
    beforeSend: function () { },
    success: function (v) {
      // check
      $.get(`${baseurl}bpjs/rujukan/data_jumlah_sep?norujukan=${norujukan}&jnsrujukan=${asalrujukan}`, function (data, status) {
        $('#jml_terbit_sep').html(data.response.jumlahSEP);
        return;
      });


      // cari poli bpjs berdasarkan id poli
      var poli = v.id_poli;

      $.ajax({
        // check
        url: `${baseurl}irj/rjcregistrasi/cari_poli_bpjs/${poli}`,
        beforeSend: function () { },
        success: function (s) {
          // console.log(s);
          if (s.poli_bpjs !== null || s.poli_bpjs != '') {
            if (kodepoli !== '') {
              s.poli_bpjs = kodepoli;
            }
            // disini cari berdasarkan poli rujukan
            $.ajax({
              // check
              url: `${baseurl}bpjs/referensi/dokter_dpjp?pelayanan=2&spesialis=${s.poli_bpjs}`,
              dataType: "json",
              success: function (data) {
                // console.log(data);
                if (data.response !== null) {

                  var html = '';
                  var dokter_list = data.response.list;

                  for (var i = 0; i < dokter_list.length; i++) {
                    html += `<option value="${dokter_list[i].kode}">${dokter_list[i].nama}</option>`;
                  }
                  $('#dpjp_skdp').html(html);
                }
              }
            });
            // cek jika pasien merupakan pasca rawat inap ( asal faskes = 3)
            // maka masukan no surat kontrol terakhir kedalam inputan
            $("#div-suratkontrol").show();
          }

        },
        error: function (xhr) { },
        complete: function () { },
      });
    },
    error: function (xhr) { },
    complete: function () { },
  });
}

function getlistrujukannew() {
  var nokartu = $("#irj-no_kartu").val();
  $.ajax({
    // check
    url: `${baseurl}bpjs/rujukan/no_kartu_all_list/${nokartu}`,
    beforeSend: function () {

    },
    success: function (req) {
      if (req.metaData.code === 200) {
        var html1 = `<table class="table table-hover table-bordered">
            <tr>
                <th>No. Rujukan</th>
                <th>Tgl. Rujukan</th>
                <th>Poli Tujuan</th>
                <th>Aksi</th>
            </tr>
            
        `;
        req.response.faskes1.map((e) => {
          html1 += `<tr>
            <td>${e.noKunjungan}</td>
            <td>${e.tglKunjungan}</td>
            <td>${e.poliRujukan.nama}</td>
            <td><button type="button" class="btn btn-primary" onclick="pilihrujukanini('${e.noKunjungan}','1','${e.tglKunjungan}','${e.provPerujuk.kode}','${e.poliRujukan.kode}')"  data-target="#demo">Pilih Rujukan</button></td>
        </tr>`
        })
        $("#fk1-buatrawatjalan").html(
          html1 + '</table>'
        )
        var html2 = `<table class="table table-hover table-bordered">
            <tr>
                <th>No. Rujukan</th>
                <th>Tgl. Rujukan</th>
                <th>Poli Tujuan</th>
                <th>Aksi</th>
            </tr>
            
        `;
        req.response.faskes2.map((e) => {
          html2 += `<tr>
            <td>${e.noKunjungan}</td>
            <td>${e.tglKunjungan}</td>
            <td>${e.poliRujukan.nama}</td>
            <td><button type="button" class="btn btn-primary" onclick="pilihrujukanini('${e.noKunjungan}','2','${e.tglKunjungan}','${e.provPerujuk.kode}','${e.poliRujukan.kode}')"  data-target="#demo">Pilih Rujukan</button></td>
        </tr>`
        })
        $("#fk2-buatrawatjalan").html(
          html2 + '</table>'
        )

        var html3 = `<table class="table table-hover table-bordered">
            <tr>
                <th>No. Rujukan</th>
                <th>Tgl. Rujukan</th>
                <th>Poli Tujuan</th>
                <th>Aksi</th>
            </tr>
        `;
        req.response.rawatinap.map((e) => {
          html3 += `<tr>
            <td>${e.no_sep}</td>
            <td>${e.tgl_keluar}</td>
            <td>Rawat Inap</td>
            <td><button type="button" class="btn btn-primary" onclick="pilihrujukanini('${e.no_sep}','3','${e.tgl_keluar}','0311R001')"  data-target="#demo">Pilih Rujukan</button></td>
        </tr>`
        })
        $("#fk3-buatrawatjalan").html(
          html3 + '</table>'
        )
      }
    }
  });
}

function hapus_sep(data) {
  swal({
    title: "Yakin hapus SEP?",
    text: `SEP No: ${data.no_sep} akan dihapus. Lanjutkan?`,
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Batal",
    closeOnConfirm: false,
    showLoaderOnConfirm: true
  }, function () {
    $.ajax({
      url: `${baseurl}/bpjs/sep/delete_sep_2/${data.no_sep}/${data.no_register}`,
      type: "POST", // ganti dengan "DELETE" jika backend mendukung
      dataType: "json",
      success: function (response) {
        if (response.metaData && response.metaData.code === '200') {
          swal.close(); // tutup swal setelah sukses
          Notify(`${response.metaData.message}`, null, null, "success");
        } else {
          swal("Gagal", response.metaData?.message || "Terjadi kesalahan", "error");
        }
        table.ajax.reload();
        tableigd.ajax.reload();
        tableiri.ajax.reload();
      },
      error: function (xhr) {
        swal("Gagal", "Terjadi kesalahan saat menghapus SEP", "error");
      }
    });
  });
}


function pilihansuratkontrol(val) {
  if (val === '2') {
    const procedureRadios = document.querySelectorAll('input[name="flag_procedure"]');
    procedureRadios.forEach(radio => {
      radio.disabled = false;
    });
    $.ajax({
      // check
      url: `${baseurl}irj/rjcregistrasi/ambil_surat_kontrol_terakhir/${$("#irj-no_kartu").val()}`,
      beforeSend: function () { },
      success: function (s) {
        if (s) {
          $("#nosurat_skdp_sep").val(s.surat_kontrol);
          $("#dpjp_skdp_sep").val(s.dokter_bpjs);
        } else {
          swal("Peringatan!", 'Buatkan Dulu Surat Kontrol di Menu Pembuatan Surat Kontrol!', "error");
          return;
        }

      },
      error: function (xhr) { },
      complete: function () { },
    });
    $("#div-suratkontrol").show();
  } else {
    if (val === '0') {
      const procedureRadios = document.querySelectorAll('input[name="flag_procedure"]');
      procedureRadios.forEach(radio => {
        radio.disabled = true;
      });
      if ($("#irj-asalrujukan").val() === '3') {
        $.ajax({
          url: `${baseurl}irj/rjcregistrasi/ambil_surat_kontrol_terakhir/${$("#irj-no_kartu").val()}`,
          beforeSend: function () { },
          success: function (s) {
            if (s) {
              $("#nosurat_skdp_sep").val(s.surat_kontrol);
              $("#dpjp_skdp_sep").val(s.dokter_bpjs);
            } else {
              swal("Peringatan!", 'Buatkan Dulu Surat Kontrol di Menu Pembuatan Surat Kontrol!', "error");
              return;
            }

          },
          error: function (xhr) { },
          complete: function () { },
        });
        $("#div-suratkontrol").show();
      }
    } else {
      const procedureRadios = document.querySelectorAll('input[name="flag_procedure"]');
      procedureRadios.forEach(radio => {
        radio.disabled = false;
      });
      $("#div-suratkontrol").hide()
    }
  }

}



function buatsepirj(data) {
  $("#div-suratkontrol").hide();
  $("#irj-no_kartu").val(data.no_kartu);
  $("#irj-no_register").val(data.no_register);
  $.ajax({
    // check
    url: `${baseurl}/irj/rjcregistrasi/grab_kebutuhan_daftar_ulang_irj_sebelumnya/${data.no_register}`,
    beforeSend: function () { },
    success: function (v) {
      var norujukan = v.no_rujukan;
      var asalrujukan = v.asal_rujukan;
      if (norujukan === '' || norujukan === null) {
        $.ajax({
          // check
          url: `${baseurl}bpjs/rujukan/cari_rujukan?pencarian=kartu&nomor=${data.no_kartu}`,
          beforeSend: function () { },
          success: function (s) {
            console.log(s);
            if (s.data.response !== null) {
              $("#irj-no_rujukan").val(s.data.response.rujukan.noKunjungan);
              // check
              $.get(`${baseurl}bpjs/rujukan/data_jumlah_sep?norujukan=${s.data.response.rujukan.noKunjungan}&jnsrujukan=${s.type}`, function (data, status) {
                $('#jml_terbit_sep').html(data.response.jumlahSEP);
                return;
              })
            }

          },
          error: function (xhr) { },
          complete: function () { },
        });
      } else {
        $("#irj-no_rujukan").val(norujukan);
        asalrujukan = v.cara_kunj === 'RUJUKAN PUSKESMAS' ? '1' : '2';
        // check
        $.get(`${baseurl}bpjs/rujukan/data_jumlah_sep?norujukan=${norujukan}&jnsrujukan=${asalrujukan}`, function (data, status) {
          $('#jml_terbit_sep').html(data.response.jumlahSEP);
          return;
        })
      }
      var poli = v.id_poli;
      $.ajax({
        // check
        url: `${baseurl}irj/rjcregistrasi/cari_poli_bpjs/${poli}`,
        beforeSend: function () { },
        success: function (s) {
          if (s.poli_bpjs !== null || s.poli_bpjs != '') {
            // Check if poli is mata (BH00) to show katarak checkbox
            if (s.poli_bpjs === 'MAT' || v.id_poli === 'BH00') {
              $("#div-katarak").show();
            } else {
              $("#div-katarak").hide();
            }
            $.ajax({
              // check
              url: `${baseurl}bpjs/referensi/dokter_dpjp?pelayanan=2&spesialis=${s.poli_bpjs}`,
              dataType: "json",
              success: function (data) {
                if (data.response !== null) {

                  var html = '';
                  var dokter_list = data.response.list;

                  for (var i = 0; i < dokter_list.length; i++) {
                    html += `<option value="${dokter_list[i].kode}">${dokter_list[i].nama}</option>`;
                  }
                  $('#dpjp_skdp').html(html);
                }
              }
            });
          }

        },
        error: function (xhr) { },
        complete: function () { },
      });

      $(".autocomplete_diagnosa_irj").select2({
        // dropdownParent: $(".modal_buat_sep .modal-content"),
        ajax: {
          // check
          url: `${baseurl}irj/rjcpelayanan/select2s_diagnosa`,
          dataType: 'json',
          delay: 250,

          data: function (params) {
            return {
              term: params.term
            };
          },
          processResults: function (data) {
            console.log(data);
            return {
              results: data
            };
          },
          cache: true
        },
        minimumInputLength: 2, // Minimum characters to start searching
        placeholder: 'Search for a diagnosis',
      });
      if ((v.diagnosa !== '' || v.diagnosa !== null) && v.nama_diagnosa !== '') {
        $("#diagnosa_irj").html(`<option value="${v.diagnosa}" selected>${v.diagnosa} - ${v.nama_diagnosa}</option>`)
      }

    },
    error: function (xhr) { },
    complete: function () { },
  });
  $(".modal_buat_sep_irj").modal("toggle");
}

function perbaruisep(data) {
  const { no_register } = data;
  const no_sep = $("#" + no_register).val();
  $.post(urlupdatesep, { no_register, no_sep }, function (data, status) {
    Notify(data.metadata.response, null, null, "success");
    //   alert("Data: " + data + "\nStatus: " + status);
  });
}

function showmodalspri(data){
  $("#no_kartu_buat_spri").val(
    data.no_kartu
  );
  $("#no_ipd").val(
    data.no_register
  );
  $("#title-spri").html("PEMBUATAN SPRI");
  $("#tgl_rencana_ranap").val("");

  $(".modal_spri").modal("toggle");
}

function showmodalsuratkontrol(data) {
  // console.log(data.no_register);
  // console.log($("#" + data.no_register).val());
  $("#no_sep_surat_bikin").val(
    data.no_sep ? data.no_sep : $("#" + data.no_register).val()
  );
  $("#title-suratkontrol").html("PEMBUATAN Surat Kontrol");
  // Restore original label for regular surat kontrol
  $("label[for='no_sep_surat_bikin'], .modal_suratkontrol .form-group:first-child label").text("No.SEP");

  // Restore original onchange function for regular surat kontrol
  $("#tgl_surat_bikin").attr('onchange', 'ambilpolikontrol(this.value)');

  $("#footer-suratkontrol").html(`
        <button type="button" class="btn btn-primary waves-effect text-left" id="buat-suratkontrol" onclick="buatsuratkontrol()" >Buat Surat Kontrol</button>
    `);
  $("#tgl_surat_bikin").val("");

  $(".modal_suratkontrol").modal("toggle");
}

function showmodalskdppascarawatinap(data) {
  // Set the SEP number for SKDP Pasca Rawat Inap
  const sepNumber = data.no_sep ? data.no_sep : $("#" + data.no_register).val();
  $("#no_sep_surat_bikin").val(sepNumber);

  $("#title-suratkontrol").html("PEMBUATAN SKDP PASCA RAWAT INAP");
  // Keep original label for creating new SKDP (uses SEP)
  $("label[for='no_sep_surat_bikin'], .modal_suratkontrol .form-group:first-child label").text("No.SEP");

  // Change the date input onchange function to use SKDP specific function
  $("#tgl_surat_bikin").attr('onchange', `ambilpolikontrolpascarawatinap('${sepNumber}', this.value)`);

  $("#footer-suratkontrol").html(`
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary waves-effect text-left" id="buat-skdp-pascarawatinap" onclick="buatskdppascarawatinap()" >Buat SKDP Pasca Rawat Inap</button>
    `);
  $("#tgl_surat_bikin").val("");

  $(".modal_suratkontrol").modal("toggle");
}


function perbaruishowmodalspri(data){
  console.log(data);
  $("#no_kartu_buat_spri").val(data.no_kartu);
  $("#no_ipd").val(data.no_register);
  $.ajax({
    url: `${baseurl}/irj/rjcregistrasi/get_spri/${data.no_surat}`,
    beforeSend: function () { },
    success: function (v) {
      $("#tgl_rencana_ranap").val(v.tgl_rencana_kontrol);
      ambilpolispri(v.tgl_rencana_kontrol);
      $("#title-spri").html("Edit SPRI");
      $("#footer-spri").html(`
        <button type="button" id="edit-spri" class="btn btn-primary waves-effect text-left" onclick="editspri('${data.no_surat}')" >Edit SPRI</button>
            `);
      $("#buat-spri").hide();
    },
    error: function (xhr) { },
    complete: function () { },
  });
  $(".modal_spri").modal("toggle");
}

function perbaruishowmodalsuratkontrol(data) {
  console.log(data);
  $("#no_sep_surat_bikin").val(data.no_sep);
  $.ajax({
    url: `${baseurl}/irj/rjcregistrasi/get_suratkontrol/${$(
      "#no_sep_surat_bikin"
    ).val()}`,
    beforeSend: function () { },
    success: function (v) {
      $("#tgl_surat_bikin").val(v.tgl_rencana_kontrol);
      $("#title-suratkontrol").html("Edit Surat Kontrol");
      // Restore original label for regular surat kontrol edit
      $("label[for='no_sep_surat_bikin'], .modal_suratkontrol .form-group:first-child label").text("No.SEP");

      // Restore original onchange function for regular surat kontrol edit
      $("#tgl_surat_bikin").attr('onchange', 'ambilpolikontrol(this.value)');

      $("#footer-suratkontrol").html(`
				<button type="button" id="edit-suratkontrol" class="btn btn-primary waves-effect text-left" onclick="editsuratkontrol('${data.no_surat}')" >Edit Surat Kontrol</button>
            `);
      $("#buat-suratkontrol").hide();
    },
    error: function (xhr) { },
    complete: function () { },
  });
  $(".modal_suratkontrol").modal("toggle");
}

function editshowmodalskdppascarawatinap(data) {
  console.log(data);
  // Use no_sep to get SKDP data from bpjs_suratkontrol table
  $.ajax({
    url: `${baseurl}/irj/rjcregistrasi/get_suratkontrol/${data.no_sep}`,
    beforeSend: function () { },
    success: function (v) {
      if (v && v.surat_kontrol) {
        // Set the surat kontrol number in the field
        $("#no_sep_surat_bikin").val(v.surat_kontrol);
        $("#tgl_surat_bikin").val(v.tgl_rencana_kontrol);

        // Change the date input onchange function to use SKDP specific function
        $("#tgl_surat_bikin").attr('onchange', `ambilpolikontrolpascarawatinap('${data.no_sep}', this.value)`);

        // Load initial poli data
        ambilpolikontrolpascarawatinap(data.no_sep,v.tgl_rencana_kontrol);

        $("#title-suratkontrol").html("Edit SKDP Pasca Rawat Inap");
        // Change the label to show "No. Surat Kontrol" instead of "No.SEP"
        $("label[for='no_sep_surat_bikin'], .modal_suratkontrol .form-group:first-child label").text("No. Surat Kontrol");
        $("#footer-suratkontrol").html(`
          <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
          <button type="button" id="edit-skdp-pascarawatinap" class="btn btn-primary waves-effect text-left" onclick="editskdppascarawatinap('${data.no_sep}','${v.surat_kontrol}')" >Edit SKDP Pasca Rawat Inap</button>
        `);
        $("#buat-suratkontrol").hide();
      } else {
        swal("Error!", "Data SKDP tidak ditemukan atau belum ada SKDP yang dibuat sebelumnya", "error");
      }
    },
    error: function (xhr) {
      swal("Error!", "Data SKDP tidak ditemukan atau belum ada SKDP yang dibuat sebelumnya", "error");
    },
    complete: function () { },
  });
  $(".modal_suratkontrol").modal("toggle");
}

function ambilpolikontrol(tgl) {
  $.ajax({
    url: `${baseurl}/bpjs/rencanakontrol/data_poli?jnskontrol=2&nomor=${$(
      "#no_sep_surat_bikin"
    ).val()}&tglrencanakontrol=${tgl}`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      if (data.metaData.code === "200") {
        data.response.list.map((e) => {
          html += `<option value="${e.kodePoli}">${e.namaPoli}</option>`;
        });
        $("#poli_suratkontrol_bikin").empty();
        $("#poli_suratkontrol_bikin").append(
          '<option value="">Silahkan Pilih Poliklinik..</option>'
        );
        $("#poli_suratkontrol_bikin").append(html);
        return;
      }
      new swal("Peringatan!", data.metaData.message, "warning");
    },
    error: function (xhr) { },
    complete: function () { },
  });
}

function ambilpolikontrolpascarawatinap(nosep,tgl) {
  $.ajax({
    url: `${baseurl}/bpjs/rencanakontrol/data_poli?jnskontrol=2&nomor=${nosep}&tglrencanakontrol=${tgl}`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      if (data.metaData.code === "200") {
        data.response.list.map((e) => {
          html += `<option value="${e.kodePoli}">${e.namaPoli}</option>`;
        });
        $("#poli_suratkontrol_bikin").empty();
        $("#poli_suratkontrol_bikin").append(
          '<option value="">Silahkan Pilih Poliklinik..</option>'
        );
        $("#poli_suratkontrol_bikin").append(html);
        return;
      }
      new swal("Peringatan!", data.metaData.message, "warning");
    },
    error: function (xhr) { },
    complete: function () { },
  });
}

function ambilpolispri(tgl) {
  $.ajax({
    url: `${baseurl}/bpjs/rencanakontrol/data_poli?jnskontrol=1&nomor=${$(
      "#no_kartu_buat_spri"
    ).val()}&tglrencanakontrol=${tgl}`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      if (data.metaData.code === "200") {
        data.response.list.map((e) => {
          html += `<option value="${e.kodePoli}">${e.namaPoli}</option>`;
        });
        $("#poli_spri_bikin").empty();
        $("#poli_spri_bikin").append(
          '<option value="">Silahkan Pilih Poliklinik..</option>'
        );
        $("#poli_spri_bikin").append(html);
        return;
      }
      new swal("Peringatan!", data.metaData.message, "warning");
    },
    error: function (xhr) { },
    complete: function () { },
  });
}

function ambildoktersuratkontrol(kodepoli) {
  $.ajax({
    url: `${baseurl}/bpjs/rencanakontrol/data_dokter?jnskontrol=2&poli=${kodepoli}&tglrencanakontrol=${$(
      "#tgl_surat_bikin"
    ).val()}`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      if (data.metaData.code === "200") {
        data.response.list.map((e) => {
          html += `<option value="${e.kodeDokter}-${e.namaDokter}">${e.namaDokter} (${e.jadwalPraktek})</option>`;
        });
        $("#dpjp_suratkontrol_bikin").empty();
        $("#dpjp_suratkontrol_bikin").append(
          '<option value="">Silahkan Pilih Dokter</option>'
        );
        $("#dpjp_suratkontrol_bikin").append(html);
      }
    },
    error: function (xhr) { },
    complete: function () { },
  });
}


function ambildokterspri(kodepoli) {
  $.ajax({
    url: `${baseurl}/bpjs/rencanakontrol/data_dokter?jnskontrol=1&poli=${kodepoli}&tglrencanakontrol=${$(
      "#tgl_rencana_ranap"
    ).val()}`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      if (data.metaData.code === "200") {
        data.response.list.map((e) => {
          html += `<option value="${e.kodeDokter}-${e.namaDokter}">${e.namaDokter} (${e.jadwalPraktek})</option>`;
        });
        $("#dpjp_spri_bikin").empty();
        $("#dpjp_spri_bikin").append(
          '<option value="">Silahkan Pilih Dokter</option>'
        );
        $("#dpjp_spri_bikin").append(html);
      }
    },
    error: function (xhr) { },
    complete: function () { },
  });
}

function buatsuratkontrol() {
  $.ajax({
    method: "POST",
    type: "JSON",
    data: {
      sep: $("#no_sep_surat_bikin").val(),
      dokter: $("#dpjp_suratkontrol_bikin").val().split("-")[0],
      poli: "A -" + $("#poli_suratkontrol_bikin").val(),
      tglrencanakontrol: $("#tgl_surat_bikin").val(),
      user: "ADMIN",
      nama_dokter: $("#dpjp_suratkontrol_bikin").val().split("-")[1],
    },
    url: `${baseurl}/bpjs/rencanakontrol/insert_surat_kontrol`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      if (data.metaData.code === "200") {
        Notify(
          `No. Surat Kontrol Berhasil dibuat: ${data.response.noSuratKontrol}`,
          null,
          null,
          "success"
        );
        location.href =
          baseurl +
          `/bpjs/rencanakontrol/cetak_surkon_spri?data=${data.response.noSuratKontrol}&nokartu=${data.response.noKartu}`;
        // noKartu
        // $('#no_surat_kontrol_skdp').val(data.response.noSuratKontrol);
        // $('#dpjp_suratkontrol').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
        $(".modal_suratkontrol").modal("hide");
        table.ajax.reload();
      } else {
        // Notify(`No. Surat Kontrol Gagal dibuat: ${data.metaData.message}`, null, null, 'error');
        swal("Peringatan!", data.metaData.message, "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    },
    complete: function () { },
  });
}

function buatskdppascarawatinap() {
  $.ajax({
    method: "POST",
    type: "JSON",
    data: {
      sep: $("#no_sep_surat_bikin").val(),
      dokter: $("#dpjp_suratkontrol_bikin").val().split("-")[0],
      poli: "A -" + $("#poli_suratkontrol_bikin").val(),
      tglrencanakontrol: $("#tgl_surat_bikin").val(),
      user: "ADMIN",
      nama_dokter: $("#dpjp_suratkontrol_bikin").val().split("-")[1],
    },
    url: `${baseurl}/bpjs/rencanakontrol/insert_surat_kontrol`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      if (data.metaData.code === "200") {
        Notify(
          `No. SKDP Pasca Rawat Inap Berhasil dibuat: ${data.response.noSuratKontrol}`,
          null,
          null,
          "success"
        );
        location.href =
          baseurl +
          `/bpjs/rencanakontrol/cetak_surkon_spri?data=${data.response.noSuratKontrol}&nokartu=${data.response.noKartu}`;
        $(".modal_suratkontrol").modal("hide");
        table.ajax.reload();
        tableiri.ajax.reload();
      } else {
        swal("Peringatan!", data.metaData.message, "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    },
    complete: function () { },
  });
}



function buatspri() {
  $.ajax({
    method: "POST",
    type: "JSON",
    data: {
      noKartu: $("#no_kartu_buat_spri").val(),
      kodeDokter: $("#dpjp_spri_bikin").val().split("-")[0],
      poliKontrol:  $("#poli_spri_bikin").val(),
      tglRencanaKontrol: $("#tgl_rencana_ranap").val(),
      user: "ADMIN",
      nama_dokter: $("#dpjp_spri_bikin").val().split("-")[1],
      no_ipd: $("#no_ipd").val(),
    },
    url: `${baseurl}/bpjs/rencanakontrol/insert_spri`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      if (data.metaData.code === "200") {
        Notify(
          `No. Surat Kontrol Berhasil dibuat: ${data.response.noSPRI}`,
          null,
          null,
          "success"
        );
        location.href =
          baseurl +
          `/bpjs/rencanakontrol/cetak_spri?data=${data.response.noSPRI}&nokartu=${$("#no_kartu_buat_spri").val()}`;
        // noKartu
        // $('#no_surat_kontrol_skdp').val(data.response.noSuratKontrol);
        // $('#dpjp_suratkontrol').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
        $(".modal_spri").modal("hide");
        tableiri.ajax.reload();
      } else {
        // Notify(`No. Surat Kontrol Gagal dibuat: ${data.metaData.message}`, null, null, 'error');
        swal("Peringatan!", data.metaData.message, "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    },
    complete: function () { },
  });
}

function editspri(surat){
  const $btn = $("#edit-spri");
  $.ajax({
    method: "POST",
    type: "JSON",
    beforeSend: function () {
      $btn.prop("disabled", true);
      $btn.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    },
    data: {
      jenissurat: "1",
      noKartu: $("#no_kartu_buat_spri").val(),
      kodeDokter: $("#dpjp_spri_bikin").val().split("-")[0],
      poliKontrol: $("#poli_spri_bikin").val(),
      tglRencanaKontrol: $("#tgl_rencana_ranap").val(),
      user: "EKAMEK",
      nama_dokter: $("#dpjp_spri_bikin").val().split("-")[1],
      noSuratKontrol: surat,
      no_ipd: $("#no_ipd").val(),
    },
    url: `${baseurl}/bpjs/rencanakontrol/update_spri`,
    success: function (data) {
      let html = "";
      console.log(data);
      if (data.metaData.code === "200") {
        swal("Berhasil!", "No. SPRI Berhasil diupdate", "success");
        // Notify(`No. Surat Kontrol Berhasil diupdate`, null, null, 'success');
        // $('#no_surat_kontrol_skdp').val(data.response.noSuratKontrol);
        // $('#dpjp_suratkontrol').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
        tableiri.ajax.reload();
        $(".modal_spri").modal("hide");
      } else {
        // Notify(`No. Surat Kontrol Gagal Diupdate!`, null, null, 'error');
        swal("Peringatan!", data.metaData.message, "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    },
    complete: function () {
      $btn.prop("disabled", false);
      $btn.html("Edit SPRI");
    },
  });
}

function editsuratkontrol(surat) {
  $.ajax({
    method: "POST",
    type: "JSON",
    data: {
      jenissurat: "2",
      noSEP: $("#no_sep_surat_bikin").val(),
      kodeDokter: $("#dpjp_suratkontrol_bikin").val().split("-")[0],
      poliKontrol: $("#poli_suratkontrol_bikin").val(),
      tglRencanaKontrol: $("#tgl_surat_bikin").val(),
      user: "EKAMEK",
      nama_dokter: $("#dpjp_suratkontrol_bikin").val().split("-")[1],
      noSuratKontrol: surat,
    },
    url: `${baseurl}/bpjs/rencanakontrol/update_rencana_kontrol`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      console.log(data);
      if (data.metaData.code === "200") {
        swal("Berhasil!", "No. Surat Kontrol Berhasil diupdate", "success");
        // Notify(`No. Surat Kontrol Berhasil diupdate`, null, null, 'success');
        // $('#no_surat_kontrol_skdp').val(data.response.noSuratKontrol);
        // $('#dpjp_suratkontrol').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
        table.ajax.reload();
        $(".modal_suratkontrol").modal("hide");
      } else {
        // Notify(`No. Surat Kontrol Gagal Diupdate!`, null, null, 'error');
        swal("Peringatan!", data.metaData.message, "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    },
    complete: function () { },
  });
}

function editskdppascarawatinap(nosep,surat) {
  $.ajax({
    method: "POST",
    type: "JSON",
    data: {
      jenissurat: "2",
      noSuratKontrol: surat,
      noSEP:nosep,
      kodeDokter: $("#dpjp_suratkontrol_bikin").val().split("-")[0],
      poliKontrol: $("#poli_suratkontrol_bikin").val(),
      tglRencanaKontrol: $("#tgl_surat_bikin").val(),
      user: "ADMIN",
      nama_dokter: $("#dpjp_suratkontrol_bikin").val().split("-")[1],
    },
    url: `${baseurl}/bpjs/rencanakontrol/update_rencana_kontrol`,
    beforeSend: function () {
      $("#edit-skdp-pascarawatinap").prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    },
    success: function (data) {
      let html = "";
      console.log(data);
      if (data.metaData.code === "200") {
        swal("Berhasil!", "No. SKDP Pasca Rawat Inap Berhasil diupdate", "success");
        table.ajax.reload();
        tableiri.ajax.reload();
        $(".modal_suratkontrol").modal("hide");
      } else {
        swal("Peringatan!", data.metaData.message, "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    },
    complete: function () {
      $("#edit-skdp-pascarawatinap").prop('disabled', false).html('Edit SKDP Pasca Rawat Inap');
    },
  });
}

function cetaksuratkontrolrs(data) {
  window.open(
    `${baseurl}/emedrec/C_emedrec/cetak_surat_kontrol_new/${data.no_cm}/${data.no_register}`,
    "_blank"
  );
}

function hapusspri(data){
  $.ajax({
    method: "POST",
    type: "JSON",
    data: {
      user: "Admin IT",
      noSuratKontrol: data.no_surat,
      no_ipd: data.no_register,
    },
    url: `${baseurl}/bpjs/rencanakontrol/hapus_spri`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      console.log(data);
      if (data.metaData.code === "200") {
        swal("Berhasil!", "No. SPRI Berhasil dihapus", "success");
        // Notify(`No. Surat Kontrol Berhasil diupdate`, null, null, 'success');
        // $('#no_surat_kontrol_skdp').val(data.response.noSuratKontrol);
        // $('#dpjp_suratkontrol').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
        tableiri.ajax.reload();
        // $(".modal_suratkontrol").modal("hide");
      } else {
        // Notify(`No. Surat Kontrol Gagal Diupdate!`, null, null, 'error');
        swal("Peringatan!", data.metaData.message, "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    },
    complete: function () { },
  });
}

function hapussuratkontrol(data) {
  $.ajax({
    method: "POST",
    type: "JSON",
    data: {
      user: "EKAMEK",
      noSuratKontrol: data.no_surat,
    },
    url: `${baseurl}/bpjs/rencanakontrol/hapus_rencana_kontrol`,
    beforeSend: function () { },
    success: function (data) {
      let html = "";
      console.log(data);
      if (data.metaData.code === "200") {
        swal("Berhasil!", "No. Surat Kontrol Berhasil dihapus", "success");
        // Notify(`No. Surat Kontrol Berhasil diupdate`, null, null, 'success');
        // $('#no_surat_kontrol_skdp').val(data.response.noSuratKontrol);
        // $('#dpjp_suratkontrol').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
        table.ajax.reload();
        $(".modal_suratkontrol").modal("hide");
      } else {
        // Notify(`No. Surat Kontrol Gagal Diupdate!`, null, null, 'error');
        swal("Peringatan!", data.metaData.message, "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    },
    complete: function () { },
  });
}

function hapusskdppascarawatinap(data) {
  // Get SKDP data using same endpoint as edit function
  $.ajax({
    url: `${baseurl}/irj/rjcregistrasi/get_suratkontrol/${data.no_sep}`,
    beforeSend: function () { },
    success: function (v) {
      if (v && v.surat_kontrol) {
        // Show confirmation dialog
        swal({
          title: "Hapus SKDP Pasca Rawat Inap?",
          text: `No. Surat Kontrol: ${v.surat_kontrol}`,
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, Hapus!",
          cancelButtonText: "Batal",
          closeOnConfirm: false
        }, function() {
          // Call deletion using same pattern as hapussuratkontrol
          $.ajax({
            method: "POST",
            type: "JSON",
            data: {
              user: "ADMIN",
              noSuratKontrol: v.surat_kontrol,
            },
            url: `${baseurl}/bpjs/rencanakontrol/hapus_rencana_kontrol`,
            beforeSend: function () { },
            success: function (data) {
              console.log(data);
              if (data.metaData.code === "200") {
                swal("Berhasil!", "SKDP Pasca Rawat Inap berhasil dihapus", "success");
                tableiri.ajax.reload();
              } else {
                swal("Peringatan!", data.metaData.message, "warning");
              }
            },
            error: function (xhr) {
              swal("Peringatan!", "Hubungi Admin IT", "warning");
            }
          });
        });
      } else {
        swal("Peringatan!", "Data SKDP tidak ditemukan atau belum ada SKDP yang dibuat sebelumnya", "warning");
      }
    },
    error: function (xhr) {
      swal("Peringatan!", "Hubungi Admin IT", "warning");
    }
  });
}

