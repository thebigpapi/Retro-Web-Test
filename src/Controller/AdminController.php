<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ManageUser;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\MotherboardRepository;
use App\Repository\ManufacturerRepository;
use App\Repository\TraceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_index")
     * @param Request $request
     */
    public function index(MotherboardRepository $motherboardRepository)
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/admin/stats", name="admin_stats")
     */
    public function stats(MotherboardRepository $motherboardRepository)
    {
        $manufBoardCount = array();

        $manufBoardCount = $motherboardRepository->getManufCount();
        
        return $this->render('admin/stats.html.twig', [
            'controller_name' => 'MainController',
            'manufBoardCount' => $manufBoardCount,
            'moboCount' => $motherboardRepository->getCount(),
        ]);
    }

    /**
     * @Route("/admin/logs", name="admin_logs")
     * @param Request $request
     */
    public function logs(Request $request, TraceRepository $traceRepository, PaginatorInterface $paginator) {
        $logs = $traceRepository->findAll();
        usort(
            $logs,
            function ($a, $b) {
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

    /**
     * @Route("/admin/manage_users", name="admin_manage_users")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function manageUsers(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository)
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

                return $this->render('admin/add_user_created.html.twig', [
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
                return $this->redirect('./manage_users/add');
            }
        }
        return $this->render('admin/manage_users.html.twig', [
            'userForm' => $userForm->createView(),
            'message' => $message,
        ]);
    }

    /**
     * @Route("/admin/manage_users/add", name="admin_add_user")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function addUser(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
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

            return $this->render('admin/add_user_created.html.twig', [
                'username' => $user->getUsername(),
                'password' => $password,
            ]);
        }
        return $this->render('admin/add_user.html.twig', [
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
        $length,
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
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

    /**
     * @Route("/admin/password", name="admin_change_user_password")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function changeUserPassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository)
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
                    return new response("Password updated successfully !");
                } else {
                    return new jsonresponse(array('error' => 'The new password and verify aren\t matching.'));
                }
            } else {
                return new jsonresponse(array('error' => 'The current password is incorrect.'));
            }
        }
        return $this->render('admin/change_user_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/username", name="admin_change_user_name")
     * @param Request $request
     */
    public function changeUserName(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository)
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
                    return new jsonresponse(array('error' => 'The username is identical, try again.'));
                } else {
                    $user->setUsername($data['new_username']);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return new response("Username updated successfully ! Close this page and open TRW again.");
                }
            } else {
                return new jsonresponse(array('error' => 'The username is invalid'));
            }
        }
        return $this->render('admin/change_user_name.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
