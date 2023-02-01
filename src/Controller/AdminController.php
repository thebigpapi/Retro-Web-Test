<?php

namespace App\Controller;

use App\Entity\Trace;
use App\Entity\User;
use App\Form\ManageUser;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

class AdminController extends AbstractController
{

    #[Route('/admin', name:'admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/stats', name:'admin_stats')]
    public function stats(MotherboardRepository $motherboardRepository, GitLoader $git) : Response
    {
        $manufBoardCount = $motherboardRepository->getManufCount();
        return $this->render('admin/stats.html.twig', [
            'controller_name' => 'MainController',
            'manufBoardCount' => $manufBoardCount,
            'moboCount' => $motherboardRepository->getCount(),
            'collector' => $git,
        ]);
    }

    #[Route('/admin/logs', name:'admin_logs')]
    public function logs(Request $request, TraceRepository $traceRepository, PaginatorInterface $paginator): Response
    {
        $logs = $traceRepository->findAll();
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
        ]);
    }

    #[Route('/admin/guidelines', name:'admin_guidelines')]
    public function guidelines() : Response
    {
        return $this->render('admin/guidelines.html.twig');
    }

    #[Route('/admin/users', name:'admin_user_settings')]
    public function userIndex() : Response
    {
        return $this->render('admin/users/index.html.twig');
    }

    #[Route('/admin/users/manage', name:'admin_user_manage')]
    public function manageUsers(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository) : Response
    {
        $userForm = $this->createForm(ManageUser::class);
        $message = "";

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            if ($userForm->get('reset')->isClicked()) {
                $user = $userRepository->find($userForm->getData()['users']->getId());

                $password = $this->randomStr(16);
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->render('admin/users/user_created.html.twig', [
                    'username' => $user->getUsername(),
                    'password' => $password,
                ]);
            }
            if ($userForm->get('delete')->isClicked()) {
                $user = $userRepository->find($userForm->getData()['users']->getId());

                $message = "Successfully removed user " . $user->getUsername();
                $entityManager->remove($user);
                $entityManager->flush();
            }
            if ($userForm->get('add')->isClicked()) {
                return $this->redirect('./manage/add');
            }
        }
        return $this->render('admin/users/manage.html.twig', [
            'userForm' => $userForm->createView(),
            'message' => $message,
        ]);
    }

    #[Route('/admin/users/manage/add', name:'admin_user_add')]
    public function addUser(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager) : Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('add', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = new User();
            $user->setRoles(array('ROLE_ADMIN'));
            $user->setUsername($data['name']);
            $password = $this->randomStr(16);
            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('admin/users/user_created.html.twig', [
                'username' => $user->getUsername(),
                'password' => $password,
            ]);
        }
        return $this->render('admin/users/add.html.twig', [
            'form' => $form->createView(),
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
    ) : string {
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

    #[Route('/admin/users/password', name:'admin_user_changepwd')]
    public function changeUserPassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository) : Response
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
    
    #[Route('/admin/users/username', name:'admin_user_changename')]
    public function changeUserName(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository) : Response
    {
        $form = $this->createFormBuilder()
            ->add('new_username', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepository->findOneBy(["username" => $this->getUser()->getUserIdentifier()]);
            if (strlen($data['new_username']) > 4 && strlen($data['new_username']) < 32) {
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
