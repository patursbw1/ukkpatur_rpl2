<?php
include "koneksi.php";
session_start();

if (isset($_GET['fotoid'])) {
  $fotoid = $_GET['fotoid'];
  $sql = mysqli_query($conn, "select * from foto where fotoid='$fotoid'");
  while ($data = mysqli_fetch_array($sql)) {
    $userid2 = $_SESSION['userid'];
    $usernama2 = $_SESSION['namalengkap'];
    $fotoid2 = $data['fotoid'];
    $judulfoto2 = $data['judulfoto'];
    $deskripsifoto2 = $data['deskripsifoto'];
    $lokasi = $data['lokasifile'];
  }
}

if (isset($_POST['komentar'])) {
  $fotoid = $_POST['fotoid'];
  $isikomentar = $_POST['isikomentar'];
  $tanggalkomentar = date("Y-m-d");
  $userid = $_SESSION['userid'];

  $sql = mysqli_query($conn, "insert into komentarfoto values('','$fotoid','$userid','$isikomentar','$tanggalkomentar')");

  header("location:komentar.php?fotoid=$fotoid");
}
?>

<?php
include "layout/header_admin.html";
?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-1">Komentar</h1>
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <img src="gambar/<?= $lokasi ?>" alt="foto" class="img-thumbnail" height="400px">
      </div>
      <div class="col-sm-4">
        <h3>Komentar netizen</h3>
        <?php
        $userid = $_SESSION['userid'];
        $sql = mysqli_query($conn, "SELECT * from komentarfoto,user where komentarfoto.userid=user.userid AND komentarfoto.fotoid='$fotoid2'");
        while ($data = mysqli_fetch_array($sql)) {
        ?>
          <div class="card">
            <div class="card-body">
              <p> <?= $data['tanggalkomentar'] ?> <strong><?= $data['namalengkap'] ?> :</strong> <i> <?= $data['isikomentar'] ?> </i> </p>
            </div>
          </div>
        <?php
        }
        ?>
        <div class="card">
          <div class="card-body">
            <p> <strong><?= $userid2 ?> <?= $usernama2 ?> :</strong> <i>
                <form action="komentar.php" method="post">
                  <input type="text" name="fotoid" value="<?= $fotoid2 ?>" hidden>
                  <input type="text" name="isikomentar" id="isikomentar">
                  <input type="submit" value="komentar" name="komentar" class="btn btn-info">
                </form>
              </i> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
include "layout/footer.html"
?>