<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?=$file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?=$file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
</style>
</head>
<body>
	<div>
		<a href='<?=site_url('admin/examples/customers_management')?>'>Customers</a> |
		<a href='<?=site_url('admin/examples/orders_management')?>'>Orders</a> |
		<a href='<?=site_url('admin/examples/products_management')?>'>Products</a> |
		<a href='<?=site_url('admin/examples/offices_management')?>'>Offices</a> |
		<a href='<?=site_url('admin/examples/employees_management')?>'>Employees</a> |
		<a href='<?=site_url('admin/examples/film_management')?>'>Films</a>
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?=$output; ?>
    </div>
</body>
</html>
