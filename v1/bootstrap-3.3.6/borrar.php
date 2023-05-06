<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<body>
<div class="container">
<input class="">
<select class="list-group">
	<option class="list-group-item active">algo</option>
</select>
    <div class="list-group">
        <a href="#" class="list-group-item active">First item</a>
        <a href="#" class="list-group-item">Second item</a>
        <a href="#" class="list-group-item">Third item</a>
        <a class="list-group-item" id="" data-remote="true" href="#sub_categoria_4"  data-bs-toggle="collapse">
          <span>Compras</span>
          <span class="glyphicon glyphicon-chevron-down"></span>
        </a>
        <div class="collapse list-group-submenu" id="sub_categoria_4">
          <a href="#" class="list-group-item sub-item" data-parent="#sub_categoria_4" style="padding-left: 78px;">SubSubPos1</a>
          <a href="#" class="list-group-item sub-item" data-parent="#sub_categoria_4" style="padding-left: 78px;">SubSubPos2</a>
          <a href="#" class="list-group-item sub-item" data-parent="#sub_categoria_4" style="padding-left: 78px;">SubSubPos3</a>
          <a href="#" class="list-group-item sub-item" data-parent="#sub_categoria_4" style="padding-left: 78px;">SubSubPos4</a>
        </div>
    </div>
</div>
</body>
</html>