<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{

    /**
     * @Route("/", name="home_page", methods={"GET"})
     */
    public function indexAction()
    {
        return $this->render("default/index.html.twig");
    }

    /**
     * @Route("/", name="create_article", methods={"POST"})
     */
    public function createArticle(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("list_articles");
        } else {
            var_dump($form->getErrors());
        }
        exit;
    }

    /**
     * @Route("/all", name="list_articles")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render("default/list.html.twig",
          ["articles" => $articles]);
    }

    /**
     * @param \AppBundle\Entity\Article $article
     * @Route("/view/{id}", name="view_article")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewArticle(Article $article)
    {
        return $this->render("default/viewArticle.html.twig",
          ['article' => $article]);
    }
}
