<?= $this->extend('Crm/layout/template') ?>

<?= $this->section('content') ?>

<!-- Afisare erori de validare -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">A apărut o eroare!</strong>
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<div class="bg-white p-8 rounded-lg shadow-lg">
    <form action="<?= site_url('angajati/save') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= esc($angajat->id ?? '') ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nume -->
            <div>
                <label for="nume" class="block text-sm font-medium text-gray-700">Nume</label>
                <input type="text" name="nume" id="nume" value="<?= old('nume', $angajat->nume ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            </div>
            <!-- Prenume -->
            <div>
                <label for="prenume" class="block text-sm font-medium text-gray-700">Prenume</label>
                <input type="text" name="prenume" id="prenume" value="<?= old('prenume', $angajat->prenume ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            </div>
            <!-- Email -->
            <div class="md:col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="<?= old('email', $angajat->email ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            </div>
            <!-- Functie -->
            <div>
                <label for="functie" class="block text-sm font-medium text-gray-700">Funcție</label>
                <input type="text" name="functie" id="functie" value="<?= old('functie', $angajat->functie ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            </div>
            <!-- Zile Concediu -->
            <div>
                <label for="zile_concediu_an" class="block text-sm font-medium text-gray-700">Zile concediu/an</label>
                <input type="number" name="zile_concediu_an" id="zile_concediu_an" value="<?= old('zile_concediu_an', $angajat->zile_concediu_an ?? 21) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            </div>
            <!-- Rol -->
            <div>
                <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
                <select id="rol" name="rol" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-purple-500 focus:outline-none focus:ring-purple-500 sm:text-sm">
                    <option value="operator" <?= old('rol', $angajat->rol ?? '') == 'operator' ? 'selected' : '' ?>>Operator</option>
                    <option value="admin" <?= old('rol', $angajat->rol ?? '') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                </select>
            </div>
            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-purple-500 focus:outline-none focus:ring-purple-500 sm:text-sm">
                    <option value="activ" <?= old('status', $angajat->status ?? '') == 'activ' ? 'selected' : '' ?>>Activ</option>
                    <option value="arhivat" <?= old('status', $angajat->status ?? '') == 'arhivat' ? 'selected' : '' ?>>Arhivat</option>
                </select>
            </div>
        </div>

        <div class="mt-8 text-right">
            <a href="<?= site_url('angajati') ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Anulare
            </a>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <i class="fa-solid fa-save mr-2"></i> Salvare
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
