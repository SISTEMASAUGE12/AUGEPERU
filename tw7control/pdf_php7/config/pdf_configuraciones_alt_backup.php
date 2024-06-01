<?php
//formato de la pagina
define ('PDF_PAGE_FORMAT', 'A4');

/**
 * Page orientation (P=portrait, L=landscape).
 */
// define ('PDF_PAGE_ORIENTATION', 'P');
define ('PDF_PAGE_ORIENTATION', 'L');

// variable creador
define ('PDF_CREATOR', 'TCPDF');
// variable autor
define ('PDF_AUTHOR', 'TCPDF');
//varable titulo cabezera
define ('PDF_HEADER_TITLE', 'TCPDF Example');


define ('K_TCPDF_EXTERNAL_CONFIG', true);
//descripcion de la cabezera  header
// define ('TITULO_HEADER', "992 863 929\n www.mochetourschiclayo.com.pe");
define ('TITULO_HEADER', "  ");

//nose como se une cn el de abajo pero es la direccin de la carpeta con la imagen 
define ('K_PATH_IMAGES', dirname(__FILE__).'/../images/');

//se carga el nmbre del logo , o se deja en cadena vacia para desactivarlo
define ('LOGO', 'logo.png');
//ancho de la img
define ('LOGO_WIDTH', 60);

/**
 * Cache directory for temporary files (full path).
 */
define ('K_PATH_CACHE', sys_get_temp_dir().'/');

/**
 * Generic name for a blank image.
 */
// define ('K_BLANK_IMAGE', '_blank.png');
define ('K_BLANK_IMAGE', 'fondo_1.png');



/**
 * Document unit of measure [pt=point, mm=millimeter, cm=centimeter, in=inch].
 */
define ('PDF_UNIT', 'mm');

//Margin 
define ('PDF_MARGIN_HEADER', 5);
define ('PDF_MARGIN_FOOTER', 10);
define ('PDF_MARGIN_TOP', 27);
define ('PDF_MARGIN_BOTTOM', 25);
define ('PDF_MARGIN_LEFT', 5);
define ('PDF_MARGIN_RIGHT', 5);

//fuente
define ('PDF_FONT_NAME_MAIN', 'helvetica');
//font-size
define ('PDF_FONT_SIZE_MAIN', 10);

//fuente pra data
define ('PDF_FONT_NAME_DATA', 'helvetica');
//tamaño para data 
define ('PDF_FONT_SIZE_DATA', 8);

/**
 * Default monospaced font name.
 */
define ('PDF_FONT_MONOSPACED', 'courier');

/**
 * Ratio used to adjust the conversion of pixels to user units.
 */
define ('PDF_IMAGE_SCALE_RATIO', 1.25);

/**
 * Magnification factor for titles.
 */
define('HEAD_MAGNIFICATION', 1.1);

/**
 * Height of cell respect font height.
 */
define('K_CELL_HEIGHT_RATIO', 1.25);

/**
 * Title magnification respect main font size.
 */
define('K_TITLE_MAGNIFICATION', 1.3);

/**
 * Reduction factor for small font.
 */
define('K_SMALL_RATIO', 2/3);

/**
 * Set to true to enable the special procedure used to avoid the overlappind of symbols on Thai language.
 */
define('K_THAI_TOPCHARS', true);

/**
 * If true allows to call TCPDF methods using HTML syntax
 * IMPORTANT: For security reason, disable this feature if you are printing user HTML content.
 */
define('K_TCPDF_CALLS_IN_HTML', true);

/**
 * If true and PHP version is greater than 5, then the Error() method throw new exception instead of terminating the execution.
 */
define('K_TCPDF_THROW_EXCEPTION_ERROR', false);

//============================================================+
// END OF FILE
//============================================================+
