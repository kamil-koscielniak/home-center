<?php

namespace App\Controller;

use App\Entity\ShoppingItem;
use App\Entity\ShoppingList;
use App\Form\ShoppingListSpecialType;
use App\Form\ShoppingListType;
use App\Repository\ShoppingListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopping/list")
 */
class ShoppingListController extends AbstractController
{
    /**
     * @Route("/", name="shopping_list_index", methods="GET")
     * @param ShoppingListRepository $shoppingListRepository
     * @return Response
     */
    public function index(ShoppingListRepository $shoppingListRepository): Response
    {
        return $this->render('shopping_list/index.html.twig', ['shopping_lists' => $shoppingListRepository->findAll()]);
    }

    /**
     * @Route("/new", name="shopping_list_new", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $shoppingList = new ShoppingList();
        $repository = $this->getDoctrine()->getRepository(ShoppingList::class);
        $defaultShoppingListName = $repository->createNewShoppingListName();

        $form = $this->createForm(ShoppingListType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createShoppingList($form->getData(), $shoppingList);
            $this->createShoppingItems($form->getData(), $shoppingList);
            $this->addFlash(
                'success',
                'Twoja lista została pomyślnie utworzona'
            );

            return $this->redirectToRoute('shopping_list_index');
        }

        return $this->render('shopping_list/new.html.twig', [
            'shopping_list' => $shoppingList,
            'defaultShoppingListName' => $defaultShoppingListName,
            'form' => $form->createView(),
        ]);
    }

    private function createShoppingList($formData, $shoppingList){
        $shoppingList->setName($formData['name']);
        $shoppingList->setUser($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($shoppingList);
        $em->flush();
    }

    private function createShoppingItems($formData, $shoppingList){
        $em = $this->getDoctrine()->getManager();
        foreach ($formData['items'] as $item){
            $shoppingItem = new ShoppingItem();
            $shoppingItem->setShoppingList($shoppingList);
            $shoppingItem->setDescription($item);
            $shoppingItem->setCreator($this->getUser());
            if (!empty($item)){
                $em->persist($shoppingItem);
                $em->flush();
            }
        }
    }

    /**
     * @Route("/{id}", name="shopping_list_show", methods="GET")
     * @param ShoppingList $shoppingList
     * @return Response
     */
    public function show(ShoppingList $shoppingList): Response
    {
        return $this->render('shopping_list/show.html.twig', ['shopping_list' => $shoppingList]);
    }

    /**
     * @Route("/{id}/edit", name="shopping_list_edit", methods="GET|POST")
     * @param Request $request
     * @param ShoppingList $shoppingList
     * @return Response
     */
    public function edit(Request $request, ShoppingList $shoppingList): Response
    {
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shopping_list_edit', ['id' => $shoppingList->getId()]);
        }

        return $this->render('shopping_list/edit.html.twig', [
            'shopping_list' => $shoppingList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shopping_list_delete", methods="DELETE")
     * @param Request $request
     * @param ShoppingList $shoppingList
     * @return Response
     */
    public function delete(Request $request, ShoppingList $shoppingList): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shoppingList->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shoppingList);
            $em->flush();
        }

        return $this->redirectToRoute('shopping_list_index');
    }
}
