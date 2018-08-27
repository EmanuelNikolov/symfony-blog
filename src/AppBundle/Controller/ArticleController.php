<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{

    /**
     * @Route("/article/create", name="create_article")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("list_articles");
        }

        return $this->render("article/create.html.twig",
          ["form" => $form->createView()]);
    }

    /**
     * @Route("/all", name="list_articles")
     * @return Response
     */
    public function listAllAction()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render("article/listAll.html.twig",
          ["articles" => $articles]);
    }

    /**
     * @param \AppBundle\Entity\Article $article
     * @Route("/article/view/{id}", name="view_article")
     *
     * @return Response
     */
    public function viewAction(Article $article)
    {
        return $this->render("article/view.html.twig",
          ['article' => $article]);
    }
}
