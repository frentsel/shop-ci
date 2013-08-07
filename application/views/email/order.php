<?php if(!empty($cart)): ?>
<h1><?=$this->lang->line('order_new_order');?></h1>
<hr>
<table id="checkout" class="checkout-form">
    <tbody>
    <tr>
        <th><?=$this->lang->line('cart_count');?></th>
        <th><?=$this->lang->line('cart_item');?></th>
        <th><?=$this->lang->line('cart_price');?></th>
        <th><?=$this->lang->line('cart_subtotal');?></th>
    </tr>
        <?php $total = 0; ?>
        <?php foreach($cart as $id => $i): ?>
        <?php $total += $i['total']; ?>
    <tr>
        <td><?=(int)$i['count'];?></td>
        <td><?=$i['name'];?></td>
        <td><?=round($i['price'],2);?></td>
        <td><?=round($i['total'],2);?></td>
    </tr>
        <?php endforeach; ?>
    <tr>
        <td colspan="3"></td>
        <td><?=$this->lang->line('cart_total');?>: <?=round($total,2);?></td>
    </tr>
    </tbody>
</table>
<?php else: ?>
<h2><?=$this->lang->line('cart_empty');?></h2>
<?php endif; ?>