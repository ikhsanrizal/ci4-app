<?= $this->extend('layout/template'); ?>

<?= $this->section('content');  ?>
<div class="container">
  <div class="row">
    <div class="col">
      <h2 class="mt-2">Detail Komik</h2>
      <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="/img/<?= $komik['sampul']; ?>" class="card-img">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title"><?= $komik['judul']; ?></h5>
              <p class="card-text"><b>Penulis : </b><?= $komik['penulis']; ?></p>
              <p class="card-text"><small class="text-muted"><b>Penerbit : </b><?= $komik['penerbit']; ?></small></p>


              <a class="btn btn-warning" href="/komik/edit/<?= $komik['slug']; ?>">Edit</a>

              <!-- disebut http method spoofing pada button delete agar tidak bisa dihapus melalui url -->
              <form action="/komik/<?= $komik['id']; ?>" method="POST" class="d-inline">

                <!-- csrf_field dibuat supaya terhindar dari hacking -->
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="delete">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Tidak?')">Delete</button>
              </form>



              <div class="row no-gutters">
                <a class="mt-4" href="/komik">Kembali ke Daftar Komik</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(''); ?>