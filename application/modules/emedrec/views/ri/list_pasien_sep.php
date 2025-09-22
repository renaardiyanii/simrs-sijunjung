<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<style>
#notifications {
    cursor: pointer;
    position: fixed;
    right: 0px;
    z-index: 9999;
    top: 100px;
    margin-bottom: 22px;
    margin-right: 15px;
    max-width: 300px;
}
.input-group-text i.mdi.mdi-calendar {
    font-size: 18px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

/* Style for the white background div */
.input-group {
    background-color: white;
    border: 1px solid #ccc;
    /* Add a border for visual separation */
}

/* Style for the input field */
.form-control {
    min-height:22px;
    /* border: none; */
    /* Remove the input field border */
}
.borderless{
    border: none!important;

}

/* Style for the icon */
.input-group-text i.mdi.mdi-calendar {
    font-size: 18px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

/* .dataTables_filter {
    display: none;
}

.dataTables_length {
    display: none;
} */

.dataTables_info {
    margin-left: 1em;
    margin-bottom: 1em;
}

.paginate_button {
    margin-right: 1em;
    margin-bottom: 1em;
}
</style>
<script type="text/javascript">
var datenow = '<?= date('Y-m-d') ?>';
var urllistirj = "<?php echo base_url('emedrec/c_emedrec_iri/get_sep_iri'); ?>";
var urlupdatesep = "<?php echo base_url('emedrec/c_emedrec_iri/update_sep'); ?>";
var baseurl = '<?= base_url('') ?>';
var table;
// $(document).ready(function() {
//     $('#example').DataTable();
// });

$(function () {
    table = new DataTable("#example", {
    processing: true,
    searching: true,
    columns: [
      {
        data: "tgl_masuk",
      },
      {
        data: "tgl_keluar",
      },
      {
        data: "nmruang",
      },
      {
        data: "no_cm",
      },
      {
        data: "no_ipd",
      },
      {
        data: "nama",
      },
      {
        data: "sex",
      },
      {
        data: "dokter",
      },
      {
        data: null,
        render: function (data, type, row) {
          return `<input style="width:200px" type="text"
           class="form-control" id="${row.no_ipd}">`;
        },
      },
      {
        data: null,
        render: function (data, type, row) {
          //delete row.nama;
          return `<button type="button" class="btn btn-primary btn-sm" onclick='perbaruisep(${JSON.stringify(row)})'>Perbarui SEP</button>`;
        },
      },
    ],
    columnDefs: [
        { width: "40px", targets: [0, 2, 3, 8] }, // Set the width for the first 7 columns
        { width: "10px", targets: 5 },
        { width: "100px", targets: [1, 4, 6] },
        { width: "150px", targets: 7 },// Set the width for the button column
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

  $("#date").on("change", function () {
    table.ajax.url(urllistirj + "?tglkunjungan=" + this.value);

    // Reload the DataTable with the new AJAX URL
    table.ajax.reload();
    // table.draw();
  });

  $("#date").datepicker({
    beforeShow: function (input, inst) {
      inst.dpDiv.css({
        top: $(input).offset().top + $(input).outerHeight(),
        left: $(input).offset().left,
      });
    },
    dateFormat: "yy-mm-dd",
  });
});

function perbaruisep(data) {
  const { no_ipd } = data;
  const no_sep = $("#" + no_ipd).val();
  $.post(urlupdatesep, { no_ipd, no_sep }, function (data, status) {
    Notify(data.metadata.response, null, null, "success");
    //   alert("Data: " + data + "\nStatus: " + status);
    table.ajax.reload();
  });
}
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <div class="row p-t-0 mt-3">
                    <div class="col-sm-4">
                        <div class="input-group d-flex align-items-center">
                            <input type="text" class="form-control borderless" id="date" placeholder="Pilih Tanggal">

                            <div class="input-group-prepend mr-2">
                                <span class="input-group-text">
                                    <i class="mdi mdi-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
			</div>			
		</div>						
	</div>
</div>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Pasien Rawat Inap SEP Kosong</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tgl Masuk</th>
                                        <th>Tgl Keluar</th>
                                        <th>Ruang</th>
                                        <th>No Medrec</th>
                                        <th>No Register</th>
                                        <th>Nama</th>
                                        <th>J.Kel</th>
                                        <th>DPJP</th>
                                        <th>No SEP</th>
                                        <th>Aksi</th>
                                    </tr>                                      
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->
<div id="notifications"></div>
<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-datatablenew.js"></script>
<!-- <script src="<?= base_url() ?>asset/js/jquery-dataTables.js"></script> -->
<script src="<?= base_url('assets/notify.js') ?>"></script>
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>