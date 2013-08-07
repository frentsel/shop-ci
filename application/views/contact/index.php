<h2><?=$this->lang->line('contact');?></h2>
<div class="line"></div>
<div class="page">
    <form action="/contact/send/" method="post" autocomplete="on" class="contact">
        <p><input type="text" name="name" required="required" placeholder="<?=$this->lang->line('contact_name');?> *"></p>
        <p><input type="email" name="email" placeholder="<?=$this->lang->line('contact_email');?> *" required="required"></p>
        <p><textarea placeholder="<?=$this->lang->line('contact_message');?> *" name="message" required="required"></textarea></p>
        <input type="submit" value="<?=$this->lang->line('button_send_email');?>" class="btn">
    </form>
</div>