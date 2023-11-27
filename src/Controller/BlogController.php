// src/Controller/BlogController.php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_index")
     */
    public function index(Request $request)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        $article = new Article();
        $articleForm = $this->createForm(ArticleType::class, $article);

        $articleForm->handleRequest($request);
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $article->setUser($this->getUser()); // Set the current user as the article author
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            // Clear the form after successful submission
            $article = new Article();
            $articleForm = $this->createForm(ArticleType::class, $article);

            $this->addFlash('success', 'Article published successfully!');
        }

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'articleForm' => $articleForm->createView(),
        ]);
    }
}
