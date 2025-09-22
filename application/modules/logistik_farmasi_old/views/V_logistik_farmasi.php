<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?>
    <head>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="/assets/mdb2/css/mdb.min.css" />
    </head>

    <div class="container">
      <center><h1>Logistik Farmasi</h1></center>
    </div>
    <div class="container">
      <div class="form-outline">
        <input type="text" id="formControlDefault" class="form-control" />
        <label class="form-label" for="formControlDefault">NO. RM</label>
      </div>
    </div>
    <div class="container">
      <!-- Tabs navs -->
    <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
      <li class="nav-item" role="presentation">
        <a
          class="nav-link active"
          id="ex3-tab-1"
          data-mdb-toggle="tab"
          href="#ex3-tabs-1"
          role="tab"
          aria-controls="ex3-tabs-1"
          aria-selected="true"
          >Link</a
        >
      </li>
      <li class="nav-item" role="presentation">
        <a
          class="nav-link"
          id="ex3-tab-2"
          data-mdb-toggle="tab"
          href="#ex3-tabs-2"
          role="tab"
          aria-controls="ex3-tabs-2"
          aria-selected="false"
          >Very very very very long link</a
        >
      </li>
      <li class="nav-item" role="presentation">
        <a
          class="nav-link"
          id="ex3-tab-3"
          data-mdb-toggle="tab"
          href="#ex3-tabs-3"
          role="tab"
          aria-controls="ex3-tabs-3"
          aria-selected="false"
          >Another link</a
        >
      </li>
      <li class="nav-item" role="presentation">
        <a
          class="nav-link"
          id="ex3-tab-4"
          data-mdb-toggle="tab"
          href="#ex3-tabs-4"
          role="tab"
          aria-controls="ex3-tabs-4"
          aria-selected="false"
          >hehe</a
        >
      </li>
    </ul>
    <!-- Tabs navs -->

    <!-- Tabs content -->
    <div class="tab-content" id="ex2-content">
      <div
        class="tab-pane fade show active"
        id="ex3-tabs-1"
        role="tabpanel"
        aria-labelledby="ex3-tab-1"
      >
        Tab 1 content
      </div>
      <div
        class="tab-pane fade"
        id="ex3-tabs-2"
        role="tabpanel"
        aria-labelledby="ex3-tab-2"
      >
        Tab 2 content
      </div>
      <div
        class="tab-pane fade"
        id="ex3-tabs-3"
        role="tabpanel"
        aria-labelledby="ex3-tab-3"
      >
        Tab 3 content
      </div>
      <div
        class="tab-pane fade"
        id="ex3-tabs-4"
        role="tabpanel"
        aria-labelledby="ex3-tab-4"
      >
        Hehe
      </div>
    </div>
    <!-- Tabs content -->
    </div> 
    
    <!-- MDB -->
    <script type="text/javascript" src="/assets/mdb2/js/mdb.min.js"></script>
    <!-- Custom scripts -->
    <script type="text/javascript">
      var a = document.getElementById('disc-50');
      a.onclick = function () {
        Clipboard_CopyTo("T9TTVSQB");
        var div = document.getElementById('code-success');
        div.style.display = 'block';
        setTimeout(function () {
          document.getElementById('code-success').style.display = 'none';
        }, 900);
      };

      function Clipboard_CopyTo(value) {
        var tempInput = document.createElement("input");
        tempInput.value = value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
      }
    </script>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>