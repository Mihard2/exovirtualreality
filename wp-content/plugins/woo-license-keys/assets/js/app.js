/*!
 * License keys plugin script.
 * This affects pages at my-account and other.
 *
 * @author Cami Mostajo <info@10quality.com>
 * @copyright 10 Quality <http://www.10quality.com/>
 * @license GPLv3
 * @package LicenseKeys
 * @version 1.2.1
 */
// Init clipboard copy
if ( jQuery('.clipboard-copy').length ) {
    var clipboard = new ClipboardJS( '.clipboard-copy' );
}