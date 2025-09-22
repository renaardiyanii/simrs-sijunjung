<?php 
     //   if ($role_id == 1) {
            $this->load->view("layout/header_left");
       // } else {
         //   $this->load->view("layout/header_horizontal");
       // }
    ?> 
    
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
    <!-- column -->
        <div class="col-lg-12 col-md-12">
            <?php if($cek_kasir!=''){?>
            <form class="form" id="form_akses_kasir">
            <!--div class="form-group row">
                <label for="loket_kasir" class="col-3 col-form-label">Loket Kasir </label>
                <div class="col-9">
                        <select id="loket_kasir" class="form-control" name="loket_kasir" required>
                                    <option value="">-Pilih Loket Kasir-</option>
                                    <?php 
                                        foreach($kasir as $row){                                             
                                            echo '<option '; echo 'value="'.$row->kasir.'@'.$row->idkasir.'">'.$row->kasir.' - '.$row->deskripsi.'</option>';
                                            }?>
                                </select>   
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-3 col-sm-9">                                  
                                <button type="submit" class="btn btn-primary" id="btn-diagnosa"><i class="fa fa-floppy-o"></i> Simpan</button>
                </div>
            </div -->                                      
            </form>
            <?php }?>
            <center>
            <!-- <div class="card">
            <img src="<?= base_url(''); ?>" alt="">
            </div> -->
            </center>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <script type="text/javascript">
       $(document).ready(function() {
        $("#form_akses_kasir").submit(function(event) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'beranda/insert_aksesLoket'; ?>",
            dataType: "JSON",
            data: $('#form_akses_kasir').serialize(),
            success: function(data){   
                if (data.success == true) {
                    getKasir();
                    swal("Sukses", "Akses Loket berhasil disimpan.", "success");
                } else {
                   
                    swal("Error", "Gagal menginput loket. Silahkan coba lagi.", "error");                
                }
            },
            error:function(event, textStatus, errorThrown) {      
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            },
            timeout: 0
        });
        event.preventDefault();
        });
        getKasir();
    });

    function getKasir(){
        $.ajax(
           {
              type:'GET',
              url:"<?php echo base_url().'beranda/getUserKasir/'; ?>",
              dataType:'json',
              success: function(data){
                //alert(data.kasir+'@'+data.idkasir);
                $('#loket_kasir').val(data.kasir+'@'+data.idkasir).change();
              }
           }
        );
    }
    </script>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 