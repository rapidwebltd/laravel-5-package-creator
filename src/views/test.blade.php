<html>
	<head>
		<title>Laravel</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
			
			p.name {
				color: #555 !important;
				font-family:arial;
			}
			
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title" style="color:black;">Laravel 5</div>
				
				<h2 style="font-weight:normal;color:black;font-family:arial;">Marks Test Page</h2>
				
				<div class="quote" style="color:black;font-weight:bold;font-family:arial;">{{ Inspiring::quote() }}</div>
				
				@foreach($customers as $customer)
					
					<p class="name">{{ $customer->full_name }}</p>
					
				@endforeach
				
			</div>
		</div>
	</body>
</html>
