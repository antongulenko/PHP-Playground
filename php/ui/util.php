<?
require_once 'php/util.php';

/* 
 * ===================================================================
 * Include Scripts
 * ===================================================================
 */

function includeJs($scriptNameS) {
	if (!is_array($scriptNameS)) $scriptNameS = array($scriptNameS);
	foreach ($scriptNameS as $scriptName) {
		?><script type="text/javascript" language="javascript" src="<? echo $scriptName ?>"></script><?
	}
}

function includeCss($cssScriptS) {
	if (!is_array($cssScriptS)) $cssScriptS = array($cssScriptS);
	foreach ($cssScriptS as $cssScript) {
		?><link href="<? echo $cssScript ?>" rel="stylesheet" type="text/css"><?
	}
}

/* 
 * ===================================================================
 * Special functions
 * ===================================================================
 */

function menu_element($text, $link, $isSelected) { 
	?><a <? 
	if ($isSelected) { ?>class="selected" <? } ?>
	href="<? echo session_link($link) ?>"><? echo $text ?></a><?
}

/* 
 * ===================================================================
 * Rendering DOM-elements: Simple & Forms
 * ===================================================================
 */

function _h1($content) {
	?><h1><? executeDomContent($content) ?></h1><?
}

function _h2($content) {
	?><h2><? executeDomContent($content) ?></h2><?
}

function _h3($content) {
	?><h3><? executeDomContent($content) ?></h3><?
}

function _br() {
	?><br/><?
}

function _span($content) {
	?><span><? executeDomContent($content) ?></span><?
}

function _link($caption, $target, $classes = null) {
	?><a <? printClasses($classes) ?> href="<? echo $target ?>"><? echo $caption ?></a><?
}

function _backLink($caption, $classes = null) {
	?><a <? printClasses($classes) ?> onclick="history.go(-1)"><? echo $caption ?></a><?
}

function _navigationLink($caption, $target, $classes = array()) {
	array_push($classes, 'navigation-link');
	_link($caption, $target, $classes);
}

// $targetQuery will be a hidden form-query-key, so that the same page can
// contain the form and work the form result.
function _form($target, $targetQuery, $content, $classes = null) {
	?><form <? printClasses($classes) ?> method="POST" action="<? echo $target ?>"><?
	executeDomContent($content);
	if (isset($targetQuery)) {
		_input('hidden', null, $targetQuery);
	}
	?></form><?
}

function _simpleForm($target, $targetQuery, $content) {
	_form($target, $targetQuery, $content, array('simple-form'));
}

function _input($type, $label, $key) {
	static $firstElement = true;
	static $tabIndex = 1;
	if (isset($label)) { ?>
		<label for="<? echo $key ?>"><? executeDomContent($label) ?></label>
	<? } ?>
	<input 
	<? if ($firstElement) { $firstElement = false; echo 'autofocus="autofocus"'; } ?>
	REQUIRED tabindex="<? echo $tabIndex++ ?>" type="<? echo $type ?>" name="<? echo $key ?>" />
	<?
}

function _textInput($label, $key) {
	_input('text', $label, $key);
}

function _passwordInput($label, $key) {
	_input('password', $label, $key);
}

function _submit($content) {
	static $button_count = 0;
	$id = 'submit_button_'. $button_count;
	_centered(function() use($content, $id) {
		_br();
		?>
		<!-- label for="<? echo $id ?>"></label -->
		<input id="<? echo $id ?>" name="<? echo $id ?>" class="navigation-link"
		type="submit" value="<? executeDomContent($content) ?>" />
		<?
	});
}

function _centered($content) {
	?><div class="centered"><?
	executeDomContent($content);
	?></div><?
}

function _checkbox($name, $defaultChecked, $changeable) {
	?><input type="checkbox" name="<? echo $name ?>"
		<? if ($defaultChecked) { ?>CHECKED <? } ?>
		<? if (!$changeable) { ?>READONLY <? } ?>
	/><?
}

/* 
 * ===================================================================
 * Rendering DOM-elements: Table
 * ===================================================================
 */

function _table($headers, $content) {
	?>
	<table id="users_table" cellpadding="0" cellspacing="0" border="0" class="display">
		<thead><? _headerRow($headers) ?></thead>
		<? executeDomContent($content); ?>
		<tfoot><? _headerRow($headers) ?></tfoot>
	</table>
	<?
}

function _rows($allElements, $renderer) {
	foreach($allElements as $element) {
		_row(function() use ($element, $renderer) { $renderer($element); });
	}
}

function _row($content) {
	?><tr><? executeDomContent($content) ?></tr><?
}

function _headerRow($elements) {
	_row(function() use ($elements) {
		foreach ($elements as $element) {
			_namedCell('th', $element);
		}
	});
}

function _namedCell($cellType, $content, $visible = true) {
	if ($visible) {
		?><<? echo $cellType ?>><? executeDomContent($content) ?></<? echo $cellType ?>><?
	}
}

function _cell($content, $visible = true) {
	_namedCell('td', $content, $visible);
}

/* 
 * ===================================================================
 * Rendering DOM-elements: Boxes
 * ===================================================================
 */

function _box($headerText = null, $content = null, $error = false) {
	?><div class="box-container">
	<div class="<? echo $error ? 'error-box' : 'content-box' ?>">
		<? if (isset($headerText)) _h3($headerText); ?>
		<div class="box-content">
		<? executeDomContent($content); ?>
	</div></div></div><?
}

function _boxes($messages, $error = false) {
	foreach ($messages as $key => $message) {
		if (queried($key)) {
			_box($message, null, $error);
			_br();
		}
	}
}

function _errorBoxes($messages) {
	_boxes($messages, true);
}

function _areYouSureBox($question, $noText, $okText, $target) {
	_box($question, function() use ($noText, $okText, $target) {
		_centered(function() use($noText, $okText, $target) {
			_backLink($noText, array('navigation-link'));
			_br();
			_br();
			_navigationLink($okText, $target);
		});
	});
}

/* 
 * ===================================================================
 * Private Functions
 * ===================================================================
 */

function executeDomContent($element) {
	if (!isset($element)) return;
	if (is_string($element)) {
		echo $element;
	} else if (is_callable($element)) {
		$element();
	} else {
		echo 'DOM-RENDERING-ERROR, cannot render. Dumping.';
		var_dump($element);
	}
}

function printClasses($classes) {
	if (isset($classes)) {
		echo 'class="';
		foreach ($classes as $classname) {
			echo "$classname ";
		}
		echo '" ';
	}
}
