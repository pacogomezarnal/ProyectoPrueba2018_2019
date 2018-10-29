<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Producto;
use AppBundle\Form\ProductoType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/contactar/", name="contactar")
     */
    public function contactarAction(Request $request)
    {
      $number = random_int(0, 100);

      return new Response(
          '<html><body>Lucky number: '.$number.'</body></html>'
      );
    }
    /**
     * @Route("/paco/", name="yo")
     */
    public function yoAction(Request $request)
    {
      return $this->render('paco/paco.html.twig');
    }
    /**
     * @Route("/tu/", name="tu")
     */
    public function tuAction(Request $request)
    {
      return $this->redirectToRoute("yo");
    }
    /**
     * @Route("/productos/", name="productos")
     */
    public function productosAction(Request $request)
    {
      $repository = $this->getDoctrine()->getRepository(Producto::class);
      $products = $repository->findAll();
      return $this->render('paco/productos.html.twig',array('productos'=>$products));
    }

    /**
     * @Route("/productoNuevo/", name="productoNuevo")
     */
    public function productoNuevoAction(Request $request)
    {
      $producto=new Producto();
      $form = $this->createForm(ProductoType::class, $producto);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $producto = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($producto);
        $entityManager->flush();
        return $this->redirectToRoute('productos');
      }
      return $this->render('paco/productoNuevo.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/fichaProducto/{id}", name="producto")
     */
    public function productoAction(Request $request,$id=null)
    {
      $repository = $this->getDoctrine()->getRepository(Producto::class);
      $product = $repository->find($id);
      return $this->render('paco/productos.html.twig',array('producto'=>$product));
    }
}
