<div id="sidebar">
    <span><?=$this->lang->line('sidebar_title');?></span>
    <div class="line"></div>
    <ul>
        <?php if(!empty($categories)): ?>
            <?php foreach($categories as $c): ?>
                <li><a href="/category/<?=$c->category_id;?>/<?=$c->category_url;?>/0/"><?=$c->category_title;?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>