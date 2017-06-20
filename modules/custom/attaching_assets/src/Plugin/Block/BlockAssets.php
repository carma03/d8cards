<?php
/**
 * @file
 * Contains \Drupal\attaching_assets\Plugin\Block\BlockAssets.
 */
namespace Drupal\attaching_assets\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'attaching_assets' block.
 *
 * @Block(
 *   id = "attaching_assets_block",
 *   admin_label = @Translation("Day 9 - ­Attaching assets"),
 * )
 */
class BlockAssets extends BlockBase {
  /**
  * {@inheritdoc}
  */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => 'We are all familiar with the multiple ways of adding JS/CSS to a module or a theme to be available on select / all pages on D7. In this exercise we will check out how we could do the same on D8.',
      '#attached' => [
        'library' => [
          'attaching_assets/custom_blocks',
          'attaching_assets/custom_tables'
        ],
      ],
    ];
  }
}
