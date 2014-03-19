<?php if(!empty($posts)): ?>
    <div class="posts">
        <?php foreach($posts as $p): ?>
            <article>
                <h1><a href="/post/<?=$p->post_id;?>/"><?=$p->post_title;?></a></h1>
                <p><?=$p->post_description;?></p>
                <div class="post-info">
                    <ul>
                        <li class="date">
                            date: <span><?=$p->post_date_create;?></span>
                        </li>
                        <li class="author">
                            author: <span><?=$p->user_name;?></span>
                        </li>
                    </ul>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<div id="pagination">
    <?=@$pagination;?>
</div>
<?php endif; ?>