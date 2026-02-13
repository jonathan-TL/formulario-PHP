<?php

// ARREGLO ASOCIATIVO PREESTABLECIDO DE USUARIOS VÁLIDOS


$usuarios_validos = [
    'admin@udgvirtual.mx' => 'Admin123',
    'alumno@udgvirtual.mx' => 'Alumno2026',
    'asesor@udgvirtual.mx' => 'Asesor456',
    'coordinador@udgvirtual.mx' => 'Coord789'
];


// INICIALIZACIÓN DE VARIABLES Y MENSAJES

$correo_enviado = $contrasena_enviada = "";
$mensaje_error = $mensaje_exito = "";
$intento_validacion = false;


// PROCESAMIENTO DEL FORMULARIO AL ENVIAR

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $intento_validacion = true;
    
    // Obtener valores del formulario y sanitizar
    $correo_enviado = isset($_POST['correo']) ? trim($_POST['correo']) : "";
    $contrasena_enviada = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : "";
    
    // Validación de campos vacíos
    if (empty($correo_enviado) || empty($contrasena_enviada)) {
        $mensaje_error = "❌ ERROR: Todos los campos son obligatorios. Por favor, complete el formulario.";
    } 
    // Validación de formato de correo electrónico
    elseif (!filter_var($correo_enviado, FILTER_VALIDATE_EMAIL)) {
        $mensaje_error = "❌ ERROR: El formato del correo electrónico no es válido. Ejemplo: usuario@dominio.com";
    }
    else {
        // Verificar si el correo existe en el arreglo de usuarios válidos
        if (array_key_exists($correo_enviado, $usuarios_validos)) {
            // Verificar si la contraseña coincide
            if ($usuarios_validos[$correo_enviado] === $contrasena_enviada) {
                $mensaje_exito = "✅ ACCESO CONCEDIDO: Bienvenido al sistema " . htmlspecialchars($correo_enviado);
            } else {
                $mensaje_error = "❌ ERROR: Contraseña incorrecta. Por favor, verifique sus credenciales.";
            }
        } else {
            $mensaje_error = "❌ ERROR: El correo electrónico no está registrado en el sistema.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario de login para validación de usuarios - Unidad 1 Programación Web">
    <meta name="author" content="Juan Carlos Pérez López">
    <title>Sistema de Login | Unidad 1 - Programación Web</title>
    <style>

        /* ESTILOS CSS INTEGRADOS PARA DISEÑO PROFESIONAL */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            line-height: 1.6;
        }
        
        .contenedor-principal {
            max-width: 800px;
            width: 100%;
        }
        
        /* Estilos de la portada */

        .portada {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px;
            border-radius: 15px 15px 0 0;
            text-align: center;
            border-bottom: 5px solid #ffd700;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .portada h1 {
            font-size: 28px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .portada h2 {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: 300;
        }
        
        .datos-portada {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
            text-align: left;
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
        }
        
        .datos-portada p {
            margin: 5px 0;
            font-size: 16px;
        }
        
        .resaltado {
            color: #ffd700;
            font-weight: bold;
        }
        
        /* Estilos del formulario */

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h3 {
            color: #333;
            font-size: 24px;
            border-bottom: 3px solid #667eea;
            display: inline-block;
            padding-bottom: 10px;
        }
        
        .grupo-formulario {
            margin-bottom: 25px;
            position: relative;
        }
        
        .grupo-formulario label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 15px;
        }
        
        .grupo-formulario input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .grupo-formulario input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        
        /* Estilos para mensajes */

        .mensaje-error {
            background-color: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #c33;
            font-weight: 500;
            animation: slideIn 0.5s ease;
        }
        
        .mensaje-exito {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #2e7d32;
            font-weight: 500;
            animation: slideIn 0.5s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Botón de envío */

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102,126,234,0.4);
        }
        
        /* Información de ayuda */

        .info-ayuda {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 5px solid #667eea;
        }
        
        .info-ayuda h4 {
            color: #333;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .info-ayuda p {
            color: #666;
            margin: 5px 0;
            font-family: monospace;
        }
        
        .usuarios-ejemplo {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }
        
        /* Referencias APA */

        .referencias {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 14px;
            color: #666;
            border-top: 2px dashed #667eea;
        }
        
        .referencias h4 {
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .referencias ul {
            list-style: none;
            padding-left: 20px;
        }
        
        .referencias li {
            margin-bottom: 5px;
            text-indent: -20px;
            padding-left: 20px;
        }
        
        /* Responsive */

        @media (max-width: 600px) {
            .portada, .login-container {
                padding: 20px;
            }
            
            .portada h1 {
                font-size: 22px;
            }
            
            .datos-portada {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor-principal">

        <!-- PORTADA CON DATOS DEL ALUMNO -->
        
        <div class="portada">
            <h1>🏫 UNIVERSIDAD</h1>
            <h2>PROGRAMACIÓN WEB Y BASES DE DATOS</h2>
            <div class="datos-portada">
                <div>
                    <p><span class="resaltado">👨‍🎓 ALUMNO:</span> [alumno] </p>
                    <p><span class="resaltado">🎓 CARRERA:</span> [carrera]</p>
                </div>
                <div>
                    <p><span class="resaltado">👨‍🏫 ASESOR:</span> [Nombre del Asesor]</p>
                    <p><span class="resaltado">📚 MATERIA:</span> [Nombre de la Materia]</p>
                    <p><span class="resaltado">📅 FECHA:</span> [Fecha de Entrega]</p>
                </div>
                <div>
                    <p><span class="resaltado">📌 UNIDAD:</span> [Unidad]</p>
                    <p><span class="resaltado">📝 ACTIVIDAD:</span> [Actividad]</p>
                </div>
            </div>
        </div>
        
        <!-- FORMULARIO DE LOGIN-->
        
        <div class="login-container">
            <div class="login-header">
                <h3>🔐 SISTEMA DE ACCESO</h3>
            </div>
            
            <!-- Visualización de mensajes de error o éxito -->
            
            <?php if ($intento_validacion): ?>
                <?php if ($mensaje_error): ?>
                    <div class="mensaje-error">
                        <?php echo $mensaje_error; ?>
                    </div>
                <?php elseif ($mensaje_exito): ?>
                    <div class="mensaje-exito">
                        <?php echo $mensaje_exito; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Formulario de login -->
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
                <div class="grupo-formulario">
                    <label for="correo">📧 CORREO ELECTRÓNICO:</label>
                    <input 
                        type="email" 
                        id="correo" 
                        name="correo" 
                        value="<?php echo htmlspecialchars($correo_enviado); ?>"
                        placeholder="ejemplo@unadmexico.mx"
                        required
                        aria-required="true"
                    >
                </div>
                
                <div class="grupo-formulario">
                    <label for="contrasena">🔑 CONTRASEÑA:</label>
                    <input 
                        type="password" 
                        id="contrasena" 
                        name="contrasena" 
                        placeholder="Ingrese su contraseña"
                        required
                        aria-required="true"
                    >
                </div>
                
                <button type="submit" class="btn-submit">
                    🚀 INGRESAR AL SISTEMA
                </button>
            </form>
            
            <!-- INFORMACIÓN DE AYUDA - USUARIOS VÁLIDOS -->
            
            <div class="info-ayuda">
                <h4>ℹ️ USUARIOS VÁLIDOS PARA PRUEBAS:</h4>
                <div class="usuarios-ejemplo">
                    <?php foreach ($usuarios_validos as $correo => $contrasena): ?>
                        <p><strong><?php echo htmlspecialchars($correo); ?></strong><br>Contraseña: <?php echo htmlspecialchars($contrasena); ?></p>
                    <?php endforeach; ?>
                </div>
                <p style="margin-top: 15px; color: #764ba2;"><em>* Estos usuarios están preestablecidos en el arreglo asociativo del programa.</em></p>
            </div>
            
            <!-- REFERENCIAS ESTILO APA-->
            
            <div class="referencias">
                <h4>📚 REFERENCIAS (ESTILO APA 7ª EDICIÓN):</h4>
                <ul>
                    <li>PHP Documentation Group. (2026). <em>PHP Manual: Funciones de arrays</em>. PHP.net. https://www.php.net/manual/es/book.array.php</li>
                    <li>Welling, L., & Thomson, L. (2024). <em>PHP and MySQL Web Development</em> (6th ed.). Addison-Wesley.</li>
                    <li>Mozilla Developer Network. (2025). <em>HTML forms guide</em>. MDN Web Docs. https://developer.mozilla.org/es/docs/Learn/Forms</li>
                    <li>Universidad Abierta y a Distancia de México. (2026). <em>Contenido de la Unidad 1: Fundamentos de PHP</em>. Plataforma educativa UnADM.</li>
                    <li>World Wide Web Consortium. (2025). <em>HTML5: A vocabulary and associated APIs for HTML and XHTML</em>. W3C Recommendation. https://www.w3.org/TR/html52/</li>
                </ul>
                <p style="margin-top: 15px; text-align: center; color: #667eea;">
                    <em>© 2026 - Producto desarrollado para la actividad de la Unidad 1. Todos los derechos reservados.</em>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
