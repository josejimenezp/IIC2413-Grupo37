<?php
  @session_start();
  if (isset($_SESSION['username'])) {
    require("header.php");
  } else {
    header("location: ../index.php");
  }

  function get_user_name($id, $curl) {

    curl_setopt ($curl, CURLOPT_URL, "http://young-ocean-30844.herokuapp.com/users/" . $id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);

    $result = json_decode(trim($result), TRUE);
    return $result[0]['name'];
  }

  // Si la busqueda es vacía, las opciones son [].
  $desired = $_GET['desired'] ? array_map("trim", explode(",", $_GET['desired'])) : [];
  $required = $_GET['required'] ? array_map("trim", explode(",", $_GET['required'])) : [];
  $forbidden = $_GET['forbidden'] ? array_map("trim", explode(",", $_GET['forbidden'])) : [];
  
  $userId =  $_SESSION['uid'];

  $data = array(
    'desired' => $desired,
    'required' => $required,
    'forbidden' => $forbidden,
    'userId' => intval($userId)
  );

  $options = array(
    'http' => array(
    'method'  => 'GET',
    'content' => json_encode( $data ),
    'header'=>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
    )
  );

  $context  = stream_context_create( $options );
  $result = file_get_contents('http://young-ocean-30844.herokuapp.com/text-search', false, $context );
  $result = json_decode($result, true);
  
  if ($result == NULL) {
    $result = [];
  }

?>

<body>

  <div class='container-fluid m-t-10' style='width: 80%; position: relative; height: 100%;'>
    <div class="card p-l-15">
      
      <div class="row">
        
        <?php require("msg_nav.php"); ?>
        
        <main class='col'>
          <div class="container-fluid">
            <br>
            <h3>Resultados</h3>
            <br>
            <table class="table">
              <thead>
                <tr>
                  <th width="17%">De</th>
                  <th width="17%">Para</th>
                  <th width="56%">Mensaje</th>
                  <th width="10%">Fecha</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($result as $res):?>
                  <tr>
                    <?php $curl = curl_init(); ?>

                    <td><p><?=get_user_name($res['sender'], $curl)?></p></td>
                    <td><p><?=get_user_name($res['receptant'], $curl)?></p></td>
                    <td><p><?=$res['message']?></p></td>
                    <td><p><?=date('j M, Y', strtotime($res['date']))?></p></td>

                    <?php curl_close($curl) ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </main>
        
      </div>
    </div>
  </div>

</body>

<?php curl_close($curl); ?>