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

$curl = curl_init();

curl_setopt ($curl, CURLOPT_URL, "http://young-ocean-30844.herokuapp.com/messages/");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec ($curl);
// curl_close ($curl);

$result = json_decode(trim($result), TRUE);

?>

<body>

  <div class='container-fluid m-t-10' style='width: 75%; position: relative; height: 100%;'>
    <div class="card p-l-15">

      <div class="row">
        
        <?php require("msg_nav.php"); ?>

        <main role="main" class='col-md-10'>
          <div class="container">
            <table class="table">
              <thead>
                <tr>
                  <th width="20%">De</th>
                  <th width="68%">Mensaje</th>
                  <th width="12%">Fecha</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($result as $k => $res):?>
                  <?php if ($res['receptant'] == $_SESSION['uid']): ?>
                    <tr>
                      <td><p><?=get_user_name($res['sender'], $curl)?></p></td>
                      <td><p><?=$res['message']?></p></td>
                      <td><p><?=date('j M, Y', strtotime($res['date']))?></p></td>
                    </tr>
                  <?php endif ?>
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