<?php

declare(strict_types=1);


namespace App\Infrastructure\Ui\Http\Rest\Controller;


use App\Application\Command\SavePost\SavePostCommand;
use App\Application\Query\FindPostById\FindPostByIdQuery;
use App\Domain\CommonValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private MessageBusInterface $commandBus;
    private MessageBusInterface $queryBus;

    public function __construct(
        MessageBusInterface $commandBus,
        MessageBusInterface $queryBus
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }


    /**
     * @Route("/post/{id}", name="get_post")
     * @param Request $request
     * @return Response
     */
    public function getPostById(Request $request): Response
    {
        $id = $request->get('id');
        $includeAuthor = $request->get('includeAuthor') === 'true';

        $envelope = $this->queryBus->dispatch(new FindPostByIdQuery($id, $includeAuthor));

        /** @var HandledStamp $handled */
        $handled = $envelope->last(HandledStamp::class);
        $productDto = $handled->getResult();

        return new Response(serialize($productDto), 200);
    }

    /**
     * @Route("/post", name="saving_post", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function savePost(Request $request): Response
    {
        $id = $request->get('id');
        $title = $request->get('title');
        $description = $request->get('description');
        $content = $request->get('content');
        $authorId = $request->get('authorId');

        CommonValidator::validateNotEmptyString($id, 'id of the post not found in request');
        CommonValidator::validateNotEmptyString($title, 'title of the post not found in request');
        CommonValidator::validateNotEmptyString($description, 'description of the post not found in request');
        CommonValidator::validateNotEmptyString($content, 'content of the post not found in request');
        CommonValidator::validateNotEmptyString($authorId, 'authorId of the post not found in request');

        $command = new SavePostCommand($id, $title, $description, $content, $authorId);

        $this->commandBus->dispatch($command);

        return new JsonResponse('', 201, [], true);
    }

}
