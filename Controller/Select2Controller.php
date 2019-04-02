<?php

namespace Vctls\Select2EntityExtensionBundle\Controller;

use Doctrine\ORM\EntityRepository;
use ReflectionClass;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Vctls\Select2EntityExtensionBundle\Util\Searcher;

/**
 * Class Select2Controller
 */
class Select2Controller extends Controller
{
    /**
     * Peupler la liste Select2.
     *
     * @param Request $request
     * @param $classname
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function searchAction(Request $request, $classname)
    {
        $this->denyAccessUnlessGranted('view', $classname);
        
        $entityReflection = new ReflectionClass($classname);
        $shortName = $entityReflection->getShortName();
        $namespace = $this->getParameter('vctls_select2_entity_extension.config')['namespace'];
        /** @var Searcher $searcher */
        $searcher = (new ReflectionClass($namespace . $shortName . "Searcher"))->newInstance();
        /** @var EntityRepository $repo */
        $repo = $this->getDoctrine()->getRepository($entityReflection->getName());
        $qb = $repo->createQueryBuilder($searcher->alias);
        $results = $searcher->search($qb, $request->get('q'), $request->get('page_limit'));
        return new JsonResponse($results);
    }
}