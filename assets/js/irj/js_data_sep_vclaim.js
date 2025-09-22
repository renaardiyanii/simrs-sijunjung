$(function () {
  const table = new DataTable("#table-artikel", {
    processing: true,
    columns: [
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
          // delete row.nama_pasien;
          
          return `
            <a target="_blank" href="${baseurl}bpjs/sep/history_sep/${row.no_kartu}"><input type="button" class="btn 
							btn-danger btn-sm" value="Lihat Data"></a> 
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
      url: urllistsepvclaim,
      type: "GET",
      dataSrc: "result",
    },
    infoCallback: function (settings, start, end, max, total, pre) {
      return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
    },
  });


  const tablekontrol = new DataTable("#table-kontrol", {
    processing: true,
    columns: [
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
          // delete row.nama_pasien;
          
          return `
            <a target="_blank" href="${baseurl}bpjs/rencanakontrol/history_rencanakontrol/${row.no_kartu}"><input type="button" class="btn 
							btn-danger btn-sm" value="Lihat Data"></a> 
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
      url: urllistsepkontrol,
      type: "GET",
      dataSrc: "result",
    },
    infoCallback: function (settings, start, end, max, total, pre) {
      return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
    },
  });

 
  $("#no_kartu").on("change", function () {
      // console.log(this.value);
    table.ajax.url(urllistsepvclaim + "/" + this.value);

    // Reload the DataTable with the new AJAX URL
    table.ajax.reload();
  });

  $("#no_kartu_kontrol").on("change", function () {
    // console.log(this.value);
    tablekontrol.ajax.url(urllistsepkontrol + "/" + this.value);

  // Reload the DataTable with the new AJAX URL
  tablekontrol.ajax.reload();
});

 
});


