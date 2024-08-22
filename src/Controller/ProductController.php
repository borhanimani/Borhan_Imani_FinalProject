<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\User;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Services\PriceWithTaxCalculate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository, PriceWithTaxCalculate $priceWithTaxCalculate): Response
    {
        $products = $productRepository->findAll();
        foreach ($products as $product) {
            $product->setPrice($priceWithTaxCalculate->calculatePriceWithTax($product->getPrice(), 'Laptop'));
        }

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product, PriceWithTaxCalculate $priceWithTaxCalculate): Response
    {
        $product->setPrice($priceWithTaxCalculate->calculatePriceWithTax($product->getPrice(), 'Laptop'));
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/buy', name: 'app_product_buy', methods: ['GET', 'POST'])]
    public function buy(Request $request, Product $product, EntityManagerInterface $entityManager ,Security $security): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        return $this->render('product/buy.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/buy/complete', name: 'app_product_buy_completion', methods: ['POST'])]
    public function endBuy(Product $product, EntityManagerInterface $entityManager, Security $security): Response
    {
        $purchase = new Purchase();
        $purchase->setUserid($this->getUser());
        $purchase->setProductid($product);
        $entityManager->persist($purchase);
        $entityManager->flush();
        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
