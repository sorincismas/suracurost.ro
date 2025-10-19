<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1><?= isset($angajat) ? 'Editare' : 'Adăugare' ?> Angajat</h1>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="<?= isset($angajat) ? site_url('angajati/update/' . $angajat['id']) : site_url('angajati/create') ?>" method="post">
        <?= csrf_field() ?>
        <?php if (isset($angajat)): ?>
             <input type="hidden" name="_method" value="PUT" />
        <?php endif; ?>
        
        <div class="mb-3">
            <label for="nume_prenume" class="form-label">Nume și Prenume</label>
            <input type="text" class="form-control" id="nume_prenume" name="nume_prenume" value="<?= set_value('nume_prenume', $angajat['nume_prenume'] ?? '') ?>">
        </div>
        
        <div class="mb-3">
            <label for="id_firma" class="form-label">Firma</label>
            <select class="form-select" id="id_firma" name="id_firma">
                <option value="">Alege o firmă</option>
                <?php if (!empty($firme) && is_array($firme)): ?>
                    <?php foreach($firme as $firma): ?>
                        <option value="<?= $firma['id'] ?>" <?= set_select('id_firma', $firma['id'], (isset($angajat) && $angajat['id_firma'] == $firma['id'])) ?>>
                            <?= esc($firma['nume_firma']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="cnp" class="form-label">CNP</label>
            <input type="text" class="form-control" id="cnp" name="cnp" value="<?= set_value('cnp', $angajat['cnp'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="functie_departament" class="form-label">Funcție / Departament</label>
            <input type="text" class="form-control" id="functie_departament" name="functie_departament" value="<?= set_value('functie_departament', $angajat['functie_departament'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="data_angajarii" class="form-label">Data Angajării</label>
            <input type="date" class="form-control" id="data_angajarii" name="data_angajarii" value="<?= set_value('data_angajarii', $angajat['data_angajarii'] ?? '') ?>">
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $angajat['email'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="telefon" class="form-label">Telefon</label>
            <input type="text" class="form-control" id="telefon" name="telefon" value="<?= set_value('telefon', $angajat['telefon'] ?? '') ?>">
        </div>

        <button type="submit" class="btn btn-success">Salvează</button>
        <a href="<?= site_url('/angajati') ?>" class="btn btn-secondary">Anulează</a>
    </form>
</div>
<?= $this->endSection() ?>
