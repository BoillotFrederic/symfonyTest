<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;

class ProductsController extends Controller {

  // Format
  private function format(Request $request, $content, $view, $params){
    switch ($request->getRequestFormat()) {
      case 'json':
      $serializer = $this->get('serializer');
      $json = $serializer->serialize($content, 'json');
      return $this->json($json);

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
    $products = $this->getDoctrine()
                    ->getRepository('AppBundle:Product')
                    ->findAll();

    return $this->format($request, $products, 'index', 'products');
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
    $product = $this->getDoctrine()
                    ->getRepository('AppBundle:Product')
                    ->find($id);

    if($product)
    return $this->format($request, $product, 'show', 'product');

    // Error
    else
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
    if($request->getMethod() == 'GET'){
      $product = $this->getDoctrine()
                      ->getRepository('AppBundle:Product')
                      ->find($id);

      $category = $this->getDoctrine()
                      ->getRepository('AppBundle:Category')
                      ->findAll();

      if($product)
      return $this->format($request, compact('product', 'category'), 'edit', 'data');
    }
    // Edit complete
    else{

      $em = $this->getDoctrine()->getManager();
      $product = $em->getRepository('AppBundle:Product')->find($id);

      if (!$product)
      throw $this->createNotFoundException('Pas de produit pour l\'id ' . $id);

      $product->setReference($request->get('ref'));
      $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($request->get('category_id'));
      $product->setCategory($category);


      // $product->setCategoryId($request->get('category_id'));
      $em->flush();

      $this->addFlash('msg', 'Produit modifié !');
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
    if($request->getMethod() == 'GET'){
      $category = $this->getDoctrine()
                      ->getRepository('AppBundle:Category')
                      ->findAll();

      if($category)
      return $this->format($request, $category, 'create', 'category');
    }

    // Create complete
    else{
      $product = new Product();
      $product->setReference($request->get('ref'));
      $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($request->get('category_id'));
      $product->setCategory($category);

      $em = $this->getDoctrine()->getManager();
      $em->persist($product);
      $em->flush();

      $this->addFlash('msg', 'Produit ajouté !');
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
    if($request->getMethod() == 'GET'){
      $product = $this->getDoctrine()
                      ->getRepository('AppBundle:Product')
                      ->find($id);

      if($product)
      return $this->format($request, $product, 'delete', 'product');
    }

    // Delete complete
    else{
      $em = $this->getDoctrine()->getManager();
      $product = $em->getRepository('AppBundle:Product')->find($id);

      if (!$product)
      throw $this->createNotFoundException('Pas de produit pour l\'id ' . $id);

      $em->remove($product);
      $em->flush();

      if($request->getRequestFormat() == 'html'){
        $this->addFlash('msg', 'Produit supprimé !');
        return $this->redirect($this->generateUrl('app_products_index'));
      }
      else
      return $this->json('Produit supprimé !');
    }

    // Error
    return $this->format($request, 'Le produit n\'existe pas !', 'error', 'error');
  }
}

?>
