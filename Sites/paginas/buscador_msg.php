<?php
  session_start();
  if (isset($_SESSION['username'])) {
      require("header.php");

  } else {
      header("location: ../index.php");
  }

?>


<body>

  <div class='container-fluid m-t-10' style='width: 75%; position: relative; height: 100%;'>
    <div class="card p-l-15">

      <div class="row">
        
        <?php require("msg_nav.php"); ?>

        <main role="main" class='col-md-10'>
          <div class="container p-t-20" id="buscador_msg" style="width: 60%; margin: 0 auto;">

            <form action="busqueda_msg.php" method="get">
              <div class="form-group">
                <label for="desired">Búsqueda simple</label>
                <textarea id="form-msg" class="form-control" name="desired" placeholder="Ingrese palabras separadas por comas" rows="2" style="border-color: #d9d9d9 !important;"></textarea>
              </div>
              <div class="form-group">
                <label for="required">Búsqueda exacta</label>
                <textarea id="form-msg" class="form-control" name="required" placeholder="Ingrese palabras separadas por comas" rows="2" style="border-color: #d9d9d9 !important;"></textarea>
              </div>
              <div class="form-group">
                <label for="forbidden">No buscar</label>
                <textarea id="form-msg" class="form-control" name="forbidden" placeholder="Ingrese palabras separadas por comas" rows="2" style="border-color: #d9d9d9 !important;"></textarea>
              </div>

              <br>
              <div class="container-login100-form-btn" style="width: 250px; margin: 0 auto;">
                <button class="login100-form-btn" type="submit">
                  Buscar
                </button>
              </div>
            </form>

          </div>
        </main>
        
      </div>
    </div>
  </div>

</body>
