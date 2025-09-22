<?php $this->load->view('layout/header_form') ?>

<div class="card m-5">

  <div class="accordion accordion-flush" id="accordionFlushExample">
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
          Catatan Awal Medis Neonatus
        </button>
      </h2>
      <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
        <?php include('catatan_medis_neonatus/catatan_medis_awal_neonatus.php') ?>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
          Catatan Awal Medis Anak
        </button>
      </h2>
      <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
        <?php include('catatan_medis_awal_anak/form_noteiri_anak.php') ?>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
          Catatan Awal Medis Dewasa
        </button>
      </h2>
      <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
        <?php include('catatan_medis_awal_dewasa/form_assesment_medis.php') ?>

      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingThrees">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThrees" aria-expanded="false" aria-controls="flush-collapseThrees">
          Catatan Awal Medis Bidan
        </button>
      </h2>
      <div id="flush-collapseThrees" class="accordion-collapse collapse" aria-labelledby="flush-headingThrees" data-bs-parent="#accordionFlushExample">
        <?php include('catatan_medis_awal_bidan/catatan_medis_awal_bidan.php') ?>

      </div>
    </div>
  </div>
</div>