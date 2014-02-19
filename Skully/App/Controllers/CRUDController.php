<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 5/7/13
 * Time: 10:40 AM
 */
namespace Skully\App\Controllers;


/**
 * Class CRUDController
 * @package Skully\App\Controllers
 * Description: Base controller for controllers that have create (add), read (index), update (edit), and destroy (delete).
 *              Feel free to override any methods here. Especially public ones are meant to be overridden depending on controller needs.
 */
class CRUDController extends BaseController
{
	// These variables MUST be overridden in inherited class!
	protected $instanceName = 'instance'; // Instance name used in parameter prefix i.e. 'instance' of $this->params['instance']['attributeName']

	// For redirect when success / error happens
	protected $indexPath = 'instances/index';
	protected $addPath = 'instances/add';
	protected $editPath = 'instances/edit';

	// If you don't want to create deleteForm.tpl. define this instead.
	// Sample value: instances/destroy
	protected $destroyPath = null;

	public $columns = array('column', 'names');
	public $thAttributes = array(); // Class sort_asc or sort_dsc can be used to set default sorting.
	public $columnDefs = ''; // Use this to handle columns' behaviours, doc: http://www.datatables.net/usage/columns

	// Override this with model linked with this controller.
	protected function model() {
		return \Skully\Core\Model;
	}

	// Method to be overridden when you need to add additional attributes for saving purpose in create, update, destroy,
	// and to be displayed in add, edit, delete, create, update, destroy
	// e.g. use to setup protected attributes on create and update.
	protected function setInstanceAttributes($instance) {
		if (!empty($this->params[$this->instanceName])) {
			$instance->setAttributes($this->params[$this->instanceName]);
		}
		return $instance;
	}

	// Override this method when you need to display additional attributes in add, edit, delete, create, update, and destroy pages.
	// NOTE: Attributes set up here will NOT make it to save() method (i.e. use setInstanceAttributes() method for that).
	protected function setupInstanceAssigns($instance) {
		if (empty($instance)) {
			$this->redirect('admin/home/notFound');
		}

		$this->smarty()->assign(array(
			$this->instanceName => $instance->attributes,
			'instanceName' => $this->instanceName
		));
		return $instance;
	}


	// Data used in index listing
	protected function listData() {
		return array();
	}

	// Method to be overridden when you need to set how to find an instance on new, edit and delete (post = false) or create, update and destroy (post = true).
	// For example if you wish to allow only certain group of users access to the model.
	protected function findInstance($post = false) {
		$id = $this->decideIdSource($post);

		$instance = null;
		if (!empty($id)) {
			$instance = $this->model()->find(array('where' => "id = '".$id."'"))->first();
		}
		else {
			$instance = $this->model()->new();
		}
		return $instance;
	}
	// Override this in inherited class to assign additional variables.
	protected function setupAdditionalAssigns($instance) {
	}

	protected function decideIdSource($post) {
		$id = '';
		if ($post) {
			if (!empty($this->params[$this->instanceName]) && !empty($this->params[$this->instanceName]['id'])) {
				$id = $this->params[$this->instanceName]['id'];
			}
		}
		else {
			if (!empty($this->params['id'])) {
				$id = $this->params['id'];
			}
		}
		return $id;
	}


	protected function beforeAction($action = '') {
		parent::beforeAction();
		if ($action == 'create') {
			// For when user go to create page directly
			if (empty($this->params[$this->instanceName])) {
				$this->redirect($this->addPath);
			}
		}
		elseif ($action == 'update') {
			// For when user go to edit page directly
			if (empty($this->params[$this->instanceName]) && !empty($this->params['id'])) {
				$this->redirect($this->editPath, array('id' => $this->params['id']));
			}
		}
	}

	public function index() {
		if ($this->app->isAjax()) {
			echo json_encode(array('aaData' => $this->listData()));
		}
		else {
			$this->render('index.tpl', array(
				'columns' => $this->columns,
				'thAttributes' => $this->thAttributes,
				'columnDefs' => $this->columnDefs
			));
		}
	}

