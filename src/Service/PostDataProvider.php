<?php

namespace App\Service;

use App\Entity\Posts;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class PostDataProvider
{
    public function serializePostData(array $data, CsrfTokenManagerInterface $csrfTokenManager): array
    {
        /** @var Posts $post */
        $post = $data['post'];
        $documents = $data['documents'];
        $comments = $data['comments'];

        $postData = [
            'id' => $post->getId(),
            'text' => $post->getText(),
            'createdAt' => $post->getCreatedAt()->format('c'),
            'updatedAt' => $post->getUpdatedAt() ? $post->getUpdatedAt()->format('c') : null,
            'user' => $post->getUser() ? [
                'id' => $post->getUser()->getId(),
                'avatar' => $post->getUser()->getAvatar() ?? '/path/to/default-avatar.png',
                'fullName' => $post->getUser()->getFullName(),
            ] : null,
        ];

        $baseUploadPath = '/uploads/documents/';

        $documentsData = array_map(function ($document) use ($baseUploadPath, $csrfTokenManager) {
            return [
                'id' => $document->getId(),
                'link' => $baseUploadPath . $document->getLink(),
                'csrfToken' => $csrfTokenManager->getToken('delete_document' . $document->getId())->getValue(),
            ];
        }, $documents);



        $commentsData = array_map(function ($comment) {
            return [
                'id' => $comment->getId(),
                'text' => $comment->getText(),
                'createdAt' => $comment->getCreatedAt()->format('c'),
                'user' => $comment->getUser() ? [
                    'id' => $comment->getUser()->getId(),
                    'avatar' => $comment->getUser()->getAvatar() ?? '/path/to/default-avatar.png',
                    'fullName' => $comment->getUser()->getFullName(),
                ] : null,
            ];
        }, $comments);

        return [
            'post' => $postData,
            'documents' => $documentsData,
            'comments' => $commentsData,
        ];
    }
}
