<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Email</title>
    <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">Validar Email</h1>
    <form method="POST" action="/validacion">
        <div class="mb-3">
            <label for="codigo" class="form-label">Código de Validación</label>
            <input type="text" name="Codigo" id="codigo" class="form-control" required>
        </div>
        <input type="hidden" name="Correo" value="<?= $_GET['correo'] ?>">
        <button type="submit" class="btn btn-primary">Validar</button>
    </form>
</div>
<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>