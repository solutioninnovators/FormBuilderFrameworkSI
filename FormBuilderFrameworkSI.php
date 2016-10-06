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
		$config->scripts->append($config->urls->FormBuilder . 'form-builder.js');
		//$config->styles->append($config->urls->templates . 'ui/Layout/Layout.css'); // Load the site's main Layout.css, which includes the base styling for form elements
		$config->styles->append($config->urls->templates . 'FormBuilder/frameworks/FormBuilderFrameworkSI.css'); // FormBuilder specific css should go in here

		// Modify markup as needed

		$markup = array(
			'item_error' => "<p class='fieldNotice fieldNotice_error'>{out}</p>",
			'success' => "<p class='formNotice formNotice_success'><i class=\"fa fa-check-circle\"></i> {out}</p>",
			'error' => "<p class='formNotice formNotice_error'><i class=\"fa fa-times-circle\"></i> {out}</p>",
		);

		InputfieldWrapper::setMarkup($markup);


		$this->form->theme = '';

	}

	/**
	 * Add custom classes on <input> tage of Inputfields (not possible using InputfieldWrapper::setClasses)
	 */
	public function hookRenderReady($event) {
		$inputfields = $event->arguments(0);
		foreach($inputfields->getAll() as $in) {
			if($in instanceof InputfieldText || $in instanceof InputfieldInteger) {
				$in->addClass("txtBox");
			}
			if($in instanceof InputfieldTextarea) {
				$in->addClass("txtBox");
				$in->addClass("txtBox_multi");
			}
			elseif($in instanceof InputfieldSubmit) {
				$in->addClass("btn");
			}
			elseif($in instanceof InputfieldSelect) {
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