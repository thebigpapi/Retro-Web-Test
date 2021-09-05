<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Motherboard;
use App\Form\ManageUser;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\MotherboardRepository;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_index")
     * @param Request $request
     */
    public function index(Request $request)
    {
        /** @var MotherboardRepository */
        $moboRepo = $this->getDoctrine()->getRepository(Motherboard::class);
        $latestMotherboards = $moboRepo->find50Latest();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'MainController',
            'latestMotherboards' => $latestMotherboards,
            'moboCount' => $moboRepo->getCount(),
        ]);
    }

    /**
     * @Route("/admin/manage_users", name="admin_manage_users")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     */
    public function manageUsers(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userForm = $this->createForm(ManageUser::class);
        $message = "";

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            if ($userForm->get('reset')->isClicked()) {
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($userForm->getData()['users']->getId());

                $password = $this->randomStr(16);
                $encoded = $encoder->encodePassword($user, $password);
                $user->setPassword($encoded);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->render('admin/add_user_created.html.twig', [
                    'username' => $user->getUsername(),
                    'password' => $password,
                ]);
            }
            if ($userForm->get('delete')->isClicked()) {
                $user = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->find($userForm->getData()['users']->getId());

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
     * @param UserPasswordEncoderInterface $encoder
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('add', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $user = new User();
            $user->setRoles(array('ROLE_ADMIN'));
            $user->setUsername($data['name']);
            $password = $this->randomStr(16);
            $encoded = $encoder->encodePassword($user, $password);
            $user->setPassword($encoded);
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
     * @param UserPasswordEncoderInterface $encoder
     */
    public function changeUserPassword(Request $request, UserPasswordEncoderInterface $encoder)
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

            $entityManager = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $checkPass = $encoder->isPasswordValid($user, $data['old_password']);
            if ($checkPass === true) {
                if ($data['new_password'] === $data['new_password_confirm']) {
                    $encoded = $encoder->encodePassword($user, $data['new_password_confirm']);
                    $user->setPassword($encoded);
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
}
