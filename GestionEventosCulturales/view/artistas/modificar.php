<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Artista</title>
    <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">Modificar Artista</h1>

    <form method="POST" action="/artistas/<?= $artista['idArtista'] ?>/modificar" class="mt-4">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $artista['Nombre'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="biografia" class="form-label">Biografía</label>
            <textarea name="biografia" id="biografia" class="form-control" required><?= $artista['Biografia'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="tipo_participacion" class="form-label">Tipo de Participación</label>
            <input type="text" name="tipo_participacion" id="tipo_participacion" class="form-control" value="<?= $artista['Tipo_Participacion'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="contacto" class="form-label">Contacto</label>
            <input type="text" name="contacto" id="contacto" class="form-control" value="<?= $artista['Contacto'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="/artistas" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>