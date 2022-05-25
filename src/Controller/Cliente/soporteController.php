<?php


namespace App\Controller\Cliente;


use App\Entity\Caso;
use App\Entity\Soporte;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class soporteController extends AbstractController
{

    /**
     * @Route("/cliente/soporte/lista", name="cliente_soporte_lista")
     */
    public function lista(Request $request, PaginatorInterface $paginator )
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('estadoSolucionado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroSoporteEstadoSolucionado'), 'required' => false])
            ->add('estadoAtendido', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroSoporteEstadoAtendido'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroSoporteEstadoSolucionado', $form->get('estadoSolucionado')->getData());
                $session->set('filtroSoporteEstadoAtendido', $form->get('estadoAtendido')->getData());
            }
        }
        $arSoportes = $paginator->paginate($em->getRepository(Soporte::class)->soportes($this->getUser()->getCodigoClienteFk()), $request->query->getInt('page', 1), 50);
        return $this->render('Cliente/soporte/lista.html.twig', [
            'arSoportes' => $arSoportes,
            'form' => $form->createView()
        ]);
    }
}