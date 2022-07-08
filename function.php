<?php
session_start();

// database conection
include 'koneksi.php';

// insert stock
if (isset($_POST['inserbrg'])) {
	$jenis= $_POST['jenis_brg'];
	$variant = $_POST['variant_brg'];
	$harga = $_POST['harga_brg'];
	$stock = $_POST['stock_brg'];
	$keterangan = $_POST['keterangan'];

	$tambahkb = mysqli_query($conn, "insert into barang (jenis, variant, harga, stock, keterangan) values ('$jenis', '$variant', '$harga', '$stock', '$keterangan')");
	if ($tambahkb) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
}

//update stock
if (isset($_POST['updatebrg'])) {
	$jenis = $_POST['jenis'];
	$variant = $_POST['variant'];
	$harga = $_POST['harga'];
	$stock = $_POST['stock'];
	$keter = $_POST['keter'];
	$id = $_POST['idbrg'];
	// print_r($iduser);
	// exit();
	$updatebrg = mysqli_query($conn, "update barang set jenis='$jenis', variant='$variant', harga='$harga' , stock='$stock', keterangan='$keter' where barang.id_barang='$id' ");
	if ($updatebrg) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
}

//delete stock
if (isset($_POST['deletebrg'])) {
	$id_barang = $_POST['idbrg'];

	$deletebrg = mysqli_query($conn, "delete from barang where id_barang='$id_barang'");
	if ($deletebrg) {
		header('location:index.php');
	} else {
		echo "gagal";
		header('location:index.php');
	}
}

//insert pegawai
if (isset($_POST['savepgw'])) {
	$nama = $_POST['nama'];
	$no_hp = $_POST['nohp'];
	$alamat = $_POST['alamat'];

	$tambahpgw = mysqli_query($conn, "insert into pegawai (nama_pgw, alamat_pgw, telp_pgw) values ('$nama', '$alamat', '$no_hp')");
	if ($tambahpgw) {
		header('location:pegawai.php');
	} else {
		echo "gagal";
		header('location:pegawai.php');
	}
}

//update pegawai
if (isset($_POST['updatepgw'])) {
	$nama = $_POST['nama'];
	$no_hp = $_POST['nohp'];
	$alamat = $_POST['alamat'];
	$id_pgw = $_POST['idpgw'];

	$updatepgw = mysqli_query($conn, "update pegawai set nama_pgw='$nama', alamat_pgw='$alamat', telp_pgw='$no_hp' where id_pegawai='$id_pgw'");
	if ($updatepgw) {
		header('location:pegawai.php');
	} else {
		echo "gagal";
		header('location:pegawai.php');
	}
}

//delete pegawai
if (isset($_POST['deletepgw'])) {
	$id_pgw = $_POST['idpgw'];

	$deletepgw = mysqli_query($conn, "delete from pegawai where id_pegawai='$id_pgw'");
	if ($deletepgw) {
		header('location:pegawai.php');
	} else {
		echo "gagal";
		header('location:pegawai.php');
	}
}


//insert pembeli
if (isset($_POST['savepembeli'])) {
	$nama = $_POST['nama'];
	$no_hp = $_POST['nohp'];
	$alamat = $_POST['alamat'];

	$tambahpembeli = mysqli_query($conn, "insert into pembeli (nama, alamat, no_hp) values ('$nama', '$alamat', '$no_hp')");
	if ($tambahpembeli) {
		header('location:pembeli.php');
	} else {
		echo "gagal";
		header('location:pembeli.php');
	}
}

//update pembeli
if (isset($_POST['updatepembeli'])) {
	$nama = $_POST['nama'];
	$no_hp = $_POST['nohp'];
	$alamat = $_POST['alamat'];
	$idpembeli = $_POST['id_pembeli'];

	$updatepembeli = mysqli_query($conn, "update pembeli set nama='$nama', alamat='$alamat', no_hp='$no_hp' where id_pembeli='$idpembeli'");
	if ($updatepembeli) {
		header('location:pembeli.php');
	} else {
		echo "gagal";
		header('location:pembeli.php');
	}
}

//delete pembeli
if (isset($_POST['deletepembeli'])) {
	$idpembeli = $_POST['id_pembeli'];

	$deletepembeli = mysqli_query($conn, "delete from pembeli where id_pembeli='$idpembeli'");
	if ($deletepembeli) {
		header('location:pembeli.php');
	} else {
		echo "gagal";
		header('location:pembeli.php');
	}
}

// insert transaksi
if (isset($_POST['savetransaksi'])) {
	$pembeli = $_POST['pembeli'];
	$pegawai = $_POST['pgw'];
	$barang = explode('_', $_POST['barang']); //[0]=>3, [1]=>1200
	$jumlah = $_POST['jumlah'];
	$harga = $_POST['harga'];

	$lihatstock = mysqli_query($conn, "select * from barang where id_barang='$barang[0]'");
	$stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
	$stockskrg = $stocknya['stock'];

	if ($jumlah <= $stockskrg) {
		$stockupdate = $stockskrg - $jumlah;
		$updatestock = mysqli_query($conn, "update barang set stock='$stockupdate' where id_barang='$barang[0]'");
		$tambahtransaksi = mysqli_query($conn, "insert into transaksi (id_pembeli, id_pegawai, id_barang, total_harga, jumlah) values ('$pembeli', '$pegawai', '$barang[0]', '$harga', '$jumlah')");
		header('location:transaksi.php');
	} else {
		echo "gagal";
		header('location:transaksi.php');
	}
}


// delete transaksi
if (isset($_POST['deletetransaksi'])) {
	$id_transaksi = $_POST['id_transaksi'];
	$id_brg = $_POST['id_brg'];
	$jumlah = $_POST['jumlah'];

	$lihatstock = mysqli_query($conn, "select * from barang where id_barang='$id_brg'");
	$stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
	$stockskrg = $stocknya['stock'];

	$stockupdate = $stockskrg + $jumlah;
	$updatestock = mysqli_query($conn, "update barang set stock='$stockupdate' where id_barang='$id_brg'");
	$tambahtransaksi = mysqli_query($conn, "delete from transaksi where id_transaksi='$id_transaksi'");

	header('location:transaksi.php');
}
