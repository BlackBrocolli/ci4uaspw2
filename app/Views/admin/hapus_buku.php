<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="row justify-content-md-center">
                <div class="col-lg-12">
                    <div class="text-center">

                        <h2>Delete Buku</h2>
                        <p>Are you sure want to delete "<?= $delete->judul; ?>"</p>

                        <?= form_open("/home/deletebuku/" . $delete->id_buku) ?>
                        <button class="btn btn-primary">Yes</button>
                        <a href="<?= site_url('/home') ?>">Cancel</a>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>