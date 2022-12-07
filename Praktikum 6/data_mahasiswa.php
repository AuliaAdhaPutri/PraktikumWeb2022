<?php
$host       = "localhost";
$user       = "root";
$pass       = "11022003";
$db         = "data_mahasiswa";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$Nim        = "";
$Nama       = "";
$Alamat     = "";
$Fakultas   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id        = $_GET['id'];
    $sql1       = "delete from cruds where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from cruds where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $Nim        = $r1['Nim'];
    $Nama       = $r1['Nama'];
    $Alamat     = $r1['Alamat'];
    $Fakultas   = $r1['Fakultas'];

    if ($Nim == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $Nim        = $_POST['Nim'];
    $Nama       = $_POST['Nama'];
    $Alamat     = $_POST['Alamat'];
    $Fakultas   = $_POST['Fakultas'];

    if ($Nim && $Nama && $Alamat && $Fakultas) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update cruds set Nim = '$Nim',nama='$Nama',alamat = '$Alamat',fakultas='$Fakultas' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data Berhasil Diinput";
            } else {
                $error  = "Data Gagal Diinput";
            }
        } else { //untuk insert
            $sql = "select * from cruds where Nim = '$Nim'";
            $q  = mysqli_query($koneksi, $sql);
            $row = mysqli_fetch_array($q);
            if ($row) {
                $error = "Nim Tidak Boleh Duplikat";
            }else{
                $sql1   = "insert into cruds (Nim,Nama,Alamat,Fakultas) values ('$Nim','$Nama','$Alamat','$Fakultas') ";
                $q1     = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses     = "Data Berhasil Disimpan";
                } else {
                    $error      = "Data Gagal Disimpan";
                }

            }
        }
    } else {
        $error = "Isi Data Terlebih Dahulu!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=data_mahasiswa.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=data_mahasiswa.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">Nim</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Nim" name="Nim" value="<?php echo $Nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Nama" name="Nama" value="<?php echo $Nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?php echo $Alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Fakultas" id="Fakultas">
                                <option value="">- Pilih Fakultas -</option>
                                <option value="Mipa" <?php if ($Fakultas == "Mipa") echo "selected" ?>> Mipa </option>
                                <option value="Teknik" <?php if ($Fakultas == "Teknik") echo "selected" ?>> Teknik </option>
                                <option value="Kedokteran" <?php if ($Fakultas == "Kedokteran") echo "selected" ?>> Kedokteran </option>
                                <option value="Keperawatan" <?php if ($Fakultas == "Keperawatan") echo "selected" ?>> Keperawatan </option>
                                <option value="Ekonomi dan Bisnis" <?php if ($Fakultas == "Feb") echo "selected" ?>> Feb </option>
                                <option value="Ilmu Budaya" <?php if ($Fakultas == "Fib") echo "selected" ?>> Fib </option>
                                <option value="Hukum" <?php if ($Fakultas == "Hukum") echo "selected" ?>> Hukum </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Nim</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from cruds order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $Nim        = $r2['Nim'];
                            $Nama       = $r2['Nama'];
                            $Alamat     = $r2['Alamat'];
                            $Fakultas   = $r2['Fakultas'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $Nim ?></td>
                                <td scope="row"><?php echo $Nama ?></td>
                                <td scope="row"><?php echo $Alamat ?></td>
                                <td scope="row"><?php echo $Fakultas ?></td>
                                <td scope="row">
                                    <a href="data_mahasiswa.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="data_mahasiswa.php?op=delete&id=<?php echo $id?>" onclick="return confirm('DATA AKAN DIHAPUS?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>