<!DOCTYPE html>
<html lang="en-us">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

	<title>Livecode - Online Code Compiler</title>

	<!-- # Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

	<!-- # CSS Plugins -->
	<link rel="stylesheet" href="plugins/slick/slick.css">
	<link rel="stylesheet" href="plugins/font-awesome/fontawesome.min.css">
	<link rel="stylesheet" href="plugins/font-awesome/brands.css">
	<link rel="stylesheet" href="plugins/font-awesome/solid.css">

	<!-- # Main Style Sheet -->
	<link rel="stylesheet" href="css/style.css">
	<style>
		.codearea {
			display: flex;
			flex-direction: column;
		}

		.code-box {
			background: #212121;
			color: #00ff00;
			font-family: monospace;
			padding: 20px;
		}
	</style>
</head>

<body>


	<section style="paddinng:0;margin:0;">
		<div class="d-flex justify-content-between" style="padding:10px 50px;">
			<div>
				<a class="navbar-brand mx-lg-1 mr-0" href="./index.php">

					<img loading="prelaod" decoding="async" class="img-fluid" width="120" src="images/logo.png"
						alt="Wallet">
				</a>
			</div>
			<div class="control-panel" style="padding-top:13px;">
				Theme:
				<select id="themename" class="themename" onchange="changetheme()">
                        <option value="eclipse"> Eclipse </option>
                        <option value="monokai"> Monokai </option>
                    </select>
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;

				Language:
				<select id="languages" class="languages" onchange="changeLanguage()">
					<option value="php"> PHP </option>
					<option value="python"> Python </option>
					<option value="node"> Node JS </option>
				</select>
				&nbsp;
			</div>
			<div style="padding-top:3px;padding-right:30px;">
				<button class="btn btn-primary" onclick="executeCode();">Run </button> &nbsp;
			</div>
		</div>
		<div>
			<div class="row justify-content-center align-items-center">
				<div class="editor col-8" id="editor" style="height: 90vh; overflow:auto;"></div>
				<div class="output col-4"
					style="font-family: Courier New, Courier, monospace; color:white; background:#222;padding:20px;height: 90vh;">
				</div>
			</div>
		</div>
	</section>



	<!-- # JS Plugins -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<script src="plugins/bootstrap/bootstrap.min.js"></script>
	<script src="plugins/slick/slick.min.js"></script>
	<script src="plugins/scrollmenu/scrollmenu.min.js"></script>

	<script src="js/lib/ace.js"></script>
	<script src="js/lib/theme-eclipse.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Main Script -->
	<script src="js/script.js"></script>

	<script>
		let editor;

		window.onload = function () {
			editor = ace.edit("editor");
			editor.setTheme("ace/theme/eclipse");
			editor.session.setMode("ace/mode/python");
			editor.setFontSize(16);
		}


		function changeLanguage() {

			let languege = $("#languages").val();

			if (languege == 'py') editor.session.setMode("ace/mode/python");
			else if (languege == 'php') editor.session.setMode("ace/mode/php");
			else if (languege == 'node') editor.session.setMode("ace/mode/javascript");
		}

		function changetheme() {
            var themename = $("#themename").val();
            editor = ace.edit("editor");
            editor.setTheme("ace/theme/" + themename);
        }

		function executeCode() {

			$.ajax({

				url: "./ide/free_compiler_run.php",

				method: "POST",

				data: {
					language: $("#languages").val(),
					code: editor.getSession().getValue()
				},

				success: function (response) {
					$(".output").text(response)
				}
			})
		}
	</script>

</body>

</html>