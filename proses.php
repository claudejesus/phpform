<?php
 
// $harga_barang = 81; //harga transaksi
 
if (isset($_POST['uid'])) {
    include 'connection.php';
    include 'connect.php';
    $id = $_POST['uid'];
    $query = mysqli_query($dbconnect, "SELECT * FROM tb_user WHERE id='$id'");
    $cek = mysqli_num_rows($query);
    if ($cek >0) {
        $data = mysqli_fetch_assoc($query);
        $hasil_saldo = $data['saldo'] - $harga_barang;
        if ($hasil_saldo >= 0) {
            mysqli_query($dbconnect, "UPDATE tb_user SET saldo ='$hasil_saldo' WHERE id='$id'");
            $status = "Transaksi Sukses";
        } else {
            $status = "Saldo tidak cukup";
            $hasil_saldo = "-";
        }
    } else {
        $status = "ID Belum Terdaftar";
        $data = "-";
        $harga_barang = "-";
        $hasil_saldo = "-";
    }
 
    $output = 
    [
        "Detail" =>
        [
            "Status" => $status,
            "Data User" => $data,
            "Nilai Transaksi" => $harga_barang,
            "Saldo Akhir" => (int)$hasil_saldo
        ]
    ];
    $json = json_encode($output);
    echo $json;
}

