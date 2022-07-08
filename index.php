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
                    <h1 class="mt-4">Stok Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn-1" data-toggle="modal" data-target="#brgmodal">
                                Tambah Stok Barang
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Jenis</th>
                                            <th>Varian</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $viewbarang = mysqli_query($conn, "SELECT * FROM `barang`");
                                        while ($data = mysqli_fetch_array($viewbarang)) {
                                            $id_barang = $data['id_barang'];
                                            $jenis = $data['jenis'];
                                            $variant = $data['variant'];
                                            $harga = $data['harga'];
                                            $stock = $data['stock'];
                                            $keterangan = $data['keterangan'];

                                        ?>
                                            <tr>
                                                <td><?= $id_barang; ?></td>
                                                <td><?= $jenis; ?></td>
                                                <td><?= $variant; ?></td>
                                                <td><?= "Rp " . $harga; ?></td>
                                                <td><?= $stock ?></td>
                                                <td><?= $keterangan; ?></td>
                                                <td>
                                                    <button style="margin: 2px;" type="button" class="btn-3" data-toggle="modal" data-target="#modalupdate<?= $id_barang; ?>">Update</button>
                                                    <button style="margin: 2px;" type="button" class="btn-3" data-toggle="modal" data-target="#modaldelete<?= $id_barang; ?>">Delete</button>
                                                </td>
                                            </tr>
                                            <!-- update modal -->
                                            <div class="modal fade" id="modalupdate<?= $id_barang; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update KB</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <input type="text" name="jenis" value="<?= $jenis; ?>" class="form-control" required>
                                                                <br />
                                                                <input type="text" name="variant" value="<?= $variant; ?>" class="form-control" required>
                                                                <br />
                                                                <input type="number" name="harga" value="<?= $harga; ?>" class="form-control" required>
                                                                <br />
                                                                <input type="number" name="stock" value="<?= $stock; ?>" class="form-control" required>
                                                                <br />
                                                                <textarea type="text" class="form-control" name="keter" rows="3" required><?= $keterangan; ?></textarea>
                                                                <input type="hidden" name="idbrg" value="<?= $id_barang; ?>">
                                                                <br />
                                                                <button type="submit" name="updatebrg" class="btn-4">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- update modal -->

                                            <!-- delete modal -->
                                            <div class="modal fade" id="modaldelete<?= $id_barang; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <fieldset disabled>
                                                                    <input type="text" name="jenis" value="<?= $jenis; ?>" class="form-control" required>
                                                                    <br />
                                                                    <input type="text" name="variant" value="<?= $variant; ?>" class="form-control" required>
                                                                    <br />
                                                                </fieldset>
                                                                <br />
                                                                Apakah anda ingin menghapus stok barang ini?
                                                                <br />
                                                                <br />
                                                                <input type="hidden" name="idbrg" value="<?= $id_barang; ?>">
                                                                <button type="submit" name="deletebrg" class="btn-5">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- delete modal -->

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

<div class="modal fade" id="brgmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="text" name="jenis_brg" placeholder="jenis" class="form-control" required>
                    <br />
                    <input type="text" name="variant_brg" placeholder="variant" class="form-control" required>
                    <br />
                    <input type="number" name="harga_brg" placeholder="harga" class="form-control" required>
                    <br />
                    <input type="number" name="stock_brg" placeholder="stock" class="form-control" required>
                    <br />
                    <textarea type="text" placeholder="keterangan" class="form-control" name="keterangan" rows="3" required></textarea>
                    <br />
                    <button type="submit" name="inserbrg" class="btn-2">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>