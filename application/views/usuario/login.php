<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- IMPORTANTE -->

    <!-- Bootstrap 3.3.1 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <style>
        /* Animación fondo degradado */
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(-45deg, #1e3c72, #2a5298, #1e3c72, #2a5298);
            background-size: 400% 400%;
            animation: gradientMove 15s ease infinite;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px 25px;
            border-radius: 8px;
            box-shadow: 0 0 25px rgba(0,0,0,0.15);
            box-sizing: border-box;
        }

        footer {
            text-align: center;
            color: #ddd;
            padding: 15px 0;
            font-size: 0.9em;
            background-color: rgba(0,0,0,0.2);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #003366;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
        }

        .alert {
            margin-top: 10px;
        }

        /* Responsive: ajustar inputs y contenedor */
        @media (max-width: 480px) {
            .login-container {
                padding: 20px 15px;
            }

            .btn-primary {
                font-size: 14px;
                padding: 10px;
            }

            label {
                font-size: 14px;
            }

            input.form-control {
                font-size: 14px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="login-container">
        <h2>Iniciar sesión</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if (!empty($validation_errors)): ?>
            <?= $validation_errors ?>
        <?php endif; ?>

        <?= form_open('usuario/login'); ?>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>

    </div>
</div>
<footer>
    <p>&copy; <?= date('Y') ?> - Taller de Vehiculos</p>
</footer>

<!-- Bootstrap JS y jQuery opcional -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</body>
</html>
