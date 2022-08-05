<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laravel Import Excel CSV to MySQL</title>
	<meta name="description" content="The tiny framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
	  .container {
		max-width: 500px;
	  }
	</style>
</head>
<body>
<div class="container mt-5">
	<div class="card">
		<div class="card-header text-center">
		<a href="<?php echo site_url('warranty') ?>" class="btn btn-dark btn-sm bi bi-chevron-left px-3 mb-3">back</a>

			<strong>Upload CSV File</strong>
		</div>
		<div class="card-body">
		<div class="mt-2">
			
		</div>	
			<form action="<?= site_url('faultyimport') ?>" method="post" enctype="multipart/form-data">
				<div class="form-group mb-3">
					<div class="mb-3">
						<input type="file" name="file" class="form-control" id="file" accept=".csv">
					</div>					   
				</div>
				<div class="d-grid">
					<input type="submit" name="submit" value="Upload" class="btn btn-dark" />
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>