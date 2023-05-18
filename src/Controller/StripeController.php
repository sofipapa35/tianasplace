<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Panier;
use App\Entity\Commande;
use App\Entity\OrderDetail;
use App\Repository\ProductRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/create-checkout-session", name="stripe")
     */
    public function index(Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $date = new \DateTimeImmutable();
        $user = $this->getUser();
        
        // L'addresse du user
        $address = $user->getName() . ' ' . $user->getFirstName() . '<br>' . $user->getAddress() . ' ' . $user->getZip() . ' ' . $user->getVille();
        
        // Nouvelle commande
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setCreatedAt($date);
        $commande->setDelivery($address);
        // Le is paid est false
        $commande->setIsPaid(false);
        // Le total prix du panier
        $commande->setTotal($panier->index()['totalPrix']);
        // Le token de securité
        $token = hash('sha256', uniqid());
        $commande->setValidationToken($token);
        
        $entityManager->persist($commande);
        
        $produits = $panier->index()['fullPanier']; // Le panier
        foreach ($produits as $produit) {
            // Pour chaque produit du panier un nouveau orderDetail se crée
            $order_details = new OrderDetail();
            $order_details->setCommande($commande);
            // ON stocke les données du produit
            $order_details->setProduct($produit['product']->getId() . ', ' . $produit['product']->getImageName() . ', ' . $produit['product']->getTitle());
            // Sa quantité
            $order_details->setQnt($produit['quantite']);
            // Son prix
            $order_details->setPrice($produit['product']->getPrice());
            // Son total prix
            $order_details->setTotal($produit['total']);
            
            $entityManager->persist($order_details);            
        }
        $entityManager->flush();

        
        $productforStripe = [];
        foreach ($produits as $produit) {
            $productforStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $produit['product']->getTitle(),
                    ],
                    'unit_amount' => $produit['product']->getPrice() * 100,
                ],
                'quantity' => $produit['quantite'],
            ];
        }

        $id = $commande->getId(); // Id de la commande
        Stripe::setApiKey('sk_test_51KQYaUKJtb6EEDI6dG3zFLFs8nit3mMKMBPhStXYv5tbml8XZKI60HZSB0kWL8D3O1xxIIOtR7bttuPGIoWpr8kB003jxnestD');

        $checkout_session = \Stripe\Checkout\Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'line_items' => [
                $productforStripe
            ],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('stripe_success', ['id' => $id, 'token' => $token], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('stripe_cancel', ['id' => $id, 'token' => $token], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return $this->redirect($checkout_session->url);
    }

    /**
     * @Route("/stripe/cancel/{id}/{token}", name="stripe_cancel")
     */
    public function cancel($id, $token, MailerInterface $mailer)
    {
        $commande = $this->entityManager->getRepository(Commande::class)->findOneById($id);
        if ($commande->getValidationToken() != $token || !$commande) { 
            // On verifie si le token est le token du membre
            // Si ce n'est pas le cas on dirige le user vers le home
            return $this->redirectToRoute('home');
        }
        // L'email du user
        $user = $commande->getUser()->getEmail();
        // numero commande
        $num_commande = $commande->getId();
        // L'email de confirmation d'annulation 
        $email = (new TemplatedEmail())
            ->from('commande@tianasplace.com')
            ->to($user)
            ->subject('La commande est annulée')
            ->htmlTemplate('commande/email_d\'annulation.html.twig')
            ->context(compact('commande'));

        $mailer->send($email);

        return $this->render('commande/cancel.html.twig', [
            'commande' => $commande,
        ]);
    }
    /**
     * @Route("/stripe/success/{id}/{token}", name="stripe_success")
     */
    public function success($id, $token, Panier $panier, EntityManagerInterface $entityManager, CommandeRepository $commandeRepository, MailerInterface $mailer, ProductRepository $productRepository)
    {
        $commande = $commandeRepository->findOneById($id);
        // On verifie si le token est le token de la commande et si la commande existe
        if ($commande->getValidationToken() != $token || !$commande) { 
            // Si ce n'est pas le cas on dirige le user vers le home
            return $this->redirectToRoute('home');
        }
        // Si on passe cette etape ça veut dire que tout est bon
        if (!$commande->getIsPaid()) {
            // Si le isPaid de la commande est false
            // On supprime le panier
            $panier->delete();
            // On set le isPaid à true
            $commande->setIsPaid(true);
            $entityManager->flush();
        }
        // L'email du user
        $user = $commande->getUser()->getEmail();
        // numero commande
        $num_commande = $commande->getId();

        // L'email de confirmation 
        $email = (new TemplatedEmail())
            ->from('commande@tianasplace.com')
            ->to($user)
            ->subject('La commande est confirmée')
            ->htmlTemplate('commande/email_de_confirmation.html.twig')
            ->context(compact('commande'));

        $mailer->send($email);

        // Top vente
        $products = $commande->getOrderDetails();  
        foreach ($products as $product) {
            // Pour chaque produit de l'orderDetails
            // On trouve le produit
            $prodString = $product->getProduct();
            $prodStringSplit = explode(',', $prodString); // split le string 
            $productId = $prodStringSplit[0];
            $quantity = $product->getQnt();
            $prod_sold = $productRepository->find($productId);
            // Le sold actuel du produit
            $sold = $prod_sold->getSold();
            // On ajoute la quantité
            $sold += $quantity;
            // On set le nouveau sold
            $prod_sold->setSold($sold);
            $entityManager->persist($prod_sold); 
        }
        $entityManager->flush();
        return $this->render('commande/success.html.twig', [
            'commande' => $commande,
        ]);
    }
}
