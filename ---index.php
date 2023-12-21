<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <tittle>CLINICA PONS</tittle>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <script src="https://kit.fontawesome.com/a076d5399.js"></script>
    </head>
    <body>
        
        <div class="btn">
            <span class="fas fa-caret"></span>
        </div>

        <nav class="sidebar">
            <div class="text">Menu</div>
            <ul>
                <li>
                    <a href="#" class="reg-btn">Registros
                            <span class="fas fa-caret-down first"></span>
                    </a>                    
                    <ul class=" reg-show">
                        <a href="/consultar_enfermedad/insertar/paciente.php">Paciente</a>
                        <a href="#">Sintoma</a>
                        <a href="#">Enfermedad</a>
                        <a href="#">Consultas</a>
                        <a href="#">Ocurrencia</a>
                    </ul>
                </li>
                <li>
                    <a href="#" class="mant-btn">Mantenimiento
                        <span class="fas fa-caret-down second"></span>
                    </a>
                    <ul class=" mant-show">
                        <a href="#">Paciente</a>
                        <a href="#">Sintoma</a>
                        <a href="#">Enfermedad</a>
                        <a href="#">Consultas</a>
                    </ul>
                </li>
                <li>
                    <a href="#" class="proc-btn">Proceso
                        <span class="fas fa-caret-down therthy"></span>
                    </a>
                    <ul class=" proc-show">
                        <a href="#">Enfermedad y Sintoma</a>
                        <a href="#">Ocurrencia</a>
                    </ul>
                </li>
            </ul>
        </nav>

        <script>
            $('.reg-btn').click(function() {
                $('nav ul .reg-show').toggleClass("show");
                $('nav ul .first').toggleClass("rotate");
            });
            $('.mant-btn').click(function() {
                $('nav ul li ul.mant-show').toggleClass("show1");
                $('nav ul .second').toggleClass("rotate");
            });
            $('.proc-btn').click(function() {
                $('nav ul li ul.proc-show').toggleClass("show2");
                $('nav ul .therthy').toggleClass("rotate");
            });
            $('nav ul li').click(function(){
                $(this).addClass("active").siblings().removeClass("active");
            });
        </script>
    </body>
</html>