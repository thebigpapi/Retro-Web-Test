<?php

namespace App\Controller;

use App\Entity\CpuSocket;
use App\Entity\ProcessorPlatformType;
use App\Entity\Trace;
use App\Entity\User;
use App\Form\ManageUser;
use App\Repository\CpuSocketRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\MotherboardRepository;
use App\Repository\TraceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\BranchLoader\GitLoader;

class AdminController extends AbstractDashboardController
{

    #[Route('/logs', name:'logs')]
    public function logs(Request $request, TraceRepository $traceRepository, PaginatorInterface $paginator): Response
    {
        $logs = $traceRepository->findAll();
        if (!$logs) {
            return $this->render('admin/logs.html.twig', [
                'objectList' => [],
                'exist' => false,
            ]);
        } else {
            usort(
                $logs,
                function (Trace $a, Trace $b) {
                    if ($a->getDate() == $b->getDate()) {
                        return 0;
                    }
                    return ($a->getDate() > $b->getDate()) ? -1 : 1;
                }
            );
            $paginatedObjects = $paginator->paginate(
                $logs,
                $request->query->getInt('page', 1),
                $this->getParameter('app.pagination.max')
            );
            return $this->render('admin/logs.html.twig', [
                'objectList' => $paginatedObjects,
                'exist' => true,
            ]);
        }
    }

    #[Route('/logs/{id}', name:'logs_filter_id', requirements: ['id' => '\d+'])]
    public function logs_filter_id(int $id, Request $request, TraceRepository $traceRepository, PaginatorInterface $paginator): Response
    {
        $logs = $traceRepository->findAllById($id);
        if (!$logs) {
            return $this->render('admin/logs.html.twig', [
                'objectList' => [],
                'exist' => false,
            ]);
        } else {
            usort(
                $logs,
                function (Trace $a, Trace $b) {
                    if ($a->getDate() == $b->getDate()) {
                        return 0;
                    }
                    return ($a->getDate() > $b->getDate()) ? -1 : 1;
                }
            );
            $paginatedObjects = $paginator->paginate(
                $logs,
                $request->query->getInt('page', 1),
                $this->getParameter('app.pagination.max')
            );
            return $this->render('admin/logs.html.twig', [
                'objectList' => $paginatedObjects,
                'exist' => true,
            ]);
        }
    }
    #[Route('/logs/{id}/{entity}', name:'logs_filter_id_entity', requirements: ['id' => '\d+'])]
    public function logs_filter_id_entity(int $id, string $entity, Request $request, TraceRepository $traceRepository, PaginatorInterface $paginator): Response
    {
        $logs = $traceRepository->findAllByIdAndEntity($id, "App\\\\Entity\\\\" . $entity);
        if (!$logs) {
            return $this->render('admin/logs.html.twig', [
                'objectList' => [],
                'exist' => false,
            ]);
        } else {
            usort(
                $logs,
                function (Trace $a, Trace $b) {
                    if ($a->getDate() == $b->getDate()) {
                        return 0;
                    }
                    return ($a->getDate() > $b->getDate()) ? -1 : 1;
                }
            );
            $paginatedObjects = $paginator->paginate(
                $logs,
                $request->query->getInt('page', 1),
                $this->getParameter('app.pagination.max')
            );
            return $this->render('admin/logs.html.twig', [
                'objectList' => $paginatedObjects,
                'exist' => true,
            ]);
        }
    }
    #[Route('/dashboard/getcpufamilies', name:'mobo_get_cpu_families', methods:['POST'])]
    public function getCPUFamilies(Request $request, CpuSocketRepository $cpuSocketRepository): JsonResponse
    {
        //dd($request->query);
        $platforms = array();
        $cpuSockets = json_decode($request->getContent());
        if ($cpuSockets[0] instanceof CpuSocket) {
            foreach ($cpuSockets as $socket) {
                $platforms = array_merge($platforms, $socket->getPlatforms()->toArray());
            }
        } else {
            foreach ($cpuSockets as $socketId) {
                $socket = $cpuSocketRepository->find($socketId);
                $platforms = array_merge($platforms, $socket->getPlatforms()->toArray());
            }
        }
        usort($platforms, function (ProcessorPlatformType $a, ProcessorPlatformType $b) {
            return strnatcasecmp($a->getName() ?? '', $b->getName() ?? '');
        });
        $cpuPlatforms = array();
        foreach($platforms as $platform){
            $cpuPlatforms["e" . (string)$platform->getId()] = $platform->getName();
        }
        return new JsonResponse($cpuPlatforms);
    }
    #[Route('/dashboard/settings', name:'admin_user_settings')]
    public function userIndex(): Response
    {
        return $this->render('admin/users/index.html.twig');
    }
    #[Route('/dashboard/settings/resetpass/{id}', name: 'admin_reset_pass', requirements: ['id' => '\d+'])]
    public function resetPasswd(int $id, Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $password = $this->randomStr(16);
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('admin/users/password_reset.html.twig', [
            'username' => $user->getUsername(),
            'password' => $password,
        ]);
    }

    /**
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     */
    private function randomStr(
        int $length,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new \Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    #[Route('/dashboard/settings/password', name:'admin_user_changepwd')]
    public function changeUserPassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('old_password', PasswordType::class)
            ->add('new_password', PasswordType::class)
            ->add('new_password_confirm', PasswordType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $userRepository->findOneBy(["username" => $this->getUser()->getUserIdentifier()]);

            $checkPass = $passwordHasher->isPasswordValid($user, $data['old_password']);
            if ($checkPass === true) {
                if ($data['new_password'] === $data['new_password_confirm']) {
                    $hashedPassword = $passwordHasher->hashPassword($user, $data['new_password_confirm']);
                    $user->setPassword($hashedPassword);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->render('admin/users/message.html.twig', [
                        'message' => 'Password updated successfully !',
                        'path' => 'admin_user_settings',
                    ]);
                } else {
                    return $this->render('admin/users/message.html.twig', [
                        'message' => 'New password fields do not match! Try again.',
                        'path' => 'admin_user_changepwd',
                    ]);
                }
            } else {
                return $this->render('admin/users/message.html.twig', [
                    'message' => 'Current password does not match! Try again.',
                    'path' => 'admin_user_changepwd',
                ]);
            }
        }
        return $this->render('admin/users/change_pass.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dashboard/settings/username', name:'admin_user_changename')]
    public function changeUserName(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $form = $this->createFormBuilder()
            ->add('new_username', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepository->findOneBy(["username" => $this->getUser()->getUserIdentifier()]);
            if (strlen($data['new_username']) > 1 && strlen($data['new_username']) < 51) {
                if ($data['new_username'] === $user->getUsername()) {
                    return $this->render('admin/users/message.html.twig', [
                        'message' => 'Username is identical! Try again.',
                        'path' => 'admin_user_changename',
                    ]);
                } else {
                    $user->setUsername($data['new_username']);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $this->render('admin/users/message.html.twig', [
                        'message' => 'Username updated successfully !',
                        'path' => 'admin_user_settings',
                    ]);
                }
            } else {
                return $this->render('admin/users/message.html.twig', [
                    'message' => 'Username is invalid! Try again.',
                    'path' => 'admin_user_changename',
                ]);
            }
        }
        return $this->render('admin/users/change_name.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
