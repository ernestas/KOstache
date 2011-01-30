<?php defined('SYSPATH') or die('No direct script access.');

class View_Kohana_Layout extends Kostache
{
	protected $_layout = 'layout';

	public $render_layout = TRUE;

	/**
	 * @var string template title
	 */
	public $title = 'Brought to you by KOstache!';

	/**
	 * Renders the body template into the layout
	 */
	public function after($rendered_string)
	{
		if ($this->_layout === NULL OR ! $this->render_layout)
			return $rendered_string;

		$this->body = $rendered_string;
		$layout = new KOstache($this->_layout, $this);
		return $layout->render();
	}

} // End View_Layout
