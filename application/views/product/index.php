<?php if(!empty($product)): ?>

    <h2><?=$product->product_title;?></h2>

    <div class="product">
        <article class="product-item">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div class="padding">
                                <ul class="gallery">
                                    <li class="first">
                                        <a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/images/<?=$product->product_image_front; ?>" title="<?=$product->product_title; ?>">
                                            <img alt="" src="/uploads/images/<?=$product->product_image_front;?>">
                                        </a>
                                    </li>
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <?php $img = 'product_image_'.$i; ?>
                                        <?php if(!empty($product->$img)): ?>
                                            <li class="thumb">
                                                <a class="fancybox-thumb" rel="fancybox-thumb" href="/uploads/images/<?=$product->$img;?>" title="<?=$product->product_title . ' photo ' . $i;?>">
                                                    <img alt="" src="/uploads/images/thumbnails_gallery/<?=thumb($product->$img);?>">
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </ul>
                                <?php if($product->product_status == 'action'): ?>
                                    <div class="p-action"></div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="description">
                            <p><?=$product->product_description;?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="line"></div>
                            <div class="padding">
                                <p><?=$this->lang->line('cart_price');?>: <small><?=$product->product_price;?></small> <?=$this->lang->line('currency');?></p>
                                <p class="info-order"><?=$this->lang->line('cart_count');?>: <input
                                        type="text"
                                        data-id="<?=$product->id_product;?>"
                                        data-price="<?=$product->product_price;?>"
                                        data-name="<?=$product->product_title;?>"
                                        max="<?=$product->product_count;?>"
                                        data-img="/uploads/images/thumbnails/<?=thumb($product->product_image_front);?>"
                                        size="3"
                                        pattern="^[0-9]{1,3}$"
                                        value="1"
                                        ></p>
                                <button class="btn btn-info add">
                                    <i class="add"></i>
                                    <?=$this->lang->line('button_add_to_cart');?>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </article>
    </div>
    <?php $this->load->view('widgets/comments',array('key'=>$product->product_comment_status)); ?>

<?php else: ?>

    <h2><?=$this->lang->line('product_not_found');?></h2>
    <div class="line"></div>

<?php endif; ?>