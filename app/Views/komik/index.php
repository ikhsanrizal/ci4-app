<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
  <div class="row">
    <div class="col">
      <h1 class="mt-2">Daftar Komik</h1>
      <a class="btn btn-primary mb-3" href="/komik/create">Tambah Data</a>
      <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" role="alert">
          <?= session()->getFlashdata('pesan'); ?>
        </div>
      <?php endif; ?>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">sampul</th>
            <th scope="col">Judul</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1 ?>
          <?php foreach ($komik as $k) : ?>
            <tr>
              <th scope="row"><?= $i++; ?> </th>
              <td><img src="/img/<?= $k['sampul']; ?>" class="sampul"></td>
              <td><?= $k['judul']; ?></td>
              <td>
                <a class="btn btn-success" href="/komik/<?= $k['slug']; ?>">detail</a>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<?= $this->endSection(''); ?>