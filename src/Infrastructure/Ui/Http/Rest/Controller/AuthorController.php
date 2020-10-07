<?php

declare(strict_types=1);


namespace App\Infrastructure\Ui\Http\Rest\Controller;


use App\Application\Command\SaveAuthor\SaveAuthorCommand;
use App\Domain\CommonValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    private MessageBusInterface $commandBus;

    public function __construct(
        MessageBusInterface $commandBus
    ) {
        $this->commandBus = $commandBus;
    }


    /**
     * @Route("/author", name="saving_author", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function saveAuthor(Request $request): Response
    {
        $id = $request->get('id');
        $name = $request->get('name');
        $surname = $request->get('surname');

        CommonValidator::validateNotEmptyString($id, 'id of the author not found in request');
        CommonValidator::validateNotEmptyString($name, 'name of the author not found in request');
        CommonValidator::validateNotEmptyString($surname, 'surname of the author not found in request');


        $this->commandBus->dispatch(new SaveAuthorCommand($id,$name,$surname));

        return new Response("", 201);
    }
}
