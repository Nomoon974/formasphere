<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Posts;
use App\Entity\Spaces;
use App\Form\CommentType;
use App\Form\PostsType;
use App\Service\FileUploader;
use App\Entity\Documents;
use App\Repository\PostsRepository;
use App\Service\MimeTypesService;
use App\Service\PostDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use HTMLPurifier;
use HTMLPurifier_Config;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/posts')]
class PostsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/', name: 'app_posts_index', methods: ['GET'])]
    public function index(PostsRepository $postsRepository): Response
    {
        return $this->render('posts/index.html.twig', [
            'posts' => $postsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_posts_new', methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('posts/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/post/{id}', name: 'app_posts_show', methods: ['GET'])]
    public function show(
        Posts $post,
        CsrfTokenManagerInterface $csrfTokenManager,
        PostsRepository $postsRepository,
        PostDataProvider $postDataProvider,
        Security $security
    ): Response {
        $user = $security->getUser();

        $data = $postsRepository->findPostWithRelations($post);
        $serializedData = $postDataProvider->serializePostData($data, $csrfTokenManager);

        $csrfToken = $csrfTokenManager->getToken('delete_document')->getValue();

        return $this->render('posts/show.html.twig', [
            'post' => $post,
            'user' => $user,
            'post_json' => json_encode($serializedData['post']),
            'documents_json' => json_encode($serializedData['documents']),
            'comments_json' => json_encode($serializedData['comments']),
            'user_json' => json_encode([
                'id' => $user ? $user->getId() : null,
                'fullName' => $user ? $user->getFullName() : null,
            ]),
            'csrf_token' => $csrfToken,
        ]);
    }

    #[Route('/post/{id}/edit', name: 'app_posts_edit', methods: ['POST'])]
    public function edit(
        Posts $post,
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security
    ): JsonResponse {
        $user = $security->getUser();

        // Vérifiez si l'utilisateur a le droit de modifier
        if (!$user || $user !== $post->getUser()) {
            return new JsonResponse(['error' => 'Permission refusée.'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $content = $data['content'] ?? '';

        // Validation du contenu
        if (strlen(trim(strip_tags($content))) < 10) {
            return new JsonResponse(['error' => 'Le contenu doit contenir au moins 10 caractères.'], 400);
        }

        $purifier = new \HTMLPurifier();
        $cleanHtml = $purifier->purify($content);

        $post->setText($cleanHtml);
        $post->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'updatedText' => $post->getText()]);
    }

    #[Route('/{id}/delete', name: 'app_posts_delete', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(
        Request $request,
        CsrfTokenManagerInterface $csrfTokenManager,
        Posts $post,
        EntityManagerInterface $entityManager,
        Security $security
    ): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        // Récupérer l'utilisateur actuel
        $user = $security->getUser();

        // Vérifier que l'utilisateur a le droit de supprimer le post (propriétaire ou admin)
        if ($post->getUser() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas la permission de supprimer ce post.');
            return $this->redirectToRoute('space_views', ['id' => $post->getSpace()->getId()]);
        }

        // Vérification du token CSRF
        $submittedToken = $request->request->get('_token');
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('delete_post' . $post->getId(), $submittedToken))) {
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('space_views', ['id' => $post->getSpace()->getId()]);
        };

        // Suppression du post
        $entityManager->remove($post);
        $entityManager->flush();

        // Ajouter un message de succès et rediriger
        $this->addFlash('success', 'Le post a été supprimé avec succès.');
        return $this->redirectToRoute('space_views', ['id' => $post->getSpace()->getId()]);
    }

    #[Route("/space/{space_id}/post/save", name: "save_post", methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function savePost(
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security,
        FileUploader $fileUploader,
        int $space_id,
    ): Response {
        // Récupération de l'utilisateur et de l'espace
        $user = $security->getUser();
        $space = $entityManager->getRepository(Spaces::class)->find($space_id);

        if (!$space) {
            throw $this->createNotFoundException('Aucun espace trouvé pour id ' . $space_id);
        }

        if (!$this->isGranted('ROLE_TEACHER', $space)) {
            $this->addFlash('error', 'Vous ne possédez pas la permission de poster dans cet espace.');
            return $this->redirectToRoute('space_views', ['id' => $space_id]);
        }

        $content = $request->request->get('content');

        // Si le contenu est vide ou trop court
        if (!$content || trim(strip_tags($content)) === '') {
            $this->addFlash('error', 'Le contenu ne peut pas être vide.');
            return $this->redirectToRoute('space_views', ['id' => $space_id]);
        }

        // Nettoyage du texte avec HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'p,b,strong,i,em,u,a[href|title],ul,ol,li,br,blockquote,h1,h2,h3,h4,h5,h6,span[style],img[src|alt|width|height]');
        $config->set('HTML.AllowedAttributes', 'href,src,alt,title,style,width,height');
        $config->set('CSS.AllowedProperties', ['color']);
        $config->set('AutoFormat.RemoveEmpty', true);

        $purifier = new HTMLPurifier($config);
        $cleanHtml = $purifier->purify($content);

        // Création et enregistrement du post
        $post = new Posts();
        $post->setUser($user);
        $post->setSpace($space);
        $post->setText($cleanHtml);
        $entityManager->persist($post);
        $entityManager->flush();

        // *** TRAITEMENT DES FICHIERS ATTACHÉS ***
        if ($request->files->has('document')) {
            $files = $request->files->get('document');
            $mimeTypes = new MimeTypes();

            foreach ($files as $uploadedFile) {
                if ($uploadedFile && $uploadedFile->isValid()) {
                    try {
                        // Vérification du type MIME
                        $mimeType = $mimeTypes->guessMimeType($uploadedFile->getPathname());
                        if (!in_array($mimeType, MimeTypesService::ALLOWED_MIME_TYPES)) {
                            $this->addFlash('error', 'Type de fichier non autorisé : ' . $mimeType);
                            continue;
                        }

                        if ($uploadedFile->getSize() > 5 * 1024 * 1024) { // 5 Mo
                            $this->addFlash('error', 'La taille d’un fichier ne peut pas dépasser 5 Mo.');
                            continue;
                        }

                        $newFilename = $fileUploader->upload($uploadedFile);

                        $document = new Documents();
                        $document->setSpace($space);
                        $document->setUser($user);
                        $document->setPost($post);
                        $document->setLink($newFilename);
                        $document->setType($mimeType);
                        $document->setTimestamp(new \DateTime());

                        $entityManager->persist($document);
                        $this->addFlash('info', 'Fichier ajouté avec succès.');
                    } catch (\Exception $e) {
                        $this->addFlash('error', 'Erreur lors du traitement du fichier : ' . $e->getMessage());
                    }
                } else {
                    $this->addFlash('error', 'Fichier invalide ou non reçu.');
                }
            }
        }

        // Sauvegarde des documents en BDD
        $entityManager->flush();

        $this->addFlash('success', 'Post créé avec succès.');
        return $this->redirectToRoute('space_views', ['id' => $space_id]);
    }

}
