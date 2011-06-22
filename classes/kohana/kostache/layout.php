<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mustache templates for Kohana.
 *
 * @package    Kostache
 * @category   Base
 * @author     Jeremy Bush <jeremy.bush@kohanaframework.org>
 * @author     Woody Gilk <woody.gilk@kohanaframework.org>
 * @copyright  (c) 2010-2011 Jeremy Bush
 * @copyright  (c) 2011 Woody Gilk
 * @license    MIT
 */
abstract class Kohana_Kostache_Layout extends Kostache {

	/**
	 * @var  string  partial name for content
	 */
	const CONTENT_PARTIAL = 'content';

	/**
	 * @var  boolean  render template in layout?
	 */
	public $render_layout = TRUE;

	/**
	 * @var  string  layout path
	 */
	protected static $_layout = 'layout';

	/**
	 * Adds template or child layout, if passed as parameter, as content partial.
	 * Returns this layout or renders parent layout with this layout as child layout
	 * if parent layout is defined.
	 *
	 * @param   string  child layout
	 * @return  string
	 */
	public function render($child_layout = NULL)
	{
		if ( ! $this->render_layout)
		{
			return parent::render();
		}

		$partials = $this->_partials;

		// add current template or child_layout as content partial
		$partials[Kostache_Layout::CONTENT_PARTIAL] = (NULL == $child_layout) ? $this->_template : $child_layout;

		// late static binding of a $_layout template
		$template = $this->_load(static::$_layout);

		if ( ! isset(static::$_parent_layout))
		{
			return $this->_stash($template, $this, $partials)->render();
		}
		else
		{
			$this_layout = $this->_stash($template, $this, $partials)->render();

			// late static binding of parent layout class
			$parent_layout_class = new static::$_parent_layout;

			// pass this layout as child_layout to the parent_layout
			return $parent_layout_class->render($this_layout);
		}
	}
}
