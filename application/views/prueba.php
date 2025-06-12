<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Prueba de Estilos</title>
  <link rel="stylesheet" href="<?= base_url('assets/backoffice/css/bootstrap/bootstrap.min.css') ?>">
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-primary">¡Funciona!</h1>
    <button class="btn btn-success" onclick="saludar()">Click</button>
  </div>

  <script src="<?= base_url('assets/backoffice/js/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/backoffice/js/plugins/sweetalert2.all.min.js') ?>"></script>
  <script>
    function saludar() {
      Swal.fire('Hola desde tu nuevo proyecto!');
    }
  </script>
</body>
</html>
