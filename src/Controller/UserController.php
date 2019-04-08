<?php

namespace App\Controller;

use App\Application\Service\IUserDeleteService;
use App\Application\Service\IUserUpdateService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use JsonSchema\Validator;

class UserController extends AbstractController
{
    /**
     * @Route(
     *      "/api/user/{uid}",
     *      name="api_user_delete",
     *      methods={"DELETE"},
     *      requirements={"uid" = "[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}"}
     * )
     */
    public function delete(
        string $uid,
        JsonResponse $jsonResponse,
        IUserDeleteService $userDeleteService
    ) {
        try {
            $userDeleteService->deleteByUid($uid);
        } catch (\Exception $ex) {
        }
        return $jsonResponse;
    }
    /**
     * @Route(
     *      "/api/user/{uid}",
     *      name="api_user_update",
     *      methods={"PUT"},
     *      requirements={"uid" = "[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}"}
     * )
     */
    public function update(
        string $uid,
        Request $request,
        JsonResponse $jsonResponse,
        IUserUpdateService $userUpdateService,
        TranslatorInterface $translator
    ) {
        try {
            $data = json_decode($request->getContent(), true);
            $validator = new Validator();
            $validation = $validator->validate(
                $data,
                (object)[
                    "type" => "array",
                    "properties" => (object)[
                        "new_layout" => (object)[
                            "type"=> "string"
                        ]
                    ],
                    "required" => [
                        "new_layout"
                ]
            ]);
            if(!$validator->isValid()){
                var_dump('oii');
            }
            $password = $request->get('password');
            $new_password = password_hash($request->get('new_password'), PASSWORD_BCRYPT);

            if (!password_verify($request->get('new_password_repeat'), $new_password)) {

                $jsonResponse
                    ->setData([
                        'message' => $translator->trans('These passwords do not match. Try again.'),
                        'property_path' => 'password_repeat',
                    ])
                    ->setStatusCode($jsonResponse::HTTP_BAD_REQUEST);

                throw new \InvalidArgumentException();
            }

            $userUpdateService->updatePassword($uid, $password, $new_password);

        } catch (\Exception $ex) {
        }

        return $jsonResponse;
    }
}
