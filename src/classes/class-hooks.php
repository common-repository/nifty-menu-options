<?php
/**
 * Handles the registration for all actions and filters for the plugin.
 *
 * (c) Dunhakdis <dunhakdis@useissuestabinstead.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP Version 5.4
 *
 * @category NiftyMenuOptions\Hooks
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @version  GIT:github.com/jasperjardin/nifty-menu-options
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */

namespace DSC\NiftyMenuOptions;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * The class that handles registration for all actions and filters for the plugin.
 *
 * @category NiftyMenuOptions\Hooks
 * @package  NiftyMenuOptions
 * @author   Dunhakdis Software Creatives <emailnotdisplayed@domain.tld>
 * @author   Jasper J. <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/nifty-menu-options
 * @since    1.0.0
 */
final class Hooks {

	/**
	 * The loader that's responsible for maintaining
	 * and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Hooks $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array $actions The actions registered with
	 *                        WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array $filters The filters registered with
	 *                        WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();
	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @param string       $hook          The name of the WordPress action
	 *                                    that is being registered.
	 * @param object       $component     A reference to the instance of
	 *                                    the object on which the action is defined.
	 * @param string       $callback      The name of the function definition
	 *                                    on the $component.
	 * @param int Optional $priority      The priority at which the function
	 *                                    should be fired.
	 * @param int Optional $accepted_args The number of arguments that should
	 *                                    be passed to the $callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_action(
		$hook,
		$component,
		$callback,
		$priority = 10,
		$accepted_args = 1
	) {
		$this->actions = $this->add(
			$this->actions,
			$hook,
			$component,
			$callback,
			$priority,
			$accepted_args
		);
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @param string       $hook          The name of the WordPress filter
	 *                                    that is being registered.
	 * @param object       $component     A reference to the instance of the
	 *                                    object on which the filter is defined.
	 * @param string       $callback      The name of the function definition
	 *                                    on the $component.
	 * @param int Optional $priority      The priority at which the function
	 *                                    should be fired.
	 * @param int Optional $accepted_args The number of arguments that should
	 *                                    be passed to the $callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_filter(
		$hook,
		$component,
		$callback,
		$priority = 10,
		$accepted_args = 1
	) {
		$this->filters = $this->add(
			$this->filters,
			$hook,
			$component,
			$callback,
			$priority,
			$accepted_args
		);
	}

	/**
	 * A utility function that is used to register the
	 * actions and hooks into WordPress via single
	 * collection.
	 *
	 * @param array        $hooks         Collection of hooks
	 *                                    (actions or
	 *                                    filters) to
	 *                                    register.
	 * @param string       $hook          Name of the WordPress
	 *                                    filter to register.
	 * @param object       $component     The instance of the object
	 *                                    where the filter is
	 *                                    defined.
	 * @param string       $callback      Name of the function defined
	 *                                    on the $component.
	 * @param int Optional $priority      Priority of function
	 *                                    should be fired.
	 * @param int Optional $accepted_args Number of arguments
	 *                                    passed to the $callback.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return array $hooks
	 * Collection of actions and filters registered in WordPress
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return $hooks;
	}
	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function runner() {
		foreach ( $this->filters as $hook ) {
			add_filter(
				$hook['hook'],
				array(
					$hook['component'],
					$hook['callback'],
				),
				$hook['priority'],
				$hook['accepted_args']
			);
		}
		foreach ( $this->actions as $hook ) {
			add_action(
				$hook['hook'],
				array(
					$hook['component'],
					$hook['callback'],
				),
				$hook['priority'],
				$hook['accepted_args']
			);
		}
	}
}