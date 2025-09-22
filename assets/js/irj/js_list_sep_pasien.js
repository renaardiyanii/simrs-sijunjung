$(function () {
  const table = new DataTable("#table-artikel", {
    processing: true,
    columns: [
      {
        data: "tgl_rencana_kontrol",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `${row.nama_pasien}<br>(${row.no_rm})`;
        },
      },
      {
        data: "no_kartu",
      },
      {
        data: "no_sep_asal",
      },
      {
        data: "no_surat",
      },
      {
        data: "nama_poli",
      },
      {
        data: null,
        render: function (data, type, row) {
          delete row.nama;
          var surkon = btoa(row.no_surat);
          return `
            <a target="_blank" href="daftarulangnew/${row.medrec}?q=${surkon}"><input type="button" class="btn 
							btn-warning btn-sm" value="Daftar Ulang"></a> 

               <a target="_blank" href="${baseurl}bpjs/rencanakontrol/update/${row.no_surat}"><input type="button" class="btn 
							btn-primary btn-sm" value="Edit Surat Kontrol"></a>

              <button type="button" class="btn 
							btn-danger btn-sm" onclick='hapussuratkontrol(${JSON.stringify(
                row
              )})'>Hapus Surat Kontrol</button>
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
      url: urllistkontrol,
      type: "GET",
      dataSrc: "result",
    },
    infoCallback: function (settings, start, end, max, total, pre) {
      return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
    },
  });



  const tablekonsul = new DataTable("#table-konsul", {
    processing: true,
    columns: [
      {
        data: "tgl_konsul",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `${row.nama}<br>(${row.no_cm})`;
        },
      },
      {
        data: "no_reg",
      },
      {
        data: "no_kartu",
      },
      {
        data: "poli_asal",
      },
      {
        data: "dokter_asal",
      },
      {
        data: "poli_akhir",
      },
      {
        data: "dokter_akhir",
      },
      {
        data: null,
        render: function (data, type, row) {
          delete row.nama;

          return ` <a target="_blank" href="${baseurl}emedrec/C_emedrec/lembar_konsul_pasien/${row.no_reg}/${row.no_cm}/${row.no_medrec}"><input type="button" class="btn 
							btn-primary" value="Cetak Lembar Konsul"></a><br>
          
          <a target="_blank" href="daftarulangnew/${row.no_medrec}/${row.no_reg}"><input type="button" class="btn 
							btn-danger" value="Daftar Ulang"></a> `;
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
      url: urllistkonsul,
      type: "GET",
      dataSrc: "result",
    },
    infoCallback: function (settings, start, end, max, total, pre) {
      return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
    },
  });


  const tablerujukan = new DataTable("#table-rujukan", {
    processing: true,
    columns: [
      {
        data: "tgl_input",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `${row.nama}<br>(${row.no_cm})`;
        },
      },
      {
        data: "no_kartu",
      },
      {
        data: "no_sep",
      },
      {
        data: "rumah_sakit",
      },
      {
        data: "bagian",
      },
      {
        data: null,
        render: function (data, type, row) {
          delete row.nama;

          return ` <a target="_blank" href="${baseurl}emedrec/C_emedrec/surat_rujukan_pasien/${row.no_register}/${row.no_cm}/${row.no_medrec}"><input type="button" class="btn 
							btn-primary" value="Cetak Surat Rujukan"></a><br>
              <a target="_blank" href="${baseurl}bpjs/rujukan/insertrujukan/${row.no_sep}"><input type="button" class="btn 
							btn-danger" value="Buat Surat Rujukan"></a><br> `;
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
      url: urllistrujukan,
      type: "GET",
      dataSrc: "result",
    },
    infoCallback: function (settings, start, end, max, total, pre) {
      return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
    },
  });

  const tableiri = new DataTable("#table-iri", {
    processing: true,
    columns: [
      {
        data: "tgl_keluar",
      },
      {
        data: "nama",
      },
      {
        data: "no_cm",
      },
      {
        data: "no_kartu",
      },
      {
        data: "no_sep",
      },
      {
        data: null,
        render: function (data, type, row) {
          // delete row.nama;

          return ` <a target="_blank" href="${baseurl}bpjs/rencanakontrol/insert/${row.no_sep}"><input type="button" class="btn 
							btn-danger btn-sm" value="Buat Surat Kontrol"></a> `;
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

  const tablebackdateranap = new DataTable("#table-backdateranap", {
    processing: true,
    columns: [
      {
        data: "tgl_kunjungan",
      },
      {
        data: "nama",
      },
      {
        data: "no_cm",
      },
      {
        data: "no_kartu",
      },
      {
        data: null,
        render: function (data, type, row) {
          // delete row.nama;

          return `   <a type="button" class="btn btn-primary" onclick='pengajuanbackdatefinger(${JSON.stringify(
                            row
                          )})'>Pengajuan Backdate</a> `;
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
      url: urllistbackdateranap,
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

  $("#inputcustom-konsul").keyup(function () {
    tablekonsul.search($(this).val()).draw();
  });

  $("#inputcustom-rujukan").keyup(function () {
    tablerujukan.search($(this).val()).draw();
  });

  $("#inputcustom-iri").keyup(function () {
    tableiri.search($(this).val()).draw();
  });

  $("#inputcustom-backdateranap").keyup(function () {
    tablebackdateranap.search($(this).val()).draw();
  });


  $("#datepicker").daterangepicker({
    beforeShow: function (input, inst) {
        inst.dpDiv.css({
            top: $(input).offset().top + $(input).outerHeight(),
            left: $(input).offset().left,
        });
    },
    opens: 'left',
    // Format tanggal saat menampilkan kalender
    locale: {
        format: 'YYYY-MM-DD'
    },
    startDate: moment(),
    endDate: moment(),
}, function(start, end, label) {
    // Callback ini dipanggil setelah tanggal dipilih
    handleDateRange(start, end);
});

// Fungsi untuk menangani rentang tanggal
function handleDateRange(start, end) {
    // Format tanggal menjadi YYYY-MM-DD
    let tgl_awal = start.format('YYYY-MM-DD');
    let tgl_akhir = end.format('YYYY-MM-DD');
    
    console.log('Tanggal Awal:', tgl_awal); // Output: 2024-08-05
    console.log('Tanggal Akhir:', tgl_akhir); // Output: 2024-08-10
    
    // Set URL untuk AJAX request
    table.ajax.url(urllistkontrol + "/" + tgl_awal + "/" + tgl_akhir);
    
    // Reload DataTable dengan URL AJAX baru
    table.ajax.reload();
}



 

  $("#datepicker-konsul").on("change", function () {
    //    console.log(this.value);
    tablekonsul.ajax.url(urllistkonsul + "/" + this.value);

    // Reload the DataTable with the new AJAX URL
    tablekonsul.ajax.reload();
  });

  $("#datepicker-konsul").datepicker({
    beforeShow: function (input, inst) {
      inst.dpDiv.css({
        top: $(input).offset().top + $(input).outerHeight(),
        left: $(input).offset().left,
      });
    },
    dateFormat: "yy-mm-dd",
  });


  $("#datepicker-rujukan").on("change", function () {
     console.log(this.value);
    tablerujukan.ajax.url(urllistrujukan + "/" + this.value);

    // Reload the DataTable with the new AJAX URL
    tablerujukan.ajax.reload();
  });

  $("#datepicker-rujukan").datepicker({
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
    tableiri.ajax.url(urllistiri + "/" + this.value);

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


  $("#datepicker-backdateranap").on("change", function () {
    //    console.log(this.value);
    tablebackdateranap.ajax.url(urllistbackdateranap + "/" + this.value);

    // Reload the DataTable with the new AJAX URL
    tablebackdateranap.ajax.reload();
  });

  $("#datepicker-backdateranap").datepicker({
    beforeShow: function (input, inst) {
      inst.dpDiv.css({
        top: $(input).offset().top + $(input).outerHeight(),
        left: $(input).offset().left,
      });
    },
    dateFormat: "yy-mm-dd",
  });
});

function pengajuanbackdatefinger(data){
  var data = btoa(JSON.stringify(data));
  
  window.open(`${baseurl}bpjs/finger/index?data=${data}`, '_blank');
}


function hapussuratkontrol(data) {
  swal({
    title: "Konfirmasi Penghapusan",
    text: `Apakah Anda yakin ingin menghapus No. Surat Kontrol ${data.no_surat}?`,
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Tidak!",
    closeOnConfirm: false,
    closeOnCancel: false
  }, function (isConfirm) {
    if (isConfirm) {
      $.ajax({
        method: "POST",
        type: "JSON",
        data: {
          user: "EKAMEK",
          noSuratKontrol: data.no_surat,
        },
        url: `${baseurl}/bpjs/rencanakontrol/hapus_rencana_kontrol`,
        success: function (response) {
          if (response.metaData.code === "200") {
            swal("Berhasil!", "No. Surat Kontrol Berhasil dihapus", "success");
            table.ajax.reload();
            $(".modal_suratkontrol").modal("hide");
          } else {
            swal("Peringatan!", response.metaData.message, "warning");
          }
        },
        error: function () {
          swal("Peringatan!", "Hubungi Admin IT", "warning");
        }
      });
    } else {
      swal("Dibatalkan", "Penghapusan dibatalkan", "info");
    }
  });
}





