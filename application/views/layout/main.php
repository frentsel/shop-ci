<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title><?=$this->title;?></title>
    <!--
    <description><?=$this->description;?></description>
    -->

    <link media="screen" href="/additions/fancyBox/source/jquery.fancybox.css?v=2.1.4" type="text/css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" media="screen" href="/css/style.css">
    <link type="text/css" rel="stylesheet" media="screen" href="/css/main.css">

    <?php if($this->uri->segment(1) == 'product'): ?>
        <link type="text/css" rel="stylesheet" media="screen" href="/additions/fancyBox/source/helpers/jquery.fancybox-buttons.css">
        <link type="text/css" rel="stylesheet" media="screen" href="/additions/fancyBox/source/helpers/jquery.fancybox-thumbs.css">
    <?php endif; ?>

</head>
<body>

<div class="container container_12" id="main">
    <header>
        <h1 class="grid_9"><a href="/"><?=$this->lang->line('site_name');?></a></h1>
        <div class="grid_2 cart">
            <p><?=$this->lang->line('cart_item');?>: <span class="item"><?=$cart['item'];?></span></p>
            <p><?=$this->lang->line('cart_total');?>: <span class="total"><?=round($cart['total'],2);?></span></p>
        </div>
        <div class="grid_1">
            <a class="various fancybox.ajax" href="/cart"><img src="/img/cart.png"></a>
        </div>
        <div class="clear">&nbsp;</div>
        <nav class="">
            <ul>
                <li><a href="/"><?=$this->lang->line('header_menu_home');?></a></li>
                <li><a href="/blog/0/"><?=$this->lang->line('header_menu_blog');?></a></li>
                <li><a href="/news/0/"><?=$this->lang->line('header_menu_news');?></a></li>
                <li><a href="/contact/"><?=$this->lang->line('header_menu_contact');?></a></li>
                <?php if(!empty($data['pages'])): ?>
                    <?php foreach($data['pages'] as $p): ?>
                        <li><a href="/post/<?=$p->post_id;?>/<?=$p->post_url;?>/"><?=$p->post_title;?></a></li>
                    <?php endforeach; ?>
                <?php endif;?>
            </ul>
        </nav>
    </header>
    <div id="content">
        <div class="grid_3">
            <?php $this->load->view('blocks/sidebar',$data); ?>
        </div>
        <div class="grid_9">
            <?php $this->load->view($data['view'],$data); ?>
        </div>
        <div class="clear">&nbsp;</div>
    </div>
    <div class="line"></div>
    <footer>
        <div class="grid_12">
            <div class="padding">
                <p><?=$this->lang->line('site_name');?> 2013 &copy;</p>
            </div>
        </div>
        <div class="clear">&nbsp;</div>
    </footer>
</div>
<script src="/additions/fancyBox/lib/jquery-1.9.0.min.js"></script>
<script src="/additions/fancyBox/source/jquery.fancybox.js?v=2.1.4" type="text/javascript"></script>

<?php if($this->uri->segment(1) == 'product'): ?>
<script src="/additions/fancyBox/source/helpers/jquery.fancybox-buttons.js" type="text/javascript"></script>
<script src="/additions/fancyBox/source/helpers/jquery.fancybox-thumbs.js" type="text/javascript"></script>
<?php endif; ?>

<script src="/js/main.js" type="text/javascript"></script>
</body>
</html>