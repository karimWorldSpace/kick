<?php

namespace Drupal\my_commerce\Plugin\Block;

use Drupal\Core\Url;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\commerce_cart\CartProviderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Checkout Button' block.
 *
 * @Block(
 *   id = "my_commerce_checkout_button_block",
 *   admin_label = @Translation("Checkout Button Block"),
 * )
 */
final class CheckoutButtonBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $cartProvider;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, CartProviderInterface $cart_provider) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->cartProvider = $cart_provider;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('commerce_cart.cart_provider')
    );
  }

  public function build() {
    // Récupère les paniers de l'utilisateur courant.
    $carts = $this->cartProvider->getCarts();
    //dd($carts);
    // Si pas de panier ou panier vide → ne rien afficher.
    if (empty($carts)) {
      return [];
    }

    // Vérifie si l'utilisateur est déjà sur une page du checkout.
    $current_path = \Drupal::service('path.current')->getPath();
    if (str_contains($current_path, '/checkout')) {
      return [];
    }

    // Lien vers la route checkout.
    $url = Url::fromRoute('commerce_checkout.checkout');

    return [
      '#type' => 'link',
      '#title' => $this->t('Pssasser la commande'),
      '#url' => $url,
      '#attributes' => [
        'class' => ['btn', 'btn-primary', 'checkout-footer-button' ,'edit-checkout'],
        'id'=> "edit-checkout",
        'data-drupal-selector'=> ["edit-checkout"]
      ],
    ];
  }

  public function blockAccess(AccountInterface $account) {
    // Seulement pour les utilisateurs ayant accès au checkout.
    return AccessResult::allowedIfHasPermission($account, 'access checkout');
  }
}