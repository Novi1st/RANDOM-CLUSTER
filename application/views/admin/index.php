<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <form action="<?= base_url('admin'); ?>" method="post">
        <div class="form-group">
          <select name="year_transaction" id="year_transaction" class="form-control">
            <option value="">Select Year</option>
            <?php foreach ($year as $y) :?>
              <option value="<?php echo $y['date']; ?>"><?php echo $y['date']; ?></option>
            <?php endforeach;?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Cluster</button>
    </form>
    <?= $jumlah_data;?>
    <?= $numlocal;?>
    <!-- <?= $maxneighbor;?> -->

<h2>Data All</h2>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Product</th>
      <th scope="col">Total</th>
      <th scope="col">Modus</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach ($data_transaction as $dt) : ?>
      <tr>
        <th scope="row"><?= $i; ?></th>
        <td><?= $dt['product'] ?></td>
        <td><?= $dt['total'] ?></td>
        <td><?= $dt['modus'] ?></td>
      </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
<!-- <a class="badge badge-success" href="<?= base_url('admin/cluster/') . $dt['date'];?>">Cluster</a> -->
</table>

<h2>Currentnode</h2>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Product</th>
      <th scope="col">Total</th>
      <th scope="col">Modus</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach ($currentnode as $cn) : ?>
      <tr>
        <th scope="row"><?= $i; ?></th>
        <td><?= $cn['product'] ?></td>
        <td><?= $cn['total'] ?></td>
        <td><?= $cn['modus'] ?></td>
      </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
<!-- <a class="badge badge-success" href="<?= base_url('admin/cluster/') . $dt['date'];?>">Cluster</a> -->
</table>

<h2>Medoid</h2>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Product</th>
      <th scope="col">Total</th>
      <th scope="col">Modus</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach ($medoid as $md) : ?>
      <tr>
        <th scope="row"><?= $i; ?></th>
        <td><?= $md['product'] ?></td>
        <td><?= $md['total'] ?></td>
        <td><?= $md['modus'] ?></td>
      </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
<!-- <a class="badge badge-success" href="<?= base_url('admin/cluster/') . $dt['date'];?>">Cluster</a> -->
</table>

<h2>Non Medoid</h2>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Product</th>
      <th scope="col">Total</th>
      <th scope="col">Modus</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php foreach ($nonmedoid as $nm) : ?>
      <tr>
        <th scope="row"><?= $i; ?></th>
        <td><?= $nm['product'] ?></td>
        <td><?= $nm['total'] ?></td>
        <td><?= $nm['modus'] ?></td>
      </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
<!-- <a class="badge badge-success" href="<?= base_url('admin/cluster/') . $dt['date'];?>">Cluster</a> -->
</table>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->