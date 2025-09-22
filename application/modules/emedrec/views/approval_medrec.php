<?php 
    $this->load->view('layout/header_left');
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
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: black;
    /* background-color: #fff; */
    /* border-color: #ddd #ddd #fff; */
    /* border-bottom-color: rgb(255, 255, 255); */
    border-bottom: 3px solid black !important;
    background-color: transparent;
}

.nav-tabs .nav-link {
    border: none !important;
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

.dataTables_filter {
    display: none;
}

.dataTables_length {
    display: none;
}

.dataTables_info {
    margin-left: 1em;
    margin-bottom: 1em;
}

.paginate_button {
    margin-right: 1em;
    margin-bottom: 1em;
}
</style>
<h4> <b> Daftar Permintaan Akses Rekam Medis </b></h4>
<div class="card mt-2">

    <div class=" m-t-0">

        <!-- example datatable server side -->
        <table class="table table-striped table-bordered" id="table-artikel">
            <thead>
                <tr>    
                    <th >Pasien</th>
                    <th>Tgl Permintaan</th>
                    <th >Permintaan Oleh</th>
                    <th >Aksi</th>
                </tr>
            </thead>
            <tbody id="hasil-irj">

            </tbody>
        </table>
    </div>
</div>

<div id="notifications"></div>

<script>
    var datenow = '<?= date('Y-m-d') ?>';
    var urllistirj = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs?pelayanan=irj'); ?>";
    var urllistigd = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs?pelayanan=igd'); ?>";
    var urllistiri = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs?pelayanan=iri'); ?>";
    var urlupdatesep = "<?php echo base_url('irj/rjcregistrasi/update_sepbpjs'); ?>";
    var baseurl = '<?= base_url('') ?>';
</script>   

<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-datatablenew.js"></script>
<script src="<?= base_url('assets/notify.js') ?>"></script>
<script>
    $(function(){
        const table = new DataTable('#table-artikel', {
            processing: true,
            columns: [
                
                {
                    data: null,
                    render:function(data,type,row){
                        return `${row.nama}<br>(${row.no_cm})`;
                    }
                },
                {
                    data:'tgl_req'
                },
                {
                    data: 'name',
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                        <?= $aksesfull = [1,1025];
                        if(in_array($role_id,$aksesfull)){ ?>
                            <button type="button" class="btn btn-primary" onclick='setujui(${JSON.stringify(row)})'>Setujui</button>
                            <?php } ?>
                        `;
                        // return `<button type="button" class="btn btn-danger btn-sm selesai" onclick='perbaruisep(${JSON.stringify(row)})'>Perbarui SEP</button>`;
                    }
                },
            ],
            language: {
                emptyTable: 'Belum ada Daftar Pasien',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Selanjutnya'
                }
            },
            ajax: {
                url: '<?= base_url('emedrec/C_emedrec/get_permintaan_medrec') ?>',
                type: "GET",
                dataSrc: 'result'
            },
            infoCallback: function(settings, start, end, max, total, pre) {
                return `Menampilkan ${start} sampai ${end} dengan total data ${total}`;
            }
        });
    })

    function setujui(data)
    {
        $.ajax({
            method:"post",
            url: "<?php echo base_url('emedrec/C_emedrec/acc_permintaan_medrec')?>",
            data: {
                id: data.id,
            },
            success: function(data) {
                // console.log(data);
                Notify('Rekam Medis Berhasil Diapproval!', null, null, 'success');

            },
            error: function() {
            }
        });
    }
</script>

<?php 
    $this->load->view('layout/footer_left');
?>