	public function add() {
		$this->breadcrumbs[] = array('url' => url($this->indexPath), 'name' => ucfirst($this->instanceName) . ' List');
		$this->breadcrumbs[] = array('url' => '', 'name' => 'New '.$this->instanceName);
		$instance = $this->findInstance(false);
		$instance = $this->setInstanceAttributes($instance);
		$this->setupAssigns($instance);
		$this->render('add.tpl');
	}
	public function edit() {
		$this->breadcrumbs[] = array('url' => url($this->indexPath), 'name' => ucfirst($this->instanceName) . ' List');
		$this->breadcrumbs[] = array('url' => '', 'name' => 'Edit '.$this->instanceName);
		$instance = $this->findInstance(false);
		$instance = $this->setInstanceAttributes($instance);
		$this->setupAssigns($instance);
		$this->render('edit.tpl');
	}

	public function delete() {
		$instance = $this->findInstance(false);
		$instance = $this->setInstanceAttributes($instance);
		$this->setupAssigns($instance);
		if ($this->destroyPath != null) {
			$this->smarty()->assign(array('destroyPath' => $this->destroyPath));
		}
		$this->render('delete.tpl');
	}

	// Most of the times you will need to override this method because some variables will be protected.
	// In that scenario, if behaviours in instance creation is similar with update, override $this->setInstanceAttributes() instead.
	// Only override this and update() method when instance creations have different behaviours.
	public function create() {
		$this->breadcrumbs[] = array('url' => url($this->indexPath), 'name' => ucfirst($this->instanceName) . ' List');
		$this->breadcrumbs[] = array('url' => '', 'name' => 'New '.$this->instanceName);

		if (!empty($this->params[$this->instanceName]) && !empty($this->params[$this->instanceName]['id'])) {
			// For upload images, where image upload will return id to form.
			$instance = $this->findInstance(true);
		}
		else {
			$instance = $this->findInstance(false);
		}

		$instance = $this->setInstanceAttributes($instance);
		if ($instance->save()) {
			$instance = $this->setupAssigns($instance);
			$this->successAction(lang('created'), url($this->indexPath), 'create', $instance);
		}
		else {
			$instance = $this->setupAssigns($instance);
			$this->displayError($instance, $this->instanceName, 'add.tpl');
		}
	}

	// See comments in create() method.
	public function update() {
		$this->breadcrumbs[] = array('url' => url($this->indexPath), 'name' => ucfirst($this->instanceName) . ' List');
		$this->breadcrumbs[] = array('url' => '', 'name' => 'Edit '.$this->instanceName);
		$instance = $this->findInstance(true);
		$instance = $this->setInstanceAttributes($instance);
		if ($instance->save()) {
			$instance = $this->setupAssigns($instance);
			$this->successAction(lang('updated'), url($this->indexPath), 'update', $instance);
		}
		else {
			$instance = $this->setupAssigns($instance);
			$this->displayError($instance, $this->instanceName, 'edit.tpl');
		}
	}

	public function destroy() {
		$instance = $this->findInstance(true);
		$instance = $this->setInstanceAttributes($instance);
		if ($instance->destroy()) {
			$this->successAction(lang('deleted'), url($this->indexPath), 'destroy', $instance);
		}
		else {
			$instance = $this->setupAssigns($instance);
			$this->displayError($instance, $this->instanceName, 'delete.tpl');
		}
	}

	// Inheritable method to setup smarty assigns before rendering CRUD pages.
	protected function setupAssigns($instance) {
		$this->setupInstanceAssigns($instance);
		$this->setupAdditionalAssigns($instance);
		return $instance;
	}

	// Display errors with model's instance, instance name, and template name.
	protected function displayError($modelInstance, $instanceName, $template) {
		if ($this->app->isAjax()) {
			echo json_encode(array(
				'error' => $modelInstance->errorMessage(),
				'errorAttributes' => $modelInstance->errors,
				'instance' => $instanceName
			));
		}
		else {
			$this->smarty()->assign(array(
				'error' => $modelInstance->errorMessage(),
				'errorAttributes' => $modelInstance->errors,
				'instance' => $instanceName
			));

			$this->setupAssigns($modelInstance);
			$this->render($template);
		}
		return true;
	}
}
