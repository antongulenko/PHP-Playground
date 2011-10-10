
// This does not work... Would be nice to replace this with working code sometime.

// Get all a-elements and prevent them from being in the tab-cycle-index
var links = document.getElementsByTagName( 'a' );
for( var i = 0, j =  links.length; i < j; i++ ) {
	link.setAttribute( 'tabindex', '-1' );
}
