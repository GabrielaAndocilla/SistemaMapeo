<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<!-- Latest compiled and minified CSS -->
	<!-- Latest compiled and minified CSS -->
	<!-- Latest compiled and minified CSS -->
	<style type="text/css">
	table {
		border-collapse: collapse;
	}

	table, th, td {
		border: 1px solid black;
	}
	body{
		background-color: #fff;
	}
	hr{
		border-top: 1px solid #989898;

	}
	footer{
		width: 100%;
		bottom: 0px;
		background-color: #eee;
		position: relative;
	}

	.card{
		padding: 20px;
		margin-bottom: 20px;
		background-color: #ffffff;
		border: 1px solid transparent;
		border-radius: 4px;
		border-color: #dddddd;
	}

	.row-rda{
		font-size: 12px;
		background-color: #E6E6E6;
	}
	.udla-navbar{
		background-color: #000000;
		border: 0px;
		border-bottom: 3px solid;
		border-color: #81020e;
	}

	.navbar-default .navbar-nav > li > a {
		color: #FFFFFF;
	}

	.navbar-default .navbar-nav > li:hover > a {
		background-color: #A63D47;
		color: #FFFFFF;
	}

	.btn-add{
		background-color: #DFDFDF;
		border: #DFDFDF;
		width: 40px;
		height: 40px;

	}
	.btn-add:hover{
		background-color: #676565;
		color: #fff;
	}
	.link_{
		color: #000;
		text-decoration: none;
	}

	.h-60{
		height: 60px;
	}

	.wrapword{
		white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
		white-space: -webkit-pre-wrap;
		white-space: -pre-wrap;      /* Opera 4-6 */
		white-space: -o-pre-wrap;    /* Opera 7 */
		white-space: pre-wrap;       /* css-3 */
		word-wrap: break-word;       /* Internet Explorer 5.5+ */
		white-space: normal;
		white-space: pre;
	}


	@media (min-width: 768px) {
		.udla-navbar {
			border-radius: 0px;
		}
	}

	.navbar-brand {
		height: 60px;
	}

	.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
		background-color: #81020e;
		color: #FFFFFF;
	}

	@media (min-width: 768px){
		.navbar-nav > li > a {
			padding-top: 20px;
			padding-bottom: 15px;
		}
	}

	.panel {
		border-radius: 0px;
	}
	.udla-add-header{
		background-color: #eee;
		text-align: right;
	}
	.udla-add-header>button{
		background-color: #DFDFDF;
		border: #DFDFDF;
		width: 40px;
		height: 40px;
	}
	.udla-add-header>button:hover{
		background-color: #676565;
		color: #fff;
	}
	.udla-add-header>button:focus {outline:0;}

	.udla-add-header>label{
		float: left;
		padding: 10px;
		color: #252525;
		font-weight: bold;
	}

	.table-editable {
		position: relative;

	}

	.glyphicon {
		font-size: 20px;
	}

	.table-remove {
		color: #700;
		cursor: pointer;
	}
	.table-remove:hover {
		color: #f00;
	}

	.table-up, .table-down {
		color: #007;
		cursor: pointer;


	}
	.table-down:hover {
		color: #00f;
	}

	.table-add {
		cursor: pointer;
	}
	.table-add:hover {
		color: #0b0;
	}
	.pintado{
		width: 20px;
		height: 20px;
		margin: auto;
		border-radius: 20px;
		background: rgba(0, 128, 0, 0.59);
	}
	.table-mapeo {
		max-height: 500px;
		margin-bottom: 10px;
	}
	.form-inputs-style{
		background: #dcdcdc;
		padding: 10px;
		border-radius: 3px;
	}
	.sca-exportar{
		margin: 10px 0px;
	}
	.pie{
		margin-top: 30px;
		width: 100%;
	}
	.revision{
		width: 100%;
	}
	.space{
		width: 100%;
		height: 50px;
		padding-left: 10px;
		padding-right: 10px;
	}

	.rt{
		width: 100%;
	}

	.rt,.rt tr, .rt td {
		border: 0px;
	}

	.space>span{
		min-width: 100%;
		border-bottom: 1px solid #000;
	}

	</style>

</head>
<body>
	@yield('content')
	<div class="pie">
		<p>
			Fecha de impresion: {{date('Y-m-d H:i:s',strtotime('-5 hour'))}}
		</p>
		<div class="revision">
		<table class="rt">
			<tr>
				<td>Elaborado por:</td>
				<td>Revisado por:</td>
				<td>Aprobado por:</td>
			</tr>
			<tr>
				<td class="space"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
				<td class="space"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
				<td class="space"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
			</tr>
		</table>
		</div>
	</div>
</body>
</html>
