<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Panier
{
    private $session;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function get()
    {
        return $this->session->get('panier');  // On récupère le panier de la session
    }

    public function delete()
    {
        return $this->session->remove('panier');
    }

    public function index()
    {
        // On fabrique les données
        $fullPanier = []; // Le total du panier est un array qui contient le produit, sa quantité et son prix total
        $totalPieces = 0; // Le total des pieces
        $totalPrix = 0; // Le prix total du panier

        if ($this->get() != null) {  // Si le panier n'est pas vide
            foreach ($this->get() as $id => $quantite) {  // Pour chaque ligne du tableau du panier
                // On cherche les informations du produit $id dans la classe Product
                $product = $this->entityManager->getRepository(Product::class)->findOneById($id);  
                if (!$product) {  // S'il n'existe pas on le supprime  
                    $this->delete($id);
                    continue;
                }
                // On stocke dans l'array fullPanier les informations
                $fullPanier[] = [
                    'product' => $product,
                    'quantite' => $quantite,
                    'total' => $product->getPrice() * $quantite
                ]; 
                // On calcule le total de piece et le prix total
                $totalPieces += $quantite;
                $totalPrix += $product->getPrice() * $quantite;
            }
        }
        // On returne un array qui contient le panier, le total de piece et le prix total
        return ['fullPanier' => $fullPanier, 'totalPieces' => $totalPieces, 'totalPrix' => $totalPrix];
    }

    public function add($id)
    {
        // On recupere le panier actuel
        $panier = $this->session->get('panier', []); // On initialise le panier avec un tableau vide
        
        if (!empty($panier[$id])) {
            // Si l'id d'un produit existe dans le panier on l'incrimente
            $panier[$id]++; 
        } else {
            // Sinon on le definit à 1
            $panier[$id] = 1;  
        }
        // On sauvegarde le panier dans la session
        $this->session->set('panier', $panier);
    }

    public function decrease($id)
    {
        $panier = $this->session->get('panier', []); // On récupère le panier de la session
        if ($panier[$id] > 1) {  // Si le panier pour un produit est plus grand que 1
            $panier[$id]--;  // On dencrémente 
        } else {  // Sinon
            unset($panier[$id]);  // On retire la ligne
        }
        //On sauvegarde le panier dans la session
        $this->session->set('panier', $panier);        
    }
}
