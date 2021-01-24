<?php 
    // koneksi database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "db_mahasiswa";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi)); 

    // jika tombol simpan di klik (awal)
    if (isset($_POST['bsimpan'])) 
    {
        //pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            // data akan di edit
            $edit = mysqli_query($koneksi, "UPDATE tbmahasiswa set 
                                                nim = '$_POST[tnim]',
                                                nama = '$_POST[tnama]',
                                                alamat = '$_POST[talamat]',
                                                prodi = '$_POST[tprodi]'
                                            WHERE id_mahasiswa = '$_GET[id]' 
                                           ");

        if ($edit)  //jika simpan berhasil
        {
         echo "<script>
         alert('Edit Data Sukses!');
         document.location='index.php';
         </script>";
         }
        else // jika simpan gagal
         {
         echo "<script>
         alert('Edit Data GAGAL!');
         document.location='index.php';
         </script>";
         }

         } 
        else 
         {
          // data akan di simpan baru
          $simpan = mysqli_query($koneksi, 
          "INSERT INTO tbmahasiswa (nim, nama, alamat, prodi)
           VALUES ('$_POST[tnim]', 
                  '$_POST[tnama]', 
                  '$_POST[talamat]',
                  '$_POST[tprodi]') 
           ");
        if ($simpan)  //jika simpan berhasil
         {
         echo "<script>
         alert('Simpan Data Sukses!');
         document.location='index.php';
         </script>";
         }
        else // jika simpan gagal
         {
          echo "<script>
          alert('Simpan Data GAGAL!');
          document.location='index.php';
          </script>";
         }
         }


        
    }

    //pengujian jika edit atau hapus saat di klik
    if(isset($_GET['hal']))
    {
        // pengujian jika edit data
        if ($_GET['hal'] == "edit")
        {
            //tampilkan data yang akan di edit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tbmahasiswa WHERE id_mahasiswa = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan, maka data ditampung ke dalam variabel
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];
            }
        } 
        else if ($_GET['hal'] == "hapus")
        {
            //persiapan hapus data
            $hapus = mysqli_query($koneksi, "DELETE FROM tbmahasiswa WHERE id_mahasiswa = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                alert('HAPUS Data Sukses!');
                document.location='index.php';
                </script>"; 
            }

        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>CRUD</title>
</head>
<body>

    <h2 class="text-center bg-dark text-white card-header">Mengisi Data Mahasiswa</h2>
    <br>

<div class="container"> <!-- container awal -->

 
    <!-- awal card form -->
    <div class="card mt-3">
    <div class="card-header bg-dark text-white">
        Form Input Data Mahasiswa
    </div>
    <div class="card-body">
      <form action="" method="post">
        <div class="form-group">
            <label>Nim</label>
            <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Masukkan Nim Anda!" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan Nama Anda!" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control" name="talamat" placeholder="Masukkan Alamat Anda">
            <?=@$valamat?></textarea>
        </div>
        <div class="form-group">
            <label>Program Studi</label>
            <select placeholder="Pilih Prodi" name="tprodi" class="form-control" >
                <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                <option value="D3-Elektronika">D3-Elektronika</option>
                <option value="D3-Manajemen Informatika">D3-Manajemen Informatika</option>
                <option value="S1-Fisika">S1-Fisika</option>
                <option value="S1-Biologi">S1-Biologi</option>
                <option value="S1-Farmasi">S1-Farmasi</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="bsimpan">Simpan</button>
        <button type="reset" class="btn btn-success" name="breset">Kosongkan</button>

      </form>  
    </div>
    </div>
    <!-- akhir card form -->

    <!-- awal card tabel mahasiswa -->
    <div class="card mt-3">
    <div class="card-header bg-dark text-white">
        Daftar Mahasiswa
    </div>
    <div class="card-body">
      
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>Nim</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Program Studi</th>
                <th>Tindakan</th>
            </tr>

            <?php //pembuka perulangan while php
            $nomor = 1;
            $tampil = mysqli_query($koneksi, "SELECT * from tbmahasiswa order by id_mahasiswa desc");
            while ($data = mysqli_fetch_array($tampil)) :

            ?>

            <tr>
                <td><?=$nomor++?></td>        <!-- looping pada nomor urut -->
                <td><?=$data['nim']?></td>    <!-- mengambil data dari database tabel nim -->
                <td><?=$data['nama']?></td>   <!-- mengambil data dari database tabel nama siswa -->
                <td><?=$data['alamat']?></td> <!-- mengambil data dari database tabel alamat -->
                <td><?=$data['prodi']?></td>  <!-- mengambil data dari database tabel prodi -->
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['id_mahasiswa']?>" class="btn btn-warning"> Edit </a>
                    <a href="index.php?hal=hapus&id=<?=$data['id_mahasiswa']?>" onclick="return confirm('Apakah yakin ingin menghapus Data ini?')"
                       class="btn btn-danger"> Hapus </a>
                </td>
            </tr>
        <?php endwhile; //penutup perulangan while php ?>
        </table>

    </div>
    </div>
    <!-- akhir card tabel -->

</div> <!-- container awal -->


<script src="js/bootstrap.min.js"></script>    
</body>
</html>