<?php
namespace Drupal\cncextwig\TwigExtension;

use Drupal\node\Entity\Node;

class Manufacturers extends \Twig_Extension {

  /**
   * Gets a unique identifier for this Twig extension.
   */
  public function getName() {
    return 'cncextwig.twig_extension';
  }

  /**
   * Generates a list of all Twig filters that this extension defines.
   */
  public function getFilters() {
    return [
      new \Twig_SimpleFilter('mfr_list', array($this, 'mfrList'), array('is_safe' => array('html')))
    ];
  }

  /**
   * Replaces all numbers from the string.
   */
  public static function mfrList($string) {

    $manufacturers = db_select('node__field_manufacturer', 'r')
        ->fields('r', array('field_manufacturer_value'))
        ->groupBy('r.field_manufacturer_value')
        ->orderBy('r.field_manufacturer_value')
        ->execute()
        ->fetchAll();

    $tally = [];

    foreach ($manufacturers as $key => $value) {
      $tally[] = $value->field_manufacturer_value;
    }

    $return = '<div class="views-element-container"><div class="view-content">';
    foreach ($tally as $m) {
      $return .= '<div class="views-row">
        <div class="views-field views-field-field-manufacturer">
           <div class="field-content">
             <a href="/machinery-sale/all-machinery-sale?field_manufacturer_value=' . $m . '">
              <span><p>' . $m . '</p>
              </span></a>
            </div>
          </div>
        </div>';
    }
    $return .= '</div></div>';

    return $return;
  }





}
