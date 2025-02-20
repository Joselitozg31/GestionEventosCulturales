<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Artista</title>
    <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">Ver Artista</h1>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= $artista['idArtista'] ?></td>
        </tr>
        <tr>
            <th>Nombre</th>
            <td><?= $artista['Nombre'] ?></td>
        </tr>
        <tr>
            <th>Biografía</th>
            <td><?= $artista['Biografia'] ?></td>
        </tr>
        <tr>
            <th>Tipo de Participación</th>
            <td><?= $artista['Tipo_Participacion'] ?></td>
        </tr>
        <tr>
            <th>Contacto</th>
            <td><?= $artista['Contacto'] ?></td>
        </tr>
    </table>
    <a href="/artistas" class="btn btn-secondary">Volver</a>
</div>
<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>