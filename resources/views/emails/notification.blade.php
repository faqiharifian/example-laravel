<html>
	<head>
		<style type="text/css">
			
		</style>
	</head>
	<body>
		<h3>There is a message from:</h3>
		<table>
			<tbody>
				<tr>
					<td class="head">Name</td>
					<td>: {{ $name }}</td>
				</tr>
				<tr>
					<td class="head">Email</td>
					<td>: {{ $email }}</td>
				</tr>
			</tbody>
		</table>

		<hr/>
		<h3>Content</h3>
		{{ $content }}
	

	</body>
</html>