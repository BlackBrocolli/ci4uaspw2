<?php

namespace App\Controllers;

use App\Models\ViewPinjamModel;
use App\Models\PinjamModel;
use App\Models\BukuModel;
use App\Models\AnggotaModel;

class Pinjam extends BaseController
{
    public function index()
    {
        if (session()->get('level') !== 'admin') { // jika bukan admin
            return redirect()->back();
        }
        $data['title'] = 'Peminjaman';
        $viewPinjam = new ViewPinjamModel();
        $data['pinjam'] = $viewPinjam->orderBy('id_peminjaman', 'asc')->paginate(5);
        $data['pager'] = $viewPinjam->pager;
        $data['nomor'] = nomor($this->request->getVar('page'), 5);
        return view('admin/peminjaman', $data);
    }

    // menampilkan view tambah peminjaman
    public function addpeminjaman()
    {
        if (session()->get('level') !== 'admin') { // jika bukan admin
            return redirect()->back();
        }
        $data['title'] = 'Tambah Peminjaman';
        // ambil data buku dan anggota untuk dropdown
        $anggota = new AnggotaModel();
        $buku = new BukuModel();
        $data['anggota'] = $anggota->orderBy('kode_anggota', 'asc')->findAll();
        $data['buku'] = $buku->orderBy('id_buku', 'asc')->findAll();
        return view('admin/add_peminjaman', $data);
    }

    public function createpeminjaman()
    {
        // ambil data post yang dikirim
        $kode_anggota = $this->request->getPost("kode_anggota");
        $id_buku = $this->request->getPost("id_buku");
        $tanggal_kembali = $this->request->getPost("tanggal_kembali");

        // jika semua field sudah diisi
        if ($kode_anggota != "" && $id_buku != "" && $tanggal_kembali != "") {
            // cek stok buku yang ingin dipinjam
            $db = \Config\Database::connect();
            $query = $db->query('SELECT stok FROM buku WHERE id_buku=' . $id_buku);
            $row   = $query->getRow();
            $oldstok = $row->stok;
            $newstok = $oldstok - 1;

            if ($oldstok == 0) {
                return redirect()->back()
                    ->with('info', 'Maaf, stok buku tidak tersedia saat ini');
            } else {
                $pinjam = new PinjamModel();

                $tglPinjam = date('Y-m-d');

                // insert data peminjaman
                $result = $pinjam->insert([
                    'tanggal_pinjam' => $tglPinjam,
                    'tanggal_kembali' => $this->request->getPost("tanggal_kembali"),
                    'id_buku' => $this->request->getPost("id_buku"),
                    'kode_anggota' => $this->request->getPost("kode_anggota"),
                ]);

                // jika berhasil insert data peminjaman
                if ($result == true) {
                    // kurangi stok buku yang dipinjam
                    $buku = new BukuModel();

                    $result = $buku->update($id_buku, [
                        'stok' => $newstok
                    ]);

                    return redirect()->to("/home/peminjaman")
                        ->with('info', 'Berhasil menambahkan data');
                } else {
                    return redirect()->back()
                        ->with('errors', $pinjam->errors());
                }
            }
        }
    }

    public function edittanggal($id_peminjaman)
    {
        if (session()->get('level') !== 'admin') { // jika bukan admin
            return redirect()->back();
        }
        $data['title'] = 'Update tanggal';
        $viewPinjam = new ViewPinjamModel();
        $data['edit'] = $viewPinjam->find($id_peminjaman);
        return view('admin/update_tanggal', $data);
    }

    public function updatetanggal($id_peminjaman)
    {
        $pinjam = new PinjamModel();

        $result = $pinjam->update($id_peminjaman, [
            'tanggal_kembali' => $this->request->getPost("tanggal_kembali")
        ]);

        return redirect()->to('/home/peminjaman')
            ->with('info', 'Berhasil memperpanjang waktu pinjam');
    }

    // untuk update status peminjaman menjadi selesai
    // lalu mengupdate stok buku pada tabel buku
    public function editstatus($id_peminjaman, $id_buku)
    {
        $data['title'] = 'Konfirmasi status';
        $viewPinjam = new ViewPinjamModel();
        $data['update'] = $viewPinjam->find($id_peminjaman);

        if ($this->request->getMethod() === 'post') {

            // update status
            $pinjam = new PinjamModel();

            $result = $pinjam->update($id_peminjaman, [
                'status' => 'selesai'
            ]);

            // update stok buku
            $db = \Config\Database::connect();
            $query = $db->query('SELECT stok FROM buku WHERE id_buku=' . $id_buku);
            $row   = $query->getRow();
            $oldstok = $row->stok;
            $newstok = $oldstok + 1;
            // tambahkan stok buku yang dikembalikan
            $buku = new BukuModel();

            $result = $buku->update($id_buku, [
                'stok' => $newstok
            ]);

            return redirect()->to('/home/peminjaman')
                ->with('info', 'Peminjaman selesai');
        }

        return view('admin/update_status', $data);
    }
}
