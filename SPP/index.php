<?php 
 
include 'db_config.php';
 
error_reporting(0);
 
session_start();
 
if (isset($_SESSION['nama_user'])) {
    header("Location: main.php");
}
 
if (isset($_POST['submit'])) {
    $nama_user = $_POST['nama_user'];
    $kata_sandi = $_POST['kata_sandi'];
 
    $sql = "SELECT * FROM pengguna WHERE nama_user='$nama_user' AND kata_sandi='$kata_sandi'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['nama_user'] = $row['nama_user'];
        $_SESSION['nama'] = $row['nama'];
        echo session_id();
        header("Location: main.php");
    } else {
        echo "<script>alert('Username atau Password Anda salah. Silahkan coba lagi!')</script>";
    }
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="alert alert-warning" role="alert">
        <?php echo $_SESSION['error']?>
    </div>
    <div class="back">
        <div class="div-center">
            <div class="content">
                <h3>Login</h3>
                <hr/>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nama_user">Username</label>
                        <input type="text" class="form-control" name="nama_user" placeholder="Username" value="<?php echo $nama_user; ?>" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="kata_sandi">Password</label>
                        <input type="password" class="form-control" name="kata_sandi" placeholder="Password" value="<?php echo $_POST['kata_sandi']; ?>" required>
                    </div>
                    <div class="btn-login mt-3 text-center">
                        <button type="submit" name="submit" class="btn btn-primary" style="width: 150px;">Login</button>
                    </div>
                    <hr />
                    <div class="p text-center">
                        <p>&#169; SMAN 2 BONDOWOSO</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>