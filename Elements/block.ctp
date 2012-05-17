<?php
	$this->set(compact('block'));
	$b = $block['Block'];
	$class = 'block block-' . $b['alias'];
	if ($block['Block']['class'] != null) {
		$class .= ' ' . $b['class'];
	}
?>
<div id="block-<?php echo $b['id']; ?>" class="<?php echo $class; ?>">
<?php if ($b['show_title'] == 1) { ?>
    <ul class="breadcrumb block-title">
        <li><h4><?php echo $b['title']; ?></h4></li>
    </ul>
<?php } ?>
	<div class="block-body">
            <p>
<?php echo $this->Layout->filter($b['body']); ?>
            </p>
	</div>
</div>