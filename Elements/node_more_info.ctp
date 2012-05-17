<div class="node-more-info">
    <em>
<?php
	$type = $types_for_layout[$this->Layout->node('type')];

	if (is_array($this->Layout->node['Taxonomy']) && count($this->Layout->node['Taxonomy']) > 0) {
		$nodeTerms = Set::combine($this->Layout->node, 'Taxonomy.{n}.Term.slug', 'Taxonomy.{n}.Term.title');
		$nodeTermLinks = array();
		if (count($nodeTerms) > 0) {
			foreach ($nodeTerms AS $termSlug => $termTitle) {
				$nodeTermLinks[] = $this->Html->link($termTitle, array(
					'controller' => 'nodes',
					'action' => 'term',
					'type' => $this->Layout->node('type'),
					'slug' => $termSlug,
				));
			}
			echo __('Posted in') . ' <i class="icon-book"></i> ' . implode(', ', $nodeTermLinks);
		}
	}

	if ($this->params['action'] != 'view' && $type['Type']['comment_status']) {
		if (isset($nodeTerms) && count($nodeTerms) > 0) {
			echo ' | <i class="icon-comment"></i> ';
		}

		$commentCount = '';
		if ($this->Layout->node('comment_count') == 0) {
			$commentCount = __('Leave a comment');
		} elseif ($this->Layout->node('comment_count') == 1) {
			$commentCount = $this->Layout->node('comment_count') . ' ' . __('Comment');
		} else {
			$commentCount = $this->Layout->node('comment_count') . ' ' . __('Comments');
		}
		echo $this->Html->link($commentCount, $this->Html->url($this->Layout->node('url'), true) . '#comments');
	}
?>
    </em>
</div>