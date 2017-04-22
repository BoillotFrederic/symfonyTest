<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProductsController extends Controller {

  const PRODUCTS_TEST = [
      ['id' => 1, 'reference' => 'AFR-1'],
      ['id' => 2, 'reference' => 'AFR-2'],
      ['id' => 3, 'reference' => 'AFR-3'],
      ['id' => 4, 'reference' => 'AFR-4']
  ];

  // Format
  private function format(Request $request, $content, $view, $params){
    switch ($request->getRequestFormat()) {
      case 'json':
      return $this->json($content);

      case 'html':
      return $this->render('products/'.$view.'.html.twig', [
        $params => $content
      ]);
    }
  }


  /**
   * @Route(
   * "/products.{_format}",
   * defaults={"_format": "html"},
   * requirements={"_format": "html|json"},
   * )
   * @Method("GET")
   */
  public function indexAction(Request $request) {
    return $this->format($request, self::PRODUCTS_TEST, 'index', 'products');
  }

  /**
  *@Route(
  * "/products/{id}.{_format}",
  * defaults={"_format": "html"},
  * requirements={"_format": "html|json", "id": "\d+"}
  * )
  * @Method("GET")
  */
  public function showAction(Request $request, $id) {
    // Product
    foreach (self::PRODUCTS_TEST as $value)
    if($id == $value['id'])
    return $this->format($request, $value, 'show', 'product');

    // Error
    return $this->format($request, 'Aucun résultat trouvé !', 'error', 'error');
  }

  /**
   * @Route(
   * "/products/edit/{id}.{_format}",
   * defaults={"_format": "html", "id": "1"},
   * requirements={"_format": "html|json", "id": "\d+"}
   *)
   * @Method({"GET", "PUT", "PATCH"})
   */
  public function editAction(Request $request, $id) {
    // Edit product
    if($request->getMethod() == 'GET')
      foreach (self::PRODUCTS_TEST as $value){
        if($id == $value['id'])
        return $this->format($request, $value, 'edit', 'product');
      }
    // Edit complete
    else{
      $this->get('session')->getFlashBag()->add('notice', array(
        'title' => 'Produit modifié !',
        'message' => 'L\'action a réussie !'
      ));
      return $this->redirect($this->generateUrl('app_products_index'));
    }

    // Error
    return $this->format($request, 'Le produit n\'existe pas !', 'error', 'error');
  }

  /**
   * @Route(
   * "/products/create.{_format}",
   * defaults={"_format": "html"},
   * requirements={"_format": "html|json"}
   *)
   * @Method({"GET","POST"})
   */
  public function createAction(Request $request) {
    // Create product
    if($request->getMethod() == 'GET')
    return $this->format($request, null, 'create', 'null');
    // Create complete
    else{
      $this->get('session')->getFlashBag()->add('notice', array(
        'title' => 'Produit ajouté !',
        'message' => 'L\'action a réussie !'
      ));
      return $this->redirect($this->generateUrl('app_products_index'));
    }
  }

  /**
   * @Route(
   * "/products/delete/{id}.{_format}",
   * defaults={"_format": "html"},
   * requirements={"_format": "html|json", "id": "\d+"}
   *)
   * @Method({"GET", "DELETE"})
   */
  public function deleteAction(Request $request, $id) {
    // Delete product
    if($request->getMethod() == 'GET')
    foreach (self::PRODUCTS_TEST as $value){
      if($id == $value['id'])
      return $this->format($request, $value, 'delete', 'product');
    }

    // Delete complete
    else{
      $this->get('session')->getFlashBag()->add('notice', array(
        'title' => 'Produit supprimé !',
        'message' => 'L\'action a réussie !'
      ));
      return $this->redirect($this->generateUrl('app_products_index'));
    }

    // Error
    return $this->format($request, 'Le produit n\'existe pas !', 'error', 'error');
  }
}

?>
