$(function () {
  const table = new DataTable("#table-artikel", {
    processing: true,
    columns: [
      {
        data: "tgl",
      },
      {
        data: "nama_pasien",
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
        data: "nama_poli",
      },
      {
        data: null,
        render: function (data, type, row) {
          // delete row.nama_pasien;
          
          return `
            <a target="_blank" href="${baseurl}bpjs/rencanakontrol/insert/${row.no_sep}"><input type="button" class="btn 
							btn-danger btn-sm" value="Buat Surat Kontrol"></a> 
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



  

  $("#inputcustom").keyup(function () {
    table.search($(this).val()).draw();
  });
 
  $("#datepicker").on("change", function () {
      // console.log(this.value);
    table.ajax.url(urllistkontrol + "/" + this.value);

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
});


