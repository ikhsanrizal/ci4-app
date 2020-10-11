<?php

namespace App\Controllers;

use App\Models\Komik_Model;
use CodeIgniter\Validation\Rules;

class Komik extends BaseController
{
  protected $komikmodel;
  public function __construct()
  {
    $this->komikmodel = new \App\Models\Komik_Model();
  }
  public function index()
  {

    // konek tanpa model :
    // $db = \config\Database::connect();
    // $komik = $db->query("SELECT * FROM komik");
    // foreach ($komik->getResultArray() as $row) {
    //   d($row);
    // }

    // $komikmodel = new \App\Models\Komik_Model();
    // $komik = $this->komikmodel->findAll();


    $data = [
      'title' => 'Daftar komik',
      'komik' => $this->komikmodel->getKomik()
    ];



    return view('komik/index', $data);
  }

  public function detail($slug)
  {

    $data = [
      'title' => 'Detail Komik',
      'komik' => $this->komikmodel->getKomik($slug)
    ];

    // cara ganti error / jika komik tidak ada di tabel
    if (empty($data['komik'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik ' . $slug . ' tidak ditemukan');
    }

    return view('komik/detail', $data);
  }

  public function create()
  {
    // // buat session karena method withInput tersimpan di session
    // session();


    $data = [
      'title' => 'Tambah Data Komik',
      'validation' => \config\Services::validation()
    ];

    return view('komik/create', $data);
  }

  public function save()
  {
    // cek data apa berhasil ditangkap atau tidak
    // dd($this->request->getVar());

    // validasi 
    if (!$this->validate([
      'judul' => [
        'rules' => 'required|is_unique[komik.judul]',
        'errors' => [
          'required' => '{field} komik harus diisi.',
          'is_unique' => '{field} Judul komik sudah ada.'
        ]
      ],

      'sampul' => [
        'rules' => 'uploaded[sampul]|max_size[sampul, 2048]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
        'errors' => [
          'uploaded' => 'Pilih gambar sampul terlebih dahulu',
          'max_size' => 'Ukuran gambar terlalu besar',
          'is_image' => 'Pastikan yang anda pilih gambar',
          'mime_in' => 'Pastikan yang anda pilih gambara'
        ]
      ]


    ])) {
      // $validation = \config\Services::validation();
      // return redirect()->to('/Komik/create')->withInput()->with('validation', $validation);
      return redirect()->to('/Komik/create')->withInput();
    }

    //ambil gambar
    $fileSampul = $this->request->getFile('sampul');


    $slug = url_title($this->request->getVar('judul'), '-', true);

    $this->komikmodel->save([
      'judul' => $this->request->getVar('judul'),
      'slug' => $slug,
      'penulis' => $this->request->getVar('penulis'),
      'penerbit' => $this->request->getVar('penerbit'),
      'sampul' => $this->request->getVar('sampul')
    ]);

    session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

    return redirect()->to('/komik');
  }

  public function delete($id)
  {
    $this->komikmodel->delete($id);
    session()->setFlashdata('pesan', 'Data berhasil dihapus.');
    return redirect()->to('/komik');
  }

  public function edit($slug)
  {
    $data = [
      'title' => 'Ubah Data Komik',
      'validation' => \config\Services::validation(),
      'komik' => $this->komikmodel->getKomik($slug)
    ];

    return view('komik/edit', $data);
  }

  public function update($id)
  {
    // cek judul

    // cara alternatif cek judul pas edit apa ada di tabel atau belum 

    // $komikLama  = $this->komikmodel->getKomik($this->request->getVar('slug'));
    // if ($komikLama['judul'] == $this->request->getVar('judul')) {
    //   $rule_judul = 'required';
    // } else {
    //   $rule_judul = 'required|is_unique[komik.judul]';
    // }


    if (!$this->validate([
      'judul' => [
        'rules' => 'required|is_unique[komik.judul,id' . $id . ']',
        'errors' => [
          'required' => '{field} komik harus diisi.',
          'is_unique' => '{field} Judul komik sudah ada.'
        ]
      ]

    ])) {
      $validation = \config\Services::validation();
      return redirect()->to('/Komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
    }

    // url title = auto buat slug baru dari judul 
    $slug = url_title($this->request->getVar('judul'), '-', true);

    $this->komikmodel->save([
      'id' => $id,
      'judul' => $this->request->getVar('judul'),
      'slug' => $slug,
      'penulis' => $this->request->getVar('penulis'),
      'penerbit' => $this->request->getVar('penerbit'),
      'sampul' => $this->request->getVar('sampul')
    ]);

    session()->setFlashdata('pesan', 'Data berhasil diubah');

    return redirect()->to('/komik');
  }
}
