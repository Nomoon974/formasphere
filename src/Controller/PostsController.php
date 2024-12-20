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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Routing\Attribute\Route;
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

    #[Route('/post/{id}', name: 'app_posts_show', methods: ['GET', 'POST'])]
    public function show(
        Posts                  $post,
        Request                $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        // Récupérer les commentaires associés au post
        $comments = $entityManager->getRepository(Comment::class)->findBy(
            ['post' => $post],
            ['created_at' => 'DESC']
        );

        $documents = $entityManager->getRepository(Documents::class)->findBy(['post' => $post]);
        foreach ($documents as $document) {
            $document->setLink($this->getParameter('uploads_directory') . $document->getLink());
        }

        // Créer le formulaire pour ajouter un commentaire
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setPost($post);
            $comment->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_posts_show', ['id' => $post->getId()]);
        }

        // Création du formulaire d'édition pour ce post spécifique
        $editForm = $this->createForm(PostsType::class, $post);

        // Traite le formulaire s'il est soumis
        $editForm->handleRequest($request);

        if ($request->isMethod('POST') && $editForm->isSubmitted()) {
            if ($editForm->isValid()) {


                $content = $editForm->get('editContent')->getData();
                if (strlen(trim(strip_tags($content))) < 10) {
                    $this->addFlash('error', 'Le contenu doit contenir au moins 10 caractères.');
                    return $this->redirectToRoute('app_posts_show', ['id' => $post->getId()]);
                }

                $purifier = new \HTMLPurifier();
                $cleanHtml = $purifier->purify($content);

                $plainText = strip_tags($cleanHtml);
                if (strlen(trim($plainText)) < 10) {
                    $this->addFlash('error', 'Le contenu est trop court ou invalide après nettoyage.');
                    return $this->redirectToRoute('app_posts_show', ['id' => $post->getId()]);
                }

                $post->setText($cleanHtml);

                $post->setUpdatedAt(new \DateTime());
                $entityManager->flush();

                $this->addFlash('success', 'Le post a été modifié avec succès.');
                return $this->redirectToRoute('app_posts_show', ['id' => $post->getId()]);
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs. Veuillez vérifier les champs et réessayer.');
            }
        }

        return $this->render('posts/show.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'documents' => $documents,
            'form' => $form->createView(),
            'editForm' => $editForm->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_posts_delete', methods: ['POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(Request $request, Posts $post, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être authentifié pour supprimer un post.');
            return $this->redirectToRoute('app_login'); // Redirige vers la page de connexion
        }

        // Seul l'admin et le créateur du post peuvent le supprimer
        $user = $security->getUser();
        if ($post->getUser() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas la permission de supprimer ce post.');
            return $this->redirectToRoute('space_views', ['id' => $post->getSpace()->getId()]);
        }

        // Valider le token CSRF
        if (!$this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('space_views', ['id' => $post->getSpace()->getId()]);
        }

        // Supprimer le post
        $entityManager->remove($post);
        $entityManager->flush();

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
        $user = $security->getUser();
        $space = $entityManager->getRepository(Spaces::class)->find($space_id);

        if (!$space) {
            throw $this->createNotFoundException('Aucun espace trouvé pour id ' . $space_id);
        }

        if (!$this->isGranted('ROLE_TEACHER', $space)) {
            $this->addFlash('error', 'Vous ne possédez pas la permission de poster dans cet espace.');
            return $this->redirectToRoute('space_views', ['id' => $space_id]);
        }

        // Création du post
        $content = $request->request->get('content');
        if (!$content || trim(strip_tags($content)) === '') {
            $this->addFlash('error', 'Le contenu ne peut pas être vide.');
            return $this->redirectToRoute('space_views', ['id' => $space_id]);
        }

        $post = new Posts();
        $post->setUser($user);
        $post->setSpace($space);
        $post->setText(strip_tags($content));
        $entityManager->persist($post);
        $entityManager->flush();

        // Gestion des fichiers
        if ($request->files->has('document')) {

            $files = $request->files->get('document');
            $files = $request->files->get('document');
            if (!$files) {
                $this->addFlash('error', 'Aucun fichier.');
            }
            $mimeTypes = new MimeTypes(); // Instance de MimeTypes

            foreach ($files as $uploadedFile) {
                if ($uploadedFile && $uploadedFile->isValid()) {
                    try {
                        // Utilisation du composant Mime pour deviner le type MIME
                        $mimeType = $mimeTypes->guessMimeType($uploadedFile->getPathname());

                        // Vérifie le type MIME et la taille avant le déplacement
                        if (!in_array($mimeType, ['application/pdf', 'image/png', 'image/jpeg'])) {
                            $this->addFlash('error', 'Type de fichier non autorisé : ' . $mimeType);
                            continue;
                        }

                        if (count($files) > 6) { // Exemple : 6 fichiers max
                            $this->addFlash('error', 'Vous ne pouvez pas télécharger plus de 6 fichiers.');
                            return $this->redirectToRoute('space_views', ['id' => $space_id]);
                        }

                        if ($uploadedFile->getSize() > 5 * 1024 * 1024) { // 5 Mo
                            $this->addFlash('error', 'La taille d’un fichier ne peut pas dépasser 2 Mo.');
                            continue;
                        }

                        // Déplace le fichier et génère un nouveau nom
                        $newFilename = $fileUploader->upload($uploadedFile);

                        // Création de l'entité Document
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
        $entityManager->flush();

        $this->addFlash('success', 'Poste créés avec succès.');

        return $this->redirectToRoute('space_views', ['id' => $space_id]);
    }

}
