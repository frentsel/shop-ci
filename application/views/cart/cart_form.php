<?php if(!empty($cart)): ?>
    <form action="/cart/checkout/" method="post">
        <table id="cart">
            <tbody>
            <tr>
                <th><?=$this->lang->line('cart_image');?></th>
                <th><?=$this->lang->line('cart_count');?></th>
                <th><?=$this->lang->line('cart_item');?></th>
                <th><?=$this->lang->line('cart_price');?></th>
                <th><?=$this->lang->line('cart_total');?></th>
                <th><?=$this->lang->line('cart_action');?></th>
            </tr>
                <?php foreach($cart as $id => $i): ?>
                <tr>
                    <td>
                        <a href="/product/<?=$id;?>">
                            <img class="cart-img" src="<?=$i['img'];?>">
                        </a>
                    </td>
                    <td>
                        <input type="text"
                               id="<?=$id;?>"
                               name="item[<?=$id;?>][count]"
                               size="1"
                               pattern="^[0-9]{1,3}$"
                               value="<?=(int)$i['count'];?>">
                        <input type="hidden" name="item[<?=$id;?>][total]" value="<?=round($i['total'],2);?>">
                        <input type="hidden" name="item[<?=$id;?>][price]" value="<?=round($i['price'],2);?>">
                    </td>
                    <td><?=$i['name'];?></td>
                    <td><?=round($i['price'],2);?></td>
                    <td><?=round($i['total'],2);?></td>
                    <td>
                        <button name="remove" id="<?=$id;?>" class="btn btn-remove">
                            <i class="remove"></i>
                            <?=$this->lang->line('button_remove');?>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <button type="submit" name="checkout" class="btn btn-info">
            <i class="ok"></i>
            <?=$this->lang->line('button_checkout');?>
        </button>
        <button name="clear" class="btn btn-clear">
            <i class="trash"></i>
            <?=$this->lang->line('button_clear');?>
        </button>
    </form>
<?php else: ?>
    <h2><?=$this->lang->line('cart_empty');?></h2>
<?php endif; ?>