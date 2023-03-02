<?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html><?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html><?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html><?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html><?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html><?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html><?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html><?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html><?php

require_once '../../global.php';

$sql = "SELECT
COUNT(p.product_name) 'quantity',
c.category_name
FROM
`category` c
LEFT JOIN product p ON
p.category_id = c.category_id
GROUP BY
c.category_name";

$dataPoints = array();
$countProductByCate = queryDB($sql, 1);

foreach ($countProductByCate as $row) {
	$quantity = $row['quantity'];
	$category_name = $row['category_name'];

	array_push($dataPoints, array("label" => $category_name, "y" => $quantity));
}

$sql = "SELECT
	COUNT(com.comment_id) 'comment',
		c.category_name
	FROM
		`category` c
	LEFT JOIN product p ON
		p.category_id = c.category_id
	LEFT JOIN comment com ON com.product_id = p.product_id
		GROUP BY
		c.category_name
";

$countCommentByCate = queryDB($sql, 1);
$dataPointsComment = array();

foreach ($countCommentByCate as $row) {
	$commentTotal = $row['comment'];
	$com_category_name = $row['category_name'];

	array_push($dataPointsComment, array("label" => $com_category_name, "y" => $commentTotal));
}


?>
<!DOCTYPE HTML>
<html>

<head>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng sản phẩm"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();


			var chart = new CanvasJS.Chart("chartContainer2", {
				animationEnabled: true,
				exportEnabled: true,
				title: {
					text: "Thống kê loại hàng theo số lượng bình luận"
				},
				subtitles: [{
					text: "Đơn vị: Cái"
				}],
				data: [{
					type: "pie",
					showInLegend: "true",
					legendText: "{label}",
					indexLabelFontSize: 16,
					indexLabel: "{label} - #percent%",
					yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($dataPointsComment, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>

	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		.btn-primary {
			margin: 50px 120px;
			width: 100px;
			text-align: center;
		}
	</style>
</head>

<body>
	<div class="container-fluid d-flex flex-lg-row flex-sm-column mt-5">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<br>
		<div class="mt-5 mt-sm-0" id="chartContainer2" style="height: 370px; width: 100%;"></div>
	</div>

	<a class="btn btn-primary" href="../../admin/adminhomepage.php">Trở về</a>

	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>