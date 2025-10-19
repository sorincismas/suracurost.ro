<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Listă Angajați</h1>
        <a href="<?= site_url('angajati/new') ?>" class="btn btn-primary">Adaugă Angajat</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nume și Prenume</th>
                <th>Firma</th>
                <th>CNP</th>
                <th>Funcție / Departament</th>
                <th>Data Angajării</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($angajati) && is_array($angajati)): ?>
                <?php foreach ($angajati as $angajat): ?>
                <tr>
                    <td><?= esc($angajat['id']) ?></td>
                    <td><?= esc($angajat['nume_prenume']) ?></td>
                    <td><?= esc($angajat['nume_firma']) ?></td>
                    <td><?= esc($angajat['cnp']) ?></td>
                    <td><?= esc($angajat['functie_departament']) ?></td>
                    <td><?= esc($angajat['data_angajarii']) ?></td>
                    <td>
                        <a href="<?= site_url('angajati/edit/' . $angajat['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="<?= site_url('angajati/delete/' . $angajat['id']) ?>" method="post" class="d-inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ești sigur că vrei să ștergi acest angajat?');">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Nu există angajați înregistrați.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
