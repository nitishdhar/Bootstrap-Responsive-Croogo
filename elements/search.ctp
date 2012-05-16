<?php
$b = $block['Block'];
$class = 'block block-' . $b['alias'];
if ($block['Block']['class'] != null) {
    $class .= ' ' . $b['class'];
}
?>
<div id="block-<?php echo $b['id']; ?>" class="<?php echo $class; ?> text-center">
    <?php if ($b['show_title'] == 1) { ?>
        <h3><?php echo $b['title']; ?></h3>
    <?php } ?>
    <div class="block-body">
        <form class="well form-search" id="searchform" method="post" action="javascript: document.location.href=''+Croogo.basePath+'search/q:'+encodeURI($('#searchform #q').val());">
            <div class="input-append input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <?php
                $qValue = null;
                if (isset($this->params['named']['q'])) {
                    $qValue = $this->params['named']['q'];
                }
                echo $this->Form->input('q', array(
                    'label' => false,
                    'name' => 'q',
                    'value' => $qValue,
                    'class' => '',
                    'div' => false,
                ));
                ?>

                <?php
                echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-info'));
                ?>
            </div>
        </form>
    </div>
</div>
