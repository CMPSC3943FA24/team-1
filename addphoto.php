<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Power Outage Report</title>

  <link rel="stylesheet" type"text/css" href="ExoElectricStyles.css">
  <style>h1 {text-align: center;} </style>
</head>
<header>

  <a href="javascript:history.back()" class="back-button">
      <img src="icons8-back-arrow-50.png" alt="Back Button" />
  </a>
</header>
<body>

  <!-- LOGO -->
  <h1>
  <div align="center">
     <a href="index.html">
  	 <img src="LongLogo_Blk.png" alt="ExoElectric Logo" width="50%" height="auto"> </a>
</h1>
</form>



<div align="center">
<form action="submit_photo.php" method="post" enctype="multipart/form-data">
  <label for="image">Upload Image (PNG/JPG):</label>
  <input type="file" id="image" name="image" accept=".png, .jpg, .jpeg">

<br>
  <input type="submit" value="Submit Ticket">
</form>
</body>
</html>