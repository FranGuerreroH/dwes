<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
    <style>
        body {
            text-align: center;
        }

        h2 {
            background-color: darkcyan;
        }

        img {
            border: solid orange;
            box-shadow: 10px 10px 10px  darkslategray;
        }
        
        button {
            background-color: darkcyan;
        }

    </style>
</head>

<body>
    <h2> Mi cuenta </h2>

    <p style="font-weight: bold;"> ¡Bienvenido seas, <?= \App\Soporte\e($usuario->nombre) ?> ! </p>

    <img src="https://media.istockphoto.com/id/2162451866/es/foto/hermosa-vista-del-amanecer-en-el-bosque-brumoso-en-la-toscana-italia-con-colinas-verdes-y.jpg?s=612x612&w=0&k=20&c=eU6DZx4iBFs664oD6yeZKy2xbQtNEjl0KYT3ATCvKJg=" alt="">
    
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum distinctio maxime temporibus et repudiandae optio 
        dolores ullam aspernatur officia molestias quisquam, quasi nobis labore animi sint hic. Tempora est veniam 
        consequatur doloremque officiis sapiente repudiandae modi excepturi quisquam! Cum perspiciatis ipsum quisquam 
        veniam a quibusdam tempora earum dolores aliquid sed! Pariatur optio animi veritatis veniam magnam sed totam, 
        ab dolore praesentium, at voluptatum accusamus culpa doloribus perspiciatis voluptate assumenda! Aperiam quo sapiente 
        reiciendis natus quis maiores sed laboriosam, fugit atque eos officiis, cumque illum dignissimos, blanditiis 
        labore! Illo debitis ea porro, consequatur placeat voluptatibus, impedit velit labore veritatis, quos minima?
    </p>

    <h3>Sabías que...</h3>
    <p>Si te atas una cuerda alrededor del dedo.....se te pone morado</p>

    <p> &copy; Francisco Guerrero</p>


</body>

</html>