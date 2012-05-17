<div class="comment-form">
	<h3><?php echo __('Add New Comment'); ?></h3>
	<?php
		$type = $types_for_layout[$node['Node']['type']];

		if ($this->params['controller'] == 'comments') {
			$nodeLink = $this->Html->link(__('Go back to original post') . ': ' . $node['Node']['title'], $node['Node']['url']);
			echo $this->Html->tag('p', $nodeLink, array('class' => 'back'));
		}

		$formUrl = array(
			'controller' => 'comments',
			'action' => 'add',
			$node['Node']['id'],
		);
		if (isset($parentId) && $parentId != null) {
			$formUrl[] = $parentId;
		}

		echo $this->Form->create('Comment', array('url' => $formUrl, 'class' => 'well'));
			if ($this->Session->check('Auth.User.id')) {
				echo $this->Form->input('Comment.name', array(
					'label' => __('Name'),
					'value' => $this->Session->read('Auth.User.name'),
					'readonly' => 'readonly',
				));
				echo $this->Form->input('Comment.email', array(
					'label' => __('Email'),
					'value' => $this->Session->read('Auth.User.email'),
					'readonly' => 'readonly',
				));
				echo $this->Form->input('Comment.website', array(
					'label' => __('Website'),
					'value' => $this->Session->read('Auth.User.website'),
					'readonly' => 'readonly',
                                        
				));
				echo $this->Form->input('Comment.body', array('label' => false, 'style' => 'width:95%;'));
			} else {
				echo $this->Form->input('Comment.name', array('label' => __('Name')));
				echo $this->Form->input('Comment.email', array('label' => __('Email')));
				echo $this->Form->input('Comment.website', array('label' => __('Website')));
				echo $this->Form->input('Comment.body', array('label' => false, 'style' => 'width:95%;'));
			}

			if ($type['Type']['comment_captcha']) {
				echo $this->Recaptcha->display_form();
			}
		 echo $this->Form->submit('Post Comment', array('class' => 'btn btn-success'));
                echo $this->Form->end();
	?>
</div>