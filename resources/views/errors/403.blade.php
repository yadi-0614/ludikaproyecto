<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso Denegado</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #00A19B;
            /* Teal UT Selva */
            --secondary: #F7941E;
            /* Naranja UT Selva */
            --dark: #002D44;
            /* Azul Marino UT Selva */
            --bg: #f8fafc;
            --text: #1e293b;
        }

        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        } */

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark);
            color: var(--text);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(0, 161, 155, 0.2) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(247, 148, 30, 0.2) 0%, transparent 40%);
        }

        .container {
            text-align: center;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 2rem;
            border: 5px solid var(--secondary);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            max-width: 500px;
            width: 90%;
            animation: fadeIn 0.8s ease-out;
            margin: 1rem;
            position: relative;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .image-container {
            margin-bottom: 2rem;
        }

        .image-container img {
            width: 100%;
            max-width: 180px;
            border-radius: 1.5rem;
            box-shadow: 0 15px 35px rgba(0, 45, 68, 0.3);
            animation: float 4s ease-in-out infinite;
            border: 3px solid var(--primary);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        h2 {
            font-size: 4rem;
            margin-bottom: 1rem;
            font-weight: 200;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        p {
            color: #334155;
            margin-bottom: 2.5rem;
            line-height: 1.6;
            font-size: 1.1rem;
            font-weight: 200;
        }

        .btn {
            display: inline-block;
            padding: 1.1rem 2.5rem;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 1rem;
            font-weight: 400;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 15px -3px rgba(0, 161, 155, 0.4);
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (min-width: 640px) {
            .container {
                padding: 3.5rem;
            }

            h2 {
                font-size: 2rem;
            }

            .btn {
                width: auto;
            }
        }

        .btn:hover {
            transform: translateY(-4px) scale(1.02);
            background-color: var(--dark);
            box-shadow: 0 20px 25px -5px rgba(0, 45, 68, 0.4);
        }

        .brand-accent {
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--secondary);
            color: white;
            padding: 4px 20px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="image-container">
            <img src="/images/403-access-denied.png" alt="Acceso Denegado">
        </div>
        <h2>¡Acceso Restringido!</h2>
        <p>Lo sentimos, no cuentas con los privilegios suficientes para entrar aquí. Por favor, vuelve al inicio o
            contacta soporte.</p>
        <a href="{{ url('/') }}" class="btn">Regresar al Home</a>
        <div class="brand-accent">ERROR 403</div>
    </div>
</body>

</html>
