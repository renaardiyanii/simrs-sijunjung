<?php
    $this->load->view("layout/header_left");
?>
<script src="<?php echo base_url('assets/form/sweetalert2@11.js') ?>"></script>
<div class="alert alert-warning" role="alert">
Data yang berhasil disimpan menunggu aproval dari BPJS atau otomatis approve jadwal dokter oleh sistem, 
misal pengajuan perubahan jadwal oleh RS diantara jam 00.00 - 20.00 , 
kemudian alokasi approve manual oleh BPJS/cabang di jam 20.01-00.00. 
Jika pukul 00.00 belum dilakukan aproval oleh kantor cabang, 
maka otomatis approve by sistem akan dilaksanakan setelah jam 00.00 dan yang berubahnya esoknya (H+1). 
</div>
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h2>Update Jadwal Dokter</h2>
            <button class="btn btn-primary mt-2 mb-2" onclick="updateJadwalDokter()">Update Jadwal Dokter</button>
        </div>
        <hr>
    </div>
    <div class="body p-4">
        <div class="mb-4">
            <form id="form-update-jadwal-dokter">
                <div>
                    <label for="kodepoli">Poliklinik</label>
                    <select name="kodepoli" id="kodepoli" class="form-control" onchange="loadDoctors()">
                        <option value="">--Silahkan Pilih Poliklinik--</option>
                        <?php
                        foreach($poli as $v){
                            echo '<option value="'.$v->id_poli.'@'.$v->poli_bpjs.'">'.$v->nm_poli.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="kodedokter">Dokter</label>
                    <select name="kodedokter" id="kodedokter" class="form-control">
                        <option value="">--Silahkan Pilih Dokter--</option>
                    </select>
                </div>
                <div id="harijadwal">
                    <hr>
                    <div>
                        <label >Hari</label>
                        <select class="form-control" name="hari[]">
                            <option value="">--Silahkan Pilih Hari--</option>
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
                            <option value="7">Minggu</option>
                            <option value="8">Hari Libur Nasional</option>
                        </select>
                    </div>
                    <div>
                        <label>Jam Buka</label>
                        <input type="time" class="form-control" name="buka[]">
                    </div>
                    <div>
                        <label>Jam Tutup</label>
                        <input type="time" class="form-control" name="tutup[]">
                    </div>
                    <hr>
                </div>
                <button class="btn btn-info" type="button" onclick="tambahjadwal()">Tambah Jadwal</button>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-datatablenew.js"></script>
<script>

    function loadDoctors() {
        var kodepoli = $('#kodepoli').val();
        if (kodepoli !== '') {
            // Make AJAX request to fetch doctors based on selected polyclinic
            $.ajax({
                url: `${baseurl}/antrol/getdoctors?kodepoli=${kodepoli.split('@')[0]}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.metadata.code === 200) {
                        // Update the options in the kodedokter select element
                        var doctors = response.response;
                        var select = $('#kodedokter');
                        // Clear existing options
                        select.empty();
                        // Add a default option
                        select.append('<option value="">--Silahkan Pilih Dokter--</option>');
                        // Add options based on the response
                        $.each(doctors, function(index, doctor) {
                            select.append('<option value="' + doctor.kode_dpjp_bpjs + '">' + doctor.nm_dokter + '</option>');
                        });
                    } else {
                        // Handle error if needed
                        console.error('Error:', response.metadata.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error if needed
                    console.error('Error:', status, error);
                }
            });
        }
    }


    function tambahjadwal(){
        $("#harijadwal").append(`
            <div>
                <label >Hari</label>
                <select class="form-control" name="hari[]">
                    <option value="">--Silahkan Pilih Hari--</option>
                    <option value="1">Senin</option>
                    <option value="2">Selasa</option>
                    <option value="3">Rabu</option>
                    <option value="4">Kamis</option>
                    <option value="5">Jumat</option>
                    <option value="6">Sabtu</option>
                    <option value="7">Minggu</option>
                    <option value="8">Hari Libur Nasional</option>
                </select>
            </div>
            <div>
                <label>Jam Buka</label>
                <input type="time" class="form-control" name="buka[]">
            </div>
            <div>
                <label>Jam Tutup</label>
                <input type="time" class="form-control" name="tutup[]">
            </div>
            <hr>
        `);
    }
    function updateJadwalDokter() {
        let data = $("#form-update-jadwal-dokter").serialize();
        // Make AJAX request to the API
        $.ajax({
            url: `${baseurl}/antrol/updatejadwaldokter`,
            type: 'POST',
            data: data,
            success: function(response) {
                // Handle the response as needed
                if(response){
                    Swal.fire({
						title: response.metadata.code === 200?"Berhasil!":'Gagal',
						text: response.metadata.message,
						icon: response.metadata.code === 200?"success":'error'
					});
                }
            },
            error: function(xhr, status, error) {
                // Handle error if needed
                console.error('Error:', status, error);
                Swal.fire({
                    title: 'Gagal',
                    text: 'Hubungi Tim IT',
                    icon: 'error'
                });
            }
        });
    }
</script>
<?php
    $this->load->view("layout/footer_left");
?>
