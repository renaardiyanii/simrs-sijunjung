<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<style type="text/css">
    table {
        display: block;
        overflow-x: auto;
    }
</style>
<script type="text/javascript"></script>
<script>
var site = "<?php echo site_url(); ?>";
var table=null;
$(document).ready(function() {
    $('.tgl_jadwal_ok').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        minDate: '0'
    });

    tablejadwalok('');
	tablejadwalinap('');

	var v00 = $("#formsearchok").validate({
      rules: {
        tglok: {
          required: true
        }
      },
    highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
     errorElement: "span",
     errorClass: "help-block help-block-error",
     submitHandler: function(form) {
     		var jadwal = document.getElementById('tglok').value;
             tablejadwalok(jadwal);
        }
    });

    var v00 = $("#formsearchbed").validate({
      rules: {
        tglbed: {
          required: true
        }
      },
    highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
     errorElement: "span",
     errorClass: "help-block help-block-error",
     submitHandler: function(form) {
     		var jadwal = document.getElementById('tglbed').value;
             tablejadwalinap(jadwal);
        }
    });
});

function tablejadwalok(tgl_jadwal){
    table = $('#operasi').DataTable({
        ajax: "<?php echo site_url();?>iri/ricreservasi/show_schedule/"+tgl_jadwal,
        columns: [
            { data: "no_reservasi" },
            { data: "no_reservasi" },
            { data: "type_rawat" },
            { data: "no_cm" },
            { data: "nama" },
            { data: "cara_bayar" },
            { data: "prioritas" },
            { data: "nm_dokter" },
            { data: "ket" },
            { data: "tgl_jadwal_ok" },
            { data: "waktu_ok"},
            { data: "detail"}
        ],        
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
    });
}

var ajaxku;
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function stateChangedRoom(){
    var data;
    if (ajaxku.readyState==4){
        data=ajaxku.responseText;
        if(data.length>=0){
            document.getElementById("ruang").innerHTML = data;
        }
    }
}

function stateChangedBed(){
    var data;
    if (ajaxku.readyState==4){
        data=ajaxku.responseText;
        if(data.length>=0){
            document.getElementById("bed").innerHTML = data;
        }
    }
}

function getemptyroom(tgl){
        if(tgl!='' && tgl!=null){
            ajaxku = buatajax();
            var url="<?php echo site_url('iri/ricreservasi/emptyroom_date'); ?>";
            url=url+"/"+tgl;
            url=url+"/"+Math.random();
            ajaxku.onreadystatechange=stateChangedRoom;
            ajaxku.open("GET",url,true);
            ajaxku.send(null);
        }       
}

function getemptybed(room){
    if(room!='' && room!=null){
        var roomray = room.split("-");
        //alert(roomray[2]);
        var tglrsv = document.getElementById("calendar-tgl-rencana-masuk").value;
        ajaxku = buatajax();
        var url="<?php echo site_url('iri/ricreservasi/emptybed_date');?>"+'/'+roomray[0]+'/'+roomray[2];
        url=url+"/"+tglrsv;
        url=url+"/"+Math.random();
        ajaxku.onreadystatechange=stateChangedBed;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }
}

function tablejadwalinap(tgl_jadwal){
    table = $('#roombed').DataTable({
        ajax: "<?php echo site_url();?>iri/ricreservasi/show_reservation/"+tgl_jadwal,
        columns: [
            { data: "no_reservasi" },
            { data: "no_reservasi" },
            { data: "asal" },
            { data: "no_cm" },
            { data: "nama" },
            { data: "cara_bayar" },
            { data: "nmruang" },
            { data: "kelas" },
            { data: "bed" },
            { data: "nm_dokter" },
            { data: "ket" },
            { data: "tglrencanamasuk" }
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
    });
}

function detail_ok(id){
    window.open('<?php echo site_url('ok/okcdaftar/detail_ok');?>/'+id, '_blank');    
}

function detail_rsrv(id){
    window.open('<?php echo site_url('iri/ricreservasi/detail_rsrv');?>/'+id, '_blank');
}
</script>
<section class="content" style="width:98%;">
        <div class="row">           
            <div class="col-md-12">             
                <div class="card card-outline-info">
                    <div class="card-header" align="center" ><h4 class="text-white">Jadwal Operasi</h4></div>
                    <div class="card-block" >

                        <form class="form-horizontal" method="POST" id="formsearchok">
                            <div class="col-sm-5" >
                                <div class="input-group ">
                                    <input type="text" id="tglok" class="form-control tgl_jadwal_ok" placeholder="Tanggal Jadwal OK" name="tglok" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </span>
                                </div><!-- /input-group -->
                            </div>                              
                        </form>
                        <br>
                        <hr>
                        <table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%" id="operasi">
                            <thead>
                                <tr>
                                    <th>No Reservasi</th>
                                    <th>No Reg/No Reserv</th>
                                    <th>Asal</th>
                                    <th>No MR</th>
                                    <th>Nama</th>                               
                                    <th>Cara Bayar</th>
                                    <th>Prioritas</th>
                                    <th>Dokter</th>
                                    <th>Ket</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>                            
                        </table>
                        <br>
                        <hr>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 