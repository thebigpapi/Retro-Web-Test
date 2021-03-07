<?php

namespace App\Controller;

use App\Entity\Chipset;
use App\Entity\ChipsetPart;
use App\Entity\Manufacturer;
use App\Entity\Coprocessor;
use App\Entity\Processor;
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
use App\Form\ManageInstructionSet;
use App\Form\EditInstructionSet;
use App\Form\ManageProcessor;
use App\Form\EditProcessor;
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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
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
        return $this->render('admin/index.html.twig', [
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

     /**
     * @Route("/admin/manage_resources", name="admin_manage_resources")
     * @param Request $request
     */
    public function manage_resources(Request $request)        
    {
        $chipsets = $this->getDoctrine()
            ->getRepository(Chipset::class)
            ->findAllChipsetManufacturer();

        $chipsetForm = $this->createForm(ManageChipset::class, NULL, [
            'chipsets' => $chipsets,
        ]);
        $chipsetForm->handleRequest($request);
        if ($chipsetForm->isSubmitted() && $chipsetForm->isValid()) {
            if($chipsetForm->get('edit')->isClicked()) return $this->redirect('./chipset_edit/' . $chipsetForm->getData()['chipsets']->getId());
            if($chipsetForm->get('add')->isClicked()) return $this->redirect('./chipset_add');
        }

        $chipsetParts = $this->getDoctrine()
            ->getRepository(ChipsetPart::class)
            ->findAll(array(),array('name' => 'ASC', 'shortName' => 'ASC'));

        usort($chipsetParts, function ($a, $b)
            {
                if ($a->getFullName() == $b->getFullName()) {
                    return 0;
                }
                return ($a->getFullName() < $b->getFullName()) ? -1 : 1;
            }
        );

        $chipsetPartForm = $this->createForm(ManageChipsetPart::class, NULL, [
            'chipsetParts' => $chipsetParts,
        ]);
        $chipsetPartForm->handleRequest($request);
        if ($chipsetPartForm->isSubmitted() && $chipsetPartForm->isValid()) {
            if($chipsetPartForm->get('edit')->isClicked()) return $this->redirect('./chipset_part_edit/' . $chipsetPartForm->getData()['chipsetParts']->getId());
            if($chipsetPartForm->get('add')->isClicked()) return $this->redirect('./chipset_part_add');
        }

        $coprocessors = $this->getDoctrine()
            ->getRepository(Coprocessor::class)
            ->findAllOrderByManufacturer();

        $coprocessorForm = $this->createForm(ManageCoprocessor::class, NULL, [
            'coprocessors' => $coprocessors,
        ]);

        $coprocessorForm->handleRequest($request);
        if ($coprocessorForm->isSubmitted() && $coprocessorForm->isValid()) {
            if($coprocessorForm->get('edit')->isClicked()) return $this->redirect('./coprocessor_edit/' . $coprocessorForm->getData()['coprocessors']->getId());
            if($coprocessorForm->get('add')->isClicked()) return $this->redirect('./coprocessor_add');
        }

        $processors = $this->getDoctrine()
            ->getRepository(Processor::class)
            ->findAllOrderByManufacturer();

        $processorForm = $this->createForm(ManageProcessor::class, NULL, [
            'processors' => $processors,
        ]);

        $processorForm->handleRequest($request);
        if ($processorForm->isSubmitted() && $processorForm->isValid()) {
            if($processorForm->get('edit')->isClicked()) return $this->redirect('./processor_edit/' . $processorForm->getData()['processors']->getId());
            if($processorForm->get('add')->isClicked()) return $this->redirect('./processor_add');
        }

        $processorPlatformTypeForm = $this->createForm(ManageProcessorPlatformType::class);

        $processorPlatformTypeForm->handleRequest($request);
        if ($processorPlatformTypeForm->isSubmitted() && $processorPlatformTypeForm->isValid()) {
            if($processorPlatformTypeForm->get('edit')->isClicked()) return $this->redirect('./processorPlatformType_edit/' . $processorPlatformTypeForm->getData()['processorPlatformTypes']->getId());
            if($processorPlatformTypeForm->get('add')->isClicked()) return $this->redirect('./processorPlatformType_add');
        }

        $manufacturers = $this->getDoctrine()
            ->getRepository(Manufacturer::class)
            ->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));

        $manufacturerForm = $this->createForm(ManageManufacturer::class, NULL, [
            'manufacturers' => $manufacturers,
        ]);

        $manufacturerForm->handleRequest($request);
        if ($manufacturerForm->isSubmitted() && $manufacturerForm->isValid()) {
            if($manufacturerForm->get('edit')->isClicked()) return $this->redirect('./manufacturer_edit/' . $manufacturerForm->getData()['manufacturers']->getId());
            if($manufacturerForm->get('add')->isClicked()) return $this->redirect('./manufacturer_add');
        }

        $cpuSpeeds = $this->getDoctrine()
            ->getRepository(CpuSpeed::class)
            ->findBy(array(), array('value' => 'ASC'));

        $cpuSpeedForm = $this->createForm(ManageCpuSpeed::class, NULL, [
            'cpuSpeeds' => $cpuSpeeds,
        ]);

        $cpuSpeedForm->handleRequest($request);
        if ($cpuSpeedForm->isSubmitted() && $cpuSpeedForm->isValid()) {
            if($cpuSpeedForm->get('edit')->isClicked()) return $this->redirect('./cpuSpeed_edit/' . $cpuSpeedForm->getData()['cpuSpeeds']->getId());
            if($cpuSpeedForm->get('add')->isClicked()) return $this->redirect('./cpuSpeed_add');
        }

        $dramTypeForm = $this->createForm(ManageDramType::class, NULL);

        $dramTypeForm->handleRequest($request);
        if ($dramTypeForm->isSubmitted() && $dramTypeForm->isValid()) {
            if($dramTypeForm->get('edit')->isClicked()) return $this->redirect('./dramType_edit/' . $dramTypeForm->getData()['dramTypes']->getId());
            if($dramTypeForm->get('add')->isClicked()) return $this->redirect('./dramType_add');
        }

        $expansionSlotForm = $this->createForm(ManageExpansionSlot::class, NULL);

        $expansionSlotForm->handleRequest($request);
        if ($expansionSlotForm->isSubmitted() && $expansionSlotForm->isValid()) {
            if($expansionSlotForm->get('edit')->isClicked()) return $this->redirect('./expansionSlot_edit/' . $expansionSlotForm->getData()['expansionSlots']->getId());
            if($expansionSlotForm->get('add')->isClicked()) return $this->redirect('./expansionSlot_add');
        }

        $formFactorForm = $this->createForm(ManageFormFactor::class, NULL);

        $formFactorForm->handleRequest($request);
        if ($formFactorForm->isSubmitted() && $formFactorForm->isValid()) {
            if($formFactorForm->get('edit')->isClicked()) return $this->redirect('./formFactor_edit/' . $formFactorForm->getData()['formFactors']->getId());
            if($formFactorForm->get('add')->isClicked()) return $this->redirect('./formFactor_add');
        }

        $instructionSetForm = $this->createForm(ManageInstructionSet::class, NULL);

        $instructionSetForm->handleRequest($request);
        if ($instructionSetForm->isSubmitted() && $instructionSetForm->isValid()) {
            if($instructionSetForm->get('edit')->isClicked()) return $this->redirect('./instructionSet_edit/' . $instructionSetForm->getData()['instructionSets']->getId());
            if($instructionSetForm->get('add')->isClicked()) return $this->redirect('./instructionSet_add');
        }

        $ioPortForm = $this->createForm(ManageIoPort::class, NULL);

        $ioPortForm->handleRequest($request);
        if ($ioPortForm->isSubmitted() && $ioPortForm->isValid()) {
            if($ioPortForm->get('edit')->isClicked()) return $this->redirect('./ioPort_edit/' . $ioPortForm->getData()['ioPorts']->getId());
            if($ioPortForm->get('add')->isClicked()) return $this->redirect('./ioPort_add');
        }

        $knownIssueForm = $this->createForm(ManageKnownIssue::class, NULL);

        $knownIssueForm->handleRequest($request);
        if ($knownIssueForm->isSubmitted() && $knownIssueForm->isValid()) {
            if($knownIssueForm->get('edit')->isClicked()) return $this->redirect('./knownIssue_edit/' . $knownIssueForm->getData()['knownIssues']->getId());
            if($knownIssueForm->get('add')->isClicked()) return $this->redirect('./knownIssue_add');
        }

        $languageForm = $this->createForm(ManageLanguage::class, NULL);

        $languageForm->handleRequest($request);
        if ($languageForm->isSubmitted() && $languageForm->isValid()) {
            if($languageForm->get('edit')->isClicked()) return $this->redirect('./language_edit/' . $languageForm->getData()['languages']->getId());
            if($languageForm->get('add')->isClicked()) return $this->redirect('./language_add');
        }

        $maxRams = $this->getDoctrine()
            ->getRepository(MaxRam::class)
            ->findBy(array(), array('value' => 'ASC'));

        $maxRamForm = $this->createForm(ManageMaxRam::class, NULL, [
            'maxRams' => $maxRams,
        ]);

        $maxRamForm->handleRequest($request);
        if ($maxRamForm->isSubmitted() && $maxRamForm->isValid()) {
            if($maxRamForm->get('edit')->isClicked()) return $this->redirect('./maxRam_edit/' . $maxRamForm->getData()['maxRams']->getId());
            if($maxRamForm->get('add')->isClicked()) return $this->redirect('./maxRam_add');
        }

        $cacheSizes = $this->getDoctrine()
            ->getRepository(CacheSize::class)
            ->findBy(array(), array('value' => 'ASC'));

        $cacheSizeForm = $this->createForm(ManageCacheSize::class, NULL, [
            'cacheSizes' => $cacheSizes,
        ]);

        $cacheSizeForm->handleRequest($request);
        if ($cacheSizeForm->isSubmitted() && $cacheSizeForm->isValid()) {
            if($cacheSizeForm->get('edit')->isClicked()) return $this->redirect('./cacheSize_edit/' . $cacheSizeForm->getData()['cacheSizes']->getId());
            if($cacheSizeForm->get('add')->isClicked()) return $this->redirect('./cacheSize_add');
            if($cacheSizeForm->get('delete')->isClicked()) return $this->redirect('./cacheSize_add');
        }

        $videoChipsets = $this->getDoctrine()
            ->getRepository(VideoChipset::class)
            ->findAllVideoChipsetManufacturer();

        $videoChipsetForm = $this->createForm(ManageVideoChipset::class, NULL, [
            'videoChipsets' => $videoChipsets,
        ]);

        $videoChipsetForm->handleRequest($request);
        if ($videoChipsetForm->isSubmitted() && $videoChipsetForm->isValid()) {
            if($videoChipsetForm->get('edit')->isClicked()) return $this->redirect('./videoChipset_edit/' . $videoChipsetForm->getData()['videoChipsets']->getId());
            if($videoChipsetForm->get('add')->isClicked()) return $this->redirect('./videoChipset_add');
            if($videoChipsetForm->get('delete')->isClicked()) return $this->redirect('./videoChipset_add');
        }

        $audioChipsets = $this->getDoctrine()
            ->getRepository(AudioChipset::class)
            ->findAllAudioChipsetManufacturer();

        $audioChipsetForm = $this->createForm(ManageAudioChipset::class, NULL, [
            'audioChipsets' => $audioChipsets,
        ]);

        $audioChipsetForm->handleRequest($request);
        if ($audioChipsetForm->isSubmitted() && $audioChipsetForm->isValid()) {
            if($audioChipsetForm->get('edit')->isClicked()) return $this->redirect('./audioChipset_edit/' . $audioChipsetForm->getData()['audioChipsets']->getId());
            if($audioChipsetForm->get('add')->isClicked()) return $this->redirect('./audioChipset_add');
            if($audioChipsetForm->get('delete')->isClicked()) return $this->redirect('./audioChipset_add');
        }

        $creditors = $this->getDoctrine()
            ->getRepository(Creditor::class)
            ->findAll();

        $creditorsForm = $this->createForm(ManageCreditor::class, NULL, [
            'creditors' => $creditors,
        ]);

        $creditorsForm->handleRequest($request);
        if ($creditorsForm->isSubmitted() && $creditorsForm->isValid()) {
            if($creditorsForm->get('edit')->isClicked()) return $this->redirect('./creditor_edit/' . $creditorsForm->getData()['creditors']->getId());
            if($creditorsForm->get('add')->isClicked()) return $this->redirect('./creditor_add');
            if($creditorsForm->get('delete')->isClicked()) return $this->redirect('./creditor_add');
        }

        return $this->render('admin/manage_resources.html.twig', [
            'chipsetForm' => $chipsetForm->createView(),
            'chipsetPartForm' => $chipsetPartForm->createView(),
            'coprocessorForm' => $coprocessorForm->createView(),
            'processorForm' => $processorForm->createView(),
            'processorPlatformTypeForm' => $processorPlatformTypeForm->createView(),
            'manufacturerForm' => $manufacturerForm->createView(),
            'cpuSpeedForm' => $cpuSpeedForm->createView(),
            'dramTypeForm' => $dramTypeForm->createView(),
            'expansionSlotForm' => $expansionSlotForm->createView(),
            'formFactorForm' => $formFactorForm->createView(),
            'instructionSetForm' => $instructionSetForm->createView(),
            'ioPortForm' => $ioPortForm->createView(),
            'knownIssueForm' => $knownIssueForm->createView(),
            'languageForm' => $languageForm->createView(),
            'maxRamForm' => $maxRamForm->createView(),
            'cacheSizeForm' => $cacheSizeForm->createView(),
            'videoChipsetForm' => $videoChipsetForm->createView(),
            'audioChipsetForm' => $audioChipsetForm->createView(),
            'creditorsForm' => $creditorsForm->createView(),
        ]);

    }

    /**
     * @Route("/admin/chipset_add", name="chipset_add")
     * @param Request $request
     */
    public function chipsetAdd(Request $request)        
    {
        return $this->renderChipsetForm($request, new Chipset());
    }

    /**
     * @Route("/admin/chipset_edit/{id}", name="chipset_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function chipsetEdit(Request $request, int $id)        
    {
        return $this->renderChipsetForm($request, $this->getDoctrine()
                                        ->getRepository(Chipset::class)
                                        ->find($id)
                                    );
    }

    private function renderChipsetForm(Request $request, $chipset) {
        $entityManager = $this->getDoctrine()->getManager();
        $chipsetManufacturers = $this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));

        $chipsetParts = $this->getDoctrine()
            ->getRepository(ChipsetPart::class)
            ->findAll(array(),array('name' => 'ASC', 'shortName' => 'ASC'));

        usort($chipsetParts, function ($a, $b)
            {
                if ($a->getFullName() == $b->getFullName()) {
                    return 0;
                }
                return ($a->getFullName() < $b->getFullName()) ? -1 : 1;
            }
        );
        
        $form = $this->createForm(EditChipset::class, $chipset, [
            'chipsetManufacturers' => $chipsetManufacturers,
            'chipsetParts' => $chipsetParts,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipset = $form->getData();

            /*foreach ($form['chipsetChipsetParts']->getData() as $key => $val) {
                $val->setChipset($chipset);
            }*/
            
            $entityManager->persist($chipset);
            $entityManager->flush();

            return $this->redirectToRoute('admin_manage_resources', array()); 
        }
        return $this->render('admin/add_chipset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/chipset_part_add", name="chipset_part_add")
     * @param Request $request
     */
    public function chipsetPartAdd(Request $request)        
    {
        return $this->renderChipsetPartForm($request, new ChipsetPart());
    }

    /**
     * @Route("/admin/chipset_part_edit/{id}", name="chipset_part_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function chipsetPartEdit(Request $request, int $id)        
    {
        return $this->renderChipsetPartForm($request, $this->getDoctrine()
                                        ->getRepository(ChipsetPart::class)
                                        ->find($id)
                                    );
    }

    private function renderChipsetPartForm(Request $request, $chipsetPart) {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(EditChipsetPart::class, $chipsetPart);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipsetPart = $form->getData();

            foreach ($form['chip']['chipAliases']->getData() as $key => $val) {
                $val->setChip($chipsetPart);
            }
            foreach ($form['chip']['images']->getData() as $key => $val) {
                $val->setChip($chipsetPart);
            }
            
            
            $entityManager->persist($chipsetPart);
            $entityManager->flush();

            return $this->redirectToRoute('admin_manage_resources', array());
        }
        return $this->render('admin/add_chipset_part.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/coprocessor_add", name="coprocessor_add")
     * @param Request $request
     */
    public function coprocessorAdd(Request $request)        
    {
        return $this->renderCoprocessorForm($request, new Coprocessor());
    }

    /**
     * @Route("/admin/coprocessor_edit/{id}", name="coprocessor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function coprocessorEdit(Request $request, int $id)        
    {
        return $this->renderCoprocessorForm($request, $this->getDoctrine()
                                        ->getRepository(Coprocessor::class)
                                        ->find($id)
                                    );
    }

    private function renderCoprocessorForm(Request $request, $coprocessor) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(EditCoprocessor::class, $coprocessor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $coprocessor = $form->getData();
            foreach ($form['processingUnit']['instructionSets']->getData() as $key => $val) {
                $val->addProcessingUnit($coprocessor);
            }
            foreach ($form['processingUnit']['chip']['chipAliases']->getData() as $key => $val) {
                $val->setChip($coprocessor);
            }
            foreach ($form['processingUnit']['chip']['images']->getData() as $key => $val) {
                $val->setChip($coprocessor);
            }
            
            $entityManager->persist($coprocessor);
            $entityManager->flush();

            return $this->redirectToRoute('admin_manage_resources', array()); 
        }
        return $this->render('admin/add_coprocessor.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/processor_add", name="processor_add")
     * @param Request $request
     */
    public function processorAdd(Request $request)        
    {
        return $this->renderProcessorForm($request, new Processor());
    }

    /**
     * @Route("/admin/processor_edit/{id}", name="processor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function processorEdit(Request $request, int $id)        
    {
        return $this->renderProcessorForm($request, $this->getDoctrine()
                                        ->getRepository(Processor::class)
                                        ->find($id)
                                    );
    }

    private function renderProcessorForm(Request $request, $processor) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(EditProcessor::class, $processor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $processor = $form->getData();
            foreach ($form['processingUnit']['instructionSets']->getData() as $key => $val) {
                $val->addProcessingUnit($processor);
            }
            foreach ($form['processingUnit']['chip']['chipAliases']->getData() as $key => $val) {
                $val->setChip($processor);
            }
            foreach ($form['processingUnit']['chip']['images']->getData() as $key => $val) {
                $val->setChip($processor);
            }

            $entityManager->persist($processor);
            $entityManager->flush();

            return $this->redirectToRoute('admin_manage_resources', array());
        }
        return $this->render('admin/add_processor.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/processorPlatformType_add", name="processorPlatformType_add")
     * @param Request $request
     */
    public function processorPlatformTypeAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new ProcessorPlatformType(), EditProcessorPlatformType::class, 'admin/add_processorPlatformType.html.twig');
    }

    /**
     * @Route("/admin/processorPlatformType_edit/{id}", name="processorPlatformType_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function processorPlatformTypeEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request, $this->getDoctrine()
                                        ->getRepository(ProcessorPlatformType::class)
                                        ->find($id)
                                        , EditProcessorPlatformType::class, 'admin/add_processorPlatformType.html.twig');
    }

    /**
     * @Route("/admin/manufacturer_add", name="manufacturer_add")
     * @param Request $request
     */
    public function manufacturerAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new Manufacturer(), EditManufacturer::class, 'admin/add_manufacturer.html.twig');
    }

    /**
     * @Route("/admin/manufacturer_edit/{id}", name="manufacturer_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function manufacturerEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(Manufacturer::class)
                                        ->find($id)
                                        , EditManufacturer::class, 'admin/add_manufacturer.html.twig');
    }


    /**
     * @Route("/admin/cpuSpeed_add", name="cpuSpeed_add")
     * @param Request $request
     */
    public function cpuSpeedAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new CpuSpeed(), EditCpuSpeed::class, 'admin/add_cpuSpeed.html.twig');
    }

    /**
     * @Route("/admin/cpuSpeed_edit/{id}", name="cpuSpeed_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function cpuSpeedEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(CpuSpeed::class)
                                        ->find($id)
                                        , EditCpuSpeed::class, 'admin/add_cpuSpeed.html.twig');
    }

    /**
     * @Route("/admin/dramType_add", name="dramType_add")
     * @param Request $request
     */
    public function dramTypeAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new DramType(), EditDramType::class, 'admin/add_dramType.html.twig');
    }

    /**
     * @Route("/admin/dramType_edit/{id}", name="dramType_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function dramTypeEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(DramType::class)
                                        ->find($id)
                                        , EditDramType::class, 'admin/add_dramType.html.twig');
    }

    /**
     * @Route("/admin/expansionSlot_add", name="expansionSlot_add")
     * @param Request $request
     */
    public function expansionSlotAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new ExpansionSlot(), EditExpansionSlot::class, 'admin/add_expansionSlot.html.twig');
    }

    /**
     * @Route("/admin/expansionSlot_edit/{id}", name="expansionSlot_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function expansionSlotEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(ExpansionSlot::class)
                                        ->find($id)
                                    , EditExpansionSlot::class, 'admin/add_expansionSlot.html.twig');
    }

    /**
     * @Route("/admin/formFactor_add", name="formFactor_add")
     * @param Request $request
     */
    public function formFactorAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new FormFactor(), EditFormFactor::class, 'admin/add_formFactor.html.twig');
    }

    /**
     * @Route("/admin/formFactor_edit/{id}", name="formFactor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function formFactorEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(FormFactor::class)
                                        ->find($id)
                                    , EditFormFactor::class, 'admin/add_formFactor.html.twig');
    }

    /**
     * @Route("/admin/instructionSet_add", name="instructionSet_add")
     * @param Request $request
     */
    public function instructionSetAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new InstructionSet(), EditInstructionSet::class, 'admin/add_instructionSet.html.twig');
    }

    /**
     * @Route("/admin/instructionSet_edit/{id}", name="instructionSet_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function instructionSetEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(InstructionSet::class)
                                        ->find($id)
                                    , EditInstructionSet::class, 'admin/add_instructionSet.html.twig');
    }

    /**
     * @Route("/admin/ioPort_add", name="ioPort_add")
     * @param Request $request
     */
    public function ioPortAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new IoPort(), EditIoPort::class, 'admin/add_ioPort.html.twig');
    }

    /**
     * @Route("/admin/ioPort_edit/{id}", name="ioPort_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function ioPortEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(IoPort::class)
                                        ->find($id)
                                    , EditIoPort::class, 'admin/add_ioPort.html.twig');
    }

    /**
     * @Route("/admin/knownIssue_add", name="knownIssue_add")
     * @param Request $request
     */
    public function knownIssueAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new KnownIssue(), EditKnownIssue::class, 'admin/add_knownIssue.html.twig');
    }

    /**
     * @Route("/admin/knownIssue_edit/{id}", name="knownIssue_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function knownIssueEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(KnownIssue::class)
                                        ->find($id)
                                    , EditKnownIssue::class, 'admin/add_knownIssue.html.twig');
    }

    /**
     * @Route("/admin/language_add", name="language_add")
     * @param Request $request
     */
    public function languageAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new Language(), EditLanguage::class, 'admin/add_language.html.twig');
    }

    /**
     * @Route("/admin/language_edit/{id}", name="language_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function languageEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(Language::class)
                                        ->find($id)
                                    , EditLanguage::class, 'admin/add_language.html.twig');
    }

    /**
     * @Route("/admin/maxRam_add", name="maxRam_add")
     * @param Request $request
     */
    public function maxRamAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new MaxRam(), EditMaxRam::class, 'admin/add_maxRam.html.twig');
    }

    /**
     * @Route("/admin/maxRam_edit/{id}", name="maxRam_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function maxRamEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(MaxRam::class)
                                        ->find($id)
                                    , EditMaxRam::class, 'admin/add_maxRam.html.twig');
    }

    /**
     * @Route("/admin/cacheSize_add", name="cacheSize_add")
     * @param Request $request
     */
    public function cacheSizeAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new CacheSize(), EditCacheSize::class, 'admin/add_cacheSize.html.twig');
    }

    /**
     * @Route("/admin/cacheSize_edit/{id}", name="cacheSize_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function cacheSizeEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(CacheSize::class)
                                        ->find($id)
                                    , EditCacheSize::class, 'admin/add_cacheSize.html.twig');
    }

    /**
     * @Route("/admin/videoChipset_add", name="videoChipset_add")
     * @param Request $request
     */
    public function videoChipsetAdd(Request $request)        
    {
        return $this->renderVideoChipsetForm($request, new VideoChipset());
    }

    /**
     * @Route("/admin/videoChipset_edit/{id}", name="videoChipset_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function videoChipsetEdit(Request $request, int $id)        
    {
        return $this->renderVideoChipsetForm($request,$this->getDoctrine()
                                        ->getRepository(VideoChipset::class)
                                        ->find($id)
                                    );
    }

    private function renderVideoChipsetForm(Request $request, $chipset) {
        $entityManager = $this->getDoctrine()->getManager();
        $chipsetManufacturers = $this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));
        
        $form = $this->createForm(EditVideoChipset::class, $chipset, [
            'chipsetManufacturers' => $chipsetManufacturers,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipset = $form->getData();
            
            $entityManager->persist($chipset);
            $entityManager->flush();
            
            return $this->redirectToRoute('admin_manage_resources', array());
        }
        return $this->render('admin/add_videoChipset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/audioChipset_add", name="audioChipset_add")
     * @param Request $request
     */
    public function audioChipsetAdd(Request $request)        
    {
        return $this->renderAudioChipsetForm($request, new AudioChipset());
    }

    /**
     * @Route("/admin/audioChipset_edit/{id}", name="audioChipset_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function audioChipsetEdit(Request $request, int $id)        
    {
        return $this->renderAudioChipsetForm($request,$this->getDoctrine()
                                        ->getRepository(AudioChipset::class)
                                        ->find($id)
                                    );
    }

    private function renderAudioChipsetForm(Request $request, $chipset) {
        $entityManager = $this->getDoctrine()->getManager();
        $chipsetManufacturers = $this->getDoctrine()
        ->getRepository(Manufacturer::class)
        ->findBy(array(), array('name' => 'ASC', 'shortName' => 'ASC'));
        
        $form = $this->createForm(EditAudioChipset::class, $chipset, [
            'chipsetManufacturers' => $chipsetManufacturers,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chipset = $form->getData();
            
            $entityManager->persist($chipset);
            $entityManager->flush();

            return $this->redirectToRoute('admin_manage_resources', array()); 
        }
        return $this->render('admin/add_audioChipset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function renderEntityForm(Request $request, $entity, $class, $template) {
        $entityManager = $this->getDoctrine()->getManager();
        
        $form = $this->createForm($class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            
            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->redirectToRoute('admin_manage_resources', array());
        }
        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/creditor_add", name="creditor_add")
     * @param Request $request
     */
    public function creditorAdd(Request $request)        
    {
        return $this->renderEntityForm($request, new Creditor(), EditCreditor::class, 'admin/add_creditor.html.twig');
    }

    /**
     * @Route("/admin/creditor_edit/{id}", name="creditor_edit", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function creditorEdit(Request $request, int $id)        
    {
        return $this->renderEntityForm($request,$this->getDoctrine()
                                        ->getRepository(Creditor::class)
                                        ->find($id)
                                        , EditCreditor::class, 'admin/add_creditor.html.twig');
    }
}