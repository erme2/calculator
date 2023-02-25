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
        $data = [
            'result' => null,
            'values' => [
                'firstNumber' => $request->request->get('firstNumber', 0),
                'operator' => $request->request->get('operator', ""),
                'secondNumber' => $request->request->get('secondNumber', 0),
            ]
        ];
        if ($request->isMethod(Request::METHOD_POST)) {
            $data = $this->getTheResult($data, $validator);
        }
        return $this->render('calculator/index.html.twig',  $data);
    }

    private function getTheResult(array $data, ValidatorInterface $validator): array
    {
        // validating data :)
        $operation = new Operation(
            $data['values']['firstNumber'],
            $data['values']['operator'],
            $data['values']['secondNumber']
        );
        $errors = $validator->validate($operation);
        foreach ($errors as  $error) {
            $this->addFlash('error', $error->getMessage());
        }
        if (count($errors) === 0) {
            try {
                $data['result'] = $operation->calculate();
            } catch (\Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }
        }
        return $data;
    }

}