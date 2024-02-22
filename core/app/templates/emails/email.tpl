<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<div style="height:100%; max-width: 500px; margin: 0 auto; padding: 32px 64px; border-radius: 12px; background: #f6f8fa; color: #24292f;">
		<h2>{$title}</h2>
		
		{block 'main'}

		{/block}

		<p><small>{'site_url'|config}</small></p>
	</div>
</body>
</html>