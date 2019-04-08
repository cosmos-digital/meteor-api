<?php

namespace App\Controller;

use App\Application\Service\IAccountCreateService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/api/signup", name="api_account_create", methods={"POST"}))
     */
    public function signup(
        Request $request,
        JsonResponse $jsonResponse,
        IAccountCreateService $accountCreateService,
        TranslatorInterface $translator
    ) {
        try {

            $user = new User(
                $request->get('username')
            );
            $user->setPassword(
                $request->get('password')
            );

            if (!password_verify($request->get('password_repeat'), $user->getPassword())) {
               
                $jsonResponse
                    ->setData([
                        'message' => $translator->trans('These passwords do not match. Try again.'),
                        'property_path' => 'password_repeat',
                    ])
                    ->setStatusCode($jsonResponse::HTTP_BAD_REQUEST);

                throw new \InvalidArgumentException();
            }

            $accountCreateService->create($user);

        } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $ex) {
            $jsonResponse->setData(
                [
                    "message" => $translator->trans(
                        "%username% already_taken",
                        ['%name%' => $user->getUsername()]
                    ),
                    "property_path" => "user_already",
                ]
            )->setStatusCode(
                $jsonResponse::HTTP_ALREADY_REPORTED
            );

        } catch (\Exception $ex) {
        }

        return $jsonResponse;
    }
}
