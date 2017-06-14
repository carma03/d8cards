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
      '#attached' => [
        'library' => [
          'attaching_assets/custom_blocks',
          'attaching_assets/custom_tables'
        ],
      ],
    ];
  }
}
