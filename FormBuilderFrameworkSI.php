<?php

/**
 * Custom Solution Innvoators FormBuilder framework initialization file
 *
 */

class FormBuilderFrameworkSI extends FormBuilderFramework {

	public function load() {
		$this->addHookBefore('FormBuilderProcessor::renderReady', $this, 'hookRenderReady');

		$config = $this->wire('config');
		$config->inputfieldColumnWidthSpacing = 0; // percent spacing between columns

		$config->styles->append($config->urls->FormBuilder . 'FormBuilder.css');
		$config->styles->append($config->urls->templates . 'FormBuilder/frameworks/FormBuilderFrameworkSI.css'); // FormBuilder specific css tweaks should go in here
		$config->styles->append($config->urls->templates . 'library/si-reset.css'); // Load the SI Reset
		$config->styles->append($config->urls->templates . 'ui/Layout/Layout.css'); // Load the site's main Layout.css, which includes the base styling for form elements
		//$config->styles->append("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,700,700i"); // Make sure to load your web fonts

		$config->scripts->append($config->urls->FormBuilder . 'form-builder.js');

		// Modify markup as needed

		$markup = array(
			'item_error' => "<p class='field-error'>{out}</p>",
			'success' => "<p class='notice notice_success'><i class='fal fa-check'></i> {out}</p>",
			'error' => "<p class='notice notice_error'><i class='fal fa-times'></i> {out}</p>",
			'item_label' => "<label class='InputfieldHeader field-label' for='{for}'>{out}</label>",
			'item_notes' => "<p class='field-notes'><small>{out}</small></p>",
			'item_description' => "<p class='field-description description'>{out}</p>",
		);

		$classes = array(
			'item' => 'field Inputfield Inputfield_{name} {class}',
			'item_error' => 'field_error InputfieldStateError',
		);

		InputfieldWrapper::setMarkup($markup);
		InputfieldWrapper::setClasses($classes);


		$this->form->theme = '';

	}

	/**
	 * Add our custom classes on <input> tags of Inputfields (not possible using InputfieldWrapper::setClasses)
	 */
	public function hookRenderReady($event) {
		$inputfields = $event->arguments(0);
		foreach($inputfields->getAll() as $in) {
			if($in instanceof InputfieldText || $in instanceof InputfieldInteger || $in instanceof InputfieldDatetime) {
				$in->addClass("txtBox");
			}
			elseif($in instanceof InputfieldTextarea) {
				$in->addClass("txtBox");
				$in->addClass("txtBox_multi");
			}
			elseif($in instanceof InputfieldSubmit) {
				$in->addClass("btn");
			}
			elseif(get_class($in) === 'ProcessWire\InputfieldSelect' || get_class($in) === 'ProcessWire\InputfieldPage') { // Using get_class to make sure we don't apply these classes to subclasses of InputfieldSelect
				$in->addClass("txtBox");
				$in->addClass("txtBox_select");
			}
		}
	}

	/**
	 * Return Inputfields for configuration of framework
	 *
	 * @return InputfieldWrapper
	 *
	 */
	public function getConfigInputfields() {
		$inputfields = parent::getConfigInputfields();

		return $inputfields;
	}

	public function getFrameworkURL() {
		return dirname(__FILE__);
	}

}