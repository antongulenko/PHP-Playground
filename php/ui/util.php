<?
require_once 'php/util.php';

// $error_messages can contain key-value-string or just strings.
// If a string (key) exists as parameter, an error-box will be rendered.
// The error-message is the value in the array (if it contains values) or the value of the request-parameter.
// This will open two <div>-element, which must be closed.
function openBox($error_messages) {
	if (isset($error_messages)) {
		$isNumbered = isNumbered($error_messages);
		$parameters = $isNumbered ? $error_messages : array_keys($error_messages);
		$parameter = firstExistingParameter($parameters);
	}
	?>
	<div class="box-container">
	<div class="<? echo isset($parameter) ? 'error-box' : 'content-box' ?>"><?
	if (isset($parameter)) { 
		$message = $isNumbered ? $_REQUEST[$parameter] : $error_messages[$parameter]; ?>
		<span><? echo $message ?></span><?
	}
}

function closeBox() {
	?>
	</div>
	</div>
	<?
}

// array of arrays of the form array('type', 'label', 'name')
function simpleForm($specs, $method, $action) {
	$tabindex = 1;
	?>
	<form class="simple_form" method="<? echo $method ?>" action="<? echo $action ?>" >
	<?
	foreach ($specs as $spec) {
		$submit = strcasecmp($spec[0], 'submit') == 0; ?>
		<label for="<? echo $spec[2] ?>"><? echo ($submit ? ' ' : $spec[1]) ?></label>
		<input tabindex="<? echo $tabindex++ ?>" 
			<? if ($submit) echo "value='$spec[1]'" ?> type="<? echo $spec[0] ?>" name="<? echo $spec[2] ?>" />
		<br/>
		<?
	}
	?>
	</form>
	<?
}

?>