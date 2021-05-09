<?php

namespace App\Controller;

use App\Entity\Chipset;
use App\Entity\ChipsetPart;
use App\Entity\Manufacturer;
use App\Entity\Coprocessor;
use App\Entity\Processor;
use App\Entity\CpuSocket;
use App\Entity\ProcessorPlatformType;
use App\Entity\CpuSpeed;
use App\Entity\DramType;
use App\Entity\ExpansionSlot;
use App\Entity\FormFactor;
use App\Entity\IoPort;
use App\Entity\KnownIssue;
use App\Entity\Language;
use App\Entity\MaxRam;
use App\Entity\CacheSize;
use App\Entity\VideoChipset;
use App\Entity\AudioChipset;
use App\Entity\User;
use App\Entity\Creditor;
use App\Entity\InstructionSet;
use App\Entity\Motherboard;
use App\Form\Admin\Manage\ProcessorSearchType;
use App\Form\ManageInstructionSet;
use App\Form\EditInstructionSet;
use App\Form\ManageProcessor;
use App\Form\EditProcessor;
use App\Form\ManageCpuSocket;
use App\Form\EditCpuSocket;
use App\Form\ManageChipset;
use App\Form\EditChipset;
use App\Form\ManageChipsetPart;
use App\Form\EditChipsetPart;
use App\Form\ManageCoprocessor;
use App\Form\EditCoprocessor;
use App\Form\ManageProcessorPlatformType;
use App\Form\EditProcessorPlatformType;
use App\Form\ManageManufacturer;
use App\Form\EditManufacturer;
use App\Form\ManageCpuSpeed;
use App\Form\EditCpuSpeed;
use App\Form\ManageDramType;
use App\Form\EditDramType;
use App\Form\ManageExpansionSlot;
use App\Form\EditExpansionSlot;
use App\Form\ManageFormFactor;
use App\Form\EditFormFactor;
use App\Form\ManageIoPort;
use App\Form\EditIoPort;
use App\Form\ManageKnownIssue;
use App\Form\EditKnownIssue;
use App\Form\ManageLanguage;
use App\Form\EditLanguage;
use App\Form\ManageMaxRam;
use App\Form\EditMaxRam;
use App\Form\ManageCacheSize;
use App\Form\EditCacheSize;
use App\Form\ManageVideoChipset;
use App\Form\EditVideoChipset;
use App\Form\ManageAudioChipset;
use App\Form\EditAudioChipset;
use App\Form\ManageUser;
use App\Form\ManageCreditor;
use App\Form\EditCreditor;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin_index")
     * @param Request $request
     */
    public function index(Request $request)        
    {
        $latestMotherboards = $this->getDoctrine()->getRepository(Motherboard::class)->find50Latest();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'MainController',
		    'latestMotherboards' => $latestMotherboards,
            'moboCount' => $this->getDoctrine()->getRepository(Motherboard::class)->getCount(),
        ]);
    }

    /**
     * @Route("/admin/manage_users", name="admin_manage_users")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     */
    public function manage_users(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userForm = $this->createForm(ManageUser::class);
        $message = "";

        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            if($userForm->get('reset')->isClicked()){
                $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($userForm->getData()['users']->getId());

                $password = $this->random_str(16);
                $encoded = $encoder->encodePassword($user, $password);
                $user->setPassword($encoded);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->render('admin/add_user_created.html.twig', [
                    'username' => $user->getUsername(),
                    'password' => $password,
                ]);
            }
            if($userForm->get('delete')->isClicked()) {
                $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($userForm->getData()['users']->getId());

                $message = "Successfully removed user " . $user->getUsername();
                $entityManager->remove($user);
                $entityManager->flush();
            }
            if($userForm->get('add')->isClicked()) return $this->redirect('./manage_users/add');
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
    public function add_user(Request $request, UserPasswordEncoderInterface $encoder)
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
            $password = $this->random_str(16);
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
    function random_str(
        $length,
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
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
    public function change_user_password(Request $request, UserPasswordEncoderInterface $encoder)
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
            if($checkPass === true) {
                if($data['new_password'] === $data['new_password_confirm']) {
                    $encoded = $encoder->encodePassword($user, $data['new_password_confirm']);
                    $user->setPassword($encoded);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return new response("Password updated successfully !");
                }
                else {
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