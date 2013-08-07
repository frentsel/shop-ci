<h2><?=$post->post_title;?></h2>
<div class="line"></div>
<div class="page">
    <?php if(!empty($post)): ?>
        <p><?=$post->post_text;?></p>
        <?php $this->load->view('widgets/comments',array('key'=>$post->post_comment_status)); ?>
    <?php endif; ?>
</div>