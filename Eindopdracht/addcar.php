<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVerhuur|AddCar</title>
    <link rel="stylesheet" href="/css/addcar.css">
</head>
<body>
<button id="back"><a href="adminvehicle.php">HOME</a></button>
 <div class="main">

        <div class="register">
        <h2>Voer details van de nieuwe auto in</h2>
        <form id="register"  action="upload.php" method="POST" enctype="multipart/form-data">
            <label>Autonaam: </label>
            <br>
            <input type ="text" name="carname"
            id="name" placeholder="Voer de autonaam in" required>
            <br><br>

            <label>Brandstoftype: </label>
            <br>
            <input type ="text" name="ftype"
            id="name" placeholder="Voer het brandstoftype in" required>
            <br><br>

            <label>Capaciteit: </label>
            <br>
            <input type="number" name="capacity" min="1"
            id="naam" placeholder="Voer capaciteit van auto in" required>
            <br><br>

            <label>Prijs:</label>
            <br>
            <input type="number" name="price" min="1"
            id="name" placeholder="Voer de prijs van de auto in voor één dag" required>
            <br><br>

            <label>Auto afbeelding: </label>
            <br>
            <input type="file" name="image" required>
           <br><br>
            <input type="submit" class="btnn"  value="ADD CAR" name="addcar">
        </input>
        </form>
        </div>
    </div.main>
</body>
</html>