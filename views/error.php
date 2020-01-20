<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>
			<?= isset($title) ? $title : 'Erreur'; ?>
		</title>
		<link rel="stylesheet" href="/public/css/style-error.css">
	</head>
	<body>
		<?= $content ?>
	</body>
</html>