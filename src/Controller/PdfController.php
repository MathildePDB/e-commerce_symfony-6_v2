<?php

namespace App\Controller;

use App\Entity\Orders;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/pdf', name: 'app_pdf_')]
class PdfController extends AbstractController
{
    #[Route('/commande/{id}', name: 'order')]
    public function order(int $id, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // sécuriser pour que seul l'user connecté ait accès à ses factures
        $user = $this->getUser();

        $order = $em->getRepository(Orders::class)->find($id);

        if ($order->getUsers() !== $user) {
            $this->addFlash('danger', 'Une erreur s\'est produite');
            return $this->redirectToRoute('main');
        }

        $orderDetails = $order->getOrdersDetails();
        $total = 0;

        foreach ($orderDetails as $item) {
            $unitPrice = $item->getPrice();
            $quantity = $item->getQuantity();
            $total += $unitPrice * $quantity;
        }
        
        $dompdf = new Dompdf();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);

        $html = $this->renderView('pdf/order.html.twig', [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'total' => $total,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $pdfContent = $dompdf->output();

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-disposition' => 'attachment; filename="facture.pdf"',
        ]);
    }
}
