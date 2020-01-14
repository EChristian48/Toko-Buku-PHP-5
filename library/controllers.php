<?php
class oop {
    function simpan($table, array $field, $redirect) {
        $sql = "INSERT INTO $table SET";
        foreach ($field as $key => $value) {
            $sql.=" $key = '$value',";
        }
        $sql = rtrim($sql, ',');
        $jalan = mysql_query($sql);
        if ($jalan) {
            echo "<script>alert('Data tersimpan...');document.location.href='$redirect'</script>";
        } else {
            echo mysql_error();
        }
    }
    function tampil($table) {
        $sql = "SELECT * FROM $table";
        $tampil = mysql_query($sql);
        while ($data = mysql_fetch_assoc($tampil))
            $isi[] = $data;
        return $isi;
    }
    function hapus($table, $where, $redirect) {
        $sql = "DELETE FROM $table WHERE $where";
        $jalan = mysql_query($sql);
        if ($jalan) {
            echo "<script>alert('Data terhapus...');document.location.href='$redirect'</script>";
        } else {
            echo mysql_error();
        }
    }
    function edit($table, $where) {
        $sql = "SELECT * FROM $table WHERE $where";
        $jalan = mysql_fetch_assoc(mysql_query($sql));
        return $jalan;
    }
    function ubah($table, array $field, $where, $redirect) {
        $sql = "UPDATE $table SET";
        foreach ($field as $key => $value) {
            $sql.=" $key = '$value',";
        }
        $sql = rtrim($sql, ',');
        $sql.=" WHERE $where";
        $jalan = mysql_query($sql);
        if ($jalan) {
            echo "<script>alert('Data terupdate...');document.location.href='$redirect'</script>";
        } else {
            echo mysql_error();
        }
    }
    function upload($foto, $tempat) {
        $alamat = $foto['tmp_name'];
        $namafile = $foto['name'];
        move_uploaded_file($alamat, "$tempat/$namafile");
        return $namafile;
    }
    function login($table, $username, $password, $akses, $nama_form) {   
        @session_start();
        $sql = "SELECT * FROM $table WHERE username = '$username' and password = '$password' and akses='$akses'";
        $jalan = mysql_query($sql);
        $tampil = mysql_fetch_assoc($jalan);
        $cek = mysql_num_rows($jalan); 
        if ($cek > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['id_user'] = $tampil['id_user'];
            $_SESSION['akses'] = $tampil['akses'];
            echo "<script>alert('Selamat datang $username');document.location.href='$nama_form'</script>";
		} else {
            echo "<script>alert('Username dan Password tidak sesuai !!');document.location.href='?log=wls'</script>";
        }
    }
}
?>