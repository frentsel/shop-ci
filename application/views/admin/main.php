<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <?php foreach ($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?=$file; ?>">
    <?php endforeach; ?>

    <link type="text/css" rel="stylesheet" href="/css/admin.css">

    <?php foreach ($js_files as $file): ?>
        <script src="<?=$file; ?>"></script>
    <?php endforeach; ?>

</head>
<body>
    <div class="container">
        <header>
            <nav>
                <ul>
                    <li><a href='/'><?=$this->lang->line('admin_site');?></a></li>
                    <li><a href='/admin/main/orders/'><?=$this->lang->line('admin_orders');?></a></li>
                    <li><a href='/admin/main/categories/'><?=$this->lang->line('admin_categories');?></a></li>
                    <li><a href='/admin/main/news/'><?=$this->lang->line('admin_news');?></a></li>
                    <li><a href='/admin/main/blog'><?=$this->lang->line('admin_blog');?></a></li>
                    <li><a href='/admin/products/'><?=$this->lang->line('admin_products');?></a></li>
                    <li><a href='/admin/main/pages/'><?=$this->lang->line('admin_pages');?></a></li>
                    <li><a href='/admin/main/users/'><?=$this->lang->line('admin_users');?></a></li>
                    <li><a href='/admin/main/settings/'><?=$this->lang->line('admin_settings');?></a></li>
                    <li><a href='/admin/login/logout/'><?=$this->lang->line('admin_logout');?></a></li>
                </ul>
            </nav>
        </header>
        <br>
        <div>
            <?=$output; ?>
        </div>
    </div>
</body>
</html>
