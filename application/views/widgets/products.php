<?php if(!empty($products)): ?>
    <div class="products-wrapper">
        <?php foreach($products as $p): ?>
            <article>
                <div class="block-image">
                    <a href="/product/<?=$p->id_product;?>/" title="<?=$p->product_title;?>">
                        <img src="/uploads/images/thumbnails/<?=thumb($p->product_image_front);?>" >
                    </a>
                </div>
                <div class="line"></div>
                <p class="product-title"><a href="/product/<?=$p->id_product;?>/"><?=$p->product_title;?></a></p>

                <?php if($p->product_status == 'action'): ?>
                    <div class="action"></div>
                <?php endif; ?>

                <div class="info">
                    <p><small><?=$p->product_price;?></small> <?=$this->lang->line('currency');?></p>
                    <!--
                <p class="info-order"><?=$this->lang->line('cart_count');?>: <input
                        type="text"
                        data-id="<?=$p->id_product;?>"
                        data-price="<?=$p->product_price;?>"
                        data-name="<?=$p->product_title;?>"
                        max="<?=$p->product_count;?>"
                        data-img="/uploads/images/thumbnails/<?=thumb($p->product_image_front);?>"
                        size="1"
                        pattern="^[0-9]{1,3}$"
                        max="<?=$p->product_count;?>"
                        value="1"
                        ></p>
                <button class="btn btn-info add" value="" name="add"><i class="add"></i><?=$this->lang->line('button_add_to_cart');?></button>
                -->
                </div>

            </article>
        <?php endforeach; ?>
    </div>
    <div class="separate"></div>
    <div id="pagination">
        <?=(!empty($pagination)) ? $pagination : '<br>';?>
    </div>
<?php endif; ?>