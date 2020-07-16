<html>
	<head>
		<style type="text/css">
			body {
				background-color: black;
				color: white;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<?php if(count($errors) > 0) : ?>

		<div>

		    <?php foreach($errors as $error) : ?>
		    <p>
		    <?php echo $error ?>
		    </p>
		    <?php endforeach ?>

		</div>

		<?php endif ?>
	</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 06547998a3bbb3bf538e1696c7a582e0573939a1
