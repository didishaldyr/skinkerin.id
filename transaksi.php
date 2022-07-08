<?php
require 'function.php';
require 'ceklog.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Record Transaksi</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="design.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand">
        <a class="navbar-brand" href="index.php">Record Transaksi</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <?php
                        $call = mysqli_query($conn, "select * from login");
                        while ($list = mysqli_fetch_array($call)) {
                            $name = $list['username'];
                        ?>
                            <div>
                                <h3 class="sb-sidenav-menu-heading" style="margin-left: 35px;">Welcome <?= $name; ?></h3>
                                <img src="assets/img/admin.png" alt="" width="100px" style="margin-left: 70px;">
                            </div>

                        <?php
                        }
                        ?>

                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                            Stok Barang
                        </a>
                        <a class="nav-link" href="pegawai.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                            Pegawai
                        </a>
                        <a class="nav-link" href="pembeli.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-bag"></i></div>
                            Pembeli
                        </a>
                        <a class="nav-link" href="transaksi.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                            Transaksi
                        </a>
                        <a class="nav-link" href="logout.php" onclick="confirm('yakin ingin logout?');">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Data Transaksi</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn-1" data-toggle="modal" data-target="#transaksimodal">
                                Tambah Transaksi
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Tanggal</th>
                                            <th>Pembeli</th>
                                            <th>Pegawai</th>
                                            <th>Jenis</th>
                                            <th>Varian</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $viewtransaksi = mysqli_query($conn, "select * from transaksi left join barang on transaksi.id_barang=barang.id_barang left join pegawai on transaksi.id_pegawai=pegawai.id_pegawai left join pembeli on transaksi.id_pembeli=pembeli.id_pembeli
                                        ");
                                        while ($data = mysqli_fetch_array($viewtransaksi)) {
                                            $idtransaksi = $data['id_transaksi'];
                                            $tanggal = $data['tanggal'];
                                            $nama_pembeli = $data['nama'];
                                            $nama_pegawai = $data['nama_pgw'];
                                            $jenis = $data['jenis'];
                                            $variant = $data['variant'];
                                            $jumlah = $data['jumlah'];
                                            $total_harga = $data['total_harga'];
                                            $idpembeli = $data['id_pembeli'];
                                            $idpegawai = $data['id_pegawai'];
                                            $idbarang = $data['id_barang'];
                                            $harga = $data['harga'];

                                        ?>
                                            <tr>
                                                <td><?= $idtransaksi; ?></td>
                                                <td><?= $tanggal; ?></td>
                                                <td><?= $nama_pembeli; ?></td>
                                                <td><?= $nama_pegawai; ?></td>
                                                <td><?= $jenis; ?></td>
                                                <td><?= $variant; ?></td>
                                                <td><?= $jumlah; ?></td>
                                                <td>Rp <?= $total_harga; ?></td>
                                                <td>
                                                    <button style="margin: 2px;" type="button" class="btn-1" data-toggle="modal" data-target="#deletetransaksi<?= $idtransaksi; ?>">delete</button>
                                                </td>
                                            </tr>

                                            <!-- delete modal transaksi -->
                                            <div class="modal fade" id="deletetransaksi<?= $idtransaksi; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Transaksi</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <fieldset disabled>
                                                                    <input type="text" value="<?= $nama_pembeli; ?>" class="form-control">
                                                                    <br />
                                                                    <input type="text" value="<?= $jenis; ?>" class="form-control">
                                                                    <br />
                                                                    <input type="text" value="<?= $variant; ?>" class="form-control">
                                                                    <br>
                                                                    <input type="text" value="<?= $total_harga; ?>" class="form-control">
                                                                    <br />
                                                                </fieldset>
                                                                <br />
                                                                Apakah anda ingin menghapus data transaksi ini?
                                                                <br />
                                                                <br />
                                                                <input type="hidden" name="id_transaksi" value="<?= $idtransaksi; ?>">
                                                                <input type="hidden" name="id_hp" value="<?= $idbarang; ?>">
                                                                <input type="hidden" name="jumlah" value="<?= $jumlah; ?>">
                                                                <button type="submit" name="deletetransaksi" class="btn-1">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- delete modal transaksi -->

                                        <?php
                                        };

                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Didi, Farras, Lya 2022</a></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

<!-- Modal -->
<div class="modal fade" id="transaksimodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pembeli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <select name="pembeli" class="form-control">
                        <option selected value="<?= $idpembeli; ?>">pilih pembeli</option>
                        <?php
                        $tampilanpembeli = mysqli_query($conn, "select * from pembeli");
                        while ($fetcharray = mysqli_fetch_array($tampilanpembeli)) {
                            $nama_list = $fetcharray['nama'];
                            $idpembeli = $fetcharray['id_pembeli'];
                        ?>
                            <option value="<?= $idpembeli; ?>"><?= $nama_list; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br />
                    <select name="pgw" class="form-control">
                        <option selected value="<?= $idpegawai; ?>">pilih pegawai</option>
                        <?php
                        $tampilanpegawai = mysqli_query($conn, "select * from pegawai");
                        while ($fetcharray = mysqli_fetch_array($tampilanpegawai)) {
                            $namapegawai = $fetcharray['nama_pgw'];
                            $idpgw = $fetcharray['id_pegawai'];
                        ?>
                            <option value="<?= $idpgw; ?>"><?= $namapegawai; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <select name="barang" class="form-control " id="barang" required>
                        <option selected>pilih barang</option>
                        <?php
                        $tampilanbrg = mysqli_query($conn, "select * from barang");
                        while ($d = mysqli_fetch_array($tampilanbrg)) {
                        ?>
                            <option value="<?php echo $d['id_barang'] ?>_<?php echo $d['harga'] ?>"><?php echo $d['jenis'] ?> <?php echo $d['variant'] ?> <?php echo $d['harga'] ?>, <?php echo $d['stock'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <br />
                    <input type="number" name="jumlah" placeholder="jumlah" id="jumlah" class="form-control">
                    <br />
                    <input type="number" name="harga" placeholder="harga" class="form-control harga">
                    <br />
                    <button type="submit" name="savetransaksi" class="btn-2">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>

<script>
    var data = 0;
    var jumlah = 0;
    var total = 0;
    $('#barang, #jumlah').on('change input', function() {
        var data = $('#barang').val().split('_') || 0;
        var jumlah = $('#jumlah').val() || 0;
        var total = data[1] * jumlah;
        $('.harga').val(total);
    });
</script>