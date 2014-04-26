<?php $this->display("header.html"); ?>
<?php if(isset($this->contentTemplate)):
	$this->display($this->contentTemplate);
elseif(isset($this->content)):
	print $this->content;
endif; ?>
<?php $this->display("footer.html"); ?>