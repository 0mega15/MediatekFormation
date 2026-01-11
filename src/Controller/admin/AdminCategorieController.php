<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategorieController extends AbstractController
{
    /**
     *
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    private $formationRepository;
    
    public function __construct(CategorieRepository $categorieRepository, FormationRepository $formationRepository)
    {
        $this->categorieRepository= $categorieRepository;
        $this->formationRepository= $formationRepository;
    }
    
    #[Route('/admin/categories', name: 'admin.categories')]
    public function index(): Response
    {
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/admin.categories.html.twig", [
            'categories' => $categories,
            'formations' => $formations
        ]);
    }
    
    #[Route('/admin/categories/suppr/{id}', name: 'admin.categories.suppr')]
    public function suppr(int $id): Response{
        $categories = $this->categorieRepository->find($id);
        $this->categorieRepository->remove($categories);
        return $this->redirectToRoute('admin.categories');
    }
    
    #[Route('/admin/categories/ajout', name: 'admin.categories.ajout')]
    public function ajout(Request $request): Response{
        $nomCategorie = $request->get("name");
        $categories = new Categorie();
        $categories->setName($nomCategorie);
        $this->categorieRepository->add($categories);
        return $this->redirectToRoute('admin.categories');
    }
}
