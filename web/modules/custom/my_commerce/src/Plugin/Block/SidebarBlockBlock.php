<?php

declare(strict_types=1);

namespace Drupal\my_commerce\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a sidebar block block.
 */
#[Block(
  id: 'my_commerce_sidebar_block',
  admin_label: new TranslatableMarkup('Sidebar block'),
  category: new TranslatableMarkup('Custom'),
)]
final class SidebarBlockBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
