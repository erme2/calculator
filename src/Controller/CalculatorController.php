<?php

namespace App\Controller;

use App\Entity\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CalculatorController extends AbstractController
{
    #[Route('/calculator', name: 'calculator')]
    public function index(Request $request, ValidatorInterface $validator): Response
    {
        $result = null;
        $errors = [];
        $values = [
            'firstNumber' => $request->request->get('firstNumber', 0),
            'operator' => $request->request->get('operator', ""),
            'secondNumber' => $request->request->get('secondNumber', 0),
        ];
        if ($request->isMethod(Request::METHOD_POST)) {
            // validating data :)
            $operation = new Operation(
                $values['firstNumber'],
                $values['operator'],
                $values['secondNumber']
            );
            foreach ($validator->validate($operation) as  $error) {
                $errors[] = $error->getMessage();
            }

            if (count($errors) === 0) {
                try {
                    $result = $operation->calculate();
                } catch (\Exception $exception) {
                    $errors[] = $exception->getMessage();
//                    $this->addFlash('error', $exception->getMessage());
                }
            }
        }

        return $this->render('calculator/index.html.twig',  [
            'controller_name' => 'CalculatorController',
            'result' => $result ?? null,
            'errors' => count($errors) > 0 ? $errors : null,
            'preset' => $values,
        ]);
    }

}