<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Artistas</title>
    <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">Lista de Artistas</h1>
    <a href="/artistas/crear" class="btn btn-success mb-3">Agregar Nuevo Artista</a>

    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Biografía</th>
            <th>Tipo de Participación</th>
            <th>Contacto</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($artistas as $artista): ?>
            <tr>
                <td><a href="#" class="detalle-artista" data-id="<?= $artista['idArtista'] ?>"><?= $artista['idArtista'] ?></a></td>
                <td><?= $artista['Nombre'] ?></td>
                <td><?= $artista['Biografia'] ?></td>
                <td><?= $artista['Tipo_Participacion'] ?></td>
                <td><?= $artista['Contacto'] ?></td>
                <td>
                    <a href="/artistas/<?= $artista['idArtista'] ?>/modificar" class="btn btn-warning">Modificar</a>
                    <a href="/artistas/<?= $artista['idArtista'] ?>/eliminar" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                    <a class="page-link" href="/artistas?pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <div id="detalle-artista" class="mt-4"></div>
</div>
<script>
$(document).ready(function() {
    $('.detalle-artista').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: '/artistas/' + id,
            method: 'GET',
            success: function(data) {
                $('#detalle-artista').html(data);
            },
            error: function() {
                alert('Error al cargar los detalles del artista.');
            }
        });
    });
});
</script>
<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>