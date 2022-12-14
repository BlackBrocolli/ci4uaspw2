<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Peminjaman</h6>
        </div>
        <div class="card-body">

            <!-- tombol tambah peminjaman -->
            <a href="<?= base_url(); ?>/home/addpeminjaman" class="btn btn-primary">Tambah Peminjaman</a>
            <br><br>

            <!-- tampilkan info jika ada -->
            <?php if (!empty(session()->getFlashdata('info'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo session()->getFlashdata('info'); ?>
                </div>
            <?php endif; ?>

            <!-- Tabel buku -->
            <table class="table table-bordered">
                <tr>
                    <th>No</th>
                    <th>Kode Anggota</th>
                    <th>Nama Anggota</th>
                    <th>ID Buku</th>
                    <th>Judul</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php
                $no = 1;
                foreach ($pinjam as $row) : ?>
                    <tr>
                        <td><?php echo $nomor++; ?></td>
                        <td><?php echo $row->kode_anggota; ?></td>
                        <td><?php echo $row->nama_anggota; ?></td>
                        <td><?php echo $row->id_buku; ?></td>
                        <td><?php echo $row->judul; ?></td>
                        <td><?php echo $row->tanggal_pinjam; ?></td>
                        <td><?php echo $row->tanggal_kembali; ?></td>
                        <td><?php echo $row->status; ?></td>
                        <td>
                            <?php if ($row->status == 'ongoing') : ?>
                                <a title="Tambah waktu pinjam" class="btn btn-warning" href="<?= base_url(); ?>/home/edittanggal/<?= $row->id_peminjaman; ?>"><i class="fas fa-fw fa-calendar-plus" style="margin: -4px"></i></a>
                                <a title="Peminjaman selesai" class="btn btn-success" href="<?= base_url(); ?>/home/editstatus/<?= $row->id_peminjaman; ?>/<?= $row->id_buku; ?>"><i class="fas fa-fw fa-check" style="margin: -4px"></i></a>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
            <!-- end of Tabel buku -->

            <?= $pager->links() ?>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>