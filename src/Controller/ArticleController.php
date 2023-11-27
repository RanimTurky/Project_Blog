<?php

// src/Controller/ArticleController.php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/create-article", name="create_article")
     */
    public function createArticle(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérez le téléchargement de l'image s'il y en a une
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageName = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('articles_images_directory'),
                    $imageName
                );
                $article->setImage($imageName);
            }

            // Associez l'article à l'utilisateur actuellement connecté
            $article->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('home'); // Remplacez 'home' par la route de votre choix
        }

        return $this->render('article/create_article.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }
}
